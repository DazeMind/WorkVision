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
        Schema::create('products_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_company');
            $table->string('name');
            $table->string('description');
            $table->integer('sale_price');//precio de venta
            $table->integer('purchase_price');//precio de compra o gasto
            $table->string('SKU');//identificador
            $table->string('type');//Tipo de producto o servicio (por ejemplo, "producto" o "servicio").
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('width')->nullable();
            $table->integer('length')->nullable();
            $table->boolean('is_fabricable')->nullable(); //confeccion
            $table->boolean('is_resellable')->nullable(); //reventa
            $table->boolean('is_rentable')->nullable(); //Arriendo
            $table->string('unit_of_measure')->nullable();
            $table->string('average_cost')->nullable();
            $table->string('markup_percentage')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
        });
    }
        
    public function down(): void
    {
        Schema::dropIfExists('products_services');
    }
};
