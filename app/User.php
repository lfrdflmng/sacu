<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @property false|string fecha_ultimo_ingreso
 */

class User extends Authenticatable {
    use Notifiable;

    protected $table = 'usuario';

    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = 'fecha_actualizacion';

    const DELETED_AT = 'fecha_eliminacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'contrasena'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'contrasena',
        'remember_token'
    ];


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->contrasena;
    }


    # RELACIONES

    /**
     * La relación está estructurada de muchos a muchos
     * pero se va a usar como uno a uno con tabla pivote
     */
    public function persona() {
        return $this->belongsToMany('App\Persona', 'usuario_persona','id_usuario', 'id_persona');
    }


    # METODOS

    /**
     * Registra una nueva sesión para el usuario
     *
     * @return bool
     */
    public function iniciarSesion() {
        Auth::login($this);
        if (Auth::check()) {
            $this->fecha_ultimo_ingreso = date('Y-m-d H:i:s');
            $this->save();
            return true;
        }
        return false;
    }


    /**
     * Busca y retorna la persona asociada al usuario
     *
     * @return mixed
     */
    public function traerPersona() {
        return $this->persona()->first();
    }
}
