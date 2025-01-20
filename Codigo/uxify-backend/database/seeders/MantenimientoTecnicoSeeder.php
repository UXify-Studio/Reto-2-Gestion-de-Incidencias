<?php

namespace Database\Seeders;

use App\Models\MantenimientoTecnico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MantenimientoTecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MantenimientoTecnico::factory(10)->create();
    }
}
