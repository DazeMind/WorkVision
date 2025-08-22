<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Activo','description' => 'actvo'],
            ['name' => 'Inactivo','description' => 'actvo'],
            ['name' => 'Completo','description' => 'actvo'],
            ['name' => 'Incompleto','description' => 'actvo'],
            ['name' => 'En Proceso','description' => 'actvo'],
            ['name' => 'Pendiente','description' => 'actvo'],
            ['name' => 'Aprobado','description' => 'actvo'],
            ['name' => 'Rechazado','description' => 'actvo'],
            ['name' => 'Pendiente de revisión','description' => 'actvo'],
            ['name' => 'Finalizado','description' => 'actvo'],
            ['name' => 'Cancelado','description' => 'actvo'],
            ['name' => 'Suspendido','description' => 'actvo'],
            ['name' => 'Vencido','description' => 'actvo'],
            ['name' => 'Eliminado','description' => 'actvo'],
        ];
        DB::table('states')->insert($states);
    }
}
