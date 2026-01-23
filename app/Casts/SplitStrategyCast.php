<?php

namespace App\Casts;

use App\SplitStrategies\EqualSplitStrategy;
use App\SplitStrategies\FixedSplitStrategy;
use App\SplitStrategies\IncomeSplitStrategy;
use App\SplitStrategies\SplitStrategyInterface;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * @implements CastsAttributes<SplitStrategyInterface, SplitStrategyInterface|string>
 */
class SplitStrategyCast implements CastsAttributes
{
    /**
     * Map of strategy keys to their class names.
     *
     * @var array<string, class-string<SplitStrategyInterface>>
     */
    protected static array $strategies = [
        'income' => IncomeSplitStrategy::class,
        'equal' => EqualSplitStrategy::class,
        'fixed' => FixedSplitStrategy::class,
    ];

    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): SplitStrategyInterface
    {
        $strategyKey = $value ?? 'income';

        if (!isset(self::$strategies[$strategyKey])) {
            // Default to income strategy if unknown
            return new IncomeSplitStrategy();
        }

        return new self::$strategies[$strategyKey]();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if ($value instanceof SplitStrategyInterface) {
            return $value::key();
        }

        if (is_string($value) && isset(self::$strategies[$value])) {
            return $value;
        }

        throw new InvalidArgumentException(
            'The given value is not a valid split strategy. Valid options: ' . implode(', ', array_keys(self::$strategies))
        );
    }

    /**
     * Register a new strategy class.
     *
     * @param class-string<SplitStrategyInterface> $strategyClass
     */
    public static function register(string $strategyClass): void
    {
        self::$strategies[$strategyClass::key()] = $strategyClass;
    }

    /**
     * Get all registered strategies.
     *
     * @return array<string, class-string<SplitStrategyInterface>>
     */
    public static function strategies(): array
    {
        return self::$strategies;
    }

    /**
     * Get all strategies as instances (useful for dropdowns).
     *
     * @return array<string, SplitStrategyInterface>
     */
    public static function options(): array
    {
        return array_map(
            fn (string $class) => new $class(),
            self::$strategies
        );
    }
}
