<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentales', function (Blueprint $table) {
                    
            $table->increments('id');
            $table->integer('idusuario')->unsigned();//Para capturar quien fue el que lo hiso el movimiento
            $table->string('nombre_documental',100);
            $table->string('codigo_diminutivo',100);
            $table->string('descripcion',100)->nullable();//no obligatorio y que permita nulos
            $table->string('vigencia',100);
            $table->boolean('estado')->default(1); 
            $table->timestamps();
            
        });

        DB::table('documentales')->insert(array('id'=>'1','idusuario'=>'1',   'nombre_documental'=>'ACCION PERSONAL','codigo_diminutivo'=>'ACP-7','descripcion'=>'municipalidad de carrillo','vigencia'=>'2031','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'2','idusuario'=>'1',   'nombre_documental'=>'ACTAS','codigo_diminutivo'=>'ACT-20','descripcion'=>'municipalidad de carrillo','vigencia'=>'2032','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'3','idusuario'=>'1',   'nombre_documental'=>'ACUERDOS','codigo_diminutivo'=>'ACD-17','descripcion'=>'municipalidad de carrillo','vigencia'=>'2033','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'4','idusuario'=>'1',   'nombre_documental'=>'ACUMULADO INGRESO','codigo_diminutivo'=>'ACM-2','descripcion'=>'municipalidad de carrillo','vigencia'=>'2034','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'5','idusuario'=>'1',   'nombre_documental'=>'ADELANTO CAJA CHICA','codigo_diminutivo'=>'ACH-10','descripcion'=>'municipalidad de carrillo','vigencia'=>'2035','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'6','idusuario'=>'1',   'nombre_documental'=>'AHORRO Y APORTE PATRONAL ASEMUC ','codigo_diminutivo'=>'AAPA-1','descripcion'=>'municipalidad de carrillo','vigencia'=>'2036','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'7','idusuario'=>'1',   'nombre_documental'=>'ALBUM DE DIAPOSITIVAS ','codigo_diminutivo'=>'ADD-9','descripcion'=>'municipalidad de carrillo','vigencia'=>'2037','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'8','idusuario'=>'1',   'nombre_documental'=>'ARQUEO','codigo_diminutivo'=>'ARQ-1','descripcion'=>'municipalidad de carrillo','vigencia'=>'2038','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'9','idusuario'=>'1',   'nombre_documental'=>'ARREGLOS DE PAGO ','codigo_diminutivo'=>'ADP-6','descripcion'=>'municipalidad de carrillo','vigencia'=>'2039','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'10','idusuario'=>'1',   'nombre_documental'=>'ASIENTOS CONTABLES','codigo_diminutivo'=>'ASC-87','descripcion'=>'municipalidad de carrillo','vigencia'=>'2040','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'11','idusuario'=>'1',   'nombre_documental'=>'AUTORIZACONES','codigo_diminutivo'=>'AUT-2','descripcion'=>'municipalidad de carrillo','vigencia'=>'2041','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'12','idusuario'=>'1',   'nombre_documental'=>'AVALUOS','codigo_diminutivo'=>'AVL-173','descripcion'=>'municipalidad de carrillo','vigencia'=>'2042','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'13','idusuario'=>'1',   'nombre_documental'=>'AVISO DE COBRO','codigo_diminutivo'=>'ADC-236','descripcion'=>'municipalidad de carrillo','vigencia'=>'2043','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'14','idusuario'=>'1',   'nombre_documental'=>'BALANCES FINANCIEROS','codigo_diminutivo'=>'BFN-2','descripcion'=>'municipalidad de carrillo','vigencia'=>'2044','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'15','idusuario'=>'1',   'nombre_documental'=>'CENSO','codigo_diminutivo'=>'CNS-10','descripcion'=>'municipalidad de carrillo','vigencia'=>'2045','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'16','idusuario'=>'1',   'nombre_documental'=>'CERTIFICACIONES','codigo_diminutivo'=>'CFC-118','descripcion'=>'municipalidad de carrillo','vigencia'=>'2046','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'17','idusuario'=>'1',   'nombre_documental'=>'COMPROBANTE DE EGRESOS','codigo_diminutivo'=>'CPE-1','descripcion'=>'municipalidad de carrillo','vigencia'=>'2047','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'18','idusuario'=>'1',   'nombre_documental'=>'COMPROBANTE DE PAGO','codigo_diminutivo'=>'CDP-1','descripcion'=>'municipalidad de carrillo','vigencia'=>'2048','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'19','idusuario'=>'1',   'nombre_documental'=>'COMPROBANTES DE INGRESOS Y RECIBOS MULTIPLES','codigo_diminutivo'=>'CIR-677','descripcion'=>'municipalidad de carrillo','vigencia'=>'2049','estado'=>'1'));
        DB::table('documentales')->insert(array('id'=>'20','idusuario'=>'1',   'nombre_documental'=>'COMPROBANTES DE PAGO','codigo_diminutivo'=>'COMP-DE-PAGO','descripcion'=>'municipalidad de carrillo','vigencia'=>'2050','estado'=>'1'));
       
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentales');
    }
}
