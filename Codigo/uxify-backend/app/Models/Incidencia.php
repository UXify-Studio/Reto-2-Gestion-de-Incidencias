<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $fillable = [
        'id_usuario', 'id_maquina',	'titulo',	'descripcion', 'estado', 'id_categoria', 'resuelta'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'fecha_creacion' => 'datetime',
    ];

    public function adjuntos(){
        return $this->hasMany(File::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function maquina(){
        return $this->belongsTo(Maquina::class);
    }

    public function usuarios_trabajando(){
        return $this->belongsToMany(User::class);
    }
}
