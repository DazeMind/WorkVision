<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            ['id_client' => 1,'name' => 'CoDaze', 'email' => 'danny.darwin.dzf@gmail.com', 'rut' => '20458806-6','phone' => 964467685,'address' => 'los aromos 3445','creation_date' => '2020-01-01','id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_client' => 2,'name' => 'ChoapaConstruccion', 'email' => 'jztecnico@gmail.com', 'rut' => '13876176-2','phone' => 964467686,'address' => 'salamanca','creation_date' => '2009-01-01','id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_client' => 2,'name' => 'Jorge Zepeda', 'email' => 'jztecnico@gmail.com', 'rut' => '13876176-2','phone' => 964467686,'address' => 'la serena','creation_date' => '2012-01-01','id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
