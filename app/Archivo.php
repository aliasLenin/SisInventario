<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
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


          // un archivo pertenece a un departamento y un departamento tiene muchas archivos
          // sacado de laravel.com eloquent relations metodo de devuelta
        public function departamento(){ // va en singular 
          // para hacer referencia al modelo Departamento
            return $this->belongsTo('App\Departamento'); // al modelo Departamento que esta aqui con foraneo 
        
        }


         // un archivo pertenece a un docuemntal y un documental tiene muchas archivos
         // sacado de laravel.com eloquent relations metodo de devuelta
        public function documental(){ // va en singular 
            // para hacer referencia al modelo Documentales
                return $this->belongsTo('App\Documentales'); // al modelo Documentales que esta aqui con foraneo 
            
        }


        // un archivo es confeccionado por una persona y una persona confeccina muchos archivos
        // sacado de laravel.com eloquent relations metodo de devuelta
        public function persona(){ // va en singular 
            // para hacer referencia al modelo Persona
                return $this->belongsTo('App\Persona'); // al modelo Persona que esta aqui con foraneo 
            
        }

         // un archivo pertenece a una caja y una caja tiene muchas archivos
         // sacado de laravel.com eloquent relations metodo de devuelta
        public function caja(){ // va en singular 
            // para hacer referencia al modelo Caja
                return $this->belongsTo('App\Caja'); // al modelo Caja que esta aqui con foraneo 
            
        }


         // un archivo es guardado por un usuario y un usuario guardara muchos archivos
         // sacado de laravel.com eloquent relations metodo de devuelta
         public function usuario(){ // va en singular 
            // para hacer referencia al modelo User
                return $this->belongsTo('App\User'); // al modelo User que esta aqui con foraneo 
            
        }















}





















