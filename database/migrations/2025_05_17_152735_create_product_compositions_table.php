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
        Schema::create('product_compositions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product_service');
            $table->string('version');
            $table->integer('yield_quantity');
            $table->string('unit_of_yield');
            $table->string('description');
            $table->string('estimated_cost');
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_compositions');
    }
};
