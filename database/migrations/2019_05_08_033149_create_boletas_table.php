<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletas', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('num_boleta')->unsigned();  
            $table->string('tipo_comprobante',45)->nullable();//no obligatorio;
            $table->integer('idusuario')->unsigned();   // para saber quien fue el gestor 
            $table->integer('iddepartamento')->unsigned(); // para el campo dependencia solicita
            $table->integer('idpersona')->unsigned(); // para saber quien fue el responsable
            $table->dateTime('fecha_limite')->nullable();//QUITAR EL NULLABLE LENIN RECUERDA QUE LA FECHA LIMITE YA CAROLINA SE LO DA
            $table->boolean('estado')->default(1);
            $table->timestamps();
           
            $table->foreign('idusuario')->references('id')->on('users');
            $table->foreign('iddepartamento')->references('id')->on('departamentos');
            $table->foreign('idpersona')->references('id')->on('personas');
           


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletas');
    }
}
