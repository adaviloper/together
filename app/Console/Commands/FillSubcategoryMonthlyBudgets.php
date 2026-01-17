<?php

namespace App\Console\Commands;

use App\Models\Subcategory;
use Illuminate\Console\Command;

class FillSubcategoryMonthlyBudgets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-subcategory-monthly-budgets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subcategories = Subcategory::query()->where('monthly_budgeted', 0)->get();
        $bar = $this->output->createProgressBar(count($subcategories));
        $bar->start();

        foreach ($subcategories as $subcategory) {
            $budgeted = rand(200, 3000);
            $subcategory->update([
                'monthly_budgeted' => $budgeted,
            ]);
            $this->info("Updating [{$subcategory->name}] monthly_budgeted to {$budgeted}.");
            $bar->advance();
        }

        $bar->finish();
    }
}
