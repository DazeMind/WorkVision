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
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order'); // Relación con orders
            $table->integer('shiping_price')->nullable(); // Precio de envío
            $table->double('weight')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->double('length')->nullable();
            $table->string('destination_address')->nullable();
            $table->string('destination_comuna')->nullable();
            $table->string('destination_region')->nullable();
            $table->string('origin')->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->unsignedBigInteger('id_courier')->nullable(); //persona que ahce el delibery
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade');
            // $table->foreign('id_courier')->references('id')->on('couriers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_deliveries');
    }
};
