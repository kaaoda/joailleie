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
        Schema::create('restoration_request_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("restoration_request_id")->constrained("restoration_requests")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("employee_name");
            $table->text("description");
            $table->date("happened_at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restoration_request_transactions');
    }
};
