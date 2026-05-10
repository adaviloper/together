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
        $this->users = User::query()->get();

        $this->categories = Category::query()->with('subcategories')->get()->keyBy('name');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $year = 2025; */
        /* $month = 12; */
        foreach ($this->users as $user) {
            for ($year = 2022; $year <= now()->year + 1; $year++) {
                for ($month = 1; $month <= 12; $month++) {
                    try {
                        $this->generateTransaction('Income', $user, $year, $month, 2);

                        $this->generateTransaction('Bill', $user, $year, $month, 12);

                        $this->generateTransaction('Expense', $user, $year, $month, 36);

                        /* $this->generateTransaction('Saving Goal', $user, $year, $month, 2); */

                        /* $this->generateTransaction('Debt', $user, $year, $month, 2); */
                    } catch (\Throwable $th) {
                        dd($th, __METHOD__ . ':' . __LINE__);
                    }
                }
            }
        }
    }

    public function generateTransaction(string $category, User $user, int $year, int $month, int $count = 1): void
    {
        $subcategories = $this->categories[$category]->subcategories;
        /* dd($subcategories->pluck('name'), __METHOD__ . ':' . __LINE__); */

        for ($i = 0; $i < $count; $i++) {
            $subcategory = $subcategories->random();
            $method = $this->getMethod($category);

            try {
                Transaction::factory()
                    ->create([
                        'category_id' => $subcategory?->category_id,
                        'subcategory_id' => $subcategory?->id,
                        'user_id' => $user->id,
                        'transaction_date' => now()->year($year)->month($month)->format('Y-m-d'),
                    ]);
            } catch (\Throwable $th) {
                dd($th, __METHOD__ . ':' . __LINE__);
            }
        }
    }

    private function getMethod(string $category): string
    {
        if ($category === 'Income') {
            return 'credit';
        }
        return rand(0, 1000) < 75 ? 'credit' : 'debit';
    }
}
