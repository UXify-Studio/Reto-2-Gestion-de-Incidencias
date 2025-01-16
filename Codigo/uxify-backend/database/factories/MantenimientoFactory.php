<?php

namespace Database\Factories;

use App\Models\Maquina;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mantenimiento>
 */
class MantenimientoFactory extends Factory
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
            'descripcion' => $this->faker->text(50),
            //'duracion' => $this->faker->randomDigit(),
            'fecha_inicio' => $this->faker->date(),
            'proxima_fecha' => $this->faker->date(),
            'periodo' => $this->faker->randomElement(['diario', 'semanal', 'mensual', 'anual']),
        ];
    }
}
