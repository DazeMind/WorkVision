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
        Schema::create('production_consumptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_production_order');
            $table->string('component_type');
            $table->integer('id_component')->nullable();
            $table->integer('quantity_used');
            $table->integer('unit_cost');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_consumptions');
    }
};
