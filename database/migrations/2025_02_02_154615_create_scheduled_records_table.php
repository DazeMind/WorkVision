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
        Schema::create('scheduled_records', function (Blueprint $table) {
            $table->id();
            $table->integer('DOTM');//dia del mes
            $table->unsignedBigInteger('id_record');
            $table->date('next_execution');
            $table->unsignedBigInteger('id_state');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('id_record')->references('id')->on('records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_records');
    }
};
