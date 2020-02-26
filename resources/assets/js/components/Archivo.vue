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
                        <i class="fa fa-align-justify"></i> Listado Archivos
                        <button type="button"  @click="abrirModal('archivo','registrar')" class="btn btn-secondary"> <!-- invocamos a la funcion abrir modal-->
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                      <div class="panel-body table-responsive">  
                      

                        <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Diminutivo caja</th>               
                                    <th>Nuevo # expediente</th>
                                    <th>Viejo # expediente</th>
                                    <th>Departamento</th>
                                    <th>Tipo Documental</th>
                                    <th>Fecha Extrema</th>
                                  <!--  <th>Anno</th> -->
                                    <th>Ubicacion</th>
                                    <th>fecha ingreso</th>
                                  <!--   <th>Ususario Gestor</th> -->
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <tr v-for= "archivo in arrayArchivo" :key = "archivo.id">
                                   
                                   
                                    <td>

                                        <!-- invocamos a la funcion abrir modal pero esta vez para actualizar y le enviamos el modelo-->
                                       <button type="button"  @click="abrirModal('archivo','actualizar',archivo)" class="btn btn-warning btn-sm"> 
                                       <i class="icon-pencil"></i>
                                       </button> &nbsp;

                                         <template v-if="archivo.estado ==1"> <!-- si nuestro estado es 1 -->
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarArchivo(archivo.id)"> <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                         </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarArchivo(archivo.id)">  <!-- eneviamos el id al metodo -->
                                                <i class="icon-check"></i>
                                            </button>
                                        </template> &nbsp;
                                       
                                         
                                            <button type="button" class="btn btn-dark btn-sm" @click="eliminarArchivo(archivo.id)"> <!-- eneviamos el id al metodo -->
                                                <i class="icon-trash"></i>
                                            </button>
                                       


                                    </td>

                                            <td v-text="archivo.diminutivo_caja"></td> 
                                            <td v-text="archivo.codigo_diminutivo +'-'+ archivo.nuevo_num_expediente"></td> 
                                            <td v-text="archivo.viejo_num_expediente"></td>
                                            <td v-text="archivo.nombre_departamento"></td>
                                            <td v-text="archivo.nombre_documental"></td>
                                            <td v-text="archivo.fecha_extrema"></td>
                                       <!--      <td v-text="archivo.anno"></td> -->
                                            <td v-text="archivo.ubicacion"></td>
                                            <td v-text="archivo.created_at"></td>
                                        <!--      <td v-text="archivo.usuario"></td> -->

              
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

                             <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Diminutivo caja</th>               
                                    <th>Nuevo # expediente</th>
                                    <th>Viejo # expediente</th>
                                    <th>Departamento</th>
                                    <th>Tipo Documental</th>
                                    <th>Fecha Extrema</th>
                              <!--  <th>Anno</th> -->
                                    <th>Ubicacion</th>
                                    <th>fecha ingreso</th>
                              <!--        <th>Ususario Gestor</th>  -->
                                    <th>Status</th>
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
                    <form action="" method="post" enctype="multipart/form-data" class="form-inline"> <!-- para dejar los input unos a la par de otros-->

<div class="col-md-6">   

  <!--combobx para seleccionar un departamento -->
                         <br>
                        <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Departamento que envia:</label>
                                <div class="col-md-9">
                                      <select  v-model="iddepartamento" @change="selectCajaRegistrar" name="iddepartamento" id="iddepartamento" class="select-picker" searchable="Search here.."
                                       data-live-search="true" data-style="btn-warning" data-size="5" maxlength="10" required > <!--enlazamos con la variable iddepartamento declarada abajo en la propieda data-->
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre_departamento"></option>
                                    </select>
                                </div>
                            </div>
                              <br>

                         <!--combobx para seleccionar persona -->
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Confeccionado por:</label>
                                    <div class="col-md-9">
                                        <select v-model="idpersona" class="col-md-9" maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="persona in arrayPersona" :key="persona.id" :value="persona.id" v-text="persona.nombre"></option>
                                        </select>
                                    </div>
                        </div>
                          <br>

                        <!--combobx para seleccionar una caja al cual se guardara ese archivo entrante -->
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Numero de caja:</label>
                                    <div class="col-md-9">
                                       <select v-model="idcaja"  @change="obtenerUbicacionCaja" class="col-md-9"  maxlength="10" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="caja in arrayCaja" :key="caja.id" :value="caja.id" v-text="caja.diminutivo_caja"     ></option>
                                        </select>
                                    </div>
                        </div>
                          <br>

                        <!--combobx para seleccionar el tipo de documental de ese archivo -->
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Tipo documental:</label>
                                    <div class="col-md-9">
                                        <select  v-model="iddocumental" @change="selectNumExpediente" class="col-md-9"  maxlength="10" required> <!--  v-bind:disabled="bloquearCBX" enlazamos con la variable iddocumental declarada abajo en la propieda data-->
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="documental in arrayDocumental" :key="documental.id" :value="documental.id" v-text="documental.nombre_documental +'-'+ documental.codigo_diminutivo"></option>
                                        </select>
                                    </div>
                        </div>
                          <br>

                                  <!-- oculto para concatenarcelo al viejo numero de expediente en caso de que el archivo a registrar no lo traiga-->
                                <input type="hidden" v-model="codigo_diminutivo" class="form-control" > 
                    

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nuevo Numero Expediente:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="nuevo_num_expediente"  v-bind:disabled="bloquear" class="form-control"  placeholder=" cargando ... "  maxlength="10"  required> <!-- v-model es como los names-->
                            </div>
                        </div>
                          <br>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Actual Numero Expediente:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="viejo_num_expediente" class="form-control"  placeholder="escriba el actual numero de expediente aqui "  maxlength="20"  required> <!-- v-model es como los names-->
                            </div>
                        </div>
                          <br>
                          
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Contenido:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                 <textarea type="text" v-model="contenido" class="form-control"  placeholder="escriba el contenido aqui "  maxlength="256" cols="23" rows="2" style="resize: both;" required></textarea>  
                            </div>
                        </div>

                         <br>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha extrema:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="fecha_extrema" class="form-control"  placeholder="escriba la fecha extrema aqui "  maxlength="45" required> <!-- v-model es como los names-->
                            </div>
                        </div>
                    

                        

</div>



<div class="col-md-6">   


                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Anno:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="anno" class="form-control"  placeholder="escriba el ano aqui "  maxlength="45" required> <!-- v-model es como los names-->
                            </div>
                        </div>
                          <br>

                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Ubicacion:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="ubicacion"  v-bind:disabled="bloquear" class="form-control"  placeholder=" cargando ... "  maxlength="45" required> <!-- v-model es como los names-->
                            </div>
                        </div>
                          <br>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">descripcion:</label>
                            <div class="col-md-9">
                                                    <!-- readonly="readonly"  v-on:keyup="btnStatus"= id bloquea el input-->
                                <input type="text" v-model="descripcion" class="form-control"  placeholder="escriba la descripcion aqui "  maxlength="256"> <!-- v-model es como los names-->
                            </div>
                        </div>
                          <br>

                            
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Valor: </label>
                                    <div class="col-md-9">
                                        <select v-model="valor" class="col-md-9"  maxlength="20" required>
                                              <option value="0" disabled>Seleccione</option>
                                              <option value="1">Legal</option> 
                                              <option value="2">Cientifico Cultural</option>   
                                        </select>                                    
                                    </div>
                        </div>

                        <br>

                          
                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Vigencia: </label>
                                    <div class="col-md-9">
                                      <!--  <input type="number" v-model="vigencia" class="form-control"  min="1" max="30" maxlength="2" required>  value="25" step="5"   -->
                                        <select v-model="vigencia" class="col-md-9"  maxlength="2" required>
                                              <option value="0" disabled>Seleccione</option>
                                              <option value="1"> 1 año</option> 
                                              <option value="2"> 2 anos</option> 
                                              <option value="3"> 3 años</option>
                                              <option value="4"> 4 años</option>  
                                              <option value="5"> 5 años</option> 
                                              <option value="6"> 6 años</option>  
                                              <option value="7"> 7 años</option>  
                                              <option value="8"> 8 años</option>  
                                              <option value="9"> 9 años</option>   
                                              <option value="10">10 años</option> 
                                              <option value="11"> 11 años</option>   
                                              <option value="12"> 12 años</option>   
                                              <option value="13"> 13 años</option>   
                                              <option value="14"> 14 años</option>   
                                              <option value="15"> 15 años</option>   
                                              <option value="16"> 16 años</option>    
                                              <option value="17"> 17 años</option>  
                                              <option value="18"> 18 años</option>                                                                                
                                        </select>  
                                    </div>
                        </div>

                          <br>


                        <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">status: </label>
                                    <div class="col-md-9">
                                        <select v-model="estado" class="col-md-9" maxlength="10" required>
                                              <option value="0" disabled>Seleccione</option>
                                              <option value="1">Disponible</option> 
                                              <option value="2">Prestado</option>                                        
                                        </select>                                    
                                    </div>
                        </div>

                        <br>      

                        

                            <div v-show="errorArchivo" class="form-group row div-error"> <!-- si viene con un 1 la variable errorCodigo iteramos     row div-error = esta declarada en los estilos                    -->
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsjArchivo" :key="error" v-text="error"></div>
                                    </div>    
                                </div>




</div>




                    </form>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" @click = "limpiar()" v-bind:disabled="bloquearBtnLimpiar" >Limpiar</button>
                    <button type="button" class="btn btn-danger" @click = "cerrarModal()">Cerrar</button>
                    <button type="button" v-if = "tipoAccion==1" class="btn btn-success" @click = "registrarArchivo()">Guardar</button>
                    <button type="button" v-if = "tipoAccion==2" class="btn btn-success" @click = "actualizarArchivo()">Actualizar</button>
            
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
                archivo_id: 0,
                iddepartamento : 0,
                nombre_departamento: '',
                iddocumental : 0,
                nombre_documental: '',
                idpersona : 0,
                nombre: '',
                idcaja : 0,
                diminutivo_caja :'',  
                num_caja : '',      
                idusuario : 0, //no
                usuario: '', //no

                nuevo_num_expediente : '',  // estaba en cero
                viejo_num_expediente : '',

                contenido : '',
                fecha_extrema : '',
                anno: '',
                ubicacion: '',
                descripcion: '',
                valor: 0,
                vigencia: 0,
                estado : '',
                created_at : '',// no

                arrayArchivo : [],// enlista todos los archivo que vienen del metodo index del controlador
                modal : 0, // variable auxiliar para la funcion que abre el modal
                tituloModal : '', // variable auxiliar para darcela al titulo del modal dependiendo si va a entrar a registrar o actualizar
                tipoAccion : 0,
                    //variables para validar de que los datos no vallan nulos desde los campos de texto
                errorArchivo : 0,
                errorMostrarMsjArchivo : [],
                arrayDepartamento : [], // se almacenaran el lista de todos los departamentos para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectDepartamento del controlador departamento
                arrayDocumental : [], // se almacenaran el lista de todos los documentales para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectDocumental del controlador documental
                codigo_diminutivo : '',
                arrayPersona : [], // se almacenaran el lista de todos las personas para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectPersona del controlador persona
                arrayCaja : [], // se almacenaran el lista de todas las cajas para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectCajas del controlador cajas
               
                bloquear : '', // variable que servira para bloquear cualquier tipo de input cuando se abra el modal
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
        
        //metodo que enlista todos los archivos que vienen de bd
        listarArchivo (){
                let me=this;
               
               axios.get('/archivo').then(response => {
                    me.arrayArchivo = response.data;
                    this.mytable();

                })
                .catch(function (error) {
                    // en caso de error, mostrar en la consola del navegador
                    console.log(error);
                     me. msjError(); // en caso de que falle 
                });
        },
           
         // funcion que permite registrar los datos son enviados al archivoController exactamente a la funcion store
        registrarArchivo() {
                   
                    let me = this;
                        // validamos que hallan dejado espacios en blanco
                    if(this.validarArchivo()){
                            return; // si los hay se saldra y no registrara

                    }  

                         if(me.viejo_num_expediente == ''){

                                swal({
                                    title: '¿Esta seguro con dejar el numero de expediente vacio? El sistema asiganara el nuevo numero de expediente por defecto',
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

                                        axios.post('/archivo/registrar',{ //metodo store por medio de la ruta                        
                                                'iddepartamento': this.iddepartamento, 
                                                'iddocumental': this.iddocumental,
                                                'idpersona': this.idpersona,  
                                                'idcaja': this.idcaja, 
                                                'nuevo_num_expediente': this.nuevo_num_expediente, // recuerda que solo se envia el mero numero xq si no el sistema no va a poder autoincrementarlo
                                                'viejo_num_expediente': this.codigo_diminutivo +'-' +this.nuevo_num_expediente,// una vez seleccione el documental y el usuario dejo vacio el campo viejo_num_exp le concateno esto
                                                'contenido': this.contenido,
                                                'fecha_extrema': this.fecha_extrema,
                                                'anno': this.anno,
                                                'ubicacion': this.ubicacion,
                                                'descripcion': this.descripcion,
                                                'valor': this.valor,
                                                'vigencia': this.vigencia,
                                                'estado': this.estado

                                            }).then(function (response) {
                                                me.cerrarModal();
                                                me.msjRegistrar(); 
                                                //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                                                me.listarArchivo(); 
                                            }).catch(function (error) {
                                                // en caso de error mostrar en la consola del navegador
                                                console.log(error);
                                            });
                            
                                        //que no haga nada
                                    }else if(
                                    
                                        result.dismiss === swal.DismissReason.cancel
                                    ){
                                    
                                    }
                                    }) 

                         }else{

                                        
                                        axios.post('/archivo/registrar',{ //metodo store por medio de la ruta                        
                                                'iddepartamento': this.iddepartamento, 
                                                'iddocumental': this.iddocumental,
                                                'idpersona': this.idpersona,  
                                                'idcaja': this.idcaja, 
                                                'nuevo_num_expediente': this.nuevo_num_expediente, 
                                                'viejo_num_expediente': this.viejo_num_expediente,
                                                'contenido': this.contenido,
                                                'fecha_extrema': this.fecha_extrema,
                                                'anno': this.anno,
                                                'ubicacion': this.ubicacion,
                                                'descripcion': this.descripcion,
                                                'valor': this.valor,
                                                'vigencia': this.vigencia,
                                                'estado': this.estado

                                            }).then(function (response) {
                                                me.cerrarModal();
                                                me.msjRegistrar(); 
                                                //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                                                me.listarArchivo(); 
                                            }).catch(function (error) {
                                                // en caso de error mostrar en la consola del navegador
                                                console.log(error);
                                            });
                 

                        }

                     

        },

        msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Archivo registrado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },
        
        actualizarArchivo(){

                        let me= this;
     
                            // validamos que hallan dejado espacios en blanco
                        if(this.validarArchivo()){
                                return; // si los hay se saldra y no registrara
                        }  

                          
                        
                         if(me.viejo_num_expediente == ''){

                                swal({
                                    title: '¿Esta seguro con dejar el numero de expediente vacio? El sistema asiganara el nuevo numero de expediente por defecto',
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

                                                axios.put('/archivo/actualizar',{ //metodo update por medio de la ruta

                                                    'iddepartamento': this.iddepartamento, 
                                                    'iddocumental': this.iddocumental,
                                                    'idpersona': this.idpersona,  
                                                    'idcaja': this.idcaja, 
                                                    'nuevo_num_expediente': this.nuevo_num_expediente, 
                                                    'viejo_num_expediente': this.codigo_diminutivo +'-'+this.nuevo_num_expediente,
                                                    'contenido': this.contenido,
                                                    'fecha_extrema': this.fecha_extrema,
                                                    'anno': this.anno,
                                                    'ubicacion': this.ubicacion,
                                                    'descripcion': this.descripcion,
                                                    'valor': this.valor,
                                                    'vigencia': this.vigencia,
                                                    'estado': this.estado,

                                                    'id' : this.archivo_id // a diferencia del de registrar le enviamos el id que fue almacenado momentaneamente en esta variable

                                                }).then(function (response) {
                                                    me.cerrarModal();
                                                    me.msjActualizar();
                                                    //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                                                    me.listarArchivo();
                                                }).catch(function (error) {
                                                    // en caso de error mostrar en la consola del navegador
                                                    console.log(error);
                                                });

                            
                                        //que no haga nada
                                    }else if(
                                    
                                        result.dismiss === swal.DismissReason.cancel
                                    ){
                                    
                                    }
                                    }) 

                         }else{

                                      
                                                    axios.put('/archivo/actualizar',{ //metodo update por medio de la ruta

                                                        'iddepartamento': this.iddepartamento, 
                                                        'iddocumental': this.iddocumental,
                                                        'idpersona': this.idpersona,  
                                                        'idcaja': this.idcaja, 
                                                        'nuevo_num_expediente': this.nuevo_num_expediente, 
                                                        'viejo_num_expediente': this.viejo_num_expediente,
                                                        'contenido': this.contenido,
                                                        'fecha_extrema': this.fecha_extrema,
                                                        'anno': this.anno,
                                                        'ubicacion': this.ubicacion,
                                                        'descripcion': this.descripcion,
                                                        'valor': this.valor,
                                                        'vigencia': this.vigencia,
                                                        'estado': this.estado,

                                                        'id' : this.archivo_id // a diferencia del de registrar le enviamos el id que fue almacenado momentaneamente en esta variable

                                                    }).then(function (response) {
                                                        me.cerrarModal();
                                                        me.msjActualizar();
                                                        //referencia al metdo listar , cuando llegue a la primera pagina hara referencia
                                                        me.listarArchivo();
                                                    }).catch(function (error) {
                                                        // en caso de error mostrar en la consola del navegador
                                                        console.log(error);
                                                    });
                                        
                        }

        },

        msjActualizar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Archivo actualizado con exito',
            showConfirmButton: false,
            timer: 1500
            })

        },

           //metodo que elimina del todo un registro
        eliminarArchivo(id){
            swal({
                title: '¿Esta seguro de eliminar por completo este archivo?',
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

                    axios.put('/archivo/eliminar',{
                        'id': id // enviamos el parametro resivido en este metodo a la ruta /archivo/eliminar para que se lo envie al metodo del controlador eliminarArchivo
                    }).then(function (response) {
                        
                        // y volvemos a listar todos los registros
                        me.listarArchivo();
                        swal(
                        'Archivo Eliminado!',
                        'El registro ha sido eliminado por completo con éxito.',
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

        selectDepartamento(){
                // copiado de listarArchivo
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

        selectPersona(){
                // copiado de listarArchivo
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
  
        selectCaja(){  // METODO QUE SE EJECUTA CUANDO ENTRE AL MODAL A REGISTRAR Y ACTUALIZAR

              // copiado de listarArchivo
                let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                var url='/caja/seleccionarCajas';
                //tomado de github axios se lo envia al metodo seleccionasTodasCajas
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayCaja = respuesta.cajas; // paso todos los datos al arrayCaja

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });
        },

        selectCajaRegistrar(e){ // METODO QUE SE EJECUTA CUANDO ENTRE AL MODAL A REGISTRAR Y SELECCIONE UN DEPARTAMENTO

                var id = event.target.value, // obtengo el id de la vista
                value = event.target.textContent; 
                let me = this;

                var url='/caja/seleccionarCajasRegistrar?id=' + id;
                //tomado de github axios se lo envia al metodo seleccionasTodasCajas
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayCaja = respuesta.cajas; // paso todos los datos al arrayCaja

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });



        },
  
        obtenerUbicacionCaja(e){ // RESIVE COMO PARAMETRO EL ID DE CAJA SELECCIONADA EN EL CBX CAJA ESTO PARA TRAER LA UBICACION DE LA CAJA PARA DARSELA AL ARCHIVO DE UNA SOLA VEZ
              var id = event.target.value, // obtengo el id de la vista
              value = event.target.textContent; 
                    let me = this;
                    //console.log(id);
                     var array=[];
                     var url='/caja/obtenerUbicacionCaja?id=' + id; //mediante la url "ruta" le envio al metodo del controlador el id 
                    
                     axios.get(url)
                     .then(function (response) {
                     
                     var respuesta= response.data;                        
                     me.ubicacion = respuesta[0]['ubicacion']; // lo que trae de la BD se lo paso al campo UBICACION del archivo del modal 
                  
                     }).catch(function (error) {
                          // en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });

        },


        selectDocumental(){
                // copiado de listarArchivo
                let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                var url='/documental/seleccionarDocumentales';
                //tomado de github axios se lo envia al metodo seleccionarTodosDocumentales
                axios.get(url) // URL cuando abra que cargue todos los registros de la tabla 
                .then(function (response) {
               //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                var respuesta= response.data;           
                me.arrayDocumental  = respuesta.documentales; // paso todos los datos al arrayDocumental

                })
                .catch(function (error) {
                     // en caso de error mostrar en la consola del navegador
                    console.log(error);
                });

        },
         // funcion que trae el ultimo nuevo_nume_expediente guardado en la BD de un documental en especifico seleccionado
        selectNumExpediente(e){
                var id = event.target.value, // obtengo el id de la vista
                value = event.target.textContent; 
                let me = this;
                //console.log(id);

                      var url='/archivo/selectNumExpediente?id=' + id; // mediante la url "ruta" le envio el iddocumental para que me devuelva la respuesta 
                      axios.get(url)
                     .then(function (response) {
                        
                        //console.log(id);
                        var respuesta= response.data;
                        var aux_num_expediente;
                        if(respuesta == ""){ // en caso de que venga vacio y xq sera la primera vez que se registrara un documental de ese tipo por primera vez
                            
                            aux_num_expediente = 1; // le digo que empiece en 1
                            me.nuevo_num_expediente =  aux_num_expediente; // y se lo paso al campo nuevo_num_expediente del modal para que lo muestre

                        }else{ // si no pues es xq ya habian archivos registrados con ese tipo de documentales

                            aux_num_expediente = respuesta[0]['nuevo_num_expediente']; // en una variable auxiliar le paso el ultimo nuevo_num_expediente rehistrado de ese documental en especifico
                            aux_num_expediente ++; //para sumarle 1 
                            me.nuevo_num_expediente =  aux_num_expediente; // y se lo paso al campo nuevo_num_expediente del modal para que lo muestre con un 1 demas pues va a registrar uno nuevo para que no se repitan

                        }   
                                                            
                     }).catch(function (error) {
                         // en caso de error mostrar en la consola del navegador
                        console.log(error);
                    });



                     var url='/documental/selectCodigoDiminutivo?id=' + id; // mediante la url "ruta" le envio el iddocumental para que me devuelva la respuesta 
                      axios.get(url)
                     .then(function (response) {                       
                        //console.log(id);
                        var respuesta= response.data;
                     
                        if(respuesta != ""){                                                  
                            var respuesta= response.data;                        
                            me.codigo_diminutivo = respuesta[0]['codigo_diminutivo']; // lo que trae de la BD se lo paso al campo codigo diminutivo del archivo del modal 
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
                        
                        // y volvemos a listar todos los registros
                        me.listarArchivo();
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


        activarArchivo(id){ // id enviado por el boton
            swal({
                title: '¿Esta seguro con dejar en estado: Disponible este archivo?',
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
                        
                        // y volvemos a listar todos los registros
                        me.listarArchivo();
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
        
        validarArchivo(){

            // inicializamos de nuevo las variables
            this.errorArchivo=0;
            this.errorMostrarMsjArchivo = [];
           
            if(this.iddepartamento == 0 ) this.errorMostrarMsjArchivo.push("Seleccione un departamento");
            if(this.idpersona == 0 ) this.errorMostrarMsjArchivo.push("Seleccione una persona que confecciono el archivo");
            if(this.idcaja == 0 ) this.errorMostrarMsjArchivo.push("Seleccione una caja");
            if(this.iddocumental == 0 ) this.errorMostrarMsjArchivo.push("Seleccione un tipo de documental");
           // if(!this.viejo_num_expediente) this.errorMostrarMsjArchivo.push("Error,el actual numero de expediente es requerido");
            if(!this.ubicacion) this.errorMostrarMsjArchivo.push("Error,la ubicacion es requerida para este archivo");
            if(this.valor == 0) this.errorMostrarMsjArchivo.push("Error,seleccione el valor del archivo");
            if(this.vigencia == 0 ) this.errorMostrarMsjArchivo.push("Error,Seleccione la vigencia del archivo");
            if(this.estado == 0 ) this.errorMostrarMsjArchivo.push("Error,Seleccione un estado para este archivo"); 



            if(this.errorMostrarMsjArchivo.length) this.errorArchivo = 1; // si hay error que la variable errorArchivo pase a 1

            return this.errorArchivo; // la retornamos

        },
            // funcion que nos permite cerrar el modal 
        cerrarModal(){
            this.modal=0;
            this.iddepartamento=0;
            this.idpersona = 0;
            this.idcaja = 0;
            this.iddocumental = 0;  
            this.codigo_diminutivo = '';  
            this.nuevo_num_expediente = ''; // esta entero
            this.viejo_num_expediente = ''; 
            this.contenido = '';
            this.fecha_extrema = '';
            this.anno = '';
            this.ubicacion = '';
            this.descripcion = '';
            this.valor = 0;
            this.vigencia = 0;
            this.estado = '';    
           
            this.errorArchivo=0;
        },

        limpiar(){

            this.iddepartamento=0;
            this.idpersona = 0;
            this.idcaja = 0;
            this.iddocumental = 0; 
            this.codigo_diminutivo = '';   
            this.nuevo_num_expediente = ''; 
            this.viejo_num_expediente = ''; 
            this.contenido = '';
            this.fecha_extrema = '';
            this.anno = '';
            this.ubicacion = '';
            this.descripcion = '';
            this.valor = 0;
            this.vigencia = 0;
            this.estado = '';          
            this.errorArchivo=0;

        },

           // funcion que nos permite abrir el modal
        abrirModal(modelo, accion, data =[]){ // parametro modelo,accion, data trae todo los registros
                switch(modelo){
                    case "archivo": // en el caso que sea con el modelo archivo
                    {
                    switch(accion){
                        case 'registrar': // en el caso de que el modal sea para registar 
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Registrar Archivo' // encabezado del modal
                                this.tipoAccion = 1;
                                this.bloquearCBX =false; //se desbloqueara
                                this.bloquear = true; // se bloquearan ambos input diminutivo_caja y num_caja mediante la directiva  v-bind:disabled="bloquear"
                                this.bloquearBtnLimpiar = false; // se desbloqueara

                                this.iddepartamento = 0; // los objetos name del modal deben de inicializar vacios por que va a registrar 
                                this.idpersona = 0;
                                this.idcaja = 0;
                                this.iddocumental = 0;
                                this.codigo_diminutivo = '';  
                               // this.idusuario = 0;  
                                this.nuevo_num_expediente = ''; 
                                this.viejo_num_expediente = ''; 
                                this.contenido = '';
                                this.fecha_extrema = '';
                                this.anno = '';
                                this.ubicacion = '';
                                this.descripcion = '';
                                this.valor = 0;
                                this.vigencia = 0;    
                                this.estado = ''; 

                                
                               
                                break;
                            }
                        case 'actualizar': // en el caso de que sea para modificar
                            {
                               
                                this.modal = 1; // indica que se debe habilitar la vista modal
                                this.tituloModal ='Actualizar Archivo' // encabezado del modal
                                this.tipoAccion = 2;
                                this.bloquearCBX = true; // se bloqueara
                                this.bloquear = true; // se bloquearan ambos input diminutivo_caja y num_caja mediante la directiva  v-bind:disabled="bloquear"
                                this.bloquearBtnLimpiar = true; // se bloqueara

                              
                                this.archivo_id = data['id'] // aqui se almacenara momentaneamente el id a modificar 
                               
                               // cargara los datos a la vista
                                this.iddepartamento = data['iddepartamento']; 
                                this.idpersona = data['idpersona']; 
                                this.idcaja = data['idcaja'];      
                                this.iddocumental = data['iddocumental']; 
                                this.codigo_diminutivo = data['codigo_diminutivo'];                     
                               
                                this.nuevo_num_expediente = data['nuevo_num_expediente']; //se le indica que se va acceder exactamente a la propieda nuevo_num_expediente
                                this.viejo_num_expediente = data['viejo_num_expediente'];
                                this.contenido = data['contenido'];
                                this.fecha_extrema = data['fecha_extrema'];
                                this.anno = data['anno'];
                                this.ubicacion = data['ubicacion'];
                                this.descripcion = data['descripcion'];
                                this.valor = data['valor'];
                                this.vigencia = data['vigencia'];
                                this.estado = data['estado'];
                              
                                break;


                            }
                        }
                    }
                }
                this.selectCaja();
                this.selectDocumental();
                this.selectDepartamento(); // para llamar al metodo que carga el combobox de los departamento en esta vista de archivo por medio de la url
                this.selectPersona();
              
        },


        
        },

        mounted() {
            this.listarArchivo();
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








