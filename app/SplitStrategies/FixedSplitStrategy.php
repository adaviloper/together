<?php

namespace App\SplitStrategies;

class FixedSplitStrategy implements SplitStrategyInterface
{
    public static function key(): string
    {
        return 'fixed';
    }

    public function __toString(): string
    {
        return self::key();
    }

    public function label(): string
    {
        return 'Fixed ratio';
    }

    public function description(): string
    {
        return 'Use a custom fixed split ratio';
    }

    public function calculateRatio(int $userId, array $incomeRatios, array $userIds, ?float $fixedRatio = null): float
    {
        // If no fixed ratio is set, fall back to equal split
        if ($fixedRatio === null) {
            return 1 / count($userIds);
        }

        // First user in the array gets the fixed ratio
        $firstUserId = $userIds[0] ?? null;

        if ($userId === $firstUserId) {
            return $fixedRatio;
        }

        // Remaining users split the remainder equally
        $remainingUsers = count($userIds) - 1;

        if ($remainingUsers <= 0) {
            return 1 - $fixedRatio;
        }

        return (1 - $fixedRatio) / $remainingUsers;
    }
}
