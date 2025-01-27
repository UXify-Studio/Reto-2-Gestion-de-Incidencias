<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_maquina',
        'id_usuario',
        'descripcion',
        'periodo',
        'duracion',
        'fecha_inicio',
        'resuelta',
        'proxima_fecha'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'duracion' => 'integer', // Corrección: ahora es integer
        'fecha_inicio' => 'date', // Corrección: ahora es date
        'proxima_fecha' => 'date', // Corrección: ahora es date
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }
}

