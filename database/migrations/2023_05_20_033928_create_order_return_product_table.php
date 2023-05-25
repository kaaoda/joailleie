<?php

use App\Models\OrderReturn;
use App\Models\Product;
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
        Schema::create('order_return_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderReturn::class)->constrained("order_returns")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Product::class)->constrained("products")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedDecimal("price", 20);
            $table->unsignedDecimal("gram_price")->nullable();
            $table->unsignedDecimal("sale_manufacturing_value")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_return_product');
    }
};
