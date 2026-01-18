<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TransactionTableSeeder extends Seeder
{
    /** @var Collection $categories */
    protected $categories;

    /** @var User $user1 */
    protected $user1;

    /** @var User $user2 */
    protected $user2;

    public function __construct()
    {
        $this->user1 = User::query()->first();
        $this->user2 = User::query()->latest()->first();

        $this->categories = Category::query()->with('subcategories')->get()->keyBy('name');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $year = 2025; */
        /* $month = 12; */
        for ($year = 2022; $year <= now()->year + 1; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                try {
                    $this->generateTransaction('Income', $this->user1, $year, $month, 2);
                    $this->generateTransaction('Income', $this->user2, $year, $month, 2);

                    $this->generateTransaction('Bill', $this->user1, $year, $month, 12);
                    $this->generateTransaction('Bill', $this->user2, $year, $month, 12);

                    $this->generateTransaction('Expense', $this->user1, $year, $month, 36);
                    $this->generateTransaction('Expense', $this->user2, $year, $month, 36);

                    /* $this->generateTransaction('Saving Goal', $this->user1, $year, $month, 2); */
                    /* $this->generateTransaction('Saving Goal', $this->user2, $year, $month, 2); */
                    /**/
                    /* $this->generateTransaction('Debt', $this->user1, $year, $month, 2); */
                    /* $this->generateTransaction('Debt', $this->user2, $year, $month, 2); */
                } catch (\Throwable $th) {
                    dd($th, __METHOD__ . ':' . __LINE__);
                }
            }
        }
    }

    public function generateTransaction(string $category, User $user, int $year, int $month, int $count = 1): void
    {
        $subcategories = $this->categories[$category]->subcategories;

        for ($i = 0; $i < $count; $i++) {
            $subcategory = $subcategories->random();
            if ($category === 'Income' && $year === 2026 && $month && 1) {
                $this->command->info("Adding transaction for [category: {$category}] {$subcategory}");
            }
            $method = rand(0, 1000) < 75 ? 'credit' : 'debit';

            try {
                Transaction::factory()
                    ->{$method}()
                    ->create([
                        'category_id' => $subcategory?->category_id,
                        'subcategory_id' => $subcategory?->id,
                        'user_id' => $user->id,
                        'transaction_date' => now()->year($year)->month($month)->format('Y-m-d'),
                        'posted_date' => now()->year($year)->month($month)->format('Y-m-d'),
                    ]);
            } catch (\Throwable $th) {
                dd($th, __METHOD__ . ':' . __LINE__);
            }
        }
    }
}
