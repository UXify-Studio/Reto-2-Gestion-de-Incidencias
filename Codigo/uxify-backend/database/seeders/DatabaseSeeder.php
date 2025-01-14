<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\Maquina;
use App\Models\Section;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

//        $this->call([
//            CampusSeeder::class,
//            SectionSeeder::class,
//        ]);
//
//        $this->call([
//            MaquinaSeeder::class,
//        ]);

//        $this->call([
//            UserSeeder::class,
//        ]);


        // DATOS PARA CAMPUS, SECCION, MAQUINAS
        for ($i = 0; $i < 5; $i++) {
            $campus = Campus::factory()->create();

            $num_sections = rand(0, 3);

            for ($j = 0; $j < $num_sections; $j++) {
                $section = Section::factory()->create([
                    'id_campus' => $campus->id,
                ]);

                $num_maquinas = rand(0, 3);

                for ($j = 0; $j < $num_maquinas; $j++) {
                    Maquina::factory()->create([
                        'id_section' => $section->id,
                    ]);


                }
            }
        }



    }
}
