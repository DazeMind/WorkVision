<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Disponible','description' => 'El colaborador esta Activo y Disponible para ser asignado'],
            ['name' => 'En uso','description' => 'El Colaborador Esta asignado a uno o mas proyectos'],
            ['name' => 'Inactivo','description' => 'El Colaborador no esta disponible'],
            ['name' => 'En Proceso','description' => 'El Colaborador esta en proceso de admision'],
            ['name' => 'Incompleto','description' => 'El Colaborador tiene datos incompletos'],
            ['name' => 'Completo','description' => 'El Colaborador esta siendo revisado para pasar a Disponible'],
            ['name' => 'Pendiente','description' => 'El Colaborador esta siendo revisado para pasar a Disponible'],
            ['name' => 'Suspendido','description' => 'El Colaborador ha cometido una infraccion'],
            ['name' => 'Vencido','description' => 'El Colaborador tiene documentos vencidos'],
            ['name' => 'Eliminado','description' => 'Eliminado'],
        ];
        DB::table('worker_states')->insert($states);
    }
}
