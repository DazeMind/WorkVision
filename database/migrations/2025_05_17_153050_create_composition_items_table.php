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
        Schema::create('composition_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product_composition');
            $table->integer('id_material')->nullable();
            $table->integer('quantity_required');
            $table->integer('unit_cost_snapshot');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composition_items');
    }
};
