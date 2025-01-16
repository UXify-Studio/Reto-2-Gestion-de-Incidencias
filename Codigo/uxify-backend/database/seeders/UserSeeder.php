<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Adrian',
            'username' => '',
            'email' => 'adrian@uxifystudio.com',
            'password' => Hash::make('password'),
            'id_rol' => 1,
        ]);

        User::create([
            'name' => 'Zahir',
            'username' => '',
            'email' => 'editor@uxifystudio.com',
            'password' => Hash::make('password'),
            'id_rol' => 1,
        ]);

        User::create([
            'name' => 'Jason',
            'username' => 'YeiVi',
            'email' => 'viewer@uxifystudio.com',
            'password' => Hash::make('password'),
            'id_rol' => 1,
        ]);

        User::factory(10)->create();
    }
}
