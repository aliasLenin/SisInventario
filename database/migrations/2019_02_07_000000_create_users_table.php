<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('iddepartamento')->unsigned();
            $table->integer('idusuario')->unsigned();//Para capturar quien fue el que lo hiso el movimiento
            $table->integer('idrol')->unsigned();
            $table->string('usuario', 100)->unique();
            $table->string('password', 100);
            $table->boolean('estado')->default(1);
          
            $table->rememberToken();
           // $table->timestamps();

             //creamos la relacion con la tabla departamento
             $table->foreign('iddepartamento')->references('id')->on('departamentos');
             //creamos la relacion con la tabla persona
             $table->foreign('id')->references('id')->on('personas');
              //creamos la relacion con la tabla roles
             $table->foreign('idrol')->references('id')->on('roles');

        });
        
              // realizo una insercion quemada en la tabla users
              DB::table('users')->insert(array(
                'id'=>'1',
                'iddepartamento'=>'1',
                'idusuario'=>'1', 
                'idrol'=>'1',
                'usuario'=>'admin',
                'password'=>'$2y$10$65S7ZUnLWdvhzVBHWZ9WsOv0nmTdhs701T/cOaWkY6sxzpWypAjDW' 
               ));
               // password 12345678
               DB::table('users')->insert(array(
                'id'=>'2',
                'iddepartamento'=>'2',
                'idusuario'=>'1', 
                'idrol'=>'2',
                'usuario'=>'carolina',
                'password'=>'$2y$10$65S7ZUnLWdvhzVBHWZ9WsOv0nmTdhs701T/cOaWkY6sxzpWypAjDW' 
               ));

               DB::table('users')->insert(array(
                'id'=>'3',
                'iddepartamento'=>'3',
                'idusuario'=>'1', 
                'idrol'=>'3',
                'usuario'=>'jason',
                'password'=>'$2y$10$65S7ZUnLWdvhzVBHWZ9WsOv0nmTdhs701T/cOaWkY6sxzpWypAjDW' 
               ));

               DB::table('users')->insert(array(
                'id'=>'4',
                'iddepartamento'=>'4',
                'idusuario'=>'1', 
                'idrol'=>'1',
                'usuario'=>'eddier',
                'password'=>'$2y$10$65S7ZUnLWdvhzVBHWZ9WsOv0nmTdhs701T/cOaWkY6sxzpWypAjDW' 
               ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
