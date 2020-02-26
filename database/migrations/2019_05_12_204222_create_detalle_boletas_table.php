<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleBoletasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_boletas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idboleta')->unsigned();   // para saber de cual boleta estan estos archivos
            $table->integer('idarchivo')->unsigned();   // para obtener los archivos deceados a agregar a la boleta 
            $table->dateTime('fecha_devolucion_archivo')->nullable();//no obligatorio y que permita nulos
            $table->timestamps(); // las necesito para los graficos asi tomo las fechas de cuantos van saliendo


            $table->foreign('idboleta')->references('id')->on('boletas')->onDelete('cascade');
            $table->foreign('idarchivo')->references('id')->on('archivos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_boletas');
    }
}
