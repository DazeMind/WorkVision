<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_categories')->insert([
            ['name' => 'Productos','color' => 'green', 'icon' => 'carrito','id_category' => 1, 'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Servicios','color' => 'green', 'icon' => 'carrito','id_category' => 1, 'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingresos diversos','color' => 'gray', 'icon' => 'billetes', 'id_category' => 2,'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intereses, ganancias de capital','color' => 'gray', 'icon' => 'billetes', 'id_category' => 2,'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Reembolso impuestos','color' => 'gray', 'icon' => 'billetes', 'id_category' => 2,'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
