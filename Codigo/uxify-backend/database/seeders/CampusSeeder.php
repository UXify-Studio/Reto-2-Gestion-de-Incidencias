<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $campuses = [
            ['id' => 1, 'nombre' => 'Arriaga', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nombre' => 'Mendizorroza', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nombre' => 'Molinuevo', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nombre' => 'Nieves Cano', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nombre' => 'Jesús Obrero', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('campuses')->insertOrIgnore($campuses);
    }
}
