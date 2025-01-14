<?php

namespace Database\Factories;

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
            'prioridad' => $this->faker->randomElement([1, 2, 3, 4]),
            'estado' => $this->faker->numberBetween(0, 1),
            'campus' => $this->faker->randomElement(['Nieves Cano', 'Arriaga', 'Jesus Obreros']),
            'id_section' => $this->faker->randomElement([1, 2, 3, 4]),
        ];
    }
}
