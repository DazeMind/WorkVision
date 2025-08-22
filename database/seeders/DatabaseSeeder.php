<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TaskPriority;
use App\Models\TasksState;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StatesSeed::class,
            BankSeeder::class,BankAccountTypeSeed::class,
            WorkerStateSeeder::class,
            RoleSeeder::class, 
            UserSeeder::class, 
            //ClientSeed::class,CompanySeed::class,
            CategorySeed::class, SubCategorySeed::class,
            WalletTypeSeed::class,//WalletSeed::class,
            TaskPrioritiesSeeder::class,
            TasksStateSeeder::class,
            CountrySeed::class,RegionSeed::class,ProvinceSeed::class,ComunaSeed::class,
            OrderStatesSeed::class
        ]);
    }
}
