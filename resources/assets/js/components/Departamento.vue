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
                        <i class="fa fa-align-justify"></i> Listado Departamentos
                        <button type="button" @click="abrirModal('departamento','registrar')" class="btn btn-secondary">
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
                                    <th>Diminutivo</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <tr v-for= "departamento in arrayDepartamento" :key = "departamento.id">
                                   
                                   
                                    <td>

                                        <button type="button" @click="abrirModal('departamento','actualizar',departamento)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                         <template v-if="departamento.estado"> <!-- si nuestro estado es 1 -->
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDepartamento(departamento.id)"> <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                         </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarDepartamento(departamento.id)">  <!-- eneviamos el id al metodo -->
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                       

                                    </td>



                                   <!-- y que valla cargando cada uno de los datos encontrados en la tabla-->
                                    <td v-text="departamento.nombre_departamento"></td>  
                                    <td v-text="departamento.diminutivo_departamento"></td>          
                                    <td v-text="departamento.descripcion"></td>

                                              <!-- <td v-text="codigo.estado"></td>-->
                                        <td>
                                            <div v-if="departamento.estado"> <!-- si el estado es 1-->
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
                                    <th>Diminutivo</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>

                        </table>



                        
                      
                    </div>
                </div> <!-- Fin ejemplo de tabla Listado -->
              </div>   
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre departamento: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre_departamento"  id="nombre_departamento" name="nombre_departamento" class="form-control" placeholder="escriba el nombre del departamento aqui" maxlength="50" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Diminutivo departamento: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="diminutivo_departamento"  id="diminutivo_departamento" name="diminutivo_departamento" class="form-control" placeholder="escriba el diminutivo del departamento aqui" maxlength="45"  required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="escriba la descripcion del departamento aqui" maxlength="50" required>
                                    </div>
                                </div>

                                  <div v-show="errorDepartamento" class="form-group row div-error"> <!-- si viene con un 1 la variable errorDepartamento iteramos    onkeyup="javascript:this.value=this.value.toUpperCase();"   row div-error = esta declarada en los estilos                    -->
                                     <div class="text-center text-error" >
                                         <div v-for="error in errorMostrarMsjDepartamento" :key="error" v-text="error"></div>
                                     </div>    
                                </div>

                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click = "limpiar()" v-bind:disabled="bloquearBtnLimpiar" >Limpiar</button>
                            <button type="button" class="btn btn-danger" @click = "cerrarModal()" >Cerrar</button>
                            <button type="button" v-if = "tipoAccion==1" class="btn btn-success" @click = "registrarDepartamento()">Guardar</button>
                            <button type="button" v-if = "tipoAccion==2" class="btn btn-success" @click = "actualizarDepartamento()">Actualizar</button>
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
            
           
            departamento_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar

            nombre_departamento :'', 
            diminutivo_departamento :'',              
            descripcion : '',
            arrayDepartamento : [], // array que optiene todos los objetos de la bd
            modal : 0, // variable auxiliar para la funcion que abre el modal
            tituloModal : '', // variable auxiliar para darcela al titulo del modal dependiendo si va a entrar a registrar o actualizar
            tipoAccion : 0,
            //variables para validar de que los datos no vallan nulos desde los campos de texto
            errorDepartamento : 0,
            errorMostrarMsjDepartamento : [],
            
            bloquearBtnLimpiar : '',
            encontrado : ''

        }
    },



 methods:{
           
        mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },



        listarDepartamento(){ 
            let me= this;
            axios.get('/departamento').then(response => {
                me.arrayDepartamento = response.data;
                this.mytable();
            })
            .catch(function (error) {
                //en caso de error que lo muestre en la consola del navegador 
                console.log(error);
                me. msjError(); // en caso de que falle 
                });
                
        },

      
        registrarDepartamento(){
                // validamos que hallan dejado espacios en blanco
                if(this.validarDepartamento()){
                        return; // si los hay se saldra y no registrara

                }  

                let me= this;
              
                        axios.post('/departamento/registrar',{ //metodo store por medio de la ruta 
                            'nombre_departamento': this.nombre_departamento,
                            'diminutivo_departamento': this.diminutivo_departamento,
                            'descripcion': this.descripcion

                        }).then(function (response) { // si se ejecuta de manera correpta la inscripcion 
                            me.cerrarModal();
                            me.msjRegistrar();          
                            //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                            me.listarDepartamento();
                        // windows.location.replace('http://localhost:8000/departamento').reload(); // probando para refrescar esa pagina en especifico
                        }).catch(function (error) { // en caso de error
                            console.log(error);
                        });

        },

        //NO SE ESTA USUANDO
        validarExistencia(){
            var sw=0;
            let me= this;

            var url='/departamento/validarExistencia?nombre_departamento='+ me.nombre_departamento; // mediante la url "ruta" le envio el iddocumental para que me devuelva la respuesta 
                      axios.get(url)
                     .then(function (response) {    
                         
                        var respuesta= response.data;                    
                          //console.log(respuesta);
                        var aux_num_caja;
                        if(respuesta == ""){ // en caso de que venga vacio y xq sera la primera vez que se registrara una caja de un departamento en especifico
                                                   
                            //me.encontrado = 0; 
                            console.log(me.encontrado);

                        }else{ 

                            me.encontrado = respuesta[0]['nombre_departamento']; // en una variable auxiliar le paso el ultimo numero de caja rehistrado de ese departamento en especifico
                            console.log(me.encontrado);
                      }   
                                        
                     }).catch(function (error) {
                         // en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });
        },


        msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Departamento registrado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },


        msjErrorDepartamentoExistente(){

             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'ERROR, El departamento ya existe',
                })      
        },

        

        actualizarDepartamento(){

                // validamos que hallan dejado espacios en blanco
                if(this.validarDepartamento()){
                    return; // si los hay se saldra y no registrara
                }  

                let me= this;

                axios.put('/departamento/actualizar',{ //metodo update por medio de la ruta
                'nombre_departamento': this.nombre_departamento,
                'diminutivo_departamento': this.diminutivo_departamento,
                'descripcion': this.descripcion,
                'id' : this.departamento_id // a diferencia del de registrar le enviamos el id que fue almacenado momentaneamente en esta variable

                }).then(function (response) { // si se ejecuta de manera correpta la actualizacion de los datos
                me.cerrarModal();
                me.msjActualizar();
                //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                me.listarDepartamento();
                })
                .catch(function (error) {
                console.log(error);
                });
        },

        
        msjActualizar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Departamento actualizado con exito',
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

        desactivarDepartamento(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de desactivar este departamento?',
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

                    axios.put('/departamento/desactivar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /departamento/desactivar para que se lo envie al metodo del controlador desactivarDepartamento
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarDepartamento();
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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


        activarDepartamento(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de activar este departamento?',
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

                    axios.put('/departamento/activar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /departamento/activar para que se lo envie al metodo del controlador desactivar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarDepartamento();
                        swal(
                        'Activado!',
                        'El registro ha sido Activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                
                }
                }) 
        },



        validarDepartamento(){

            // inicializamos de nuevo las variables
            this.errorDepartamento=0;
            this.errorMostrarMsjDepartamento = [];

            if(!this.nombre_departamento) this.errorMostrarMsjDepartamento.push("Error, nombre departamento, espacio requerido");
            if(!this.diminutivo_departamento) this.errorMostrarMsjDepartamento.push("Error, diminutivo departamento, espacio requerido");
                
                if(this.errorMostrarMsjDepartamento.length) this.errorDepartamento = 1; // si hay error que la variable erroCodigo pase a 1

                return this.errorDepartamento; // la retornamos 
        },


        // funcion que nos permite cerrar el modal 
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre_departamento = ''; // los objetos name del modal queden limpios
            this.diminutivo_departamento = '';
            this.descripcion = '';
            this.errorDepartamento=0; // para que no aparescan los msjs de error de espacios requeridos
        },


        limpiar(){

            this.nombre_departamento = ''; // los objetos name del modal queden limpios
            this.diminutivo_departamento = '';
            this.descripcion = '';

            this.errorDepartamento=0; // para que no aparescan los msjs de error de espacios requeridos


        },




        abrirModal(modelo, accion, data =[]){

            switch(modelo){
                case "departamento": // en el caso que sea con el modelo departamento
                {
                    switch(accion){
                        case 'registrar': // en el caso de que el modal sea para registar 
                            {
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Registrar Departamento' // encabezado del modal
                                this.tipoAccion = 1;
                                
                                this.bloquearBtnLimpiar = false; // se desbloquearan
                                
                                this.nombre_departamento = ''; // los objetos name del modal deben de inicializar limpios
                                this.diminutivo_departamento = '';                     
                                this.descripcion = '';
                               
                                break;
                            }
                        case 'actualizar': // en el caso de que sea para modificar
                            {
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Actualizar Departamento' // ncabezado del modal
                                this.tipoAccion = 2;
                                this.bloquearBtnLimpiar = true; // se desbloquearan

                                this.departamento_id = data['id'] // aqui se almacenara momentaneamente el id a modificar
                                // cargara los datos a la vista
                                this.nombre_departamento = data['nombre_departamento']; //se le indica que se va acceder exactamente a la propieda nombre_departamento
                                this.diminutivo_departamento = data['diminutivo_departamento'];                    
                                this.descripcion = data['descripcion'];

                                break;


                            }
                    }
                }
            }
        }
    },



        mounted() {
           this.listarDepartamento();
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






