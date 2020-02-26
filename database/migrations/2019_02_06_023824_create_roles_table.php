<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 30)->unique(); // va a ser unico
            $table->string('descripcion', 100)->nullable();//permite nulos
            $table->boolean('condicion')->default(1);   
                
        });

        // realizo una insercion quemada en la tabla roles
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Super administrador', 'descripcion'=>'super administrador'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Administrador', 'descripcion'=>'administrador'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Funcionario', 'descripcion'=>'consultor de archivos'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
