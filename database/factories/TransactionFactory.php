<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'card_number' => $this->faker->numerify('****'),
            'category_id' => Category::factory(),
            'credit' => $this->faker->numberBetween(1000, 99999),
            'debit' => $this->faker->numberBetween(1000, 99999),
            'description' => $this->faker->word(),
            'posted_date' => $this->faker->date('Y-m-d'),
            'subcategory_id' => Subcategory::factory(),
            'transaction_date' => $this->faker->date('Y-m-d'),
            'user_id' => fn () => User::factory()->create()->id,
        ];
    }

    public function debit(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'credit' => null,
            ];
        });
    }

    public function credit(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'debit' => null,
            ];
        });
    }
}
