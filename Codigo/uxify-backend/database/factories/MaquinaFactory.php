<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maquina>
 */
class MaquinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'modelo' => $this->faker->word(),
            'prioridad' => $this->faker->randomElement([1, 2, 3]),
            'estado' => $this->faker->numberBetween(0, 1),
            'id_section' => Section::pluck('id')->random(),
        ];
    }
}
