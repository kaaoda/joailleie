<?php

use App\Models\Currency;
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
        Schema::table('diamonds', function (Blueprint $table) {
            $table->unsignedDecimal("price", 20)->after("shape");
            $table->foreignIdFor(Currency::class)->after("price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diamonds', function (Blueprint $table) {
            $table->dropColumn("price");
            $table->dropConstrainedForeignIdFor(Currency::class);
        });
    }
};
