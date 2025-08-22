<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            // Bancos Tradicionales
            ['name' => 'Banco Estado'],
            ['name' => 'Banco de Chile'],
            ['name' => 'Banco Santander'],
            ['name' => 'Scotiabank Chile'],
            ['name' => 'Banco BICE'],
            ['name' => 'Banco de Crédito e Inversiones'],
            ['name' => 'Banco Itaú'],
            ['name' => 'Banco Security'],
            ['name' => 'Banco Falabella'],
            ['name' => 'Banco BCI'],
            ['name' => 'Banco Ripley'],
            ['name' => 'Banco Consorcio'],
            ['name' => 'Banco Internacional'],
            ['name' => 'Banco Penta'],
            ['name' => 'Banco BTG Pactual'],
        
            // Marcas Comerciales
            ['name' => 'Corpbanca'],
            ['name' => 'Banco Condell'],
            ['name' => 'Banco BBVA'],
            ['name' => 'Banco Paris'],
        
            // Entidades Digitales
            ['name' => 'Match'],
            ['name' => 'Tenpo cuenta digital'],
            ['name' => 'Mercado Pago'],
            ['name' => 'Vale Vista'],
        ];
        foreach ($banks as $bank) {
            DB::table('banks')->insert($bank);
        }
    }
}
