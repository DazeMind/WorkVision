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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("second_name");
            $table->string("first_last_name");
            $table->string("second_last_name");
            $table->string("rut");
            $table->string("email");
            $table->string("phone");
            $table->string("address");
            $table->date("date_of_birth");
            $table->string("afp");
            $table->string("health_plan");
            $table->string("password");
            $table->unsignedBigInteger("id_state");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
