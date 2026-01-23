<?php

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('description');
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(Subcategory::class)->nullable();
            $table->foreignIdFor(User::class);
            $table->bigInteger('amount')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeignIdFor(Category::class);
            $table->dropForeignIdFor(Subcategory::class);
        });
        Schema::dropIfExists('transactions');
    }
};
