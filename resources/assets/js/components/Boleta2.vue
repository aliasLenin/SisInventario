



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
                    <div class="card-body">
                      <div class="panel-body table-responsive">
                      

                       <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover" >
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Num Boleta</th>
                                    <th>Usuario G</th>
                                    <th>Dependencia S</th>
                                    <th>Responsable</th>
                                    <th>Fecha Salida</th> <!-- trabajar con el created_at de la base de datos-->
                                    <th>Fecha Limite</th>
                                    <th>Fecha Devolucion</th>
                                    <th>Estado</th>
                                   
                                   

                                </tr>
                            </thead>
                            <tbody>
                                  <tr v-for= "boleta in arrayBoleta" :key = "boleta.id">
                                   
                                
                                    <td>

                                        <button type="button"                                            class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
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
                                       

                                    </td>
                                            
                                            <td v-text="boleta.num_boleta"></td> 
                                            <td v-text="boleta.usuario"></td>
                                            <td v-text="boleta.nombre_departamento"></td>
                                            <td v-text="boleta.nombre +'-'+ boleta.apellido"></td> 
                                            <td v-text="boleta.fecha_registro"></td>
                                            <td v-text="boleta.fecha_limite"></td>
                                            <td v-text="boleta.fecha_devolucion"></td> <!--  +'-'+ boleta.created_at -->
                                   
                                            
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
                            
                            <thead>
                                <tr>
                              
                                    <th>Opciones</th>
                                    <th>Num Boleta</th>
                                    <th>Usuario G</th>
                                    <th>Dependencia S</th>
                                    <th>Responsable</th>
                                    <th>Fecha Salida</th> <!-- trabajar con el created_at de la base de datos-->
                                    <th>Fecha Limite</th>
                                    <th>Fecha Devolucion</th>
                                    <th>Estado</th>
                                   


                                </tr>
                            </thead>

                        </table>



                        
                      
                    </div>
                </div> <!-- Fin ejemplo de tabla Listado -->
              </div>   
            </div><!-- Fin ventana --> 




</main>
      
</template>

<script>

//exporto la clase del jtable para hacer uso de ella 
import datables from 'datatables'


export default {


    data(){
        return {
            
            boleta_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar

            num_boleta : 0, 
            idusuario : 0,   
            usuario : '',  // nombre del usuario de la tabla user        
            iddepartamento : 0,
            nombre_departamento: '',
            idpersona : '',
            nombre : '',
            apellido : '',
            num_identificacion : '',
            fecha_registro : '',
            fecha_limite : '',
            fecha_devolucion : '',
            estado : '',

            created_at : '',// si

            arrayBoleta : [], // array que optiene todos los objetos de la bd
            arrayPersona: [],
            arrayDetalle : [],
           
            arrayArchivo: [], // DETALLE BOLETA
            archivo :'',
            idboleta : 0,  
            idarchivo : 0, 
           
            listado:1,
            modal : 0,
            tituloModal : '',
            tipoAccion : 0,
            errorBoleta : 0,
            errorMostrarMsjBoleta : []
           

        }
    },



 methods:{
           
        mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },


        listarBoleta(){ 
                    let me= this;
                    axios.get('/boleta').then(response => {
                        me.arrayBoleta = response.data;
                        this.mytable();
                    })
                    .catch(function (error) {
                        //en caso de error que lo muestre en la consola del navegador 
                        console.log(error);
                        me. msjError(); // en caso de que falle 
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
                        me.listarBoleta();
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
                        me.listarBoleta();
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
                me.apellido = '',
                me.num_identificacion = '',
                me.fecha_registro = '',
                me.fecha_limite = '',
                me.fecha_devolucion = '',
               

                me.idarchivo=0;
                me.archivo='';
                me.idboleta = 0,  
                me.arrayDetalle=[];
            },



















        },

        
        mounted() {
           this.listarBoleta();
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





</style>












