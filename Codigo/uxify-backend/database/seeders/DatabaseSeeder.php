<?php

namespace Database\Seeders;

use App\Http\Controllers\CategoriaController;
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


        // DATOS ROLES, USUARIOS
        //$this->call(RolSeeder::class);
        //$this->call(UserSeeder::class);

        // DATOS PARA CAMPUS, SECCION, MAQUINAS
        //$this->call(CampusSeeder::class);
        //$this->call(SectionSeeder::class);
        //$this->call(MaquinaSeeder::class);

        // DATOS CATEGORIAS, INCIDENCIAS
        //$this->call(CategoriaSeeder::class);
        //$this->call(IncidenciaSeeder::class);

        // DATOS MANTENIMIENTOS
        $this->call(MantenimientoSeeder::class);

        // DATOS TABLA N-M
        $this->call(IncidenciaTecnicoSeeder::class);
        $this->call(MantenimientoTecnicoSeeder::class);


        /*
        for ($i = 0; $i < 5; $i++) {
            $campus = Campus::factory()->create();

            $num_sections = rand(0, 3);

            for ($j = 0; $j < $num_sections; $j++) {
                $section = Section::factory()->create([
                    'id_campus' => $campus->id,
                ]);

                $num_maquinas = rand(0, 3);

                for ($k = 0; $k < $num_maquinas; $k++) {
                    Maquina::factory()->create([
                        'id_section' => $section->id,
                    ]);


                }
            }
        }
        */





    }
}
