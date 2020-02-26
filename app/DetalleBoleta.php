<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleBoleta extends Model
{
    
      protected $table = 'detalle_boletas'; // indico que sera esta tabla detalle_boletas que se creara en la bd y no la DetalleBoleta esto por que laravel pide que la tabla en la bd valla en plural
      //campos de la base de datos de la tabla cajas
      protected $fillable=[

       
        'idboleta',
        'idarchivo',
        'fecha_devolucion_archivo',
    

    ];

    public $timestamps = false; // para que no me agregue los campos created_at y updated_at en la tabla de la bd pues no los necesito





}
