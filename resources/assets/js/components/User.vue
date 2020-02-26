<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>

              <div class="container-fluid"><!-- comienzo ventana -->
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Listado De Usuarios
                         <button type="button"  @click="abrirModal('persona','registrar')"  class="btn btn-secondary"> <!-- invocamos a la funcion abrir modal-->
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
                                    <th>Rol</th> 
                                    <th>Nombre Completo</th>
                                    <th># identificacion</th> <!-- agrege este campo de mas en el listado-->
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    
                                </tr>
                            </thead>


                            <tbody>
                                <tr v-for= "persona in arrayPersona" :key = "persona.id">
                                    
                                     <td>

                                        <!-- invocamos a la funcion abrir modal pero esta vez para actualizar y le enviamos el modelo-->
                                       <button type="button" @click="abrirModal('persona','actualizar',persona)"   class="btn btn-warning btn-sm"> 
                                       <i class="icon-pencil"></i>
                                       </button> &nbsp;

                                         <template v-if="persona.estado"> <!-- si nuestro estado es 1 -->
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(persona.id)" > <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                         </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm"  @click="activarUsuario(persona.id)" >  <!-- eneviamos el id al metodo -->
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                       

                                    </td>
                                                                   
                                      <!-- y que valla cargando cada uno de los datos encontrados en la tabla-->
                                    <td v-text="persona.nombre_departamento"></td>                                 
                                    <td v-text="persona.rol"></td>
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.num_identificacion"></td>
                                    <td v-text="persona.usuario"></td>
                                    <td>
                                        <div v-if="persona.estado">
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
                                    <th>Rol</th> 
                                    <th>Nombre Completo</th>
                                    <th># identificacion</th> <!-- agrege este campo de mas en el listado-->
                                    <th>Usuario</th>
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
                    <form action=""  method="post" enctype="multipart/form-data" class="form-inline" >

               

<div class="col-md-6">   
       <!--combobx para seleccionar un departamento -->
                        <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Departamento:</label>
                                <div class="col-md-9">
                                    <select  v-model="iddepartamento" class="form-control" v-bind:disabled="bloquearCampos" maxlength="10" required > <!--enlazamos con la variable iddepartamento declarada abajo en la propieda data-->
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre_departamento"></option>
                                    </select>

                                </div>
                            </div>
                            <br>
                          
                        
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="nombre" class="form-control"  placeholder="escriba el nombre aqui "  v-bind:disabled="bloquearCampos"  maxlength="50" required> <!-- v-model es como los names-->
                            </div>
                        </div>
                            <br>      
                                
                         <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Identificacion: </label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_identificacion" class="form-control"  v-bind:disabled="bloquearCampos"  maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="Cedula">Cedula</option>
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                        </select>                                    
                                    </div>
                        </div>
                          <br>

                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Número identificacion: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="num_identificacion" class="form-control" placeholder="101110111" pattern="[0-9]{1}[0]{1}[0-9]{3}[0]{1}[0-9]{3}"  v-bind:disabled="bloquearCampos"  maxlength="9" required>                                                 
                                    </div>
                        </div>
                          <br>

                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sexo: </label>
                                    <div class="col-md-9">
                                        <select v-model="sexo" class="form-control"  v-bind:disabled="bloquearCampos" maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                        </select>                                    
                                    </div>
                        </div>
                          <br>

                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Teléfono: </label>
                                    <div class="col-md-9">
                                        <input type="tel" v-model="telefono" class="form-control" placeholder="88888888"  v-bind:disabled="bloquearCampos" maxlength="8">   
                                    </div>
                        </div>
                          <br>

                         <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fax: </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="fax" class="form-control" placeholder="88888888"  v-bind:disabled="bloquearCampos" maxlength="8">   
                                    </div>
                        </div>
                          <br>

                         <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email:</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="escriba el email aqui"  v-bind:disabled="bloquearCampos" maxlength="50">   
                                    </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Direccion:</label>
                            <div class="col-md-9">
                            <input type="text" v-model="direccion" class="form-control" placeholder="escriba la direccion aqui" v-bind:disabled="bloquearCampos" maxlength="256" required>   
                            </div>
                        </div>
                   
                        


 </div>


 
<div class="col-md-6">  

                     <!--  border  combobx para seleccionar un departamento -->
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Personas:</label>
                                    <div class="col-md-9">
                                        <select v-model="idpersona"  @change="llenarCampos"  v-bind:disabled="bloquearCbxPersona" class="form-control" maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="persona in arrayPersonaCBX" :key="persona.id" :value="persona.id" v-text="persona.nombre"></option>
                                        </select>
                                    </div>
                        </div>
                          <br>
                         <!--combobx para seleccionar un departamento  --> 
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Rol:</label>
                                    <div class="col-md-9">
                                        <select v-model="idrol" class="form-control" maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>
                                    </div>
                        </div>
                          <br>

                        <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Usuario:</label>
                                   <div class="col-md-9">
                                     <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario" maxlength="50" required>
                                   </div>
                        </div>   
                          <br>

                        <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">password:</label>
                                <div class="col-md-9">
                                     <input type="password" v-model="password" class="form-control" placeholder="password del usuario" maxlength="50" required>
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

        data (){
            return {
                idpersona : 0, // si en el cbx persona
                persona_id: 0,
                user_id: 0,
                iddepartamento : 0, // si en el modal v-model y tambien en el metodo validar
                nombre_departamento: '', //si en el modal 
                idrol : 0 , // si 
                usuario : '',
                password : '',
                estado : '',

                nombre :'',  // si arriba en el listado
                tipo_identificacion : '',
                num_identificacion : '',
                sexo : '',
                telefono : '',
                fax : '',
                email : '',
                direccion : '',

                arrayUser : [],
                arrayDepartamento : [], //si para el select departamento
                arrayPersona : [], // si para el listado de usuarios
                arrayPersonaCBX : [], // si para el select persona
                arrayRol : [], // si para el select rol
                
                modal : 0, //si
                tituloModal : '', //si
                tipoAccion : 0, //si
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                
                bloquearCbxPersona : '', // variable que servira para bloquear cualquier tipo de input cuando se abra el modal
                bloquearBtnLimpiar : '',
                bloquearCampos : ''
            }
        },
       
        methods : {
           
        mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },
        
        //metodo que enlista todos los roles que viene de bd
        listarPersona (){
                let me=this;
               
               axios.get('/user').then(response => {
                    me.arrayPersona = response.data;
                    this.mytable();

                })
                .catch(function (error) {
                    // en caso de error, mostrar en la consola del navegador
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
                let me = this;

                 axios.post('/user/registrar',{ //metodo store por medio de la ruta 
                   
                    'id': this.idpersona,  // xq lo que va a hacer en el metodo store en el controlador sera actualizar los datos nadamas   
                    'iddepartamento': this.iddepartamento,                  
                    'nombre': this.nombre,
                    'tipo_identificacion': this.tipo_identificacion,
                    'num_identificacion': this.num_identificacion,
                    'sexo': this.sexo,
                    'telefono': this.telefono,
                    'fax': this.fax,
                    'email': this.email,
                    'direccion': this.direccion,
                    
                    'idrol' : this.idrol,
                    'usuario': this.usuario,
                    'password': this.password

                }).then(function (response) {
                    me.cerrarModal();
                    me.msjRegistrar(); 
                    me.listarPersona();
                }).catch(function (error) {
                    console.log(error);
                    me.msjErrorCbxPersona();
                    me.limpiar();
                });


        },

        
        msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Usuario registrado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },


        msjErrorCbxPersona(){
            Swal.fire({
            title: 'ERROR, 1- El usuario ya fue registrado 2- Seleccionar una persona',
            animation: false,
            customClass: 'animated tada'
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
  
        
        selectRol(){
                // copiado de listarPersona
                let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                var url='/rol/selectRol';
                //tomado de github axios se lo envia al metodo selectRol
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayRol = respuesta.roles; // paso todos los datos al arrayRol

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });

        },
  

        selectPersona(){
                // copiado de listarPersona
                let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                var url='/persona/selectPersona';
                //tomado de github axios se lo envia al metodo selectRol
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayPersonaCBX = respuesta.personas; // paso todos los datos al arrayRol

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });

        },
  

        llenarCampos(e){ // OBTIENE TODOS LA INFORMACION DE ESA PERSONA SELECCIONADA
                  var id = event.target.value, // obtengo el id de la vista
                  value = event.target.textContent; 
                    let me = this;

                     var array=[];
                     var url='/persona/llenarCampos?id=' + id; //mediante la url "ruta" le envio al metodo del controlador el id 
                    
                     axios.get(url)
                     .then(function (response) {
                     
                       var respuesta= response.data;                        
                    
                    me.iddepartamento = respuesta[0]['iddepartamento'];
                    me.nombre = respuesta[0]['nombre']; // lo que trae de la BD se lo paso al campo diminutivo de caja del modal                
                    me.tipo_identificacion =respuesta[0]['tipo_identificacion'];
                    me.num_identificacion = respuesta[0]['num_identificacion'];
                    me.sexo = respuesta[0]['sexo'];
                    me.telefono = respuesta[0]['telefono'];
                    me.fax = respuesta[0]['fax'];
                    me.email = respuesta[0]['email'];
                    me.direccion = respuesta[0]['direccion'];


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
           
        actualizarPersona(){
                     // validamos que hallan dejado espacios en blanco
                    if(this.validarPersona()){
                            return; // si los hay se saldra y no registrara
                    }  

                             let me= this;

                            axios.put('/user/actualizar',{ //metodo update por medio de la ruta
                                 'iddepartamento': this.iddepartamento, 
                                 'nombre': this.nombre,
                                 'tipo_identificacion': this.tipo_identificacion,
                                 'num_identificacion' : this.num_identificacion,
                                 'sexo' : this.sexo,
                                 'telefono' : this.telefono,
                                 'fax' : this.fax,
                                 'email': this.email,
                                 'direccion': this.direccion,                            

                                 'idrol' : this.idrol,
                                 'usuario': this.usuario,
                                 'password': this.password,
                                                               
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
            title: 'Usuario actualizado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },

        desactivarUsuario(id){
               swal({
                title: 'Esta seguro de desactivar este usuario?',
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
                    let me = this;

                    axios.put('/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona();
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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

        activarUsuario(id){
               swal({
                title: 'Esta seguro de activar este usuario?',
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
                    let me = this;

                    axios.put('/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona();
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
            if(this.idrol== 0) this.errorMostrarMsjPersona.push("Error,rol ,espacio requerido");
            if(!this.usuario) this.errorMostrarMsjPersona.push("Error,usuario ,espacio requerido");
            if(!this.password) this.errorMostrarMsjPersona.push("Error,password ,espacio requerido");
            


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

            this.idpersona = 0;    
            this.idrol = 0;      
            this.usuario = '';
            this.password = '';

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

            this.idpersona = 0;    
            this.idrol = 0;      
            this.usuario = '';
            this.password = '';

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
                                this.tituloModal ='Registrar Usuario' // encabezado del modal
                                this.tipoAccion = 1;

                                this.bloquearBtnLimpiar = false; // se desbloquearan
                                this.bloquearCbxPersona = false; // se desbloquearan
                                this.bloquearCampos = true;


                                this.iddepartamento = 0; // los objetos name del modal deben de inicializar vacios por que va a registrar 
                                this.nombre_departamento = '';
                                this.nombre = ''; // los objetos name del modal queden limpios
                                this.tipo_identificacion = '';
                                this.num_identificacion = '';
                                this.sexo = '';
                                this.telefono = '';
                                this.fax = '';      
                                this.email = '';
                                this.direccion = '';

                                this.idpersona = 0;    
                                this.idrol = 0;      
                                this.usuario = '';
                                this.password = '';
                               
                               
                                break;
                            }
                        case 'actualizar': // en el caso de que sea para modificar
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Actualizar Usuario' // ncabezado del modal
                                this.tipoAccion = 2;

                                this.bloquearBtnLimpiar = true;
                                this.bloquearCbxPersona = true; // se bloquearan
                                this.bloquearCampos = true;

                                // mo es el id del cbx persona
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

                                this.idrol=data['idrol'];
                                this.usuario = data['usuario'];
                                this.password=data['password'];

                                break;


                            }
                        }
                    }
                }

                this.selectDepartamento(); // para llamar al metodo que carga el combobox de los departamento en esta vista de persona por medio de la url
                this.selectRol();
                this.selectPersona();
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




















