<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabajar con transacciones
use App\Persona; // adjuntamos el modelo
use App\Departamento; // adjuntamos el modelo
use App\User;


class PersonaController extends Controller
{

        // metodo que optiene todos los registros de la tabla Persona de la base de datos
        // recuerda que para editar es necesario traerse los datos en el metodo enlistar que se vallan a ocupar
        public function index(Request $request)
        {
                // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
            
            $personas = Persona::join('departamentos','personas.iddepartamento','=','departamentos.id')
            ->select(
            'personas.id',
            'personas.iddepartamento','departamentos.nombre_departamento as nombre_departamento',
            'personas.nombre',
            'personas.tipo_identificacion',
            'personas.num_identificacion',
            'personas.sexo',
            'personas.telefono',
            'personas.fax',
            'personas.email',
            'personas.direccion',
            'personas.estado'
            ) 

            ->OrderBy('id', 'desc')->get();//capturamos
            
    
        return $personas;


        }



        //metodo que guarda los registros a la tabla persona a la base de datos
            
        public function store(Request $request)
        {

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
        
            $persona = new Persona(); //instancia de la clase persona que en este caso es el modelo
            $persona->iddepartamento = $request->iddepartamento;
            $persona->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
            $persona->nombre = $request->nombre;
            $persona->tipo_identificacion = $request->tipo_identificacion;
            $persona->num_identificacion = $request->num_identificacion;
            $persona->sexo = $request->sexo;
            $persona->telefono = $request->telefono;
            $persona->fax = $request->fax;
            $persona->email = $request->email;
            $persona->direccion = $request->direccion;
            $persona->estado = '1';

            $persona->save();


        }




        //metodo actualizar mediante el metodo Persona::findOrFail($request->id); el cual hace una comprobacion antes de 
        //actualizar los datos
        public function update(Request $request)
        {
            
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz   
            
                // que actualize en la tabla persona
                    $persona = Persona::findOrFail($request->id); // busco en la tabla persona
                    $persona->iddepartamento = $request->iddepartamento;
                    $persona->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
                    $persona->nombre = $request->nombre;
                    $persona->tipo_identificacion = $request->tipo_identificacion;
                    $persona->num_identificacion = $request->num_identificacion;
                    $persona->sexo = $request->sexo;
                    $persona->telefono = $request->telefono;
                    $persona->fax = $request->fax;
                    $persona->email = $request->email;
                    $persona->direccion = $request->direccion;
                // $persona->estado = '1';
                    $persona->save();

        }



        //mediante el metodo Persona::findOrFail($request->id); el cual hace una comprobacion antes de desactivar
        // esta funcion desactivara el estado
        public function desactivar(Request $request)
        {

                    
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz
            $persona = Persona::findOrFail($request->id);
            $persona->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
            $persona->estado = '0';
            $persona->save();

        }






        //mediante el metodo Persona::findOrFail($request->id); el cual hace una comprobacion antes de activar
        // esta funcion activara el estado 
        public function activar(Request $request)
        {

                
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz       
            $persona = Persona::findOrFail($request->id);
            $persona->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
            $persona->estado = '1';
            $persona->save();

        }


        // ESTE ES PARA EL CBXPERSONA DEL MODAL USUARIO Y MODULO ARCHIVO TAMBIEN
        // para que el desde la vista usuario se pueda acceder a esta funcion es necesario agregar una ruta
        // mostrara todos las personas cullo campo estado sea igual a 1 
        public function selectPersona(Request $request)
        {
                // para no volver vulnerable el sitio, accedera solo con la peticion ajax
                if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
                $personas = Persona::where('estado','=','1')
                ->select(
                    'personas.id',
                    'personas.nombre'         
                )
             
                ->orderBy('nombre', 'desc')->get();
        
                return ['personas' => $personas];
        } 

       
          // ESTE ES PARA EL CBXPERSONA DEL MODAL USUARIO
         // ESTE ES PARA CUANDO LLENE LOS INPUT DESPUES DE SELECCIONAR LA PERSONA
        public function llenarCampos(Request $request){

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
      
             $id = $request->id;
             //$id = 1;
            $personas = Persona::where('estado','=','1')
            
            ->select(
                   
                    'personas.iddepartamento',
                    'personas.nombre',
                    'personas.tipo_identificacion',
                    'personas.num_identificacion',
                    'personas.sexo',
                    'personas.telefono',
                    'personas.fax',
                    'personas.email',
                    'personas.direccion'             
                )
            ->where('id','=',  $id)->get();//capturamos
            
            return $personas;

            
       }



       // metodo especifico para llenar el CBX DEL MODULO BOLETAS
       public function seleccionarPersona(Request $request)
       {
               // para no volver vulnerable el sitio, accedera solo con la peticion ajax
               if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    

               $filtro = $request->filtro;

               $personas = Persona::where('estado','=','1')
               ->select(
                   'personas.id',
                   'personas.nombre',
                   'personas.num_identificacion',  
                   'personas.email'         
               )
               ->where('personas.nombre', 'like', '%'. $filtro . '%')
               ->orderBy('personas.nombre', 'desc')->take(2)->get(); // tome solo dos

               return ['personas' => $personas];
       } 

















}























