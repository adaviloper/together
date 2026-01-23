<?php

namespace App\Models;

use App\Casts\SplitStrategyCast;
use App\SplitStrategies\SplitStrategyInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $category_id
 * @property string $name
 * @property int $monthly_budgeted
 * @property SplitStrategyInterface $split_strategy
 * @property float|null $fixed_split_ratio
 *
 * @property Category $category
 */
class Subcategory extends Model
{
    /** @use HasFactory<\Database\Factories\SubcategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'fixed_split_ratio',
        'monthly_budgeted',
        'name',
        'split_strategy',
    ];

    protected function casts(): array
    {
        return [
            'split_strategy' => SplitStrategyCast::class,
            'fixed_split_ratio' => 'float',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->orderBy('name', 'asc');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Calculate the split ratio for a given user based on this subcategory's strategy.
     *
     * @param int $userId The user ID to get the ratio for
     * @param array<int, float> $incomeRatios Income-based ratios keyed by user ID
     * @param array<int> $userIds All user IDs in the organization
     * @return float The ratio (0.0 - 1.0) this user should pay
     */
    public function getSplitRatioForUser(int $userId, array $incomeRatios, array $userIds): float
    {
        return $this->split_strategy->calculateRatio(
            $userId,
            $incomeRatios,
            $userIds,
            $this->fixed_split_ratio
        );
    }
}
