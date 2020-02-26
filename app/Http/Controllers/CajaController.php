<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja; // adjuntamos el modelo Caja
use App\Departamento; // adjuntamos el modelo Departamento
use App\User;

class CajaController extends Controller
{
    
        
    // metodo que optiene todos los registros de la tabla caja de la base de datos
    public function index(Request $request)
    {
        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
    
        $cajas = Caja::join('departamentos','cajas.iddepartamento','=','departamentos.id')
        ->select('cajas.id',
        'cajas.iddepartamento',
        'departamentos.nombre_departamento as nombre_departamento',
        'cajas.diminutivo_caja',
        'cajas.num_caja',
        'cajas.ubicacion',
        'cajas.estado') 
        ->OrderBy('id', 'desc')->get();//capturamos
       
       
        return $cajas;

    }




    //metodo que guarda los registros a la tabla caja a la base de datos
        
    public function store(Request $request)
    {

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
    
        $caja = new Caja(); //instancia de la clase caja que en este caso es el modelo
        $caja->iddepartamento = $request->iddepartamento;
        $caja->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $caja->diminutivo_caja = $request->diminutivo_caja;
        $caja->num_caja = $request->num_caja;
        $caja->ubicacion = $request->ubicacion;
        $caja->estado = '1';

        $caja->save();


    }




    //metodo actualizar mediante el metodo Caja::findOrFail($request->id); el cual hace una comprobacion antes de 
    //actualizar los datos
    public function update(Request $request)
    {
        
        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz      
        $caja = Caja::findOrFail($request->id); // busco en la tabla caja
        $caja->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $caja->ubicacion = $request->ubicacion;
       // $caja->estado = '1';
        $caja->save();



    }





    //mediante el metodo Caja::findOrFail($request->id); el cual hace una comprobacion antes de desactivar
    // esta funcion desactivara el estado
    public function desactivar(Request $request)
    {

            
    // para no volver vulnerable el sitio, accedera solo con la peticion ajax
    if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz
    $caja = Caja::findOrFail($request->id);
    $caja->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
    $caja->estado = '0';
    $caja->save();

    }






    //mediante el metodo Caja::findOrFail($request->id); el cual hace una comprobacion antes de activar
    // esta funcion activara el estado 
    public function activar(Request $request)
    {

        
    // para no volver vulnerable el sitio, accedera solo con la peticion ajax
    if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz       
    $caja = Caja::findOrFail($request->id);
    $caja->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
    $caja->estado = '1';
    $caja->save();

    }




    // para que el controlador caja acceda a esta funcion es necesario agregar una ruta
    public function selectNumCaja(Request $request){

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
       
        $id = $request->id;
        $cajas = Caja::where('iddepartamento','=',  $id)
        ->select('num_caja')
        ->OrderBy('num_caja','desc limit 1')->get();//capturamos
            
        return $cajas;
      
        }
    

        
    // Funcion especificamente para llenar el CBX de cajas del modulo de archivo
    // funcion que devuelve todas las cajas de la tabla cajas de la BD  en el modal del modulo archivo cuando entre a actualizar
    public function seleccionarCajas(Request $request){

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
       
        //$id = $request->id;
        $cajas = Caja::where('estado','=','1')
        ->select('id','diminutivo_caja','num_caja')
        ->OrderBy('num_caja','desc limit 1')->get();//capturamos todas las cajas en general
            
        return['cajas'=>$cajas];
      
        }

      // Funcion especificamente para llenar el CBX de cajas del modulo de archivo
      // funcion que devuelve las cajas en especifico dependiendo del departamento seleccionado en el modal del modulo archivo cuando entre a registrar
       public function seleccionarCajasRegistrar(Request $request){

              // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
            
              $id = $request->id; // recibo el id departamento del modulo de archivo
              $cajas = Caja::where('estado','=','1')
              ->select(
                  'id',
                  'diminutivo_caja',
                  'num_caja'
                  )
              ->OrderBy('num_caja','desc limit 1')
              ->where('iddepartamento','=',$id)->get();//capturamos unicamente las cajas pertenecientes a el 
                  
              return['cajas'=>$cajas];
            
        }


         // Funcion especificamente para que despues de seleccionar el CBX de cajas del modulo de archivo le de la ubicacion de la caja a ese archivo
        public function obtenerUbicacionCaja(Request $request){

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
      
            $id = $request->id;
            $cajas = Caja::where('estado','=','1')
            ->select('ubicacion')
            ->where('id','=',  $id)->get();//capturamos
            
            return $cajas;

            
          }
    
         











}











