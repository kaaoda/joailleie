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
        Schema::create('product_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("branch_id")->constrained("branches")->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean("approved")->default(FALSE);
            $table->text("notices");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transfer_requests');
    }
};
