<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [            
            ['name' => 'Finalizada','description' => 'La tarea ha sido completada'],
            ['name' => 'En Proceso','description' => 'La tarea ha comenzado a ejecutarse'],
            ['name' => 'Tarea por hacer','description' => 'La tarea aun no ha sido comenzada'],
            ['name' => 'Vencido','description' => 'La tarea excedio la fecha'],
            ['name' => 'Incompleto','description' => 'El Colaborador tiene datos incompletos'],
            ['name' => 'Eliminado','description' => 'Tarea Eliminada'],
        ];
        DB::table('tasks_states')->insert($states);
    }
}
