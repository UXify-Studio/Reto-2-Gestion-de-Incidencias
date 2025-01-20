<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Maquina;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => User::pluck('id')->random(),
            'id_maquina' => Maquina::pluck('id')->random(),
            'id_categoria' => Categoria::pluck('id')->random(),
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->text(50),
            'fecha_creacion' => $this->faker->date(),
            'estado' => $this->faker->randomElement([0, 1])
        ];
    }
}
