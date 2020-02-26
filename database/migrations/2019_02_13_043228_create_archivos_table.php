<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iddepartamento')->unsigned();
            $table->integer('iddocumental')->unsigned();
            $table->integer('idpersona')->unsigned();
            $table->integer('idcaja')->unsigned();
            $table->integer('idusuario')->unsigned();
            $table->integer('nuevo_num_expediente');//requerido obligatorio
            $table->string('viejo_num_expediente', 20)->nullable(); //no obligatorio; por excell aveces no trae
            $table->string('contenido', 256)->nullable();//no obligatorio; por excell
            $table->string('fecha_extrema', 45);//no obligatorio; por excell        
            $table->string('anno', 45);//no obligatorio; por excell
            $table->string('ubicacion', 45)->nullable();//no obligatorio; por excell
            $table->string('descripcion', 256)->nullable();//no obligatorio; por excell
            $table->integer('valor')->nullable();//no obligatorio; por excell  
            $table->integer('vigencia')->nullable();//no obligatorio; por excell
            $table->integer('estado')->nullable();//no obligatorio;
            $table->timestamps();
            $table->string('fecha_expiracion', 45)->nullable();//no obligatorio; por excell

            $table->foreign('iddepartamento')->references('id')->on('departamentos');
            $table->foreign('iddocumental')->references('id')->on('documentales');
            $table->foreign('idpersona')->references('id')->on('personas');
            $table->foreign('idcaja')->references('id')->on('cajas');
            $table->foreign('idusuario')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos');
    }
}
