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
        Schema::create('workers_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_worker');
            $table->unsignedBigInteger('id_project');
            $table->string('role');
            $table->unsignedBigInteger('id_state');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers_projects');
    }
};
