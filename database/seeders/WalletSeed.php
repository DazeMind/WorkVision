<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeed extends Seeder
{
    public function run(): void
    {
        DB::table('wallets')->insert([
            ['id_client' => 1,'id_type' => 2, 'name' => 'Efectivo negocio','amount' => 50000, 'currency' => 'CLP','number_account' => NULL, 'color' => 'red', 'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_client' => 1,'id_type' => 3, 'name' => 'Debito negocio','amount' => 100000, 'currency' => 'CLP', 'number_account' => 20458806, 'color' => 'blue', 'id_state' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}