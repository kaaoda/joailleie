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
        Schema::create('diamonds', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("number_of_stones");
            $table->unsignedFloat("weight");
            $table->enum("clarity", [
                "F",
                "IF",
                "VVS1",
                "VVS2",
                "VS1",
                "VS2",
                "SI1",
                "SI2",
                "I1",
                "I2",
                "I3",
            ]);
            $table->char("color", 1);
            $table->enum("shape", [
                "Asscher",
                "Bezel Corner",
                "Heart",
                "Round Brilliant",
                "Crushed Ice",
                "Radiant",
                "Marquise",
                "Emerald",
                "Pear",
                "Oval",
                "Lozenge",
                "Baguette",
                "Tapered Baguette",
                "Trilliant",
                "Rose"
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diamonds');
    }
};
