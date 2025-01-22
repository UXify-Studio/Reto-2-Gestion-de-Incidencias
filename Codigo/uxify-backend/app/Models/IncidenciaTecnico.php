<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenciaTecnico extends Model
{
    use HasFactory;

    protected $table = 'incidencia_tecnicos';
    public $timestamps = false;

    protected $fillable = [
        'id_incidencia',
        'id_tecnico',
        'fecha_inicio'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];
}
