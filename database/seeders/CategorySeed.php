<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            // Gastos (type => 1)
            ['name' => 'Ingresos por ventas', 'color' => 'green', 'icon' => 'carrito', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Otros Ingresos', 'color' => 'gray', 'icon' => 'billetes', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nueva financiación', 'color' => 'lightblue', 'icon' => 'billete y flecha', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Inversión de socios', 'color' => 'gold', 'icon' => 'maletín', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intereses ganados', 'color' => 'green', 'icon' => 'moneda', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Devoluciones de impuestos', 'color' => 'blue', 'icon' => 'documento', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Subvenciones gubernamentales', 'color' => 'teal', 'icon' => 'edificio', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Donaciones recibidas', 'color' => 'pink', 'icon' => 'corazón', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Regalías', 'color' => 'orange', 'icon' => 'diamante', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Venta de activos', 'color' => 'green', 'icon' => 'caja y flecha', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cobro de cuentas pendientes', 'color' => 'cyan', 'icon' => 'documento y moneda', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alquileres recibidos', 'color' => 'purple', 'icon' => 'casa y llave', 'id_state' => 1, 'type' => 1, 'created_at' => now(), 'updated_at' => now()],

             // Gastos (type => 2)
            ['name' => 'Espacio & Equipo', 'color' => 'purple', 'icon' => 'market', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nómina & Gastos', 'color' => 'blue', 'icon' => 'people', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Compra de inventario', 'color' => 'lightblue', 'icon' => 'home', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Servicios operativos', 'color' => 'yellow', 'icon' => 'config', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Otros cargos y factura', 'color' => 'grey', 'icon' => 'billete y flecha arriba', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelación de préstamo', 'color' => 'red', 'icon' => 'money y reloj arena', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Compra de activos', 'color' => 'red', 'icon' => 'carro y flecha', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gastos de marketing', 'color' => 'orange', 'icon' => 'altavoz', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gastos legales', 'color' => 'brown', 'icon' => 'balanza', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Seguros', 'color' => 'cyan', 'icon' => 'escudo', 'id_state' => 1, 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
