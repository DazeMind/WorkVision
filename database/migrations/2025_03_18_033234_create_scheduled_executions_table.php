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
        Schema::create('scheduled_executions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_record_id');
            $table->unsignedBigInteger('record_id'); //Registro generado en 'records'
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_executions');
    }
};
