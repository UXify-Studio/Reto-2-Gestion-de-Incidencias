<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model {
    use HasFactory;

    protected $fillable = [
        'nombre', 'modelo', 'prioridad', 'estado', 'campus', 'id_section'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function incidencias(){
        return $this->hasMany(Incidencia::class);
    }

    public function mantenimientos(){
        return $this->hasMany(Mantenimiento::class);
    }
}
