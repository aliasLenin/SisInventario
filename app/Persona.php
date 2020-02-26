<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    
    
    //campos de la base de datos de la tabla personas
    protected $fillable=[
        'iddepartamento', 'idusuario','nombre', 'tipo_identificacion','num_identificacion','sexo', 'telefono','fax','email', 'direccion','estado'
    ];

 
          // una persona pertenece a un departamento y un departamento tiene muchas personas
          // sacado de laravel.com eloquent relations metodo de devuelta
        public function departamento(){ // va en singular 
          // para hacer referencia al modelo Departamento
            return $this->belongsTo('App\Departamento'); // al modelo Departamento que esta aqui con foraneo 
         
        }

          //una persona esta relacionada de manera directa como un usuario
        public function user()
        {
            return $this->hasOne('App\User');
        }
            
        //una persona confecciona muchos archivos
        public function archivos() // siempre va en plural
        {
            return $this->hasMany('App\Archivo'); // referencia al modelo archivo
        }





        //una persona es insertada en muchas boletas y tambien hay muchas personas que tambien son responsables de las boletas
        public function boletas() // siempre va en plural
        {
            return $this->hasMany('App\Boleta'); // referencia al modelo archivo
        }



}



















