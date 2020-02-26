<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario; // adjuntamos el modelo Archivo
use Carbon\Carbon; // para la fecha de ingreso
use DB;
use Excel;
use Input;

class InventarioController extends Controller
{
    



    public function importExcel(Request $request)
    {


       $fecha_actual= Carbon::now('America/Costa_Rica'); // capturo la fecha actual    
       $idusuario = \Auth::user()->id; 
       $nuevo_num_expediente = '0';
       $ubicacion = 'NINGUNA';
      
      

            // $data = Excel::load($request->file('file'))->get();    
             $path = $request->file('file')->getRealPath();//obtengo el nombre del paquete
             $data = Excel::load($path)->get();//leo y convierto la informacion en un formato legible y paso el paquete
           
             if($data->count()){//recorro el 
                 foreach ($data as $key => $value) {

                    $aux = $value->years_vigence;// capturo la cantidad de anos que dijito que viene de la vista pueden ser 1 o 2 o hasta 18 
                    $aux_fecha_expiracion = strtotime ( '+'.$aux.' year' , strtotime ( $fecha_actual ) ) ;// sumo esos 18 a la fecha actual y los guardo en la base de datos
                    $fecha_expiracion = date ( 'Y-m-d h:i:s' , $aux_fecha_expiracion ); // y le doy formato para mas abajo enviarlo a la base de datos
             
                     $arr[] = [
                                                                   
                                 'iddepartamento' => $value->departamento,
                                 'iddocumental' => $value->tipo_documental,
                                 'idpersona' =>$value->persona,
                                 'idcaja' => $value->caja,
                                 'idusuario' => $idusuario,
                                 'nuevo_num_expediente' => $nuevo_num_expediente,
                                 'viejo_num_expediente' =>$value->numero_expediente,
                                 'contenido' => $value->contenido,
                                 'fecha_extrema' => $value->fecha_extrema,
                                 'anno' => $value->year,
                                 'ubicacion' =>  $ubicacion,
                                 'descripcion' => $value->descripcion,
                                 'valor' => $value->valor,
                                 'vigencia' => $value->years_vigence,
                                 'estado' => $value->status,
                                 'created_at' => $fecha_actual,
                                 'fecha_expiracion' => $fecha_expiracion
                                                             
                             ];
                 }
      
                 if(!empty($arr)){
                    Inventario::insert($arr);
                 }
             }

             return  $data;


       
    }




    
}
