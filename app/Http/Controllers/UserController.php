<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabajar con transacciones
use App\User;
use App\Persona;
use App\Departamento;




class UserController extends Controller
{
    

  // metodo que optiene todos los registros de la tabla Persona de la base de datos
        // recuerda que para editar es necesario traerse los datos en el metodo enlistar que se vallan a ocupar
        public function index(Request $request)
        {
                // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
            
            $users = User::join('personas','users.id','=','personas.id')
            ->join('departamentos','users.iddepartamento','=','departamentos.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select(
            'users.id',
            'users.iddepartamento', // este es el iddepartamento de la tabla USERS
                'departamentos.nombre_departamento as nombre_departamento',// muestra el de la tabla usuario
                'personas.iddepartamento as iddepartamento', // este es el iddepartamento del tabla PERSONAS
                'personas.nombre as nombre',
                'personas.tipo_identificacion as tipo_identificacion',
                'personas.num_identificacion as num_identificacion',
                'personas.sexo as sexo',
                'personas.telefono as telefono',
                'personas.fax as fax',
                'personas.email as email',
                'personas.direccion as direccion',
            'users.idrol',
                              'roles.id as idR',
                              'roles.nombre as rol', // RECUERDA ES ROL EN VEZ DE NOMBRE_ROL
            'users.usuario',
            'users.password',
            'users.estado'
           
            
            ) 

            ->OrderBy('id', 'desc')->get();//capturamos
            
    
        return $users;


        }



        public function store(Request $request)
        {
            if (!$request->ajax()) return redirect('/');
    
            try{
                DB::beginTransaction();
    
                //$persona = new Persona(); //instancia de la clase persona que en este caso es el modelo
                $persona = Persona::findOrFail($request->id); // busco en el campo id de la tabla persona para actualizar los datos nadamas
                $persona->iddepartamento = $request->iddepartamento;
                $persona->nombre = $request->nombre;
                $persona->tipo_identificacion = $request->tipo_identificacion;
                $persona->num_identificacion = $request->num_identificacion;
                $persona->sexo = $request->sexo;
                $persona->telefono = $request->telefono;
                $persona->fax = $request->fax;
                $persona->email = $request->email;
                $persona->direccion = $request->direccion;
                //$persona->estado = '1';
                $persona->save();
    
                $user = new User(); // aqui si procedo a actualizar los datos
                $user->id = $persona->id; // igual a la persona que viene entrando
                $user->iddepartamento = $request->iddepartamento;    
                $user->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos     
                $user->idrol = $request->idrol;
                $user->usuario = $request->usuario;
                $user->password = bcrypt( $request->password);
                $user->estado = '1';            
                $user->save();
    
                DB::commit();
            } catch (Exception $e){
                DB::rollBack();
            }
        }



        public function update(Request $request)
        {
            if (!$request->ajax()) return redirect('/');

            try{
                DB::beginTransaction();

                $user = User::findOrFail($request->id); // el campo id de tabla user
                $persona = Persona::findOrFail($user->id);
                $persona->iddepartamento = $request->iddepartamento;
                $persona->nombre = $request->nombre;
                $persona->tipo_identificacion = $request->tipo_identificacion;
                $persona->num_identificacion = $request->num_identificacion;
                $persona->sexo = $request->sexo;
                $persona->telefono = $request->telefono;
                $persona->fax = $request->fax;
                $persona->email = $request->email;
                $persona->direccion = $request->direccion;
                $persona->save();

                $user->iddepartamento = $request->iddepartamento;
                $user->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
                $user->idrol = $request->idrol;
                $user->usuario = $request->usuario;
                $user->password = bcrypt( $request->password);
                //$user->estado = '1';            
                $user->save();

                DB::commit();
            } catch (Exception $e){
                DB::rollBack();
            }
        }


        //mediante el metodo User::findOrFail($request->id); el cual hace una comprobacion antes de desactivar
        // esta funcion desactivara el estado
        public function desactivar(Request $request)
        {
                  
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz
            $user = User::findOrFail($request->id);
            $user->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
            $user->estado = '0';
            $user->save();

        }






        //mediante el metodo User::findOrFail($request->id); el cual hace una comprobacion antes de activar
        // esta funcion activara el estado 
        public function activar(Request $request)
        {        
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz       
            $user = User::findOrFail($request->id);
            $user->idusuario = \Auth::user()->id; // para capturar el usuario que hizo la accion y despues con trigger guardarlo en la tabla bitacora de movimientos
            $user->estado = '1';
            $user->save();

        }














}











