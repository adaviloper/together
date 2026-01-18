<?php

namespace App\Filament\Resources\Categories\Widgets;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class MonthlyCategoryPie extends ChartWidget
{
    protected ?string $heading = "Where's my money going?";

    public ?int $month = null;

    public ?int $year = null;

    public ?string $categoryName = null;

    protected function getData(): array
    {
        $year = $this->year ?? now()->year;
        $month = $this->month ?? now()->month;
        $start = now()->year($year)->month($month)->startOfMonth();
        $end = $start->clone()->endOfMonth();
        $userIds = User::query()->where([
            'organization_id' => auth()->user()->organization_id,
        ])->get()->pluck('id');

        if ($this->categoryName === null) {
            return $this->getCategoryLevelData($userIds, $start, $end);
        }

        return $this->getSubcategoryLevelData($userIds, $start, $end);
    }

    protected function getCategoryLevelData($userIds, $start, $end): array
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Transaction::query()
            ->whereIn('user_id', $userIds)
            ->where('transaction_date', '>=', $start)
            ->where('transaction_date', '<=', $end)
            ->select(['subcategory_id', 'debit', 'credit'])
            ->with('subcategory.category');

        $transactions = $query->get()
            ->groupBy('subcategory.category.name')
            ->map->sum(function (Transaction $transaction) {
                if (!$transaction->debit) {
                    return $transaction->credit;
                }

                return $transaction->debit;
            });

        $transactions->put('Uncategorized', $transactions->get(''));
        $transactions->forget('');

        return [
            'labels' => $transactions->keys()->toArray(),
            'datasets' => [
                [
                    'label' => 'Spending by Category',
                    'data' => $transactions->values()->toArray(),
                    'backgroundColor' => $this->getBackgroundColors(),
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }

    protected function getSubcategoryLevelData($userIds, $start, $end): array
    {
        $category = Category::query()->where('name', $this->categoryName)->first();

        if ($category === null) {
            return [
                'labels' => [],
                'datasets' => [],
            ];
        }

        $subcategoryIds = Subcategory::query()
            ->where('category_id', $category->id)
            ->pluck('id');

        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Transaction::query()
            ->whereIn('user_id', $userIds)
            ->whereIn('subcategory_id', $subcategoryIds)
            ->where('transaction_date', '>=', $start)
            ->where('transaction_date', '<=', $end)
            ->select(['subcategory_id', 'debit', 'credit'])
            ->with('subcategory');

        $transactions = $query->get()
            ->groupBy('subcategory.name')
            ->map->sum(function (Transaction $transaction) {
                if (!$transaction->debit) {
                    return $transaction->credit;
                }

                return $transaction->debit;
            });

        $transactions->put('Uncategorized', $transactions->get(''));
        $transactions->forget('');

        return [
            'labels' => $transactions->keys()->toArray(),
            'datasets' => [
                [
                    'label' => $this->categoryName . ' Breakdown',
                    'data' => $transactions->values()->toArray(),
                    'backgroundColor' => $this->getBackgroundColors(),
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }

    protected function getBackgroundColors(): array
    {
        return [
            config('colors.danger.500'),
            config('colors.warning.500'),
            config('colors.success.500'),
            config('colors.info.500'),
            config('colors.primary.500'),
            config('colors.gray.500'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
