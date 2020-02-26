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
                        <i class="fa fa-align-justify"></i> Listado Personas
                           <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">             <!-- invocamos a la funcion abrir modal     -->
                            <i class="icon-plus"></i>&nbsp;Nuevo    
                          </button>   
                    </div>
                    <div class="card-body">
                      <div class="panel-body table-responsive">
                      
                      

                        <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover" >
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Departamento</th>
                                    <th>Nombre Completo</th>             
                                    <th># identificacion</th>
                                    <th>telefono</th>
                                    <th>email</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                           
                           
                           
                           
                            <tbody>
                                  <tr v-for= "persona in arrayPersona" :key = "persona.id">
                                   
                                   
                                    <td>

                                        <!-- invocamos a la funcion abrir modal pero esta vez para actualizar y le enviamos el modelo-->
                                       <button type="button"  @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm"> 
                                       <i class="icon-pencil"></i>
                                       </button> &nbsp;

                                         <template v-if="persona.estado"> <!-- si nuestro estado es 1 -->
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPersona(persona.id)"> <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                         </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarPersona(persona.id)">  <!-- eneviamos el id al metodo -->
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                       

                                    </td>

                                            <td v-text="persona.nombre_departamento"></td>
                                            <td v-text="persona.nombre"></td>                                          
                                            <td v-text="persona.num_identificacion"></td>
                                            <td v-text="persona.telefono"></td>
                                            <td v-text="persona.email"></td>

                                              <!-- <td v-text="persona.estado"></td>-->
                                        <td>
                                            <div v-if="persona.estado"> <!-- si el estado es 1-->
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
                                    <th>Nombre Completo</th>             
                                    <th># identificacion</th>
                                    <th>telefono</th>
                                    <th>email</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                           


                        </table>        
                    </div>
                  </div>
                </div><!-- Fin ejemplo de tabla Listado -->               
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
                    <form action="" method="post" enctype="multipart/form-data" class="form-inline">

 
<div class="col-md-6">    
      <!--combobx para seleccionar un departamento -->
                        <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Departamento:</label>
                                <div class="col-md-9">
                                    <select  v-model="iddepartamento" class="col-md-9" maxlength="10" required> <!--enlazamos con la variable iddepartamento declarada abajo en la propieda data-->
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre_departamento"></option>
                                    </select>


                                </div>
                            </div>
                              <br>



                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre completo:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" id="nombre" v-model="nombre" class="form-control"  placeholder="escriba el nombre aqui" maxlength="50" required> <!-- v-model es como los names-->
                            </div>
                        </div>
                          <br>
                                

                         <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Identificacion: </label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_identificacion" class="col-md-9" maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="Cedula">Cedula</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                        </select>                                    
                                    </div>
                        </div>
                          <br>
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Número identificacion: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="num_identificacion" class="form-control" placeholder="101110111" pattern="[0-9]{1}[0]{1}[0-9]{3}[0]{1}[0-9]{3}" maxlength="9" required>                                        
                                    </div>
                        </div>
                          <br>

                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sexo: </label>
                                    <div class="col-md-9">
                                        <select v-model="sexo" class="col-md-9"  maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                        </select>                                    
                                    </div>
                        </div>
                          <br>

 </div>     

<div class="col-md-6">     
    
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Teléfono: </label>
                                    <div class="col-md-9">
                                        <input type="tel" id="telefono" v-model="telefono" class="form-control" placeholder="88888888" maxlength="8">
                                  
                                    </div>
                        </div>
                          <br>

                         <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fax: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="fax" class="form-control" placeholder="88888888" maxlength="8">   
                                    </div>
                        </div>
                          <br>

                   <div class="form-group row">                   
                                    <label class="col-md-3 form-control-label" for="email-input">Email:</label>
                                    <div class="col-md-9">                                       
                                        <input type="email" id="email" v-model="email" class="form-control" placeholder="escriba el email aqui" maxlength="50" @blur="validarCampos"> 
                                          <span v-if="validarEmail">incorrept*</span>  
                                    </div>
                                </div>
                                  <br>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Direccion:</label>
                            <div class="col-md-9">
                             <textarea type="text" v-model="direccion" class="form-control" placeholder="escriba la direccion aqui"  maxlength="256" cols="23" rows="3" style="resize: both;" required></textarea>       
                            </div>
                        </div>                        
                        <br>

                         <div v-show="errorPersona" class="form-group row div-error"> <!-- si viene con un 1 la variable errorCodigo iteramos     row div-error = esta declarada en los estilos                    -->
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error"></div>
                                    </div>    
                        </div>

 </div>                  
            


                    </form>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" @click = "limpiar()" v-bind:disabled="bloquearBtnLimpiar" >Limpiar</button>
                    <button type="button" class="btn btn-danger" @click = "cerrarModal()">Cerrar</button>
                    <button type="button" v-if = "tipoAccion==1" class="btn btn-success" @click = "registrarPersona()">Guardar</button>
                    <button type="button" v-if = "tipoAccion==2" class="btn btn-success" @click = "actualizarPersona()">Actualizar</button>
                

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
                    
                    persona_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar
                    iddepartamento : 0,
                    nombre_departamento: '',

                    nombre :'',  
                    tipo_identificacion : '',
                    num_identificacion : '',
                    sexo : '',
                    telefono : '',
                    fax : '',
                    email : '',
                    direccion : '',
                    estado : '',
                    validarEmail : '',
                  



                    arrayPersona : [], // array que optiene todos los objetos de la bd

                    modal : 0, // variable auxiliar para la funcion que abre el modal
                    tituloModal : '', // variable auxiliar para darcela al titulo del modal dependiendo si va a entrar a registrar o actualizar
                    tipoAccion : 0,
                    //variables para validar de que los datos no vallan nulos desde los campos de texto
                    errorPersona : 0,
                    errorMostrarMsjPersona : [],
                    arrayDepartamento : [], // se almacenaran el lista de todos los departamentos para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectDepartamento del controlador departamento
               
                    bloquearBtnLimpiar : ''
               }
            },


        methods : {

            validarCampos: function(){

                var texto = $("#email").val();
                var arroba = texto.indexOf('@');
                var punto = texto.indexOf('.');
                if(arroba == -1 || punto == -1){
                    this.validarEmail = true;
                }else{
                    this.validarEmail= false;
                }



            },



          mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },


        listarPersona(){
            let me= this;
            axios.get('/persona').then(response => {
                me.arrayPersona = response.data;
                this.mytable();
            })
            .catch(function (error) {
                //en caso de error que lo muestre en la consola del navegador 
                console.log(error);
                me. msjError(); // en caso de que falle 
                });
                
        },
        

            // funcion que permite registrar los datos son enviados al cajaController exactamente a la funcion store
        registrarPersona() {
                        
                        // validamos que hallan dejado espacios en blanco
                    if(this.validarPersona()){
                            return; // si los hay se saldra y no registrara

                    }  

                        let me= this;

                        axios.post('/persona/registrar',{ //metodo store por medio de la ruta 
                            'iddepartamento': this.iddepartamento,                  
                            'nombre': this.nombre,
                            'tipo_identificacion': this.tipo_identificacion,
                            'num_identificacion': this.num_identificacion,
                            'sexo': this.sexo,
                            'telefono': this.telefono,
                            'fax': this.fax,
                            'email': this.email,
                            'direccion': this.direccion

                        }).then(function (response) {
                            me.cerrarModal();
                            me.msjRegistrar(); 
                            //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                            me.listarPersona(); 
                        }).catch(function (error) {
                             // en caso de error mostrar en la consola del navegador
                            console.log(error);
                        });



        },


        msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Persona registrada con exito',
            showConfirmButton: false,
            timer: 1500
            })

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

     

            // este msj de sweetalert esta sirviendo pero aun no lo estoy utilizando
        msjError(){
            Swal.fire({
            title: 'ERROR al listar los datos, 1- Revisa tu conexion, 2- Revisa el metodo Axios listarPersona() 3- Revisa el metodo index(Request $request) del controlador ',
            animation: false,
            customClass: 'animated tada'
            })
        },


        actualizarPersona(){
     
                            // validamos que hallan dejado espacios en blanco
                        if(this.validarPersona()){
                                return; // si los hay se saldra y no registrara

                        }  

                            let me= this;

                            axios.put('/persona/actualizar',{ //metodo update por medio de la ruta
                                 'iddepartamento': this.iddepartamento, 
                                 'nombre': this.nombre,
                                 'tipo_identificacion': this.tipo_identificacion,
                                 'num_identificacion' : this.num_identificacion,
                                 'sexo' : this.sexo,
                                 'telefono' : this.telefono,
                                 'fax' : this.fax,
                                 'email': this.email,
                                 'direccion': this.direccion,                            
                                 'id' : this.persona_id // a diferencia del de registrar le enviamos el id que fue almacenado momentaneamente en esta variable

                            }).then(function (response) {
                                me.cerrarModal();
                                 me.msjActualizar();
                                //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                                me.listarPersona();
                            }).catch(function (error) {
                                // en caso de error mostrar en la consola del navegador
                                console.log(error);
                            });
        },
  
        msjActualizar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Persona actualizada con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },

        desactivarPersona(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de desactivar esta persona?',
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

                    axios.put('/persona/desactivar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /persona/desactivar para que se lo envie al metodo del controlador desactivar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarPersona();
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


        activarPersona(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro de activar esta persona?',
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

                    axios.put('/persona/activar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /persona/activar para que se lo envie al metodo del controlador activar
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarPersona();
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


       
       
       
       
        validarPersona(){

            // inicializamos de nuevo las variables
            this.errorPersona=0;
            this.errorMostrarMsjPersona = [];

            if(this.iddepartamento == 0 ) this.errorMostrarMsjPersona.push("Seleccione un departamento");
            if(!this.nombre) this.errorMostrarMsjPersona.push("Error,nombre ,espacio requerido");
            if(!this.tipo_identificacion) this.errorMostrarMsjPersona.push("Error, tipo de identificacion ,espacio requerido");
            if(!this.num_identificacion) this.errorMostrarMsjPersona.push("Error,numero de identidad ,espacio requerido");   
            if(!this.sexo) this.errorMostrarMsjPersona.push("Error,sexo ,espacio requerido");
            if(!this.direccion) this.errorMostrarMsjPersona.push("Error,direccion ,espacio requerido");


            if(this.errorMostrarMsjPersona.length) this.errorPersona = 1; // si hay error que la variable erroPersona pase a 1

            return this.errorPersona; // la retornamos

        },



            // funcion que nos permite cerrar el modal 
        cerrarModal(){
            this.modal=0;
            this.iddepartamento=0;
            this.nombre_departamento ='';
            this.nombre = ''; // los objetos name del modal queden limpios
            this.tipo_identificacion = '';
            this.num_identificacion = '';
            this.sexo = '';
            this.telefono = '';
            this.fax = '';      
            this.email = '';
            this.direccion = '';
            this.errorPersona=0;
        },

        limpiar(){

                    this.iddepartamento=0;
                    this.nombre_departamento ='';
                    this.nombre = ''; // los objetos name del modal queden limpios
                    this.tipo_identificacion = '';
                    this.num_identificacion = '';
                    this.sexo = '';
                    this.telefono = '';
                    this.fax = '';      
                    this.email = '';
                    this.direccion = '';
                    this.errorPersona=0;


        },


            // funcion que nos permite abrir el modal
        abrirModal(modelo, accion, data =[]){ // parametro modelo,accion, data trae todo los registros
                switch(modelo){
                    case "persona": // en el caso que sea con el modelo persona
                    {
                    switch(accion){
                        case 'registrar': // en el caso de que el modal sea para registar 
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Registrar Persona' // encabezado del modal
                                this.iddepartamento = 0; // los objetos name del modal deben de inicializar vacios por que va a registrar 
                                this.bloquearBtnLimpiar = false;
                                
                                this.nombre_departamento = '';
                                this.nombre = ''; // los objetos name del modal queden limpios
                                this.tipo_identificacion = '';
                                this.num_identificacion = '';
                                this.sexo = '';
                                this.telefono = '';
                                this.fax = '';      
                                this.email = '';
                                this.direccion = '';
                               
                                this.tipoAccion = 1;
                                break;
                            }
                        case 'actualizar': // en el caso de que sea para modificar
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Actualizar Persona' // ncabezado del modal
                                this.tipoAccion = 2;
                                this.bloquearBtnLimpiar = true;

                                this.persona_id = data['id'] // aqui se almacenara momentaneamente el id a modificar
                                // cargara los datos a la vista
                                this.iddepartamento = data['iddepartamento']         
                               
                                this.nombre = data['nombre']; //se le indica que se va acceder exactamente a la propieda nombre
                                this.tipo_identificacion = data['tipo_identificacion'];
                                this.num_identificacion = data['num_identificacion'];
                                this.sexo = data['sexo'];
                                this.telefono = data['telefono'];
                                this.fax = data['fax'];
                                this.email = data['email'];
                                this.direccion = data['direccion'];

                                break;


                            }
                        }
                    }
                }

                this.selectDepartamento(); // para llamar al metodo que carga el combobox de los departamento en esta vista de persona por medio de la url
            }






       
       
    },


    





            mounted() {
            this.listarPersona();
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




