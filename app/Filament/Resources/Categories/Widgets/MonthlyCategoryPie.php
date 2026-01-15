<?php

namespace App\Filament\Resources\Categories\Widgets;

use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use NumberFormatter;

class MonthlyCategoryPie extends ChartWidget
{
    protected ?string $heading = 'Monthly Category Pie';

    protected function getData(): array
    {
        $userIds = User::query()->where([
            'organization_id' => auth()->user()->organization_id,
        ])->get()->pluck('id');
        $transactions = Transaction::query()
            ->whereIn('user_id', $userIds)
            ->select(['subcategory_id', 'debit'])
            ->with('subcategory.category')
            ->get()
            ->groupBy('subcategory.category.name')
            ->map->sum('debit');
        /* dd([ */
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
