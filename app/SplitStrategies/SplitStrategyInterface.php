<?php

namespace App\SplitStrategies;

use Stringable;

interface SplitStrategyInterface extends Stringable
{
    /**
     * Get the unique identifier for this strategy (stored in DB).
     */
    public static function key(): string;

    /**
     * Get a human-readable label for this strategy.
     */
    public function label(): string;

    /**
     * Get a description of how this strategy works.
     */
    public function description(): string;

    /**
     * Calculate the split ratio for a given user.
     *
     * @param int $userId The user ID to calculate the ratio for
     * @param array<int, float> $incomeRatios Income-based ratios keyed by user ID
     * @param array<int> $userIds All user IDs in the organization (ordered)
     * @param float|null $fixedRatio Optional fixed ratio from the subcategory
     * @return float The ratio (0.0 - 1.0) this user should pay
     */
    public function calculateRatio(int $userId, array $incomeRatios, array $userIds, ?float $fixedRatio = null): float;
}
