<?php

use App\SplitStrategies\IncomeSplitStrategy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->string('split_strategy')->default(IncomeSplitStrategy::key())->after('monthly_budgeted');
            $table->decimal('fixed_split_ratio', 5, 4)->nullable()->after('split_strategy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn(['split_strategy', 'fixed_split_ratio']);
        });
    }
};
