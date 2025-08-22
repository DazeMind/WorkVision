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
        Schema::create('worker_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_company");
            $table->unsignedBigInteger("id_worker");
            $table->unsignedBigInteger("id_state");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_companies');
    }
};
