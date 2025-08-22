<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeed extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->insert([
            ['id_user' => 3,'id_bank_account' => 1, 'full_name' => 'Danny Darwin Zepeda Ferrada', 'rut' => '20458806-6','address' => 'Los aromos 3445 , la serena','phone' => 964467685,'email' => 'danny.darwin.dzf@gmail.com','membership' => 'Full Enterprise','id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 4,'id_bank_account' => 1, 'full_name' => 'Jorge Marcelo Zepeda Cabrera', 'rut' => '13876176-2','address' => 'pasaje tucapel, salamanca','phone' => 964467686,'email' => 'jztecnico@gmail.com','membership' => 'Full Enterprise','id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}