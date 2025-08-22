<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = User::create(['name' => 'Super Admin','email' => 'superadmin@example.com','password' => bcrypt('12345678'),])->assignRole('SuperAdmin');
        // $user2 = User::create(['name' => 'User Contratista','email' => 'contratista@example.com','password' => bcrypt('12345678'),])->assignRole('Contratista');

        // $user3 = User::create(['name' => 'Danny Zepeda','email' => 'danny.darwin.dzf@gmail.com','password' => bcrypt('12345678'),])->assignRole('dueño');
        // $user4 = User::create(['name' => 'Jorge Zepeda','email' => 'jztecnico@gmail.com','password' => bcrypt('12345678'),])->assignRole('dueño');
    }
}
