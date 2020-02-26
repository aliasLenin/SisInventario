<template>
    
<main class="main">
            <!-- Breadcrumb  -->
            <ol class="breadcrumb">            
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li> <!--  href="/" con hacemos referencia a la raiz de todas las vista--> 
            </ol>
            <div class="container-fluid"><!-- comienzo ventana -->
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Listado de Boletas
                            <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>

                     <!-- template del listado de las boletas -->
                   <template v-if="listado==1">
                    <div class="card-body">                
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="num_boleta">Numero boleta</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarBoleta(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarBoleta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Num</th>
                                            <th>Comprobante</th>
                                            <th>Gestor</th>
                                            <th>Dependencia</th>
                                            <th>Responsable</th>
                                            <th>Fecha Registro</th> <!-- trabajar con el created_at de la base de datos-->
                                            <th>Fecha Limite</th>
                                            <th>Fecha Devolucion</th>
                                            <th>Estado</th>
                                        
                                        

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for= "boleta in arrayBoleta" :key = "boleta.id">
                                        
                                        
                                            <td>

                                                <button type="button"  @click="verBoleta(boleta.id)" class="btn btn-success btn-sm"> <!-- observar la boleta-->
                                                <i class="icon-eye"></i>
                                                </button> &nbsp;


                                                <template v-if="boleta.estado"> <!-- si nuestro estado es 1 -->
                                                    <button type="button" class="btn btn-danger btn-sm" @click="boletaPendiente(boleta.id)" > <!-- eneviamos el id al metodo -->
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                   
                                                </template>

                                                <template v-else>
                                                    <button type="button" class="btn btn-info btn-sm"  @click="boletaDevuelta(boleta.id)" >  <!-- eneviamos el id al metodo -->
                                                        <i class="icon-check"></i>
                                                    </button>
                                                 
                                                </template>

                                                 <template>
                                                      &nbsp;
                                                    <button type="button"  @click="pdfBoleta(boleta.id)" class="btn btn-warning btn-sm"> <!-- observar la boleta-->
                                                    <i class="icon-doc"></i>
                                                    </button>
                                                 </template>
                                            

                                            </td>
                                                    
                                                    <td v-text="boleta.num_boleta"></td> 
                                                    <td v-text="boleta.tipo_comprobante"></td> 
                                                    <td v-text="boleta.usuario"></td>
                                                    <td v-text="boleta.nombre_departamento"></td>
                                                    <td v-text="boleta.nombre"></td> 
                                                    <td v-text="boleta.created_at"></td>
                                                    <td v-text="boleta.fecha_limite"></td>
                                                   
                                        
                                                <td>
                                                    <div v-if="boleta.created_at == boleta.updated_at"> <!-- si el estado es 1 fue xq la devolvio-->
                                                        <span>Vacio</span>
                                                    </div>
                                                    <div v-else>  
                                                       <p v-text="boleta.updated_at"></p> <!--  +'-'+ boleta.created_at -->
                                                    </div>
                                                </td>
                                            

                                                    
                                                <td>
                                                    <div v-if="boleta.estado"> <!-- si el estado es 1 fue xq la devolvio-->
                                                        <span class="badge badge-success">Devuelta</span>
                                                    </div>
                                                    <div v-else>  <!-- si el estado es 0 aun no devuelven los archivos -->
                                                        <span class="badge badge-danger">Pendiente</span>
                                                    </div>
                                                </td>
                                            
                                            
                                            
                                        </tr>
                                    
                                    </tbody>
                                </table>
                      </div>

                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>                           
                    </div> <!-- Fin ejemplo de tabla Listado -->
                   </template>








                    <!-- template para egregar los archivo -->
                   <template v-else-if="listado==0">
                    <!-- detalle --> 
                    <div class="card-body">             
                        <!-- cabecera de la boleta  -->





                                <div class="form-group row border" > 

                                                                            <!--combobx para seleccionar persona -->
                                                <div class="col-md-3">                                                                                                                  
                                                              <div class="form-group">
                                                                   <label>Responsable documentacion:</label>
                                                                <select v-model="idpersona" class="form-control" maxlength="10" required>
                                                                    <option value="0" disabled>Seleccione</option>
                                                                    <option v-for="persona in arrayPersona" :key="persona.id" :value="persona.id" v-text="persona.nombre"></option>
                                                                </select>
                                                            </div>
                                                </div>

                        
                                                <div class="col-md-3">
                                                    
                                                      <div class="form-group">
                                                           <label>Departamento:</label>
                                                        <select  v-model="iddepartamento" class="form-control" maxlength="10" required> <!--enlazamos con la variable iddepartamento declarada abajo en la propieda data-->
                                                            <option value="0" disabled>Seleccione</option>
                                                            <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre_departamento"></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <label>Fecha limite devolucion Boleta:</label>
                                                    <input  type="datetime-local"  v-model="fecha_limite" class="form-control" step="1" min="2000-01-01T00:00" max="2030-12-31T12:00" required>     
                                                    
                                                    </div>
                                                </div>
                                                <!-- align rigth-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Numero Boleta:</label>
                                                        <input type="text" v-model="num_boleta"  v-bind:disabled="bloquear" class="form-control" maxlength="45" required>
                                                    </div>
                                                </div>
                                </div>  <!--fin del primer border -->







                        <!-- el boton que busca los archivo -->
                                <div class="form-group row border" > 
                                
                                    <div class="col-md-9">
                                        <div class="form-group"> <!-- solo se muestre cuando el idarchivo sea igual a cero-->
                                            <label>Archivo <span style="color:red;" v-show="idarchivo==0">(*Seleccione)</span></label>
                                            <div class="form-inline">                                          <!-- cuando precione la tecla enter -->
                                                <input type="text" class="form-control" v-model="aux_expediente" @keyup.enter="buscarArchivo()" placeholder="Numero de expediente">
                                                <button @click="abrirModal()" class="btn btn-primary">...</button>
                                                <input type="text" readonly class="form-control" v-model="mensaje">
                                            </div>                                    
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div v-show="errorBoleta" class="form-group row div-error">
                                            <div class="text-center text-error">
                                                <div v-for="error in errorMostrarMsjBoleta" :key="error" v-text="error">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!--fin del segundo border -->






                        <!-- tabla dinamica de abajo-->
                                <div class="form-group row border" > 

                                    <div class="table-responsive col-md-12">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Numero expediente</th>
                                                    <th>Tipo documental</th>
                                                    <th>Fecha extrema</th>
                                                    <th>ubicacion del archivo</th>
                                                    <!-- <th>fecha_devolucion</th>  esta columna estaba por si carolina deceaba ya dejar entre dicho con el funcionario que archivo especificamente le iba a poder devolver el y no toda la boleta necesariamente-->
                                                </tr>
                                            </thead>
                                            <tbody v-if="arrayDetalle.length">
                                                <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id"> <!-- el (detalle,index) es para poder iliminar los archivos que se van agregando dinamicamente a la boleta-->

                                                    <td>
                                                        <!-- mediante el index declarado arribita es como se va a poder ir eliminando cada archivo-->
                                                        <button    @click="eliminarDetalle(index)"                      type="button" class="btn btn-danger btn-sm">
                                                            <i class="icon-close"></i>
                                                        </button>
                                                    </td>

                                                    <td v-text="detalle.viejo_num_expediente">                                                      
                                                        <!--<input v-model="detalle.viejo_num_expediente" type="text" class="form-control">-->
                                                    </td>

                                                    <td v-text="detalle.nombre_documental">                                                 
                                                       <!--<input v-model="detalle.nombre_documental" type="text" class="form-control">-->
                                                   
                                                    </td>

                                                    <td v-text="detalle.fecha_extrema">
                                                       <!-- <input v-model="detalle.fecha_extrema" type="text" class="form-control">-->
                                                    </td>

                                                    <td v-text="detalle.ubicacion">
                                                       <!-- <input v-model="detalle.ubicacion" type="text" class="form-control">-->
                                                    </td>
                                            

                                                </tr>
                                                    
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        NO hay archivos agregados
                                                    </td>
                                                </tr>
                                            </tbody>         
                                                                        
                                        </table>
                                    </div>

                                
                                </div>  <!--fin del tercer border -->

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                        <button type="button" class="btn btn-primary" @click="registrarBoleta()">Registrar Boleta</button>
                                    </div>
                                </div>
                    </div>
                   </template>






                    <!-- template para observar los archivos en la boleta ya registrada -->
                   <template  v-else-if="listado==2">
                    <!-- detalle --> 
                    <div class="card-body">             
                        <!-- cabecera de la boleta  -->
                                <div class="form-group row border" > 

                                                 <!-- align rigth-->
                                               <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Numero Boleta:</label>
                                                         <p v-text="num_boleta"></p>
                                                    </div>
                                                </div>
                                               
                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Tipo comprobante:</label>
                                                         <p v-text="tipo_comprobante"></p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Usuario gestor:</label>
                                                         <p v-text="usuario"></p>
                                                    </div>
                                                </div>

                                                  <div class="col-md-4">
                                                        <div class="form-group">
                                                                <label for="">Dependencia solicito</label>
                                                                <p v-text="nombre_departamento"></p>
                                                            </div>                                                                                              
                                                </div>

                                                <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="">Responsable documentacion</label>
                                                                <p v-text="nombre"></p>
                                                            </div>        
                                                </div>
                                                                                     
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <label>Fecha limite devolucion Boleta:</label>
                                                     <p v-text="fecha_limite"></p>                                           
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <label>Fecha devolucion Boleta:</label>  
                                                             <div v-if="created_at == updated_at"> <!-- si el estado es 1 fue xq la devolvio-->
                                                                <span>Vacio</span>
                                                              </div>
                                                              <div v-else>  
                                                               <p v-text="updated_at"></p>    
                                                              </div>
                                                                                                                                                        
                                                    </div>
                                                </div>
                                                
                                            
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Estado de la boleta:</label>
                                                         <div v-if="estado ==1"> <!-- si el estado es 1-->
                                                        <span class="badge badge-success">Devuelta</span>
                                                        </div>
                                                        <div v-else> 
                                                        <span class="badge badge-danger">Pendiente</span>
                                                        </div>
                                                    </div>
                                                   </div> 

                                                
                                                <div class="col-md-4">
                                                        <div class="form-group">
                                                        <label>Fecha registro:</label>
                                                        <p v-text="created_at"></p>                                           
                                                        </div>
                                                </div>
                                                                                           
                                </div>  <!--fin del primer border -->

                        <!-- tabla dinamica de abajo-->
                                <div class="form-group row border" > 

                                    <div class="table-responsive col-md-12">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Numero expediente</th>
                                                    <th>Tipo documental</th>
                                                    <th>Fecha extrema</th>
                                                    <th>ubicacion del archivo</th>
                                                  <!--  <th>fecha devolucion archivo</th>   esta columna estaba por si carolina deceaba ya dejar entre dicho con el funcionario que archivo especificamente le iba a poder devolver el y no toda la boleta necesariamente-->
                                                    <th>estado</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="arrayDetalle.length">
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.id"> <!-- el (detalle,index) es para poder iliminar los archivos que se van agregando dinamicamente a la boleta-->

                                                    <td>
                                                            <div v-if="detalle.estado==1">
                                                            <!--  @click="activarArchivo(detalle.idarchivo)" se le indica envia el campo idarchivo del array xq asi es como ira a desactivar  <i class="icon-close"></i>-->
                                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarArchivo(detalle.idarchivo)">
                                                                  <i class="icon-trash"></i>
                                                            </button>
                                                            </div>
                                                         
                                                          <div v-else> 
                                                            <button type="button" class="btn btn-info btn-sm" @click="activarArchivo(detalle.idarchivo)">  <!-- eneviamos el id al metodo -->
                                                                <i class="icon-check"></i>
                                                            </button>
                                                           </div>
                                                    </td>

                                                    <td v-text="detalle.viejo_num_expediente">
                                                    </td>

                                                    <td v-text="detalle.nombre_documental">                                                    
                                                    </td>

                                                    <td v-text="detalle.fecha_extrema">                                                        
                                                    </td>

                                                    <td v-text="detalle.ubicacion">                                                   
                                                    </td>
                                                
                                                   <!-- <td v-text="detalle.fecha_devolucion_archivo"> 
                                                    </td>-->

                                                     <td >  
                                                            <div v-if="detalle.estado==1"> <!-- si el estado es 1-->
                                                            <span class="badge badge-success">Disponible</span>
                                                            </div>
                                                            <div v-else> 
                                                            <span class="badge badge-danger">Prestado</span>
                                                            </div>
                                                    </td>                                        
                                                </tr>
                                                    
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        NO hay archivos agregados
                                                    </td>
                                                </tr>
                                            </tbody>         
                                                                        
                                        </table>
                                    </div>

                                
                                </div>  <!--fin del tercer border -->

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                    </div>
                                </div>
                    </div>
                   </template>


                </div>   
            </div><!-- Fin ventana --> 

















 <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <select class="form-control col-md-3" v-model="criterioA">
                                            <option value="viejo_num_expediente">Viejo # expediente</option>
                                            <option value="descripcion">descripcion</option>
                                            <option value="contenido">contenido</option>
                                            </select>
                                            <input type="text" v-model="buscarA" @keyup.enter="listarArchivosModalBoleta(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                            <button type="submit" @click="listarArchivosModalBoleta(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive"> 

                                            <table class="table table-bordered table-striped table-sm table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Opciones</th>
                                                        <th>Diminutivo caja</th>               
                                                        <th>Viejo # expediente</th>
                                                        <th>Departamento</th>
                                                        <th>Tipo Documental</th>
                                                        <th>Fecha Extrema</th>
                                                    <!--  <th>Anno</th> -->
                                                        <th>Ubicacion</th>
                                                    <!--   <th>Ususario Gestor</th> -->
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for= "archivo in arrayArchivo" :key = "archivo.id">
                                                    
                                                    
                                                        <td>

                                                            <!-- invocamos a la funcion abrir modal pero esta vez para actualizar y le enviamos el modelo-->
                                                        <button type="button"  @click="agregarDetalleModal(archivo)" class="btn btn-success btn-sm"> 
                                                        <i class="icon-check"></i>
                                                        </button> 

                                                        </td>

                                                                <td v-text="archivo.diminutivo_caja"></td>                                                              
                                                                <td v-text="archivo.viejo_num_expediente"></td>
                                                                <td v-text="archivo.nombre_departamento"></td>
                                                                <td v-text="archivo.nombre_documental"></td>
                                                                <td v-text="archivo.fecha_extrema"></td>
                                                            <!-- <td v-text="archivo.anno"></td> -->
                                                                <td v-text="archivo.ubicacion"></td>
                                                            <!-- <td v-text="archivo.usuario"></td> -->                           
                                                            <td>
                                                                <div v-if="archivo.estado==1"> <!-- si el estado es 1-->
                                                                <span class="badge badge-success">Disponible</span>
                                                                </div>
                                                                <div v-else-if="archivo.estado==2"> 
                                                                <span class="badge badge-danger">Prestado</span>
                                                                </div>
                                                                 <div v-else-if="archivo.estado==3"> 
                                                                <span class="badge badge-dark">Eliminado</span>
                                                                </div>
                                                            </td>

                                                        
                                                    </tr>
                                                
                                                </tbody>
                                            </table>    
                                </div>                        
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->







</main>
      
</template>

<script>

//exporto la clase del jtable para hacer uso de ella 
import datables from 'datatables';
import Vue from 'vue';
//import VueSelect from 'vue-select';


export default {


    data(){
        return {
            
            boleta_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar
            id : 0,
            num_boleta : 0, 
            tipo_comprobante : 'boleta',
            idusuario : 0,   
            usuario : '',  // nombre del usuario de la tabla user        
            iddepartamento : 0,
            nombre_departamento: '',
            idpersona : '',
            nombre : '',
            num_identificacion : '',
            created_at : '',
            fecha_limite : '',
           

           
            created_at : '',// si
            updated_at : '',

            arrayBoleta : [], // array que optiene todos los objetos de la bd
            arrayPersona: [],
            arrayDepartamento: [],
            arrayDetalle : [],    
            arrayArchivo: [], // DETALLE BOLETA

            archivo :'',
            aux_expediente  :'',
            mensaje :'',
            idboleta : 0, 
            
            criterioA:'viejo_num_expediente',
            buscarA: '',

            idarchivo : 0,
            idcaja : 0,
            diminutivo_caja :'',  
            num_caja : '',       
            fecha_devolucion_archivo : '',
            viejo_num_expediente : '',
            iddocumental : 0,
            nombre_documental : '',
            fecha_extrema : '',
            ubicacion : '',
            vigencia: 0,
            estado : 0,
           
            fecha_devolucion_archivo : '',// propio de la tabla detalle y no de la tabla archivo

           
            listado:1,// si vizualizo o no visualizo 
            modal : 0,
            tituloModal : '',
            tipoAccion : 0,
            errorBoleta : 0,
            errorMostrarMsjBoleta : [],
            bloquear : '', // variable que servira para bloquear cualquier tipo de input cuando se abra el modal

            // para la paginacion
             pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'num_boleta',
                buscar : ''
           
        }
    },
component:{
           // VueSelect
        },

// para la paginacion
 computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },


 methods:{
           
        //mytable(){
         //   $(function(){
             //   $('#example').DataTable();
          //  });
       // },


        listarBoleta(page,buscar,criterio){ 
                    let me= this;
                    var url= '/boleta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.arrayBoleta = respuesta.boletas.data;
                         me.pagination= respuesta.pagination;
                      
                    })
                    .catch(function (error) {
                        //en caso de error que lo muestre en la consola del navegador 
                        console.log(error);
                        me.msjErrorConexicion();
                        });
                        
        },

        msjErrorConexicion(){
            Swal.fire({
            title: 'ERROR DE CONEXION, por favor actualiza el sistema y revisa luego tus datos',
            animation: false,
            customClass: 'animated tada'
            })
        },


        registrarBoleta(){
                if (this.validarBoleta()){
                    return;
                }
                
                let me = this;
                 axios.post('/boleta/registrar',{

                    'num_boleta' : this.num_boleta,
                    'iddepartamento': this.iddepartamento,
                    'idpersona': this.idpersona,
                    'fecha_limite' : this.fecha_limite,
                   
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;// que se muestre el listado
                    me.listarBoleta(1,'','num_boleta');
                    me.msjRegistrarBoleta();
                  
                    me.num_boleta='';
                    me.iddepartamento='';
                    me.idpersona=0;
                    me.fecha_limite='';
                    me.arrayDetalle=[]; // si volvemos hacer click en el boton nuevo que mi tabla dinamica se inicialice
                   
                    window.open('http://localhost:8000/boleta/pdf/'+ response.data.id + ',' + '_blank');// que se abra la vista y se la envie por la ruta y el _black indica que en una nueva vista

                }).catch(function (error) {
                    console.log(error);
                    me.msjErrorRegistrarBoleta();

                });

        },


//para comprobar la existencia del numero de la boleta NO SE ESTA UTILIZANDO
        buscarNumBoleta(){

                let me = this;
                var sw=0;
                var url='/boleta/buscarNumBoleta?num_boleta=' + me.num_boleta; // se le envia el numero de boleta que esta en ese momento
                axios.get(url).then(function (response) {

                        var respuesta= response.data;
                        var aux_num_boleta;
                        if(respuesta == ""){ // en caso de que venga vacio y xq sera la primera vez que se registrara una caja de un departamento en especifico
                              sw=true;// si devuelve un true ya existe 

                        }else{ // si no pues es xq ya habian
                             sw=false;// si devuelve un true ya existe 
                        }                 
                })
                .catch(function (error) {
                    console.log(error);
                });
        },


        msjRegistrarBoleta(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Boleta registradada con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },

        msjErrorRegistrarBoleta(){

             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'ERROR, al registrar boleta',
                })      
        },

        validarBoleta(){
                this.errorBoleta=0;
                this.errorMostrarMsjBoleta =[];

                if (this.idpersona==0) this.errorMostrarMsjBoleta.push("Seleccione una persona responsable de los archivos");
                if (this.iddepartamento==0) this.errorMostrarMsjBoleta.push("Seleccione el departamento que solicita estos archivos");
                if (!this.fecha_limite) this.errorMostrarMsjBoleta.push("Ingrese una posible fecha de devolucion de los archivos, asegurese de indicar una hora especifica");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjBoleta.push("Ingrese archivos a la boleta");
              
                if (this.errorMostrarMsjBoleta.length) this.errorBoleta = 1;

                return this.errorBoleta;
        },



        cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarBoleta(page,buscar,criterio);
        },

         //metodo que es invocado una vez el archivo es encontrado de las dos formas programadas por el boton verde +
        agregarDetalle(){
            let me=this;

          if(me.idarchivo==0){ // 1 valido si el archivo fue encontrado 

                  me.msjBotonVerde();

                }else{

                     if(me.estado == 3){ // valido si el estado del archivo esta prestado primeramente

                        me.msjEstadoEliminadoArchivo();

                    }else{

                            if(me.estado == 2){ // valido si el estado del archivo esta prestado primeramente

                                me.msjEstadoPrestadoArchivo();

                            }else{
                                // 2 valido si ya se encuentra registrado el archivo en la tabla dinamica
                                if(me.encuentra(me.idarchivo)){

                                    me.msjExisteArchivo();

                                    me.aux_expediente="";// el campo donde busca por viejo_num_expediente quede limpio de nuevo
                                    me.mensaje='No existe archivo'; // que el text vuelve a poner este msj

                                    me.idarchivo=0; //que todas las demas variables del arrayDetalle queden lipias para disponer de nuevo de una nueva entrada de archivo
                                    me.iddocumental=0;
                                    me.nombre_documental="";
                                    me.viejo_num_expediente="";
                                    me.fecha_extrema="";
                                    me.ubicacion="";
                                    me.estado= 0;


                                }else{
                                    // agregue a la tabla dinamica
                                        me.arrayDetalle.push({
                                                idarchivo: me.idarchivo,
                                                iddocumental: me.iddocumental,
                                                nombre_documental: me.nombre_documental,
                                                viejo_num_expediente: me.viejo_num_expediente,
                                                fecha_extrema: me.fecha_extrema,
                                                ubicacion: me.ubicacion
                                            });    
                                            // despues de agregado que limpie para que no me deje agregar otro igual                  
                                            me.aux_expediente="";// el campo donde busca por viejo_num_expediente quede limpio de nuevo
                                            me.mensaje='No existe archivo'; // que el text vuelve a poner este msj

                                            me.idarchivo=0; //que todas las demas variables del arrayDetalle queden lipias para disponer de nuevo de una nueva entrada de archivo
                                            me.iddocumental=0;
                                            me.nombre_documental="";
                                            me.viejo_num_expediente="";
                                            me.fecha_extrema="";
                                            me.ubicacion="";
                                            me.estado= 0;
                                }               
                            }
                        }
                  }                  
        },

        agregarDetalleModal(data =[]){

             let me=this;

          if( data['estado'] == 3){

               me.msjEstadoEliminadoArchivo();

          }else{

               if(data['estado'] == 2){ // valido si el estado del archivo esta prestado primeramente

                  me.msjEstadoPrestadoArchivo();

                }else{
                
                if(me.encuentra(data['id'])){

                            me.msjExisteArchivo();

                        }else{
                            // agregue a la tabla dinamica
                                me.arrayDetalle.push({
                                        idarchivo: data['id'],
                                        iddocumental: data['iddocumental'],
                                        nombre_documental: data['nombre_documental'],
                                        viejo_num_expediente: data['viejo_num_expediente'],
                                        fecha_extrema: data['fecha_extrema'],
                                        ubicacion: data['ubicacion']
                                        // no se agrega el estado del archivo pues es en la tabla dinamica a la que me estoy refiriendo hasta este punto
                                    });    
                                
                        }
               }

          }

           

             
        },
//metodo que me enlista los 10 primeros coincidencias del modal
        listarArchivosModalBoleta(buscar,criterio){
                let me=this;
               var url='/archivo/listarArchivosModalBoleta?buscar='+ buscar + '&criterio='+ criterio;
               axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArchivo = respuesta.archivos.data;
                })
                .catch(function (error) {
                    // en caso de error, mostrar en la consola del navegador
                    console.log(error);
                     me. msjError(); // en caso de que falle 
                });
        },

         //encaso de que el archivo ya se encuentre agregado en la tabla dinamica 
        encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){//recorro el array
                    if(this.arrayDetalle[i].idarchivo==id){ // si dentro de mi arrayDetalle atavez de mi indice i que el contador del bucle en la posicion idarchivo sea igual id
                        sw=true;// si devuelve un true ya existe 
                    }
                }
                return sw; // si no pues return 0 osea un false
        },

        eliminarDetalle(index){// recibe por parametro el indice o el id del archivo agregado en la tabla dinamica de la boleta que deceo eliminar
                let me = this;
                me.arrayDetalle.splice(index, 1);// metodo splice elimina
        },

        msjBotonVerde(){
             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'ATENCION, debes buscar y seleccionar un nuevo archivo para agregar en la boleta!',
                })      
        },

        msjExisteArchivo(){
             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'Ese archivo ya se encuentra agregado en la boleta!',
                })
        },

        msjEstadoPrestadoArchivo(){
             swal({
                    type: 'error',
                    title: 'Archivo con estado: prestado',
                     text: 'Ese archivo ya se encuentra registrado en otra boleta, y no sido devuelto',
                })
        },

        msjEstadoEliminadoArchivo(){
             swal({
                    type: 'error',
                    title: 'Archivo con estado: eliminado',
                    text: 'Ese archivo ya a sido eliminado, si decea obtener mas informacion por favor contacte con el departamento de sistemas de informacion',
                })
        },

        // cbx seleccionar Persona
        selectPersona(){ 
           
                let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                var url='/persona/selectPersona';
                //tomado de github axios se lo envia al metodo selectPersona
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayPersona = respuesta.personas; // paso todos los datos al arrayPersona

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });

        },
       

        selectDepartamento(){ 
               
                  // copiado de listarPersona
                let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                var url='/departamento/selectDepartamento';
                //tomado de github axios se lo envia al metodo selectDepartamento
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla departamento
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayDepartamento = respuesta.departamentos; // paso todos los datos al arrayDepartamento
               

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });

        },


         //llamado en el boton azul
        buscarArchivo(){
                let me=this;
                var url= '/archivo/buscarArchivo?filtro=' + me.aux_expediente; // lo que esta escrito en textfield viejo_num_expediente

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArchivo = respuesta.archivos;

                    if (me.arrayArchivo.length>0){// si coincide con ese numero de expediente y viene lleno

                        me.mensaje='Archivo encontrado';
                        me.idarchivo=me.arrayArchivo[0]['id']; // lleno la variable archivo
                        me.iddocumental=me.arrayArchivo[0]['iddocumental'];
                        me.nombre_documental=me.arrayArchivo[0]['nombre_documental'];
                        me.viejo_num_expediente=me.arrayArchivo[0]['viejo_num_expediente'];
                        me.fecha_extrema=me.arrayArchivo[0]['fecha_extrema'];
                        me.ubicacion=me.arrayArchivo[0]['ubicacion'];
                        me.estado=me.arrayArchivo[0]['estado'];
                       
                    }
                    else{
                        me.mensaje='No existe archivo';
                        me.idarchivo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
      
        // este msj de sweetalert esta sirviendo pero aun no lo estoy utilizando
        msjError(){
            Swal.fire({
            title: 'ERROR, algo a ocurrido, por favor revisa los datos',
            animation: false,
            customClass: 'animated tada'
            })
        },

        boletaPendiente(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro con dejar en estado: pendiente esta boleta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    // copiado del boton actualizar
                    let me = this;

                    axios.put('/boleta/boletaPendiente',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /archivo/desactivar para que se lo envie al metodo del controlador desactivarArchivo
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarBoleta(1,'','num_boleta'); // QUITAR
                        swal(
                        'Pendiente!',
                        'La boleta ha sido cambiado a estado: pendiente con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        //en caso de error mostrar en consola
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
                }) 



        },

        boletaDevuelta(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro con dejar en estado: Devuelto esta boleta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    // copiado del boton actualizar
                    let me = this;

                    axios.put('/boleta/boletaDevuelta',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /archivo/activar para que se lo envie al metodo del controlador activar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarBoleta(1,'','num_boleta'); // QUITAR
                        swal(
                        'Devuelta!',
                        'La boleta ha sido cambiado a estado: Devuelta con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        //en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
                }) 
        },

        pdfBoleta(id){
            // var ruta = 'http://localhost:8000';
             window.open('http://localhost:8000/boleta/pdf/'+ id + ',' + '_blank');// que se abra la vista y se la envie por la ruta y el _black indica que en una nueva vista

        },

        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
               
		        this.errorBoleta=0;// quitar por que solo va a ver los detalles de la boleta
        },

        mostrarDetalle(){
                let me=this;
                me.listado=0;
                me.arrayDetalle=[];
                me.aux_expediente='';// para limpiar
                
        },

        ocultarDetalle(){
                this.listado=1;
        },

        verBoleta(id){
                let me=this;
                me.listado=2;
              
              //Obtener los datos del ingreso
                var arrayBoletaT=[];
                var url= '/boleta/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayBoletaT = respuesta.boleta; // va en singular por que es de la tabla boleta por lo tanto solo devuelve una boleta

                    me.num_boleta = arrayBoletaT[0]['num_boleta'];
                    me.tipo_comprobante=arrayBoletaT[0]['tipo_comprobante'];
                    me.usuario=arrayBoletaT[0]['usuario'];
                    me.nombre_departamento=arrayBoletaT[0]['nombre_departamento'];
                    me.nombre=arrayBoletaT[0]['nombre'];
                  
                    me.fecha_limite=arrayBoletaT[0]['fecha_limite'];                 
                    me.estado=arrayBoletaT[0]['estado'];              
                    me.created_at=arrayBoletaT[0]['created_at'];
                    me.updated_at=arrayBoletaT[0]['updated_at'];

                })
                .catch(function (error) {
                    console.log(error);
                });



                 //Obtener los datos de los detalles  ME TIRA UNA ESPECIE DE ERROR EN EL NAVEGADOR PREGUNTAR SI NECESITO DECLARAR VARIABLES AUXILIARES POR LA BASURA QUE ME TRAE
                var urld= '/boleta/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               

        },
        
         //este metodo limpia y hace que se muestre la vista
        mostrarDetalle(){
                        let me=this;
                        me.listado=0;

                        me.idusuario=0;
                        me.usuario ='',
                    // me.num_boleta=0;
                        me.iddepartamento=0;
                        me.nombre_departamento= '',
                        me.idpersona=0;
                        me.nombre = '',
                        me.num_identificacion = '',
                        me.created_at = '',
                        me.fecha_limite = '',
                        me.updated_at = '',
                        me.fecha_devolucion_archivo = '',
                        me.estado = 0,
                        

                        me.idarchivo=0;
                        me.archivo='';
                        me.idboleta = 0,  
                        me.arrayDetalle=[];
                        me.aux_expediente = '';
                        me.mensaje='No existe archivo'; // que el text vuelve a poner este msj
                        me.obtenerUltimoNumeroBoleta(); // para que la boleta se cargue con la ultimo numero de boleta
                        this.errorBoleta=0; // para que no se muestre los msjs de error de letras rojas
        },


        activarArchivo(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro con dejar en estado: Disponible este archivo que a sido agregado a esta boleta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    // copiado del boton actualizar
                    let me = this;

                    axios.put('/archivo/activar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /archivo/activar para que se lo envie al metodo del controlador activar
                    }).then(function (response) {
                        
                        swal(
                        'Disponible!',
                        'El registro ha sido cambiado a estado: Disponible con éxito.',
                        'success'
                        )

                    }).catch(function (error) {
                        //en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
                }) 
        },

        desactivarArchivo(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro con dejar en estado: prestado este archivo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    // copiado del boton actualizar
                    let me = this;

                    axios.put('/archivo/desactivar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /archivo/desactivar para que se lo envie al metodo del controlador desactivarArchivo
                    }).then(function (response) {
                        
                        swal(
                        'Prestado!',
                        'El registro ha sido cambiado a estado: prestado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        //en caso de error mostrar en consola
                        console.log(error);
                    });
                             
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
                }) 



        },


        obtenerUltimoNumeroBoleta(){

                      let me = this;
                      var array=[];
                      var url='/boleta/obtenerUltimoNumeroBoleta'; // mediante la url "ruta" le envio el id para que me devuelva la respuesta 
                      axios.get(url).then(function (response) {
                        
                        //console.log(id);
                        var respuesta= response.data;
                        var aux_num_boleta;
                        if(respuesta == ""){ // en caso de que venga vacio y xq sera la primera vez que se registrara una caja de un departamento en especifico
                            
                            aux_num_boleta= 1; // le digo que empiece en 1
                            me.num_boleta =  aux_num_boleta; // y se lo paso al campo num_caja del modal para que lo muestre

                        }else{ // si no pues es xq ya habian

                            aux_num_boleta = respuesta[0]['num_boleta']; // en una variable auxiliar le paso el ultimo numero de caja rehistrado de ese departamento en especifico
                            aux_num_boleta ++; //para sumarle 1 
                            me.num_boleta =  aux_num_boleta; // y se lo paso al campo num_caja del modal para que lo muestre

                        }   
                                                            
                     }).catch(function (error) {
                         // en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });

        },

        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
        }, 

        abrirModal(){               
                this.arrayArchivo=[]; //PARA QUE CUANDO EL ESCRIBA EL NUMERO VIEJO DE EXPEDIENTE EN LA PARTE DE LOS TRES PUNTITOS NO ME APARESCA EN EL MODAL, PUES DECEO QUE ESTE DISPONIBLE LA BUSQUEDA LIMPIA EN EL MODAL
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
                this.buscarA = '';
                this.bloquear = true; // se bloquearan
        },

        },

        
        mounted() {
           this.listarBoleta(1,this.buscar,this.criterio);
           this.selectDepartamento();
           this.selectPersona();
        }



}



</script>




<style>


/* SE PUEDE QUITAR PRIMERO PROBARLO ESO SI*/
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important; /* claro atras*/
    }

    /* para los errores*/
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important; /* en rojo*/
        font-weight: bold; /* negrita */
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }





</style>












