<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskPrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [            
            ['name' => 'Baja','color' => 'blue'],
            ['name' => 'Media','color' => 'blue'],
            ['name' => 'Alta','color' => 'yellow'],
            ['name' => 'Urgente','color' => 'red'],
            ['name' => 'Crítica','color' => 'red'],
        ];
        DB::table('task_priorities')->insert($states);
    
    }
}
