<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'id_rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey(); // Identificador único del usuario
    }

    // Métod0 obligatorio de la interfaz
    public function getJWTCustomClaims()
    {
        return []; // Puedes agregar datos personalizados al token si es necesario
    }

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'id_rol');
    }

    public function hasRole($role) {
        return $this->rol()->where('nombre', $role)->exists();
    }

    public function incidencias_creadas(){
        return $this->hasMany(Incidencia::class);
    }

    public function incidencias_realizadas(){
        return $this->belongsToMany(Incidencia::class);
    }

    public function mantenimientos(){
        return $this->hasMany(Mantenimiento::class);
    }
}
