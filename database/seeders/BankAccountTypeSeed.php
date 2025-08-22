<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankAccountTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bank_account_types')->insert([
            ['name' => 'Cuenta Corriente', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuenta Vista', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vale Vista', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
