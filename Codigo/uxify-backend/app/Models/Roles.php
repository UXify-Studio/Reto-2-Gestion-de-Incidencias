<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users() {
        return $this->hasMany(User::class, 'id_rol');
    }
}
