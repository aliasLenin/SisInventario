<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento; // adjuntamos el modelo
use App\User;

class DepartamentoController extends Controller
{
   


// metodo que optiene todos los registros de la tabla departamento de la base de datos
    public function index(Request $request)
    {
          // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
        $departamentos = Departamento::OrderBy('id', 'desc')->get();//capturamos
        return $departamentos;

    }



//metodo que guarda los registros a la tabla departamento a la base de datos
    
    public function store(Request $request)
    {

          // para no volver vulnerable el sitio, accedera solo con la peticion ajax
          if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
        $departamento = new Departamento(); //instancia de la clase departamento que en este caso es el modelo
        $departamento->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $departamento->nombre_departamento = $request->nombre_departamento;
        $departamento->diminutivo_departamento = $request->diminutivo_departamento;
        $departamento->descripcion = $request->descripcion;
        $departamento->estado = '1';
        $departamento->save();


    }




//metodo actualizar mediante el metodo Departamento::findOrFail($request->id); el cual hace una comprobacion antes de 
//actualizar los datos
    public function update(Request $request)
    {
        
          // para no volver vulnerable el sitio, accedera solo con la peticion ajax
          if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
        $departamento = Departamento::findOrFail($request->id); // busco en la tabla departamento
        $departamento->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $departamento->nombre_departamento = $request->nombre_departamento; // le enviamos los datos
        $departamento->diminutivo_departamento = $request->diminutivo_departamento;
        $departamento->descripcion = $request->descripcion;
        //$departamento->estado = '1';
        $departamento->save();



    }

        // para que el controlador caja acceda a esta funcion es necesario agregar una ruta
        // mostrara el codigo diminutivo dependiendo del departamento seleccionado del cbx del modal
        public function selectDiminutivoDepartamento(Request $request){

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
      
            $id = $request->id;
            $departamentos = Departamento::where('estado','=','1')
            ->select('diminutivo_departamento')
            ->where('id','=',  $id)->get();//capturamos
            
            return $departamentos;

            
            }



    //mediante el metodo Departamento::findOrFail($request->id); el cual hace una comprobacion antes de desactivar
    // esta funcion desactivara el estado
   public function desactivar(Request $request)
   {
    
          // para no volver vulnerable el sitio, accedera solo con la peticion ajax
          if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
       $departamento = Departamento::findOrFail($request->id);
       $departamento->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
       $departamento->estado = '0';
       $departamento->save();


   }






     //mediante el metodo Departamento::findOrFail($request->id); el cual hace una comprobacion antes de activar
    // esta funcion activara el estado 
    public function activar(Request $request)
    {
    
           // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
        $departamento = Departamento::findOrFail($request->id);
        $departamento->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
        $departamento->estado = '1';
        $departamento->save();


    }



     //CBX BOLETAS
    // para que el controlador caja acceda a esta funcion es necesario agregar una ruta
    // mostrara todos los departamentos cullo campo estado sea igual a 1
    public function selectDepartamento(Request $request){

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
        
        $departamentos = Departamento::where('estado','=','1')
        //si se necesita seleccionar mas pues se hace 
        ->select('id','nombre_departamento','diminutivo_departamento') // este va a hacer el diminutivo de caja
        ->orderBy('nombre_departamento','desc')->get();//capturamos
        
        return['departamentos'=>$departamentos];
        
        }


    public function validarExistencia(Request $request){

        $nombre_departamento = $request->nombre_departamento;
        $departamentos = Departamento::where('nombre_departamento','=', $nombre_departamento)
        ->select('nombre_departamento','diminutivo_departamento')
        ->OrderBy('nombre_departamento','desc limit 1')->get();//capturamos    
        return $departamentos;

         


            
    }
    

        



}
