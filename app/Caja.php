<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    
    
    //campos de la base de datos de la tabla cajas
    protected $fillable=[
        'iddepartamento','idusuario','diminutivo_caja', 'num_caja', 'ubicacion','estado'
    ];


    // una caja pertenece a un departamento y un departamento tiene muchas cajas
    // sacado de laravel.com eloquent relations metodo de devuelta
    public function departamento(){ // va en singular 
        // para hacer referencia al modelo Departamento
            return $this->belongsTo('App\Departamento'); // al modelo Departamento que esta aqui con foraneo 
        
        }

    // una caja tiene muchos documentales y un documental se encontraran en muchas cajas de diferentes departamentos
    // sacado de laravel.com eloquent relations metodo de devuelta
    // public function documental(){ // va en singular 
    // para hacer referencia al modelo Documentales
    // return $this->belongsTo('App\Documentales'); // al modelo Documentales que esta aqui con foraneo   
    // }


         //una caja tiene muchos archivos
    public function archivos() // siempre va en plural
    {
        return $this->hasMany('App\Archivo'); // referencia al modelo archivo
    }









}











