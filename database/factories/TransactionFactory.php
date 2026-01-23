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
            'transaction_date' => $this->faker->date('Y-m-d'),
            'amount' => $this->faker->numberBetween(1000, 99999),
            'description' => $this->faker->words(2),
            'subcategory_id' => Subcategory::factory(),
            'category_id' => Category::factory(),
            'user_id' => fn () => User::factory()->create()->id,
        ];
    }
}
