<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iddepartamento')->unsigned();
            $table->integer('idusuario')->unsigned();//Para capturar quien fue el que lo hiso el movimiento
          //$table->integer('iddocumental')->unsigned();
            $table->string('diminutivo_caja',45);
            $table->integer('num_caja');
            $table->string('ubicacion',45)->nullable();//no obligatorio;
          //$table->string('fecha_extrema', 45);// obligatorio;     
            $table->boolean('estado')->default(1);

            $table->timestamps();
            //creamos la relacion
            $table->foreign('iddepartamento')->references('id')->on('departamentos');
          //$table->foreign('iddocumental')->references('id')->on('documentales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cajas');
    }
}
