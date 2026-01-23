<?php

namespace App\SplitStrategies;

class IncomeSplitStrategy implements SplitStrategyInterface
{
    public static function key(): string
    {
        return 'income';
    }

    public function __toString(): string
    {
        return self::key();
    }

    public function label(): string
    {
        return 'Income-based';
    }

    public function description(): string
    {
        return 'Split based on each person\'s income contribution for the month';
    }

    public function calculateRatio(int $userId, array $incomeRatios, array $userIds, ?float $fixedRatio = null): float
    {
        // Use the income ratio for this user, or fall back to equal split
        return $incomeRatios[$userId] ?? (1 / count($userIds));
    }
}
