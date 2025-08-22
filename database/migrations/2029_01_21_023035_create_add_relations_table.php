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
        Schema::table('workers', function (Blueprint $table) {
            $table->foreign('id_state')->references('id')->on('worker_states')->onDelete('cascade');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('id_task_priority')->references('id')->on('task_priorities')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('tasks_states')->onDelete('cascade');
            $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('id_worker_project')->references('id')->on('workers_projects')->onDelete('cascade');
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('id_worker')->references('id')->on('workers')->onDelete('cascade');
            $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('companies_projects', function (Blueprint $table) {
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('worker_companies', function (Blueprint $table) {
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('id_worker')->references('id')->on('workers')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('workers_projects', function (Blueprint $table) {
            $table->foreign('id_worker')->references('id')->on('workers')->onDelete('cascade');
            $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');
        });
        Schema::table('wallets', function (Blueprint $table) {
            $table->foreign('id_type')->references('id')->on('wallet_types')->onDelete('cascade');
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onDelete('cascade');

        });
        Schema::table('records', function (Blueprint $table) {
            $table->foreign('id_wallet')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('bank_data', function (Blueprint $table) {
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_bank')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('id_bank_account_type')->references('id')->on('bank_account_types')->onDelete('cascade');
        });
        
        //INVENTARIOS 
        Schema::table('stock_for_products', function (Blueprint $table) {
            $table->foreign('id_product_service')->references('id')->on('products_services')->onDelete('cascade');
            $table->foreign('id_material')->references('id')->on('materials')->onDelete('cascade');
        });
        Schema::table('inventory_snapshots', function (Blueprint $table) {
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
        });
        Schema::table('inventory_snapshot_items', function (Blueprint $table) {
            $table->foreign('id_product_service')->references('id')->on('products_services')->onDelete('cascade');
            $table->foreign('snapshot_id')->references('id')->on('inventory_snapshots')->onDelete('cascade');
            $table->foreign('id_material')->references('id')->on('materials')->onDelete('cascade');
        });
        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
        });
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id')->on('suppliers')->onDelete('cascade');
        });
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->foreign('id_purchase_order')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('id_product_service')->references('id')->on('products_services')->onDelete('cascade');
        });
        Schema::table('product_compositions', function (Blueprint $table) {
            $table->foreign('id_product_service')->references('id')->on('products_services')->onDelete('cascade');
        });
        Schema::table('composition_items', function (Blueprint $table) {
            $table->foreign('id_product_composition')->references('id')->on('product_compositions')->onDelete('cascade');
        });
        Schema::table('production_orders', function (Blueprint $table) {
            $table->foreign('id_product_service')->references('id')->on('products_services')->onDelete('cascade');
            $table->foreign('id_composition')->references('id')->on('composition_items')->onDelete('cascade');
        });
        Schema::table('production_consumptions', function (Blueprint $table) {
            $table->foreign('id_production_order')->references('id')->on('production_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_relations');
    }
};
