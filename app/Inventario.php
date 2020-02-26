<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    
    
        //campos de la base de datos de la tabla cajas
        protected $fillable=[

            'iddepartamento',
            'iddocumental',
            'idpersona',
            'idcaja',
            'idusuario',
            'nuevo_num_expediente',
            'viejo_num_expediente',
            'contenido',
            'fecha_extrema',
            'anno',
            'ubicacion',
            'descripcion',
            'valor',
            'vigencia',
            'estado',
            'fecha_expiracion',

        ];








}
