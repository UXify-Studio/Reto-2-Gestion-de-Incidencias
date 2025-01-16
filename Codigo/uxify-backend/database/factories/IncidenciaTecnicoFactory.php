<?php

namespace Database\Factories;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class IncidenciaTecnicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_incidencia' => Incidencia::pluck('id')->random(),
            'id_tecnico' => User::where('id_rol', 2)->pluck('id')->random(),
            'fecha_inicio' => $this->faker->date(),
        ];
    }
}