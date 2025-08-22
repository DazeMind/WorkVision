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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_consumer'); //id cliente
            $table->unsignedBigInteger('id_shop_order'); //id company
            $table->integer('sale_price')->nullable(); // Precio de venta total antes de descuentos
            $table->integer('discounts')->nullable(); // Descuentos aplicados
            $table->integer('total_amount')->nullable(); // Total con descuentos incluidos
            $table->datetime('payment_date')->nullable();
            $table->integer('amount_paid')->nullable(); //abono
            $table->text('note')->nullable(); 
            $table->datetime('order_date');
            $table->unsignedBigInteger('id_invoice')->nullable();
            $table->unsignedBigInteger('id_state');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_shop_order')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('order_states')->onDelete('cascade');
            $table->foreign('id_consumer')->references('id')->on('consumers')->onDelete('cascade');
            // $table->foreign('id_invoice')->references('id')->on('invoices')->onDelete('cascade');
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
