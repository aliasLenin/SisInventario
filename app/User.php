<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','iddepartamento','idusuario','idrol','usuario','password','estado',
    ];

    public $timestamps = false; // indicar queestos campos no existen en la migracion

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //password va a hacer un campo oculto
        'password', 'remember_token',
    ];

       // muchos usuario tendran un rol exclusivo o lo mismo que
       // un rol tendran muchos usuarios
    public function rol(){
        return $this->belongsTo('App\Rol');
    }

        // un usuario hace referencia a una persona esto simplemente para cargar el cbx
    public function persona(){
        return $this->belongsTo('App\Persona');
    }
        // muchos usuarios pertenecen a un departamento
    public function departamento(){ // va en singular        
        return $this->belongsTo('App\Departamento');         
        }

         //un usuario guardara muchos archivos
    public function archivos() // siempre va en plural
    {
        return $this->hasMany('App\Archivo'); // referencia al modelo archivo
    }

       // un usuario hace referencia a una persona esto simplemente para cargar el cbx
       public function boleta(){
        return $this->belongsTo('App\Boleta');
    }



}
