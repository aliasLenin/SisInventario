<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;// anadido por mi para trabajar con transacciones


class EscritorioController extends Controller
{
    
    //tomada de la documentacion de laravel donde esta la creacion de controladores basicos
   // no hay necesidad de crear rutas debido a que se esta utilizando esta funcion invoke
    public function __invoke(Request $request)
    {
      
        $anio=date('Y'); // ano actual
        //$mes=date('M');
        $archivos=DB::table('archivos as a')
        ->select(DB::raw('MONTH(a.created_at) as mes'),
                 DB::raw('YEAR(a.created_at) as anio'),
                 DB::raw('COUNT(a.id) as total'))             
        ->whereYear('a.created_at',$anio)//mostrara los meses en que apenas vamos pasando
        //->whereMonth('a.created_at',$mes)
        ->groupBy(DB::raw('MONTH(a.created_at)'),DB::raw('YEAR(a.created_at)'))
        ->get();





        $detalles=DB::table('detalle_boletas as det')
        ->select(DB::raw('MONTH(det.created_at) as mes'),
                 DB::raw('YEAR(det.created_at) as anio'),
                 DB::raw('COUNT(det.id) as total'))            
        ->whereYear('det.created_at',$anio)//mostrara los meses en que apenas vamos pasando
      
        ->groupBy(DB::raw('MONTH(det.created_at)'),DB::raw('YEAR(det.created_at)'))
        ->get();




        return ['archivos'=>$archivos, 'detalles'=>$detalles ,'anio'=>$anio];      

    }
}
