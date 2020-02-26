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
                        <i class="fa fa-align-justify"></i> Listado Cajas
                        <button type="button" @click="abrirModal('caja','registrar')" class="btn btn-secondary"> <!-- invocamos a la funcion abrir modal-->
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                      <div class="panel-body table-responsive">  
                      

                         <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Departamento</th>
                               <!-- <th>Documental</th> -->
                                    <th>Diminutivo caja</th>               
                                    <th>Ubicacion</th>
                            <!--    <th>fecha_extrema</th> -->
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <tr v-for= "caja in arrayCaja" :key = "caja.id">
                                   
                                   
                                    <td>

                                        <!-- invocamos a la funcion abrir modal pero esta vez para actualizar y le enviamos el modelo-->
                                       <button type="button" @click="abrirModal('caja','actualizar',caja)" class="btn btn-warning btn-sm"> 
                                       <i class="icon-pencil"></i>
                                       </button> &nbsp;

                                         <template v-if="caja.estado"> <!-- si nuestro estado es 1 -->
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCaja(caja.id)"> <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                         </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarCaja(caja.id)">  <!-- eneviamos el id al metodo -->
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                       

                                    </td>

                                            <td v-text="caja.nombre_departamento"></td>
                                      <!--  <td v-text="caja.nombre_documental"></td> -->
                                            <td v-text="caja.diminutivo_caja"></td> 
                                            <td v-text="caja.ubicacion"></td>
                                      <!--  <td v-text="caja.fecha_extrema"></td> -->
                                            
                                        <td>
                                            <div v-if="caja.estado"> <!-- si el estado es 1-->
                                            <span class="badge badge-success">Activo</span>
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
                                    <th>Departamento</th>
                              <!--  <th>Documental</th>  -->
                                    <th>Diminutivo caja</th>               
                                    <th>Ubicacion</th>
                              <!--  <th>fecha_extrema</th>  -->
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            
                        </table>        
                    </div>
                  </div>
                </div>  <!-- Fin ejemplo de tabla Listado -->              
            </div><!-- Fin ventana -->
            



            <!--Inicio del modal agregar/actualizar--> <!-- para mostrar el modal la variable modal que viene de abajo debe de venir ya en 1 -->
            <div class="modal fade" tabindex="-1"            :class="{'mostrar' : modal}"             role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content"> <!-- tiene el estilo que esta mas abajo-->
                
                <!--encabezado de modal-->  
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4> <!-- variable que viene de abajo para dale el encabezado al modal-->
                    <button type="button" class="close" @click = "cerrarModal()" aria-label="Close"> <!-- esta es la X que esta en la esquina del modal por lo tanto tambien invoca la funcion cerrarModal mediante la directiva @click-->
                        <span aria-hidden="true">×</span>
                    </button>
                </div>



                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                        <!--combobx para seleccionar un departamento -->
                        <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Departamento:</label>
                                <div class="col-md-9">
                                    <select  v-model="iddepartamento" @change="optenerDiminutivoDepartamento"  v-bind:disabled="bloquearCBX" class="form-control" maxlength="10" required > <!--enlazamos con la variable iddepartamento declarada abajo en la propieda data-->
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre_departamento"></option>
                                    </select>


                                </div>
                            </div>

                        <!--combobx para seleccionar el tipo de documental de ese archivo 

                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Tipo documental:</label>
                                    <div class="col-md-9">
                                        <select  v-model="iddocumental"  v-bind:disabled="bloquearCBX" class="form-control" > enlazamos con la variable iddocumental declarada abajo en la propieda data
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="documental in arrayDocumental" :key="documental.id" :value="documental.id" v-text="documental.nombre_documental +'-'+ documental.codigo_diminutivo"></option>
                                        </select>
                                    </div>
                        </div>

                         -->

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Diminutivo Caja:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="diminutivo_caja"  v-bind:disabled="bloquear" class="form-control"  placeholder="cargando... "  maxlength="45" required> <!-- v-model es como los names-->
                            </div>
                        </div>
                                


                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Numero Caja:</label>
                            <div class="col-md-9">
                                <!--acepte solo numeros-->
                            <input type="number" v-model="num_caja" v-bind:disabled="bloquear" class="form-control" placeholder="cargando ... " maxlength="10" required>   
                        
                            </div>
                        </div>
                                

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Ubicacion:</label>
                            <div class="col-md-9">
                            <input type="text" v-model="ubicacion" class="form-control" placeholder="escriba la ubicacion de la caja"  maxlength="45" required>   
                            </div>
                        </div>

                        <!--

                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha extrema:</label>
                            <div class="col-md-9">
                            <input type="text" v-model="fecha_extrema" v-bind:disabled="bloquearFecha_extrema" class="form-control" placeholder="escriba la fecha extrema de la caja"  maxlength="45">   
                            </div>
                        </div>

                        -->

                            <div v-show="errorCaja" class="form-group row div-error"> <!-- si viene con un 1 la variable errorCodigo iteramos     row div-error = esta declarada en los estilos                    -->
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsjCaja" :key="error" v-text="error"></div>
                                    </div>    
                                </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" @click = "limpiar()" v-bind:disabled="bloquearBtnLimpiar" >Limpiar</button>
                    <button type="button" class="btn btn-danger" @click = "cerrarModal()">Cerrar</button>
                    <button type="button" v-if = "tipoAccion==1" class="btn btn-success" @click = "registrarCaja()">Guardar</button>
                    <button type="button" v-if = "tipoAccion==2" class="btn btn-success" @click = "actualizarCaja()">Actualizar</button>

                </div>

            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
            </div>












        </main>
      
</template>

<script>
   
            
            //exporto la clase del jtable para hacer uso de ella 
            import datables from 'datatables'


export default {


            data(){
                return {
                    
                    caja_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar
                    iddepartamento : 0,                
                    nombre_departamento: '',
                 // iddocumental : 0,
                 // nombre_documental: '',

                    diminutivo_caja :'',  
                    num_caja : '',           
                    ubicacion : '',
                 // fecha_extrema : '',
                    estado : '',
                    arrayCaja : [], // array que optiene todos los objetos de la bd

                    modal : 0, // variable auxiliar para la funcion que abre el modal
                    tituloModal : '', // variable auxiliar para darcela al titulo del modal dependiendo si va a entrar a registrar o actualizar
                    tipoAccion : 0,
                    //variables para validar de que los datos no vallan nulos desde los campos de texto
                    errorCaja : 0,
                    errorMostrarMsjCaja : [],
                    arrayDepartamento : [], // se almacenaran el lista de todos los departamentos para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectDepartamento del controlador departamento
                //  arrayDocumental : [], // se almacenaran el lista de todos los documentales para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectDocumental del controlador documental

                    bloquear : '', // variable que servira para bloquear cualquier tipo de input cuando se abra el modal
                //  bloquearFecha_extrema : '',
                    bloquearCBX : '',
                    bloquearBtnLimpiar : ''
               }
            },


        methods : {

          mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },


        listarCaja(){
            let me= this;
            axios.get('/caja').then(response => {
                me.arrayCaja = response.data;
                this.mytable();
            })
            .catch(function (error) {
                //en caso de error que lo muestre en la consola del navegador 
                console.log(error);
                me. msjError(); // en caso de que falle 
                });
                
        },
        

            // funcion que permite registrar los datos son enviados al cajaController exactamente a la funcion store
        registrarCaja() {
                        
                        // validamos que hallan dejado espacios en blanco
                    if(this.validarCaja()){
                            return; // si los hay se saldra y no registrara

                    }  

                        let me= this;

                        axios.post('/caja/registrar',{ //metodo store por medio de la ruta 
                            'iddepartamento': this.iddepartamento,
                          //'iddocumental': this.iddocumental,                     
                            'diminutivo_caja': this.diminutivo_caja+'-'+this.num_caja,
                            'num_caja': this.num_caja,
                            'ubicacion': this.ubicacion
                          //'fecha_extrema': this.fecha_extrema

                        }).then(function (response) {
                            me.cerrarModal();
                            me.msjRegistrar(); 
                            //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                            me.listarCaja(); 
                        }).catch(function (error) {
                             // en caso de error mostrar en la consola del navegador
                            console.log(error);
                        });



        },

        msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Caja registrada con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },

        selectDepartamento(){
                // copiado de listarCaja
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

      //selectDocumental(){
                //copiado de listarCaja
                //let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                //var url='/documental/seleccionarDocumentales';
                //tomado de github axios se lo envia al metodo seleccionarTodosDocumentales
                //axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                //.then(function (response) {
                //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                //var respuesta= response.data;           
                //me.arrayDocumental  = respuesta.documentales; // paso todos los datos al arrayDocumental

                //})
                //.catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    //console.log(error);
                //});

        //},

        optenerDiminutivoDepartamento(e) { // OBTIENE EL DIMINUTIVO DEL DEPARTAMENTO PARA QUE PASE HACER EL DIMINUTIVO YA DE LA CAJA 
                  var id = event.target.value, // obtengo el id de la vista
                  value = event.target.textContent; 
                    let me = this;
                     //console.log(id);
                    me.optenerNum_caja(id); // le envio tambien el id al metodo que me optiene el numero de caja esto para que tambien lo cargue en el modal
                    
                     var array=[];
                     var url='/departamento/selectDiminutivoDepartamento?id=' + id; //mediante la url "ruta" le envio al metodo del controlador el id 
                    
                     axios.get(url)
                     .then(function (response) {
                     
                     var respuesta= response.data;                        
                     me.diminutivo_caja = respuesta[0]['diminutivo_departamento']; // lo que trae de la BD se lo paso al campo diminutivo de caja del modal 
                  
                     }).catch(function (error) {
                          // en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });
        },

            // este metodo obtiene la ultima caja registrada de un departamento en especifico
        optenerNum_caja(id){ // parameto que viene del metodo optenerDiminutivoDepartamento

                      let me = this;
                      var array=[];
                      var url='/caja/selectNumCaja?id=' + id; // mediante la url "ruta" le envio el id para que me devuelva la respuesta 
                      axios.get(url)
                     .then(function (response) {
                        
                        //console.log(id);
                        var respuesta= response.data;
                        var aux_num_caja;
                        if(respuesta == ""){ // en caso de que venga vacio y xq sera la primera vez que se registrara una caja de un departamento en especifico
                            
                            aux_num_caja = 1; // le digo que empiece en 1
                            me.num_caja =  aux_num_caja; // y se lo paso al campo num_caja del modal para que lo muestre

                        }else{ // si no pues es xq ya habian

                            aux_num_caja = respuesta[0]['num_caja']; // en una variable auxiliar le paso el ultimo numero de caja rehistrado de ese departamento en especifico
                            aux_num_caja ++; //para sumarle 1 
                            me.num_caja =  aux_num_caja; // y se lo paso al campo num_caja del modal para que lo muestre

                        }   
                                                            
                     }).catch(function (error) {
                         // en caso de error mostrar en la consola del navegador
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



        actualizarCaja(){
     
                            // validamos que hallan dejado espacios en blanco
                        if(this.validarCaja()){
                                return; // si los hay se saldra y no registrara

                        }  

                            let me= this;

                            axios.put('/caja/actualizar',{ //metodo update por medio de la ruta

                                'ubicacion': this.ubicacion,
                                'id' : this.caja_id // a diferencia del de registrar le enviamos el id que fue almacenado momentaneamente en esta variable

                            }).then(function (response) {
                                me.cerrarModal();
                                me.msjActualizar();
                                //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                                me.listarCaja();
                            }).catch(function (error) {
                                // en caso de error mostrar en la consola del navegador
                                console.log(error);
                            });
        },



        msjActualizar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Caja actualizada con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },


        desactivarCaja(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de desactivar esta caja?',
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

                    axios.put('/caja/desactivar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /caja/desactivar para que se lo envie al metodo del controlador desactivarCaja
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarCaja();
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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


        activarCaja(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de activar esta caja?',
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

                    axios.put('/caja/activar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /caja/activar para que se lo envie al metodo del controlador activar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarCaja();
                        swal(
                        'Activado!',
                        'El registro ha sido Activado con éxito.',
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








        validarCaja(){

            // inicializamos de nuevo las variables
            this.errorCaja=0;
            this.errorMostrarMsjCaja = [];


            if(this.iddepartamento == 0 ) this.errorMostrarMsjCaja.push("Seleccione un departamento");
          //if(this.iddocumental == 0 ) this.errorMostrarMsjCaja.push("Seleccione un tipo documental");
            if(!this.diminutivo_caja) this.errorMostrarMsjCaja.push("Error,diminutivo caja ,espacio requerido");
            if(!this.num_caja) this.errorMostrarMsjCaja.push("Error,numero caja ,espacio requerido, debe ser un numero");
            if(!this.ubicacion) this.errorMostrarMsjCaja.push("Error,ubicacion ,espacio requerido");
          //if(!this.fecha_extrema) this.errorMostrarMsjCaja.push("Error,fecha extrema ,espacio requerido");
            
            if(this.errorMostrarMsjCaja.length) this.errorCaja = 1; // si hay error que la variable erroCodigo pase a 1

            return this.errorCaja; // la retornamos

        },



            // funcion que nos permite cerrar el modal 
        cerrarModal(){
            this.modal=0;
            this.iddepartamento=0;
            this.nombre_departamento ='';
          //this.iddocumental=0;
          //this.nombre_documental ='';
            this.diminutivo_caja = ''; // los objetos name del modal queden limpios
            this.num_caja = '';
            this.ubicacion = '';
          //this.fecha_extrema = '';
            this.errorCaja=0;
        },

        limpiar(){

            this.iddepartamento=0;
            this.nombre_departamento ='';
          //this.iddocumental=0;
          //this.nombre_documental ='';
            this.diminutivo_caja = ''; // los objetos name del modal queden limpios
            this.num_caja = '';
            this.ubicacion = '';
          //this.fecha_extrema = '';

            this.errorCaja=0;

        },





            // funcion que nos permite abrir el modal
        abrirModal(modelo, accion, data =[]){ // parametro modelo,accion, data trae todo los registros
                switch(modelo){
                    case "caja": // en el caso que sea con el modelo caja
                    {
                    switch(accion){
                        case 'registrar': // en el caso de que el modal sea para registar 
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Registrar Caja' // encabezado del modal
                                this.tipoAccion = 1;
                               
                                this.bloquearCBX =false;// se desbloqueara el CBX que contiene los departamentos
                                this.bloquear = true; // se bloquearan ambos input diminutivo_caja y num_caja mediante la directiva  v-bind:disabled="bloquear"
                                //this.bloquearFecha_extrema = false; // se desbloqueara
                                this.bloquearBtnLimpiar = false; // se desbloquearan

                               
                                this.iddepartamento = 0; // los objetos name del modal deben de inicializar vacios por que va a registrar 
                                this.nombre_departamento = '';
                                //this.iddocumental = 0;
                                //this.nombre_documental = '';
                                this.diminutivo_caja = '';
                                this.num_caja = '';
                                this.ubicacion = '';
                                //this.fecha_extrema = '';
                               
                                break;
                            }
                        case 'actualizar': // en el caso de que sea para modificar
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Actualizar Caja' // ncabezado del modal
                                this.tipoAccion = 2;

                                this.bloquearCBX =true;// se bloqueara el CBX que contiene los departamentos
                                this.bloquear = true; // se bloquearan ambos input diminutivo_caja y num_caja mediante la directiva  v-bind:disabled="bloquear"
                                //this.bloquearFecha_extrema = true; // se bloqueara
                                this.bloquearBtnLimpiar = true; // se bloquearan

                                this.caja_id = data['id'] // aqui se almacenara momentaneamente el id a modificar
                                // cargara los datos a la vista
                                this.iddepartamento = data['iddepartamento'];
                                //this.iddocumental = data['iddocumental'];            
                                this.diminutivo_caja = data['diminutivo_caja']; //se le indica que se va acceder exactamente a la propieda diminutivo_caja
                                this.num_caja = data['num_caja'];
                                this.ubicacion = data['ubicacion'];
                                //this.fecha_extrema = data['fecha_extrema'];

                                break;


                            }
                        }
                    }
                }

                this.selectDepartamento(); // para llamar al metodo que carga el combobox de los departamento en esta vista de caja por medio de la url
                //this.selectDocumental();
            }


            },

            mounted() {
            this.listarCaja();
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



























































