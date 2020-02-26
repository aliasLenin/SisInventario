
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
                        <i class="fa fa-align-justify"></i> Listado Documentales
                        <button type="button" @click="abrirModal('documental','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                       <div class="panel-body table-responsive">
                      

                         <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover" >
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Codigo</th>
                                    <th>Descripción</th>
                                    <th>Vigencia</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <tr v-for= "documental in arrayDocumental" :key = "documental.id">
                                   
                                   
                                    <td>

                                        <button type="button" @click="abrirModal('documental','actualizar',documental)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                         <template v-if="documental.estado"> <!-- si nuestro estado es 1 -->
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDocumental(documental.id)"> <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                         </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarDocumental(documental.id)">  <!-- eneviamos el id al metodo -->
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                       

                                    </td>



                                   <!-- y que valla cargando cada uno de los datos encontrados en la tabla-->
                                    <td v-text="documental.nombre_documental"></td>  
                                    <td v-text="documental.codigo_diminutivo"></td>        
                                    <td v-text="documental.descripcion"></td>
                                     <td v-text="documental.vigencia"></td>

                                              <!-- <td v-text="codigo.estado"></td>-->
                                        <td>
                                            <div v-if="documental.estado"> <!-- si el estado es 1-->
                                                <span class="badge badge-success">Activado</span>
                                            </div>
                                            <div v-else> 
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    
                                </tr>
                              
                            </tbody>
                             
                             <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Codigo</th>
                                    <th>Descripción</th>
                                    <th>Vigencia</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>

                        </table>



                        
                      </div>
                    </div>
                </div>  <!-- Fin ejemplo de tabla Listado -->             
            </div><!-- Fin ventana -->


            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1"      :class="{'mostrar' : modal}"     role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        
                        
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4> <!-- variable que viene de abajo para dale el encabezado al modal-->
                            <button type="button" class="close" @click = "cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>


                        <div class="modal-body">
                            
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                              
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre documental: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre_documental" class="form-control" placeholder="escriba el nombre del documental aqui" maxlength="50" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo diminutivo: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo_diminutivo" class="form-control" placeholder="escriba el codigo diminutivo documental aqui" maxlength="50" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="escriba la descripcion del documental aqui" maxlength="50" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Vigencia:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="vigencia" class="form-control" placeholder="escriba la vigencia del documental aqui" maxlength="50" required>
                                    </div>
                                </div>

                                  <div v-show="errorDocumental" class="form-group row div-error"> <!-- si viene con un 1 la variable errorDocumental iteramos     row div-error = esta declarada en los estilos                    -->
                                     <div class="text-center text-error" >
                                         <div v-for="error in errorMostrarMsjDocumental" :key="error" v-text="error"></div>
                                     </div>    
                                </div>

                            </form>
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-info" @click = "limpiar()" v-bind:disabled="bloquearBtnLimpiar" >Limpiar</button>
                            <button type="button" class="btn btn-danger" @click = "cerrarModal()" >Cerrar</button>
                            <button type="button" v-if = "tipoAccion==1" class="btn btn-success" @click = "registrarDocumental()">Guardar</button>
                            <button type="button" v-if = "tipoAccion==2" class="btn btn-success" @click = "actualizarDocumental()">Actualizar</button>
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
import datables from 'datatables'


export default {


    data(){
        return {
            
            documental_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar

            nombre_documental :'', 
            codigo_diminutivo :'',              
            descripcion : '',
            vigencia : '',
            arrayDocumental : [], // array que optiene todos los objetos de la bd
            modal : 0, // variable auxiliar para la funcion que abre el modal
            tituloModal : '', // variable auxiliar para darcela al titulo del modal dependiendo si va a entrar a registrar o actualizar
            tipoAccion : 0,
            //variables para validar de que los datos no vallan nulos desde los campos de texto
            errorDocumental : 0,
            errorMostrarMsjDocumental : [],

             bloquearBtnLimpiar : ''
            
        }
    },



 methods:{
           
        mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },



        listarDocumental(){
            let me= this;
            axios.get('/documental').then(response => {
                me.arrayDocumental = response.data;
                this.mytable();
            })
            .catch(function (error) {
                //en caso de error que lo muestre en la consola del navegador 
                console.log(error);
                me. msjError(); // en caso de que falle 
                });
                
        },

        registrarDocumental(){
                // validamos que hallan dejado espacios en blanco
                if(this.validarDocumental()){
                        return; // si los hay se saldra y no registrara

                }  

                let me= this;

                axios.post('/documental/registrar',{ //metodo store por medio de la ruta 
                    'nombre_documental': this.nombre_documental,
                    'codigo_diminutivo': this.codigo_diminutivo,
                    'descripcion': this.descripcion,
                    'vigencia': this.vigencia

                }).then(function (response) { // si se ejecuta de manera correpta la inscripcion 
                    me.cerrarModal();
                    me.msjRegistrar();          
                    //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                    me.listarDocumental();
                   // windows.location.replace('http://localhost:8000/departamento').reload();
                }).catch(function (error) { 
                    //en caso de error que lo muestre en la consola del navegador 
                    console.log(error);
                });
        },

        msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Documental registrado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },
        

        actualizarDocumental(){

                // validamos que hallan dejado espacios en blanco
                if(this.validarDocumental()){
                    return; // si los hay se saldra y no registrara
                }  

                let me= this;

                axios.put('/documental/actualizar',{ //metodo update por medio de la ruta
                'nombre_documental': this.nombre_documental,
                'codigo_diminutivo': this.codigo_diminutivo,
                'descripcion': this.descripcion,
                'vigencia': this.vigencia,
                'id' : this.documental_id // a diferencia del de registrar le enviamos el id que fue almacenado momentaneamente en esta variable

                }).then(function (response) { // si se ejecuta de manera correpta la actualizacion de los datos
                me.cerrarModal();
                me.msjActualizar();
                //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                me.listarDocumental();
                })
                .catch(function (error) {
                //en caso de error que lo muestre en la consola del navegador 
                console.log(error);
                });
        },

        
        msjActualizar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Documental actualizado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },

            // este msj de sweetalert esta sirviendo pero aun no lo estoy utilizando
        msjError(){
            Swal.fire({
            title: 'ERROR, algo a ocurrido, por favor revisa los datos',
            animation: false,
            customClass: 'animated tada'
            })
        },

        desactivarDocumental(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de desactivar este documental?',
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

                    axios.put('/documental/desactivar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /documental/desactivar para que se lo envie al metodo del controlador desactivar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarDocumental();
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) { //
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
            }) 
        },


        activarDocumental(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de activar este documental?',
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

                    axios.put('/documental/activar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /documental/activar para que se lo envie al metodo del controlador desactivar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarDocumental();
                        swal(
                        'Activado!',
                        'El registro ha sido Activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                         //en caso de error que lo muestre en la consola del navegador 
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
                }) 
        },



        validarDocumental(){

            // inicializamos de nuevo las variables
            this.errorDocumental=0;
            this.errorMostrarMsjDocumental = [];

            if(!this.nombre_documental) this.errorMostrarMsjDocumental.push("Error, nombre documental, espacio requerido");
            if(!this.codigo_diminutivo) this.errorMostrarMsjDocumental.push("Error, codigo documental, espacio requerido");
            if(!this.vigencia) this.errorMostrarMsjDocumental.push("Error, vigencia documental, espacio requerido");
                
                if(this.errorMostrarMsjDocumental.length) this.errorDocumental = 1; // si hay error que la variable erroCodigo pase a 1

                return this.errorDocumental; // la retornamos 

        },


        // funcion que nos permite cerrar el modal 
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre_documental = ''; // los objetos name del modal queden limpios
            this.codigo_diminutivo = '';
            this.descripcion = '';
            this.vigencia = '';
            this.errorDocumental=0;
        },

        
        limpiar(){

            this.nombre_documental = ''; // los objetos name del modal queden limpios
            this.codigo_diminutivo = '';
            this.descripcion = '';
            this.vigencia = '';
            this.errorDocumental=0;


        },

        abrirModal(modelo, accion, data =[]){

            switch(modelo){
                case "documental": // en el caso que sea con el modelo documental
                {
                    switch(accion){
                        case 'registrar': // en el caso de que el modal sea para registar 
                            {
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Registrar Documental' // encabezado del modal
                                this.tipoAccion = 1;

                                this.bloquearBtnLimpiar = false; // se desbloquearan

                                this.nombre_documental = ''; // los objetos name del modal deben de inicializar vacios  
                                this.codigo_diminutivo = '';                   
                                this.descripcion = '';
                                this.vigencia = '';
                               
                                break;
                            }
                        case 'actualizar': // en el caso de que sea para modificar
                            {
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Actualizar Documental' // ncabezado del modal
                                this.tipoAccion = 2;

                                this.bloquearBtnLimpiar = true; // se desbloquearan

                                this.documental_id = data['id'] // aqui se almacenara momentaneamente el id a modificar
                                // cargara los datos a la vista
                                this.nombre_documental = data['nombre_documental']; //se le indica que se va acceder exactamente a la propieda nombre_documental  
                                this.codigo_diminutivo = data['codigo_diminutivo'];                   
                                this.descripcion = data['descripcion'];
                                this.vigencia = data['vigencia'];

                                break;


                            }
                    }
                }
            }
        }
    },



        mounted() {
           this.listarDocumental();
        }



    }





</script>



<style>

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












































