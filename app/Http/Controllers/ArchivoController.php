<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB; // para trabajar con transacciones
use App\Archivo; // adjuntamos el modelo Archivo
use Carbon\Carbon; // para la fecha de ingreso
use DB;
use Excel;
use Input;


class ArchivoController extends Controller
{
       // metodo que optiene todos los registros de la tabla  archivo de la base de datos
       public function index(Request $request)
       {
           // para no volver vulnerable el sitio, accedera solo con la peticion ajax
           if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0     
           $archivos = Archivo::join('departamentos','archivos.iddepartamento','=','departamentos.id')
            ->join('documentales','archivos.iddocumental','=','documentales.id')
            ->join('personas','archivos.idpersona','=','personas.id')
            ->join('cajas','archivos.idcaja','=','cajas.id')
            ->join('users','archivos.idusuario','=','users.id')
         
           ->select(
           'archivos.id',
           'archivos.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
           'archivos.iddocumental',       'documentales.nombre_documental as nombre_documental',        'documentales.codigo_diminutivo as codigo_diminutivo',
           'archivos.idpersona',          'personas.nombre as nombre',
           'archivos.idcaja',             'cajas.diminutivo_caja as diminutivo_caja',                   'cajas.num_caja as num_caja',
           'archivos.idusuario',          'users.usuario as usuario',

           'archivos.nuevo_num_expediente',
           'archivos.viejo_num_expediente',
           'archivos.contenido',
           'archivos.fecha_extrema',
           'archivos.anno',
           'archivos.ubicacion',
           'archivos.descripcion',
           'archivos.valor',
           'archivos.vigencia',
           'archivos.estado',
           'archivos.created_at'
     
          ) 
           ->where('archivos.estado','=', '1')
           ->orWhere('archivos.estado','=', '2')

           ->OrderBy('id', 'desc')->get();//capturamos
                
           return $archivos;
       }
   




        //metodo que guarda los registros a la tabla archivo a la base de datos
            
        public function store(Request $request)
        {

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
               if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
            
                $fecha_actual= Carbon::now('America/Costa_Rica'); // capturo la fecha actual
                $aux = $request->vigencia;// capturo la cantidad de anos que dijito que viene de la vista pueden ser 1 o 2 o hasta 18 
                $aux_fecha_expiracion = strtotime ( '+'.$aux.' year' , strtotime ( $fecha_actual ) ) ;// sumo esos 18 a la fecha actual y los guardo en la base de datos
                $fecha_expiracion = date ( 'Y-m-d h:i:s' , $aux_fecha_expiracion ); // y le doy formato para mas abajo enviarlo a la base de datos


                
                $archivo = new Archivo(); //instancia de la clase archivo que en este caso es el modelo
            
                $archivo->iddepartamento = $request->iddepartamento;
                $archivo->iddocumental = $request->iddocumental;
                $archivo->idpersona = $request->idpersona;
                $archivo->idcaja = $request->idcaja;
                $archivo->idusuario = \Auth::user()->id; // va quemado por el momento
                $archivo->nuevo_num_expediente = $request->nuevo_num_expediente;
                $archivo->viejo_num_expediente = $request->viejo_num_expediente;
                $archivo->contenido = $request->contenido;
                $archivo->fecha_extrema = $request->fecha_extrema;
                $archivo->anno = $request->anno;
                $archivo->ubicacion = $request->ubicacion;
                $archivo->descripcion = $request->descripcion;
                $archivo->valor = $request->valor;
                $archivo->vigencia = $request->vigencia;
                $archivo->estado = $request->estado;
                $archivo->fecha_expiracion = $fecha_expiracion;

                $archivo->save();


        }




        //metodo actualizar mediante el metodo Archivo::findOrFail($request->id); el cual hace una comprobacion antes de 
        //actualizar los datos
        public function update(Request $request)
        {
            
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz      
          
                $fecha_actual= Carbon::now('America/Costa_Rica');
                $aux = $request->vigencia;
                $aux_fecha_expiracion = strtotime ( '+'.$aux.' year' , strtotime ( $fecha_actual ) ) ;
                $fecha_expiracion = date ( 'Y-m-d h:i:s' , $aux_fecha_expiracion );

                $archivo = Archivo::findOrFail($request->id); // busco en la tabla archivo
            
                $archivo->iddepartamento = $request->iddepartamento;
                $archivo->iddocumental = $request->iddocumental;
                $archivo->idpersona = $request->idpersona;
                $archivo->idcaja = $request->idcaja;
                $archivo->idusuario = \Auth::user()->id; 
                $archivo->nuevo_num_expediente = $request->nuevo_num_expediente;
                $archivo->viejo_num_expediente = $request->viejo_num_expediente;
                $archivo->contenido = $request->contenido;
                $archivo->fecha_extrema = $request->fecha_extrema;
                $archivo->anno = $request->anno;
                $archivo->ubicacion = $request->ubicacion;
                $archivo->descripcion = $request->descripcion;
                $archivo->valor = $request->valor;
                $archivo->vigencia = $request->vigencia;
                $archivo->estado = $request->estado;
                $archivo->fecha_expiracion = $fecha_expiracion;


                $archivo->save();



        }


        //mediante el metodo Archivo::findOrFail($request->id); el cual hace una comprobacion antes de desactivar
        // esta funcion desactivara el estado
        public function desactivar(Request $request)
        {

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz
            $archivo = Archivo::findOrFail($request->id);
            $archivo->estado = '2';
            $archivo->save();

        }



        //mediante el metodo Archivo::findOrFail($request->id); el cual hace una comprobacion antes de activar
        // esta funcion activara el estado 
        public function activar(Request $request)
        {
         
            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz       
            $archivo = Archivo::findOrFail($request->id);
            $archivo->estado = '1';
            $archivo->save();

        }

        
        //mediante el metodo Archivo::findOrFail($request->id); el cual hace una comprobacion antes de poener en estado eliminado un archivo en especifico
        // esta funcion eliminara por completo un registro en especifico
        public function destroy(Request $request)
        {

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz
            $archivo = Archivo::findOrFail($request->id);
            $archivo->estado = '3';
            $archivo->save();

               // $id = $request->id;
               // $usuario = DB::table('archivos')
               // ->where('id','=',$id)
               // ->delete(); // donde esta el id, sea igual al que viene por parametro eliminilo

        }





            // selecciona el nuevo_num_expediente del ultiomo tipo documental
        public function selectNumExpediente(Request $request)
        {

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
        
            $id = $request->id; // viene el id del documental seleccionado en la vista archivo
            $archivo = Archivo::where('iddocumental','=',  $id)
            ->select('nuevo_num_expediente')
            ->OrderBy('nuevo_num_expediente','desc limit 1')->get();//capturamos el ultimo nuevo_num_expediente guardado de ese documental seleccionado 
                
            return $archivo;
        
        }
        

            // metodo especifico para el llenar cbx del modulo consultar archivo
        public function selectArchivo(Request $request)
        {

            // para no volver vulnerable el sitio, accedera solo con la peticion ajax
            //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
            
            $archivos = Archivo::select('id','viejo_num_expediente','nuevo_num_expediente','estado') 
            ->orderBy('nuevo_num_expediente','desc')->get();//capturamos
            
            return['archivos'=>$archivos];
            
        }
        
            // del modelo Boleta del ejemplo de codigo de barras se puede hacer un inner join para devolver todos los datos de la tabla archivo si deceo
            // el campo estado me lo llevo simplemente para validarlo en el modulo boletas
        public function buscarArchivo(Request $request)
        {
                
                if (!$request->ajax()) return redirect('/');
        
                $filtro = $request->filtro;
                $archivos = Archivo::join('documentales','archivos.iddocumental','=','documentales.id')
                ->select(
                    'archivos.id',
                    'archivos.iddocumental',
                    'documentales.nombre_documental as nombre_documental',
                    'archivos.viejo_num_expediente',
                    'archivos.fecha_extrema',
                    'archivos.ubicacion',
                    'archivos.estado'
                    

                    )  
                ->where('viejo_num_expediente','=', $filtro)
                ->orderBy('id', 'asc')->take(1)->get();
        
                return ['archivos' => $archivos];
        }

         // metodo que optiene todos los registros de la tabla archivo de la base de datos
        // del modelo Boleta para llenar el modal
        // el campo estado me lo llevo simplemente para validarlo en el modulo boletas
       public function listarArchivosModalBoleta(Request $request)
       {
           // para no volver vulnerable el sitio, accedera solo con la peticion ajax
           if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0   
           
           $buscar = $request->buscar;
           $criterio = $request->criterio;

           if ($buscar==''){

                        $archivos = Archivo::join('departamentos','archivos.iddepartamento','=','departamentos.id')
                            ->join('documentales','archivos.iddocumental','=','documentales.id')
                            ->join('personas','archivos.idpersona','=','personas.id')
                            ->join('cajas','archivos.idcaja','=','cajas.id')
                            ->join('users','archivos.idusuario','=','users.id')
                        
                        ->select(
                        'archivos.id',
                        'archivos.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
                        'archivos.iddocumental',       'documentales.nombre_documental as nombre_documental',        'documentales.codigo_diminutivo as codigo_diminutivo',
                        'archivos.idpersona',          'personas.nombre as nombre',
                        'archivos.idcaja',             'cajas.diminutivo_caja as diminutivo_caja',                   'cajas.num_caja as num_caja',
                        'archivos.idusuario',          'users.usuario as usuario',

                        'archivos.nuevo_num_expediente',
                        'archivos.viejo_num_expediente',
                        'archivos.contenido',
                        'archivos.fecha_extrema',
                        'archivos.anno',
                        'archivos.ubicacion',
                        'archivos.descripcion',
                        'archivos.valor',
                        'archivos.vigencia',
                        'archivos.estado',
                        'archivos.created_at'
                    
                        )
                        ->where('archivos.estado','=', '1')
                        ->orWhere('archivos.estado','=', '2')
                        ->OrderBy('archivos.id', 'desc')
                        ->paginate(10);// muestro los 10 primeros resultados nadamas

           }else{

                        $archivos = Archivo::where('archivos.estado','!=', '3')
                            ->join('departamentos','archivos.iddepartamento','=','departamentos.id')
                            ->join('documentales','archivos.iddocumental','=','documentales.id')
                            ->join('personas','archivos.idpersona','=','personas.id')
                            ->join('cajas','archivos.idcaja','=','cajas.id')
                            ->join('users','archivos.idusuario','=','users.id')
                        
                        ->select(
                        'archivos.id',
                        'archivos.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
                        'archivos.iddocumental',       'documentales.nombre_documental as nombre_documental',        'documentales.codigo_diminutivo as codigo_diminutivo',
                        'archivos.idpersona',          'personas.nombre as nombre',
                        'archivos.idcaja',             'cajas.diminutivo_caja as diminutivo_caja',                   'cajas.num_caja as num_caja',
                        'archivos.idusuario',          'users.usuario as usuario',

                        'archivos.nuevo_num_expediente',
                        'archivos.viejo_num_expediente',
                        'archivos.contenido',
                        'archivos.fecha_extrema',
                        'archivos.anno',
                        'archivos.ubicacion',
                        'archivos.descripcion',
                        'archivos.valor',
                        'archivos.vigencia',
                        'archivos.estado',
                        'archivos.created_at'
                    
                        ) 
                        ->where('archivos.'.$criterio, 'like', '%'. $buscar . '%')
                        ->OrderBy('archivos.id', 'desc')
                        ->paginate(10);// muestro los 10 primeros resultados nadamas

           }
            // si deceo pagino tambien 
           return ['archivos' => $archivos];

       }
   


            // metodo que optiene todos los registros de la tabla  archivo de la base de datos que va expirando
        public function expiraciones(Request $request)
        {
                $fecha_actual= Carbon::now('America/Costa_Rica'); // capturo la fecha actual para compararla con el campo fecha_expiracion y asi traerse los registros que verdaderamente van expirando

                // para no volver vulnerable el sitio, accedera solo con la peticion ajax
                // if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0     
                $archivos = Archivo::join('departamentos','archivos.iddepartamento','=','departamentos.id')
                 ->join('documentales','archivos.iddocumental','=','documentales.id')
                 ->join('personas','archivos.idpersona','=','personas.id')
                 ->join('cajas','archivos.idcaja','=','cajas.id')
                 ->join('users','archivos.idusuario','=','users.id')
              
                ->select(
                'archivos.id',
                'archivos.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
                'archivos.iddocumental',       'documentales.nombre_documental as nombre_documental',        'documentales.codigo_diminutivo as codigo_diminutivo',
                'archivos.idpersona',          'personas.nombre as nombre',
                'archivos.idcaja',             'cajas.diminutivo_caja as diminutivo_caja',                   'cajas.num_caja as num_caja',
                'archivos.idusuario',          'users.usuario as usuario',
     
                'archivos.nuevo_num_expediente',
                'archivos.viejo_num_expediente',
                'archivos.contenido',
                'archivos.fecha_extrema',
                'archivos.anno',
                'archivos.ubicacion',
                'archivos.descripcion',
                'archivos.valor',
                'archivos.vigencia',
                'archivos.estado',
                'archivos.created_at'
          
               ) 
                ->where('archivos.fecha_expiracion','<', $fecha_actual)
     
                ->OrderBy('id', 'desc')->get();//capturamos
                     
                return $archivos;
        }
     








}















