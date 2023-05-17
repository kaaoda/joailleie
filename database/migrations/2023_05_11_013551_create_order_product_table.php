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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained("orders")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("product_id")->constrained("products")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedDecimal("price");
            $table->unsignedDecimal("gram_price");
            $table->unsignedDecimal("sale_manufacturing_value");
            $table->unsignedSmallInteger("quantity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_order_table');
    }
};
