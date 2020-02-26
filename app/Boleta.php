<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    

        //campos de la base de datos de la tabla boletas 
        //vector
        protected $fillable=[

            'num_boleta',
            'tipo_comprobante',
            'idusuario',
            'iddepartamento',
            'idpersona',
            'fecha_limite',
            'estado',

        ];

          // una boleta es enviada a un departamento y un departamento tiene muchas boletas con lo que conlleva a solicitar muchos archivos
          // sacado de laravel.com eloquent relations metodo de devuelta
          public function departamento(){ // va en singular 
            // para hacer referencia al modelo Departamento
              return $this->belongsTo('App\Departamento'); // al modelo Departamento que esta aqui con foraneo 
          
          }

          // una boleta es confeccionado por un usuario y un usuario confeccina muchas boletas con lo que conlleva a que esta boleta sea confecionada para una persona tambien por lo que es necesario tenerlas
          //enlistada a todas las personas de ante mano para seleccionar solo una a la vez
        // sacado de laravel.com eloquent relations metodo de devuelta
        public function persona(){ // va en singular 
            // para hacer referencia al modelo Persona
                return $this->belongsTo('App\Persona'); // al modelo Persona que esta aqui con foraneo 
            
        }

         // una boleta es confeccionado por un usuario y un usuario confeccina muchas boletas con lo que conlleva a que esta boleta sea confecionada para una persona tambien por lo que es necesario tenerlas
          //enlistada a todas las personas de ante mano para seleccionar solo una a la vez
        // sacado de laravel.com eloquent relations metodo de devuelta
        public function usuario(){ // va en singular 
          // para hacer referencia al modelo Persona
               return $this->belongsTo('App\User'); // al modelo User que esta aqui con foraneo 
          
      }



}
