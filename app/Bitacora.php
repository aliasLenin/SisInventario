<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    
    //campos de la base de datos de la tabla Departamentos, los campos update_at y created_at se llenan mediente el timestand
    protected $fillable=[
        'usuario','accion','descripcion','modulo'
    ];


}