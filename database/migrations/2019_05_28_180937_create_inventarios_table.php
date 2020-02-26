<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iddepartamento', 45);//requerido obligatorio
            $table->string('iddocumental', 45);
            $table->string('idpersona', 45)->nullable();
            $table->string('idcaja', 45);
            $table->string('idusuario',45);
            $table->integer('nuevo_num_expediente')->nullable();
            $table->string('viejo_num_expediente', 45);
            $table->string('contenido', 256)->nullable();
            $table->string('fecha_extrema', 45)->nullable();
            $table->string('anno', 45)->nullable();
            $table->string('ubicacion', 45)->nullable();
            $table->string('descripcion', 256)->nullable();
            $table->string('valor', 45)->nullable();
            $table->string('vigencia', 45)->nullable();
            $table->string('estado', 45)->nullable();
            $table->timestamps();
            $table->string('fecha_expiracion', 45)->nullable();//no obligatorio; por excell
        });

         // realizo una insercion quemada en la tabla inventarios para que cuando realize la migracion se encuentre ya llena
        /* DB::table('inventarios')->insert(array(
            'id'=>'1',
            'iddepartamento'=>'CONSEJO MUNICIPAL',
            'iddocumental'=>'ACCION PERSONAL',
            'idpersona'=>'JOSE LENIN ULLOA ANCHIA',
            'idcaja'=>'CONS-MU-1',
            'idusuario'=>'1',
            'nuevo_num_expediente'=>'0',
            'viejo_num_expediente'=>'ACC-1220',
            'contenido'=>'LEYES DECRETOS JURISPRUDENCIA',
            'fecha_extrema'=>'2005',
            'anno'=>'2007',
            'ubicacion'=>'NINGUNA',
            'descripcion'=>'CUALQUIER COSA AL RESPECTO',
            'valor'=>'LEGAL',
            'vigencia'=>'1',
            'estado'=>'DISPONIBLE',
            'fecha_expiracion'=>'2020-06-01 03:52:39'
           ));

           DB::table('inventarios')->insert(array(
            'id'=>'2',
            'iddepartamento'=>'SECRETARIA DE CONSEJO',
            'iddocumental'=>'ACTAS',
            'idpersona'=>'CAROLINA BUSTAMANTE ARIAS',
            'idcaja'=>'SECRE-CONS-2',
            'idusuario'=>'2',
            'nuevo_num_expediente'=>'0',
            'viejo_num_expediente'=>'545-546-547-2000',
            'contenido'=>'RECURSO VILLAS DEL COCO VP S A',
            'fecha_extrema'=>'2008',
            'anno'=>'2008',
            'ubicacion'=>'NINGUNA',
            'descripcion'=>'CUALQUIER COSA AL RESPECTO',
            'valor'=>'CIENTIFICO CULTURAL',
            'vigencia'=>'2',
            'estado'=>'PRESTADO',
            'fecha_expiracion'=>'2022-06-01 03:52:39'
           ));

           DB::table('inventarios')->insert(array(
            'id'=>'3',
            'iddepartamento'=>'AUDITORIA INTERNA',
            'iddocumental'=>'ACUERDOS',
            'idpersona'=>'JASON BARRANTES APU',
            'idcaja'=>'AUDI-INTER-3',
            'idusuario'=>'3',
            'nuevo_num_expediente'=>'0',
            'viejo_num_expediente'=>'EXP-1221',
            'contenido'=>'MARIO MARTINEZ MARTINEZ DONACION DE FRANJA DE TERRENO',
            'fecha_extrema'=>'2010',
            'anno'=>'2012',
            'ubicacion'=>'NINGUNA',
            'descripcion'=>'CUALQUIER COSA AL RESPECTO',
            'valor'=>'LEGAL',
            'vigencia'=>'3',
            'estado'=>'DISPONIBLE',
            'fecha_expiracion'=>'2023-06-01 03:52:39'
           ));

           DB::table('inventarios')->insert(array(
            'id'=>'4',
            'iddepartamento'=>'JUNTA VIAL',
            'iddocumental'=>'ACUMULADO INGRESO',
            'idpersona'=>'EDDIER LOPEZ LOPEZ',
            'idcaja'=>'JUNT-V-4',
            'idusuario'=>'4',
            'nuevo_num_expediente'=>'0',
            'viejo_num_expediente'=>'11-000265-0412-PE',
            'contenido'=>'ALCALDIA 2009 2010 2011',
            'fecha_extrema'=>'2008',
            'anno'=>'2012',
            'ubicacion'=>'NINGUNA',
            'descripcion'=>'CUALQUIER COSA AL RESPECTO',
            'valor'=>'CIENTIFICO CULTURAL',
            'vigencia'=>'4',
            'estado'=>'PRESTADO',
            'fecha_expiracion'=>'2024-06-01 03:52:39'
           ));
           */








    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
}
