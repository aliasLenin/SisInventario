<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    
    //campos de la base de datos de la tabla Departamentos, los campos update_at y created_at se llenan mediente el timestand
    protected $fillable=[
        'idusuario','nombre_departamento','diminutivo_departamento','descripcion','estado'
    ];


    //basado a la documentacion de laravel.com en la seccion de relation one to many es necesario declarar 
    //un metodo "comments" el cual sera el metodo de envio al modelo al que esta relacionado en este caso 
    //al modelo Caja (el cual el modelo Deparetamento esta como foraneo alla en el modelo de Caja)

    //un departamento tiene muchas cajas
    public function cajas() // siempre va en plural
    {
        return $this->hasMany('App\Caja'); // referencia al modelo Caja
    }


    public function personas() // siempre va en plural
    {
        return $this->hasMany('App\Persona'); // referencia al modelo Persona
    }
    // un departamento puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany('App\User');
    }

    //un departamento tiene muchos archivos
    public function archivos() // siempre va en plural
    {
        return $this->hasMany('App\Archivo'); // referencia al modelo archivo
    }





    
    //un departamento tiene muchos boletas
    public function boletas() // siempre va en plural
    {
        return $this->hasMany('App\Boleta'); // referencia al modelo boleta
    }












}







