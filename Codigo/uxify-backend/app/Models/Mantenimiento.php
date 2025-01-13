<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model {
    protected $fillable = [
        'id_maquina', 'id_usuario', 'descripcion', 'periodo'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'duracion' => 'datetime',
        'fecha_inicio' => 'datetime',
        'proxima_fecha' => 'datetime',
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function maquina(){
        return $this->belongsTo(Maquina::class);
    }
}
