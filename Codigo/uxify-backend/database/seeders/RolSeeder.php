<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id'=> '1',
                'nombre' => 'Administrador'],
            [
                'id'=> '2',
                'nombre' => 'Tecnico'],
            [
                'id'=> '3',
                'nombre' => 'Operario'],
        ];

        DB::table('roles')->insert($roles);
    }
}
