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
        Schema::create('companies_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_company');
            $table->unsignedBigInteger('id_project');
            $table->unsignedBigInteger('id_state');
            $table->timestamps();
            $table->softDeletes();
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('companies_projects');
    }
};
