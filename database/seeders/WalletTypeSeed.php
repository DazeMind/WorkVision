<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletTypeSeed extends Seeder
{
    public function run(): void
    {
        DB::table('wallet_types')->insert([
            ['name' => 'General', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Efectivo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tarjeta de debito', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tarjeta de credito', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuenta actual', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuenta de ahorro', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bonus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Seguro', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Inversión', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Préstamo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hipoteca', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuenta con sobre giro', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuenta para proyecto', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}