<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workers')->insert([
            ['first_name' => 'Danny', 'second_name' => 'Darwin','first_last_name' => 'Zepeda','second_last_name' => 'Ferrada','rut' => '20458806-6','email' => 'danny.darwin.dzf@gmail.com', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
            
            
            // 'phone' => $formData['phone'],
            // 'address' => $formData['address'],
            // 'date_of_birth' => $formData['dob'],
            // 'afp' => $formData['afp'],
            // 'health_plan'=> $formData['health_plan'],
            // 'password' => bcrypt($password), // Encripta la contraseña
            // 'id_state' => 5, // Estado en proceso