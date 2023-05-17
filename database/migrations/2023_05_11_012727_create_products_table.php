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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_category_id")->constrained("product_categories")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("branch_id")->constrained("branches")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("supplier_id")->constrained("suppliers")->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum("kerat", ['18','21','24']);
            $table->unsignedDecimal("weight");
            $table->unsignedDecimal("cost")->default(0);
            $table->unsignedDecimal("manufacturing_value")->default(0);
            $table->unsignedDecimal("lowest_manufacturing_value_for_sale")->default(0);
            $table->string("thumbnail_path")->nullable();
            $table->string("barcode", 14);
            $table->boolean("quarantined")->default(FALSE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
