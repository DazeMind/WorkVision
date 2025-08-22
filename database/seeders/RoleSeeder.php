<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name'=> 'SuperAdmin']);
        $dueño = Role::create(['name'=> 'dueño']);
        $contratistaRole = Role::create(['name'=> 'Contratista']);
        $responsableRole = Role::create(['name'=> 'Responsable']);
        $secretarioRole = Role::create(['name'=> 'Secretari@']);
        $administradorRole = Role::create(['name'=> 'Administrador/a']);
        $supervisorRole = Role::create(['name'=> 'Supervisor/a']);
        $contadorRole = Role::create(['name'=> 'Contador']);
        $workerRole = Role::create(['name'=> 'Worker']);

        Permission::create(['name'=>'Dashboard.index'])->syncRoles([$superAdminRole,$contratistaRole,$dueño,$workerRole]);

    
    }
}
