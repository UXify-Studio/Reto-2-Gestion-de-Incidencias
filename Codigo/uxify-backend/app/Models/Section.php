<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'n_seccion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function campus(){
        return $this->belongsTo(Campus::class, 'id_campus');
    }

    public function maquinas(){
        return $this->hasMany(Maquina::class, 'id_section');
    }
}
