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
        Schema::create('supply_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("supplier_id")->constrained("suppliers")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("product_division_id")->constrained("product_divisions")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedDecimal("ore_weight_in_grams");
            $table->unsignedDecimal("cost_per_gram");
            $table->enum("cost_type", ['GOLD', 'MONEY']);
            $table->foreignId("currency_id")->nullable()->constrained("currencies");
            $table->unsignedDecimal("paid_amount");
            $table->enum("transaction_scope", ['ORE', 'PRODUCTS']);
            $table->unsignedInteger("products_number")->nullable();
            $table->text("notices")->nullable();
            $table->date("date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_transactions');
    }
};
