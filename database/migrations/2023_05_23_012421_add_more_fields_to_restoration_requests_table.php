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
        Schema::table('restoration_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('request_number')->after('id');
            $table->boolean('status')->default(FALSE)->after('deposit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restoration_requests', function (Blueprint $table) {
            $table->dropColumn('request_number');
            $table->dropColumn('status');
        });
    }
};
