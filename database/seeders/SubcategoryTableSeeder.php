<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->get()->keyBy('name');
        collect([
            ['name' => 'Mortgage', 'category' => 'Bill'],
            ['name' => 'Internet', 'category' => 'Bill'],
            ['name' => 'Electricity', 'category' => 'Bill'],
            ['name' => 'Water', 'category' => 'Bill'],
            ['name' => 'Music Service', 'category' => 'Bill'],
            ['name' => 'Gas', 'category' => 'Expense'],
            ['name' => 'Pest Control', 'category' => 'Bill'],
            ['name' => 'HOA', 'category' => 'Bill'],
            ['name' => 'Password Manager', 'category' => 'Bill'],
            ['name' => 'Synchrony', 'category' => 'Bill'],
            ['name' => 'Groceries', 'category' => 'Expense'],
            ['name' => 'Eating Out', 'category' => 'Expense'],
            ['name' => 'Pet', 'category' => 'Expense'],
            ['name' => 'Travel', 'category' => 'Expense'],
            ['name' => 'Gifts', 'category' => 'Expense'],
            ['name' => 'Entertainment', 'category' => 'Expense'],
            ['name' => 'Full-time Job', 'category' => 'Income'],
            ['name' => 'Part-time Job', 'category' => 'Income'],
            ['name' => 'Home Security', 'category' => 'Bill'],
            ['name' => 'Utilities', 'category' => 'Bill'],
            ['name' => 'Pet Insurance Reimbursement', 'category' => 'Income'],
        ])->each(function (array $category) use ($categories) {
                /* dd($categories->get($category['category']), __METHOD__ . ':' . __LINE__); */
                Subcategory::factory()->create([
                    'name' => $category['name'],
                    'category_id' => $categories->get($category['category'])->id,
                ]);
            });

    }
}
