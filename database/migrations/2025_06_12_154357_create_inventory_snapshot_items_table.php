<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_snapshot_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('snapshot_id');
            $table->unsignedBigInteger('id_product_service')->nullable();
            $table->unsignedBigInteger('id_material')->nullable();
            $table->integer('quantity');
            $table->integer('expected_quantity');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE inventory_snapshot_items ADD CONSTRAINT chk_product_or_material_not_null CHECK (id_product_service IS NOT NULL OR id_material IS NOT NULL)');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_snapshot_items');
    }
};