<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iddepartamento')->unsigned();
            $table->integer('idusuario')->unsigned();//Para capturar quien fue el que lo hiso el movimiento
            $table->string('nombre', 100)->unique();
            $table->string('tipo_identificacion',20); // cambie
            $table->integer('num_identificacion');
            $table->string('sexo', 20); // obligatorio
            $table->string('telefono', 20)->nullable();//no obligatorio y que permita nulos
            $table->string('fax', 20)->nullable(); //no obligatorio y que permita nulos
            $table->string('email', 50)->nullable(); //no obligatorio y que permita nulos
            $table->string('direccion', 265)->nullable();//no obligatorio y que permita nulos
            $table->boolean('estado')->default(1);
           
            $table->timestamps();

             //creamos la relacion
             $table->foreign('iddepartamento')->references('id')->on('departamentos');

        });

        
              // realizo una insercion quemada en la tabla personas para que cuando realize la migracion se encuentre esta persona para agregarla como usuario
              DB::table('personas')->insert(array(
                'id'=>'1',
                'iddepartamento'=>'1',
                'idusuario'=>'1',
                'nombre'=>'JOSE LENIN ULLOA ANCHIA',
                'tipo_identificacion'=>'Cedula',
                'num_identificacion'=>'604060653',
                'sexo'=>'Hombre',
                'telefono'=>'84633772',
                'fax'=>'11111111',
                'email'=>'JOSELENIN@GMAIL.COM',
                'direccion'=>'CANAS,GUANACASTE'
               ));
               DB::table('personas')->insert(array(
                'id'=>'2',
                'iddepartamento'=>'2',
                'idusuario'=>'1',
                'nombre'=>'CAROLINA BUSTAMANTE ARIAS',
                'tipo_identificacion'=>'Pasaporte',
                'num_identificacion'=>'202220222',
                'sexo'=>'Mujer',
                'telefono'=>'22222222',
                'fax'=>'22222222',
                'email'=>'CAROLINA@GMAIL.COM',
                'direccion'=>'CARRILLO,GUANACASTE'
               ));
               DB::table('personas')->insert(array(
                'id'=>'3',
                'iddepartamento'=>'3',
                'idusuario'=>'1',
                'nombre'=>'JASON BARRANTES APU',
                'tipo_identificacion'=>'Cedula',
                'num_identificacion'=>'303330333',
                'sexo'=>'Hombre',
                'telefono'=>'33333333',
                'fax'=>'33333333',
                'email'=>'JASON@GMAIL.COM',
                'direccion'=>'SANTA CRUZ, GUANACASTE'
               ));

               DB::table('personas')->insert(array(
                'id'=>'4',
                'iddepartamento'=>'4',
                'idusuario'=>'1',
                'nombre'=>'EDDIER LOPEZ LOPEZ',
                'tipo_identificacion'=>'Cedula',
                'num_identificacion'=>'404440444',
                'sexo'=>'Hombre',
                'telefono'=>'44444444',
                'fax'=>'44444444',
                'email'=>'EDDIER@GMAIL.COM',
                'direccion'=>'SARDINAL GUANACASTE'
               ));

               

   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
