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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->morphs("invoicable"); //new order or return
            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete()->cascadeOnUpdate();
            $table->string("invoice_number");
            $table->dateTime("date");
            $table->unsignedDecimal("paid_amount");
            $table->boolean("completed")->default(TRUE);
            $table->date("next_due_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
