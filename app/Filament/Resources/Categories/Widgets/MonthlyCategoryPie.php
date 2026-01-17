<?php

namespace App\Filament\Resources\Categories\Widgets;

use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Query\Builder;
use NumberFormatter;

class MonthlyCategoryPie extends ChartWidget
{
    protected ?string $heading = "Where's my money going?";

    public int $month;

    protected function getData(): array
    {
        $start = now()->subYear()->month($this->month)->startOfMonth();
        $end = $start->clone()->endOfMonth();
        $userIds = User::query()->where([
            'organization_id' => auth()->user()->organization_id,
        ])->get()->pluck('id');
        /** @var Builder $query */
        $query = Transaction::query()
            ->whereIn('user_id', $userIds)
            ->where('transaction_date', '>=', $start)
            ->where('transaction_date', '<=', $end)
            ->select(['subcategory_id', 'debit'])
            ->with('subcategory.category');
        $transactions = $query->get()
            ->groupBy('subcategory.category.name')
            ->map->sum('debit');
        $transactions->put('Uncategorized', $transactions->get(''));
        $transactions->forget('');
        /* dd([ */
        /*     'query' => $query->toRawSql(), */
        /*     'start' => $start, */
        /*     'end' => $end, */
        /*     'keys' => $transactions->keys()->toArray(), */
        /*     'values' => $transactions->values()->toArray(), */
        /* ], __METHOD__ . ':' . __LINE__); */
        return [
            'labels' => $transactions->keys()->toArray(),
            'datasets' => [
                [
                    'label' => 'Where is my money going?',
                    'data' => $transactions->values()->toArray(),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                    ],
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
