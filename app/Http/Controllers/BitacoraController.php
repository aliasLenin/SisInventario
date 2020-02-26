<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bitacora; // adjuntamos el modelo


class BitacoraController extends Controller
{
    

    // metodo que optiene todos los registros de la tabla bitacora de la base de datos
    public function index(Request $request)
    {
        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
    
        $bitacoras = Bitacora::OrderBy('idbitacora', 'desc')->get();//capturamos
        return $bitacoras;

    }




}
