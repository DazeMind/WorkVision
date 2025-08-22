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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_client");
            $table->string("name");
            $table->string("email");
            $table->string("rut")->nullable();
            $table->integer("phone");
            $table->string("address");
            $table->json("giro")->nullable(); //el campo tendra registros de esta forma ["Construccion", "Venta de prodicts","etc"]
            $table->string("type")->nullable(); // identificador "service" , "products" , "service & products"
            $table->date("creation_date");
            $table->unsignedBigInteger("id_state");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
