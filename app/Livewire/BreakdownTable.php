<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class BreakdownTable extends Component
{
    #[Url]
    public int $year;

    /** @var Collection<int, User> */
    public Collection $users;

    /** @var array<int, string> */
    public array $months = [];

    /** @var array<string, array<int, int|float|null>> */
    public array $breakdownData = [];

    /** @var array<string> */
    protected array $trackedCategories = [
        'Mortgage',
        'Bills',
        'Groceries',
        'Eating Out',
        'Entertainment',
        'Travel',
        'Pet',
        'Gifts',
    ];

    public function mount(): void
    {
        $this->year = $this->year ?? now()->year;
        $this->users = User::query()->orderBy('name')->get();
        $this->months = $this->getMonths();
        $this->calculateBreakdownData();
    }

    public function updatedYear(): void
    {
        $this->calculateBreakdownData();
    }

    /**
     * @return array<int, string>
     */
    protected function getMonths(): array
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create(null, $i)->format('M');
        }
        return $months;
    }

    /**
     * @return array<int, int>
     */
    public function getYearOptions(): array
    {
        $startYear = 2021;
        $currentYear = now()->year;
        $years = [];
        for ($i = $startYear; $i <= $currentYear + 1; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }

    protected function calculateBreakdownData(): void
    {
        $this->breakdownData = [];

        // Get all transactions for the year grouped by month and user
        $transactions = Transaction::query()
            ->with(['category', 'subcategory', 'user'])
            ->whereYear('transaction_date', $this->year)
            ->get();

        // Get all subcategories for expected totals
        $subcategories = Subcategory::query()
            ->with('category')
            ->get();

        // Calculate data for each month
        for ($month = 1; $month <= 12; $month++) {
            $monthTransactions = $transactions->filter(
                fn (Transaction $t) => Carbon::parse($t->transaction_date)->month === $month
            );

            // Calculate income per user for this month
            $incomeByUser = $this->calculateIncomeByUser($monthTransactions);
            $totalIncome = array_sum($incomeByUser);

            // Store income per user
            foreach ($this->users as $user) {
                $this->breakdownData["{$user->name} Income"][$month] = $incomeByUser[$user->id] ?? 0;
            }

            // Calculate income-based split ratios (used as default/fallback)
            $incomeRatios = $this->calculateSplitRatios($incomeByUser, $totalIncome);
            $userIds = $this->users->pluck('id')->all();

            // Calculate expected per user based on each subcategory's split strategy
            foreach ($this->users as $user) {
                $userExpectedTotal = 0;

                foreach ($subcategories as $subcategory) {
                    // Skip income subcategories
                    if ($subcategory->category && $subcategory->category->name === 'Income') {
                        continue;
                    }

                    // Get this subcategory's split ratio for this user
                    $ratio = $subcategory->getSplitRatioForUser($user->id, $incomeRatios, $userIds);
                    $userExpectedTotal += (int) round($subcategory->monthly_budgeted * $ratio);
                }

                $this->breakdownData["{$user->name} Expected Total"][$month] = $userExpectedTotal;
            }

            // Keep income ratios for other calculations (overage/owed, percentage slice)
            $splitRatios = $incomeRatios;

            // Calculate already paid per user (sum of debits)
            foreach ($this->users as $user) {
                $userTransactions = $monthTransactions->where('user_id', $user->id);
                $alreadyPaid = $userTransactions->sum('debit') ?? 0;
                $this->breakdownData["{$user->name} Already Paid"][$month] = (int) $alreadyPaid;
            }

            // Calculate overage/owed between users
            $this->calculateOverageOwed($month, $splitRatios);

            // Calculate category totals and per-user contributions
            $this->calculateCategoryTotals($month, $monthTransactions, $subcategories);
            $this->calculateUserCategoryContributions($month, $monthTransactions, $subcategories, $splitRatios);

            // Total Expenditures
            $totalExpenditures = $monthTransactions
                ->whereNull('credit')
                ->sum('debit') ?? 0;
            $this->breakdownData['Total Expenditures'][$month] = (int) $totalExpenditures;

            // Validated (placeholder - would need additional logic/field)
            $this->breakdownData['Validated?'][$month] = null;

            // Percentage Slice per user (income-based split ratio)
            foreach ($this->users as $user) {
                $ratio = $splitRatios[$user->id] ?? 0.5;
                $this->breakdownData["{$user->name} Percentage Slice"][$month] = $ratio * 100;
            }
        }
    }

    /**
     * @param Collection<int, Transaction> $transactions
     * @return array<int, int>
     */
    protected function calculateIncomeByUser(Collection $transactions): array
    {
        $incomeByUser = [];

        foreach ($this->users as $user) {
            $income = $transactions
                ->where('user_id', $user->id)
                ->whereNotNull('credit')
                ->sum('credit') ?? 0;
            $incomeByUser[$user->id] = (int) $income;
        }

        return $incomeByUser;
    }

    /**
     * @param array<int, int> $incomeByUser
     * @return array<int, float>
     */
    protected function calculateSplitRatios(array $incomeByUser, int $totalIncome): array
    {
        $splitRatios = [];

        if ($totalIncome === 0) {
            // Default to equal split if no income
            $userCount = $this->users->count();
            foreach ($this->users as $user) {
                $splitRatios[$user->id] = 1 / $userCount;
            }
        } else {
            foreach ($this->users as $user) {
                $splitRatios[$user->id] = ($incomeByUser[$user->id] ?? 0) / $totalIncome;
            }
        }

        return $splitRatios;
    }

    /**
     * @param array<int, float> $splitRatios
     */
    protected function calculateOverageOwed(int $month, array $splitRatios): void
    {
        $userArray = $this->users->values()->all();

        if (count($userArray) < 2) {
            return;
        }

        // For a two-person household
        $user1 = $userArray[0];
        $user2 = $userArray[1];

        $user1Expected = $this->breakdownData["{$user1->name} Expected Total"][$month] ?? 0;
        $user1Paid = $this->breakdownData["{$user1->name} Already Paid"][$month] ?? 0;
        $user1Difference = $user1Paid - $user1Expected;

        $user2Expected = $this->breakdownData["{$user2->name} Expected Total"][$month] ?? 0;
        $user2Paid = $this->breakdownData["{$user2->name} Already Paid"][$month] ?? 0;
        $user2Difference = $user2Paid - $user2Expected;

        // Positive difference means overpaid, negative means underpaid
        // Overage/Owed to other person
        $this->breakdownData["Overage/Owed to {$user2->name}"][$month] = $user1Difference > 0 ? $user1Difference : 0;
        $this->breakdownData["Paid/Received ({$user1->name})"][$month] = null; // Placeholder for manual tracking

        $this->breakdownData["Overage/Owed to {$user1->name}"][$month] = $user2Difference > 0 ? $user2Difference : 0;
        $this->breakdownData["Paid/Received ({$user2->name})"][$month] = null; // Placeholder for manual tracking
    }

    /**
     * @param Collection<int, Transaction> $monthTransactions
     * @param Collection<int, Subcategory> $subcategories
     */
    protected function calculateCategoryTotals(int $month, Collection $monthTransactions, Collection $subcategories): void
    {
        // Subcategories to track (excluding Bills which is a category)
        $trackedSubcategories = [
            'Mortgage',
            'Groceries',
            'Eating Out',
            'Entertainment',
            'Travel',
            'Pet',
            'Gifts',
        ];

        foreach ($trackedSubcategories as $subcategoryName) {
            $subcategory = $subcategories->firstWhere('name', $subcategoryName);
            if ($subcategory) {
                $total = $monthTransactions
                    ->where('subcategory_id', $subcategory->id)
                    ->sum('debit') ?? 0;
                $this->breakdownData["Total {$subcategoryName}"][$month] = (int) $total;
            } else {
                $this->breakdownData["Total {$subcategoryName}"][$month] = 0;
            }
        }

        // Total Bills (all Bill category transactions)
        $billCategory = Category::query()->where('name', 'Bill')->first();
        if ($billCategory) {
            $totalBills = $monthTransactions
                ->where('category_id', $billCategory->id)
                ->sum('debit') ?? 0;
            $this->breakdownData['Total Bills'][$month] = (int) $totalBills;
        } else {
            $this->breakdownData['Total Bills'][$month] = 0;
        }
    }

    /**
     * Calculate per-user contributions and slices for each category.
     *
     * @param Collection<int, Transaction> $monthTransactions
     * @param Collection<int, Subcategory> $subcategories
     * @param array<int, float> $splitRatios
     */
    protected function calculateUserCategoryContributions(
        int $month,
        Collection $monthTransactions,
        Collection $subcategories,
        array $splitRatios
    ): void {
        $billCategory = Category::query()->where('name', 'Bill')->first();

        foreach ($this->users as $user) {
            $userTransactions = $monthTransactions->where('user_id', $user->id);

            foreach ($this->trackedCategories as $categoryName) {
                if ($categoryName === 'Bills') {
                    // Bills is a category, not a subcategory
                    $userContribution = $billCategory
                        ? $userTransactions->where('category_id', $billCategory->id)->sum('debit') ?? 0
                        : 0;
                    $totalForCategory = $this->breakdownData['Total Bills'][$month] ?? 0;
                } else {
                    // These are subcategories
                    $subcategory = $subcategories->firstWhere('name', $categoryName);
                    $userContribution = $subcategory
                        ? $userTransactions->where('subcategory_id', $subcategory->id)->sum('debit') ?? 0
                        : 0;
                    $totalForCategory = $this->breakdownData["Total {$categoryName}"][$month] ?? 0;
                }

                // In-month contribution (actual amount paid by user)
                $this->breakdownData["{$user->name} In-month {$categoryName} Contribution"][$month] = (int) $userContribution;

                // Slice (percentage of total category spending by this user)
                $slice = $totalForCategory > 0
                    ? ($userContribution / $totalForCategory) * 100
                    : 0;
                $this->breakdownData["{$user->name} {$categoryName} Slice"][$month] = $slice;
            }
        }
    }

    /**
     * @return array<int, array{key: string, type: string, indent: int}>
     */
    public function getRowOrder(): array
    {
        $rows = [];

        // User income rows
        foreach ($this->users as $user) {
            $rows[] = ['key' => "{$user->name} Income", 'type' => 'money', 'indent' => 0];
        }

        // User-specific rows
        foreach ($this->users as $user) {
            $rows[] = ['key' => "{$user->name} Expected Total", 'type' => 'money', 'indent' => 0];
            $rows[] = ['key' => "{$user->name} Already Paid", 'type' => 'money', 'indent' => 0];
        }

        // Overage/Owed rows (for two users)
        $userArray = $this->users->values()->all();
        if (count($userArray) >= 2) {
            $rows[] = ['key' => "Overage/Owed to {$userArray[1]->name}", 'type' => 'money', 'indent' => 0];
            $rows[] = ['key' => "Paid/Received ({$userArray[0]->name})", 'type' => 'placeholder', 'indent' => 0];
            $rows[] = ['key' => "Overage/Owed to {$userArray[0]->name}", 'type' => 'money', 'indent' => 0];
            $rows[] = ['key' => "Paid/Received ({$userArray[1]->name})", 'type' => 'placeholder', 'indent' => 0];
        }

        // Category totals
        foreach ($this->trackedCategories as $category) {
            $rows[] = ['key' => "Total {$category}", 'type' => 'money', 'indent' => 0];
        }

        // Summary rows
        $rows[] = ['key' => 'Validated?', 'type' => 'placeholder', 'indent' => 0];
        $rows[] = ['key' => 'Total Expenditures', 'type' => 'money', 'indent' => 0];

        // Percentage Slice section per user
        foreach ($this->users as $user) {
            $rows[] = ['key' => "{$user->name} Percentage Slice", 'type' => 'percentage', 'indent' => 0];

            foreach ($this->trackedCategories as $category) {
                $rows[] = ['key' => "{$user->name} In-month {$category} Contribution", 'type' => 'money', 'indent' => 1];
                $rows[] = ['key' => "{$user->name} {$category} Slice", 'type' => 'percentage', 'indent' => 1];
            }
        }

        return $rows;
    }

    public function formatMoney(int|float|null $cents): string
    {
        if ($cents === null) {
            return '-';
        }

        return '$' . number_format($cents / 100, 2);
    }

    public function formatPercentage(int|float|null $value): string
    {
        if ($value === null) {
            return '-';
        }

        return number_format($value, 1) . '%';
    }

    public function formatValue(int|float|null $value, string $type): string
    {
        return match ($type) {
            'money' => $this->formatMoney($value),
            'percentage' => $this->formatPercentage($value),
            'placeholder' => '-',
            default => (string) ($value ?? '-'),
        };
    }

    public function render()
    {
        return view('livewire.breakdown-table');
    }
}
