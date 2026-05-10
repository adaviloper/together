<?php

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
            $table->foreignUuid('organization_id')->constrained();
            $table->foreignUuid('category_id')->nullable()->constrained();
            $table->foreignUuid('subcategory_id')->nullable()->constrained();
            $table->foreignUuid('user_id')->constrained();
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
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('transactions');
    }
};
