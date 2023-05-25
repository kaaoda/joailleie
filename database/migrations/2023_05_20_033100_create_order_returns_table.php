<?php

use App\Models\Order;
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
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained("orders")->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal("diff_amount", 20, 2)->default(0);
            $table->decimal("total", 20, 2);
            $table->unsignedDecimal("total_weight");
            $table->enum("type", ['RETURN', 'EXCHANGE']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_returns');
    }
};
