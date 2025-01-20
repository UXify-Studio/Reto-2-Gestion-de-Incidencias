<?php

namespace Database\Seeders;

use App\Models\IncidenciaTecnico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenciaTecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncidenciaTecnico::factory(10)->create();
    }
}
