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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('action');
            $table->string('table_name');
            $table->unsignedBigInteger('id_record');
            $table->string('detail');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_record')->references('id')->on('records')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
