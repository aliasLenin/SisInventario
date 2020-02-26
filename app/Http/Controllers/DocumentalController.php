<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documentales; // adjuntamos el modelo
use App\User;


class DocumentalController extends Controller
{
    




// metodo que optiene todos los registros de la tabla documentales de la base de datos
    public function index(Request $request)
    {
        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
        $documentales = Documentales::OrderBy('id', 'desc')->get();//capturamos
        return $documentales;
        
        
    }


    
    //metodo que guarda los registros a la tabla documentales a la base de datos
  
    public function store(Request $request)
    {
        
            
    // para no volver vulnerable el sitio, accedera solo con la peticion ajax
    if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
    
    $documental = new Documentales();
    $documental->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
    $documental->nombre_documental = $request->nombre_documental;
    $documental->codigo_diminutivo = $request->codigo_diminutivo;
    $documental->descripcion = $request->descripcion;
    $documental->vigencia = $request->vigencia;
    $documental->estado = '1';
    $documental->save();


    }




    //metodo actualizar mediante el metodo Documental::findOrFail($request->id); el cual hace una comprobacion antes de 
    //actualizar los datos

    public function update(Request $request)
    {
      

    // para no volver vulnerable el sitio, accedera solo con la peticion ajax
    if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz      
    $documental = Documentales::findOrFail($request->id); // busco en la tabla codigo
    $documental->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
    $documental->nombre_documental = $request->nombre_documental; // le enviamos los datos
    $documental->codigo_diminutivo = $request->codigo_diminutivo; 
    $documental->descripcion = $request->descripcion;
    $documental->vigencia = $request->vigencia;
    //$documental->estado = '1';
    $documental->save();


    }

    

    // esta funcion desactivara el estado de documental en especifco 
    public function desactivar(Request $request)
    {
        
    // para no volver vulnerable el sitio, accedera solo con la peticion ajax
    if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz
       
    
        $documental = Documentales::findOrFail($request->id);
        $documental->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $documental->estado = '0';
        $documental->save();



    }





    // esta funcion activara el estado del que se encontrara el codigo
    public function activar(Request $request)
    {

    // para no volver vulnerable el sitio, accedera solo con la peticion ajax
    if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz       
       
        $documental = Documentales::findOrFail($request->id);
        $documental->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $documental->estado = '1';
        $documental->save();

    }



        
    // Funcion especificamente para llenar el CBX de documentales del modulo de archivo (en el modulo de cajas tambien pero ya no se esta usuando)
    // funcion que devuelve todas los documentales registrados de la tabla documentales de la BD
    public function seleccionarDocumentales(Request $request){

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
       
        //$id = $request->id;
        $documentales = Documentales::where('estado','=','1')
        ->select('id','nombre_documental','codigo_diminutivo')
        ->OrderBy('nombre_documental','desc limit 1')->get();//capturamos
      
        return['documentales'=>$documentales];
      
        }

        

            // selecciona el codigo_diminutivo del id tipo documental proveniente del metodo utilizado en el modulo de archivo para dar formato al nuevo numero de expediente y viejo numero de expediente en caso de que el archivo a registrar no lo traiga
        public function selectCodigoDiminutivo(Request $request){

                // para no volver vulnerable el sitio, accedera solo con la peticion ajax
                if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
            
                $id = $request->id; // viene el id del documental seleccionado en la vista archivo
                $documentales = Documentales::where('estado','=','1')
                ->select('codigo_diminutivo')
                ->where('id','=',  $id)->get();//capturamos
                    
                return $documentales;
            
        }
            












}






