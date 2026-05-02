<?php

namespace App\Filament\Resources\Categories\Widgets;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class MonthlyIncomePie extends ChartWidget
{
    protected ?string $heading = "Where's my money going?";

    public ?int $month = null;

    public ?int $year = null;

    public ?array $categories = [];

    protected function getData(): array
    {
        $year = $this->year ?? now()->year;
        $month = $this->month ?? now()->month;
        $start = now()->year($year)->month($month)->startOfMonth();
        $end = $start->clone()->endOfMonth();
        $userIds = User::query()->where([
            'organization_id' => auth()->user()->organization_id,
        ])->get()->pluck('id');

        return $this->getCategoryLevelData($userIds, $start, $end);
    }

    protected function getCategoryLevelData(Collection $userIds, Carbon $start, Carbon $end): array
    {
        $categories = Category::query()->whereIn('name', $this->categories)->pluck('id');

        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $transactions = Transaction::query()
            ->whereIn('category_id', $categories->toArray())
            ->whereIn('user_id', $userIds)
            ->where('transaction_date', '>=', $start)
            ->where('transaction_date', '<=', $end)
            ->get();

        $transactions = $transactions
            ->groupBy('user.name')
            ->map
            ->sum('amount');

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
