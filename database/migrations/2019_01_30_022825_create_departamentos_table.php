<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     // para crear indices,tablas etc
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idusuario')->unsigned();//Para capturar quien fue el que lo hiso el movimiento
            $table->string('nombre_departamento',100);
            $table->string('diminutivo_departamento',45);
            $table->string('descripcion',100)->nullable();//no obligatorio y que permita nulos
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
         // realizo una insercion quemada en la tabla departamentos
         DB::table('departamentos')->insert(array('id'=>'1','idusuario'=>'1',    'nombre_departamento'=>'CONSEJO MUNICIPAL','diminutivo_departamento'=>'CONS-MU','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'2','idusuario'=>'1',    'nombre_departamento'=>'SECRETARIA DE CONSEJO','diminutivo_departamento'=>'SECRE-CONS','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'3','idusuario'=>'1',    'nombre_departamento'=>'AUDITORIA INTERNA','diminutivo_departamento'=>'AUDI-INTER','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'4','idusuario'=>'1',    'nombre_departamento'=>'JUNTA VIAL','diminutivo_departamento'=>'JUNT-V','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'5','idusuario'=>'1',    'nombre_departamento'=>'ALCALDIA','diminutivo_departamento'=>'ALCAL','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'6','idusuario'=>'1',    'nombre_departamento'=>'PLANIFICACION Y CONTROL','diminutivo_departamento'=>'PLANI-CONTR','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'7','idusuario'=>'1',    'nombre_departamento'=>'TECNOLOGIA DE INFORMACION Y COMUNICACION','diminutivo_departamento'=>'TIF','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'8','idusuario'=>'1',    'nombre_departamento'=>'DIRECCION INGENIERIA Y SERVICIOS','diminutivo_departamento'=>'DIRE-ING-SERV','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'9','idusuario'=>'1',    'nombre_departamento'=>'DESARROLLO TERRITORIAL','diminutivo_departamento'=>'DESARR-TERR','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'10','idusuario'=>'1',   'nombre_departamento'=>'GESTION AMBIENTAL','diminutivo_departamento'=>'GEST-AMBI','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'11','idusuario'=>'1',   'nombre_departamento'=>'OBRAS MUNICIPALES','diminutivo_departamento'=>'OBR-MUNI','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'12','idusuario'=>'1',   'nombre_departamento'=>'SERVICIOS MUNICIPALES','diminutivo_departamento'=>'SERV-MUNI','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'13','idusuario'=>'1',   'nombre_departamento'=>'PERMISOS DE CONSTRUCCION','diminutivo_departamento'=>'PERMI-CONSTR','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'14','idusuario'=>'1',   'nombre_departamento'=>'REGULACION','diminutivo_departamento'=>'REGUL','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'15','idusuario'=>'1',   'nombre_departamento'=>'OTROS PROYECTOS','diminutivo_departamento'=>'OTROS-PROY','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'16','idusuario'=>'1',   'nombre_departamento'=>'LIMPIEZA Y ORNATO','diminutivo_departamento'=>'LIMP-ORN','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'17','idusuario'=>'1',   'nombre_departamento'=>'SISTEMA GEOGRAFICO CATASTRAL','diminutivo_departamento'=>'SIST-GEOGRAF-CATAST','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'18','idusuario'=>'1',   'nombre_departamento'=>'CONTROL Y SUPERVICION','diminutivo_departamento'=>'CONTR-SUPERV','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'19','idusuario'=>'1',   'nombre_departamento'=>'UNIDAD TECNICA','diminutivo_departamento'=>'UNI-TECN','descripcion'=>'municipalidad de carrillo'));
         DB::table('departamentos')->insert(array('id'=>'20','idusuario'=>'1',   'nombre_departamento'=>'MANTENIMIENTO MUNICIPAL','diminutivo_departamento'=>'MANT-MUNI','descripcion'=>'municipalidad de carrillo'));







    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

     //revierte lo contrario de lo del metodo up
    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}
