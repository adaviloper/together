<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'Bill'],
            ['name' => 'Income'],
            ['name' => 'Expense'],
            ['name' => 'Saving Goal'],
            ['name' => 'Debt'],
        ])->each(fn (array $category) =>
        Category::factory()->create($category));
    }
}
