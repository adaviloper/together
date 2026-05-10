<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Organization $organization */
        $organization = Organization::query()->first();

        collect([
            ['name' => 'Bill'],
            ['name' => 'Income'],
            ['name' => 'Expense'],
            ['name' => 'Saving Goal'],
            ['name' => 'Debt'],
        ])->each(function (array $category) use ($organization) {
                $cat = Category::query()->firstOrCreate([
                    'name' => $category['name'],
                    'organization_id' => $organization->id,
                ]);
            });
    }
}
