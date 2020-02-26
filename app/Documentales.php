<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentales extends Model
{
    
    //campos de la base de datos de la tabla Documentales, los campos update_at y created_at se llenan mediente el timestand
    protected $fillable=[
        'idusuario','nombre_documental','codigo_diminutivo','descripcion','estado','vigencia'
    ];



    // un documental pertenecera o se encontraran en muchas cajas
    // public function cajas() // siempre va en plural
    // {
    // return $this->hasMany('App\Caja'); // referencia al modelo Caja
    // }


    //un documental tiene muchos archivos
    public function archivos() // siempre va en plural
    {
        return $this->hasMany('App\Archivo'); // referencia al modelo archivo
    }














}
