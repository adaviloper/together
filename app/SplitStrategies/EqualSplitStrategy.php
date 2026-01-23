<?php

namespace App\SplitStrategies;

class EqualSplitStrategy implements SplitStrategyInterface
{
    public static function key(): string
    {
        return 'equal';
    }

    public function __toString(): string
    {
        return self::key();
    }

    public function label(): string
    {
        return 'Equal (50/50)';
    }

    public function description(): string
    {
        return 'Split equally regardless of income';
    }

    public function calculateRatio(int $userId, array $incomeRatios, array $userIds, ?float $fixedRatio = null): float
    {
        return 1 / count($userIds);
    }
}
