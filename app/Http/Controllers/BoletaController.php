<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;// anadido por mi para trabajar con transacciones
use Carbon\Carbon; // para la fecha andido por mi
use App\Boleta; // adjuntamos el modelo
use App\DetalleBoleta; // adjuntamos el modelo
use App\User; 
use App\Notifications\NotifyAdmin;


class BoletaController extends Controller
{


    // metodo que optiene todos los registros de la tabla boleta de la base de datos
    public function index(Request $request)
    {
        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        
        //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){

            $boletas = Boleta::join('users','boletas.idusuario','=','users.id')
            ->join('departamentos','boletas.iddepartamento','=','departamentos.id')
            ->join('personas','boletas.idpersona','=','personas.id')
        
            ->select(
            'boletas.id',
            'boletas.num_boleta',
            'boletas.tipo_comprobante',
            'boletas.idusuario',          'users.usuario as usuario',
            'boletas.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
            'boletas.idpersona',          'personas.nombre as nombre',
            
            'boletas.fecha_limite',          
            'boletas.estado',
            'boletas.created_at',
            'boletas.updated_at'


            ) 
            ->OrderBy('id', 'desc')->paginate(8);
                
        }else{

            $boletas = Boleta::join('users','boletas.idusuario','=','users.id')
            ->join('departamentos','boletas.iddepartamento','=','departamentos.id')
            ->join('personas','boletas.idpersona','=','personas.id')
        
            ->select(
            'boletas.id',
            'boletas.num_boleta',
            'boletas.tipo_comprobante',
            'boletas.idusuario',          'users.usuario as usuario',
            'boletas.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
            'boletas.idpersona',          'personas.nombre as nombre',
            
            'boletas.fecha_limite',          
            'boletas.estado',
            'boletas.created_at',
            'boletas.updated_at'

            ) 
            ->where('boletas.'.$criterio, 'like', '%'. $buscar . '%')
            ->OrderBy('id', 'desc')->paginate(8);

        }

        return [
            'pagination' => [
                'total'        =>  $boletas->total(),
                'current_page' =>  $boletas->currentPage(),
                'per_page'     =>  $boletas->perPage(),
                'last_page'    =>  $boletas->lastPage(),
                'from'         =>  $boletas->firstItem(),
                'to'           =>  $boletas->lastItem(),
            ],
            'boletas' =>  $boletas
        ];



    }

    // ESTA BUENO
    // devuelve solo una boleta para almacenarlo en boleta 
    public function obtenerCabecera(Request $request){
       
       // if (!$request->ajax()) return redirect('/');

         //$id = 2;
        $id = $request->id;

        $boleta = Boleta::join('users','boletas.idusuario','=','users.id')
        ->join('departamentos','boletas.iddepartamento','=','departamentos.id')
        ->join('personas','boletas.idpersona','=','personas.id')
        
        ->select(
        'boletas.id',
        'boletas.num_boleta',
        'boletas.tipo_comprobante',
        'boletas.idusuario',          'users.usuario as usuario',
        'boletas.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
        'boletas.idpersona',          'personas.nombre as nombre',
        
        'boletas.fecha_limite', 
        'boletas.estado',
        'boletas.created_at',
        'boletas.updated_at'

        ) 
        ->where('boletas.id','=',$id)
        ->orderBy('boletas.id', 'desc')->take(1)->get(); // seleccioname el unico registro que coincide
        
        return ['boleta' => $boleta];
    }



// devuelve solo un archivo para almacenarlo en detalle de boleta
    public function obtenerDetalles(Request $request){
        
        //if (!$request->ajax()) return redirect('/');
        
        // $id = 2;
        $id = $request->id;
        // hacer un join mas con la tabla documentales
        $detalles = DetalleBoleta::join('archivos','detalle_boletas.idarchivo','=','archivos.id')
        ->join('departamentos','detalle_boletas.idarchivo','=','departamentos.id')// para acceder al nombre del departamento
        ->join('documentales','detalle_boletas.idarchivo','=','documentales.id')
        ->join('boletas','detalle_boletas.idboleta','=','boletas.id')

        ->select(
        'detalle_boletas.id', 
        'boletas.id as idboleta',  
        'archivos.id as idarchivo',
        'detalle_boletas.fecha_devolucion_archivo',
    
        'archivos.iddepartamento as iddepartamento',
        'departamentos.nombre_departamento as nombre_departamento',
      
        'archivos.iddocumental as iddocumental',
        'documentales.nombre_documental as nombre_documental',
        'archivos.viejo_num_expediente as viejo_num_expediente',
        'archivos.fecha_extrema as fecha_extrema',
        'archivos.ubicacion as ubicacion',  
        'archivos.estado' 
        )
          
        ->where('detalle_boletas.idboleta','=',$id)
        ->orderBy('detalle_boletas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }


    public function store(Request $request)
     {
       // if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            // una sola boleta recibe varios archivos como detalle
            $mytime= Carbon::now('America/Costa_Rica');

            $boleta = new Boleta();//id autoincrementable
            $boleta->num_boleta = $request->num_boleta;
            $boleta->tipo_comprobante = 'boleta';
            $boleta->idusuario = \Auth::user()->id;
            $boleta->iddepartamento = $request->iddepartamento;
            $boleta->idpersona = $request->idpersona;
            $boleta->fecha_limite = $request->fecha_limite;
            $boleta->estado = '0';// para que quede como prestada
            $boleta->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleBoleta();//idautoincrementable
                $detalle->idboleta = $boleta->id;
                $detalle->idarchivo = $det['idarchivo'];
                //$detalle->fecha_devolucion_archivo = $det['fecha_devolucion_archivo'];
                $detalle->created_at = $mytime;//AGREGADO POR LOS GRAFICOS DE SALIDA

                $detalle->save();
            }          

                    $fechaActual= date('Y-m-d');
                    $numArchivos = DB::table('archivos')->whereDate('fecha_expiracion',$fechaActual)->count(); //solo devuelve cantidad de expiraciones

                    $arregloDatos = [ 
                        'archivos' => [ 
                                    'numero' => $numArchivos, 
                                    'msj' => 'Archivos Expirados:' 
                                ]
                        ]; 

                        $superAdmin = '1';
                        $admin = '2';
                        $administrador =  User::where('idrol','=', $superAdmin)
                        ->orWhere('idrol','=', $admin)
                        ->select('id')->get();// deberia ser el rol y no el id
                        
                        User::all();

                        foreach ($administrador as $notificar) { 
                            User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos)); //id de los usuarios que van a resivir la notificacion
                        }     


            DB::commit();
            // para que imprima el pdf
            return [
                'id' => $boleta->id
            ];

        } catch (Exception $e){
            DB::rollBack();
        }
    }








    //mediante el metodo Boleta::findOrFail($request->id); el cual hace una comprobacion antes de prestar la boleta
    // esta funcion dejara en estado prestado la boleta
    public function boletaPendiente(Request $request)
    {
     
           // para no volver vulnerable el sitio, accedera solo con la peticion ajax
           if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
        
        $boleta = Boleta::findOrFail($request->id);
        $boleta->estado = '0';
        $boleta->save();
 
 
    }
 


     //mediante el metodo Boleta::findOrFail($request->id); el cual hace una comprobacion antes de devuelta la boleta
    // esta funcion dejara en estado devuelto la boleta
    public function boletaDevuelta(Request $request)
    {
    
           // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz, menu 0
       
        $boleta = Boleta::findOrFail($request->id);
        $boleta->estado = '1';
        $boleta->save();


    }

    // sirve para obtener el numero de la ultima boleta
    public function obtenerUltimoNumeroBoleta(Request $request){

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
       
        $boletas = Boleta::select('num_boleta') 
        ->OrderBy('num_boleta','desc limit 1')->get();//capturamos
        
        return $boletas;
      
        }
    
        //NO LO ESTOY UTILIZANDO
        // sirve para obtener un numero de boleta en caso de que exita se la trae 
    public function buscarNumBoleta(Request $request){

        // para no volver vulnerable el sitio, accedera solo con la peticion ajax
        //if (!$request->ajax()) return redirect('/');   // determina si la peticion es diferente , si es asi redirije a la ruta raiz    
         $num_boleta = 2;
         //$num_boleta = $request->num_boleta;
         $boletas = Boleta::where('num_boleta','=', $num_boleta)
         ->select('num_boleta')->get();//capturamos
             
         return $boletas;
      
        }

    public function pdf(Request $request, $id){

        $boleta = Boleta::join('users','boletas.idusuario','=','users.id')//nombre del responsable que listo la boleta
        ->join('departamentos','boletas.iddepartamento','=','departamentos.id')
        ->join('personas','boletas.idpersona','=','personas.id')//nombre del funcionario cliente
        
        ->select(
        'boletas.id',
        'boletas.num_boleta',
        'boletas.tipo_comprobante',
        'boletas.idusuario',          'users.usuario as usuario',
        'boletas.iddepartamento',     'departamentos.nombre_departamento as nombre_departamento',
        'boletas.idpersona',          'personas.nombre as nombre','personas.tipo_identificacion','personas.num_identificacion',
        'personas.telefono','personas.telefono','personas.email','personas.direccion',
        
        'boletas.fecha_limite', 
        'boletas.estado',
        'boletas.created_at',
        'users.usuario'

        ) 
        ->where('boletas.id','=',$id)
        ->orderBy('boletas.id', 'desc')->take(1)->get(); // seleccioname el unico registro que coincide
        
        $detalles = DetalleBoleta::join('archivos','detalle_boletas.idarchivo','=','archivos.id')
        ->join('departamentos','detalle_boletas.idarchivo','=','departamentos.id')// para acceder al nombre del departamento
        ->join('documentales','detalle_boletas.idarchivo','=','documentales.id')
        ->join('boletas','detalle_boletas.idboleta','=','boletas.id')

        ->select(
        'detalle_boletas.id', 
        'boletas.id as idboleta',  
        'archivos.id as idarchivo',
  
        'archivos.iddepartamento as iddepartamento',
        'departamentos.nombre_departamento as nombre_departamento',
      
        'archivos.iddocumental as iddocumental',
        'documentales.nombre_documental as nombre_documental',
        'archivos.viejo_num_expediente as viejo_num_expediente',
        'archivos.fecha_extrema as fecha_extrema',
        'archivos.ubicacion as ubicacion',  
        'archivos.estado' 
        )
          
        ->where('detalle_boletas.idboleta','=',$id)
        ->orderBy('detalle_boletas.id', 'desc')->get();

        $numboleta=Boleta::select('num_boleta')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.boleta',['boleta'=>$boleta,'detalles'=>$detalles]);

        return $pdf->download('boleta-'.$numboleta[0]->num_boleta.'.pdf');




    }








}












