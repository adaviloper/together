<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(OrganizationTableSeeder::class);

        $organization = Organization::query()->first();

        /** @var User $user1 */
        $user1 = User::create([
            'name' => config('dev.users.primary'),
            'email' => config('dev.users.primary') . '@together.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);
        /** @var User $user2 */
        $user2 = User::create([
            'name' => config('dev.users.secondary'),
            'email' => config('dev.users.secondary') . '@together.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);

        $this->call(CategoryTableSeeder::class);
        $this->call(SubcategoryTableSeeder::class);
        /* $this->call(ImportMappingTableSeeder::class); */
        /* $this->call(TransactionTableSeeder::class); */
    }
}
