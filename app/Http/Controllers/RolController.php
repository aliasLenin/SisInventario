<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;


class RolController extends Controller
{
    


    // metodo que optiene todos los registros de la tabla roles de la base de datos
    public function index(Request $request)
    {
        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
    
        $roles = Rol::OrderBy('id', 'desc')->get();//capturamos
        return $roles;      
        
    }

    // para que el desde la vista usuario se pueda acceder a esta funcion es necesario agregar una ruta
    // mostrara todos los roles cullo campo estado sea igual a 1
    public function selectRol(Request $request)
    {
             // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
        
            $roles = Rol::where('condicion', '=', '1')
            ->select('id','nombre')
            ->orderBy('nombre', 'desc')->get();
    
            return ['roles' => $roles];
    } 





}




















