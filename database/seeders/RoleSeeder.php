<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin    = Role::create(['name' => 'Admin']);
        $empleado = Role::create(['name' => 'Empleado']);

        $admin_per    = Permission::create(['name' => 'administrador']);
        $empleado_per = Permission::create(['name' => 'empleado']);

        $admin->syncPermissions([$admin_per,$empleado_per]);
        $empleado->syncPermissions([$empleado_per]);

    }
}
