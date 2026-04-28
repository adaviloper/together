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
            $table->uuid('id')->primary();
            $table->date('transaction_date');
            $table->string('description');
            $table->foreignUuid('category_id')->nullable();
            $table->foreignUuid('subcategory_id')->nullable();
            $table->foreignUuid('user_id');
            $table->bigInteger('amount')->nullable();
            $table->boolean('hidden')->default(false);
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
            $table->dropForeign(['category_id', 'subcategory_id']);
        });
        Schema::dropIfExists('transactions');
    }
};
