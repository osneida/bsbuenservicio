<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "Admin",
            "email" => "admin@test.com",
            "password" => bcrypt("12345678"),
            "is_admin" => 1
        ]);
        $user->assignRole('Admin');

        $user = User::create([
            "name" => "Berginie Bordones",
            "email" => "berginie@test.com",
            "password" => bcrypt("12345678"),
            "is_admin" => 1
        ]);
        $user->assignRole('Admin');

        $user = User::create([
            "name" => "Stefany",
            "email" => "stefany@test.com",
            "password" => bcrypt("12345678"),
            "is_admin" => 1
        ]);
        $user->assignRole('Admin');

        $user = User::create([
            "name" => "Empleado",
            "email" => "empleado@test.com",
            "password" => bcrypt("12345678"),
        ]);
        $user->assignRole('Empleado');
    }
}
