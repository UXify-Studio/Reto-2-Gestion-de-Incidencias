<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
    protected $fillable = [
        'name', 'file_path', 'id_incidencia'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function incidencia(){
        return $this->belongsTo(Incidencia::class);
    }
}
