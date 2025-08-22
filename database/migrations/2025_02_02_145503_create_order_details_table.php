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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_product');
            $table->integer('quantity');
            $table->integer('discount')->nullable();
            $table->integer('price');
            $table->integer('total')->nullable();
            $table->integer('tax')->nullable();
            $table->unsignedBigInteger('id_state');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products_services')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('order_states')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders_detail');
    }
};
