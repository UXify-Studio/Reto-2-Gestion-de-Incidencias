<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categorias = [
            ['id' => 1, 'nombre' => 'Mecanica', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nombre' => 'Eléctrica', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nombre' => 'Neumatica', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nombre' => 'Hidraulica', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nombre' => 'Informatica', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'nombre' => 'Instalaciones Generales', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'nombre' => 'Otros', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
