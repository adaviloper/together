<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        /** @var User $user1 */
        $user1 = User::factory()->create([
            'name' => config('dev.users.primary'),
            'email' => config('dev.users.primary') . '@together.com',
            'password' => Hash::make('password'),
            'organization_id' => Organization::query()->first(),
        ]);
        /** @var User $user2 */
        $user2 = User::factory()->create([
            'name' => config('dev.users.secondary'),
            'email' => config('dev.users.secondary') . '@together.com',
            'password' => Hash::make('password'),
            'organization_id' => $user1->organization_id,
        ]);

        $this->call(CategoryTableSeeder::class);
        $this->call(SubcategoryTableSeeder::class);
        /* $this->call(ImportMappingTableSeeder::class); */
        /* $this->call(TransactionTableSeeder::class); */
    }
}
