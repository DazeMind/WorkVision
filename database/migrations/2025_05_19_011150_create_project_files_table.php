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
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_project');
            $table->text('file_name');
            $table->text('file_path');
            $table->text('file_type'); //('contrato', 'plano', 'imagen', 'presupuesto', 'otro') 
            $table->text('uploaded_by'); //id user
            $table->text('notes');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_files');
    }
};
