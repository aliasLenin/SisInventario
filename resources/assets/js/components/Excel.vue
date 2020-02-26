<template>

 <main class="main">
            <!-- Breadcrumb -->
           <!-- Breadcrumb  -->
            <ol class="breadcrumb">            
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li> <!--  href="/" con hacemos referencia a la raiz de todas las vista--> 
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> MODULO INVENTARIO:
                    </div>

                     <div class="card-body">
                        
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                     

                     <!--
                                <div class="form-group row">
                              
                                    <label class="col-md-2 form-control-label" for="text-input">Dependencia que envia: </label>  
                                     <div class="col-md-5">                                 
                                         <select  v-model="iddepartamento" class="form-control" required>
                                                    <option value="0" disabled>Seleccione</option>
                                                    <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre_departamento"></option>
                                         </select>
                                       </div>
                                </div>

                                  <br>

                                <div class="form-group row">
                              
                                    <label class="col-md-2 form-control-label" for="text-input">Confeccionado por:</label>
                                       <div class="col-md-5">   
                                        <select v-model="idpersona" class="form-control" required>
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="persona in arrayPersona" :key="persona.id" :value="persona.id" v-text="persona.nombre +' '+ persona.apellido"></option>
                                        </select>
                                      </div>
                                </div>
                                -->

                                  <br>

                                  <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Adjuntar:</label>
                                    <div class="col-md-5"> 
                                          <input type="file" name="file" @change="obtenerArchivo2" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">

                                    </div>
                                  </div>


                                  <div v-show="errorExcel" class="form-group row div-error"> <!-- si viene con un 1 la variable errorDocumental iteramos             v-on:change="handleFileUpload()"    row div-error = esta declarada en los estilos                    -->
                                     <div class="text-center text-error" >
                                         <div v-for="error in errorMostrarMsjExcel" :key="error" v-text="error"></div>
                                     </div>    
                                  </div>

                    </form>
                </div>

                <div align="center" >

                     <button type="button" class="btn btn-info" @click ="limpiar()">Limpiar</button>
                   
                      <button type="button" class="btn btn-success" @click="registrar2()" >Registrar</button>
                  
                  
                </div>

                 <br>
                  <br>
                   <br>
                    <br>
                     <br>
                      <br>
                       <br>
                        <br>
                
                    </div>       
                 </div>



             
</main>

</template>


<script>

import Vue from 'vue';
import VueSelect from 'vue-select';

export default {


    data(){
        return {

              
                file : null,
                aux_file : '',

                iddepartamento : 0,
                nombre_departamento: '',
                iddocumental : 0,
                nombre_documental: '',
                idpersona : 0,
                nombre: '',
                apellido: '',
                idcaja : 0,
                diminutivo_caja :'',  
                num_caja : '',      
               

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

                arrayPersona: [],
                arrayDepartamento: [],

                errorExcel : 0,
                errorMostrarMsjExcel : [],

                 modal : 0, // variable auxiliar para la funcion que abre el modal
                 tituloModal : '', // variable auxiliar para darcela al titulo del modal dependiendo si va a entrar a registrar o actualizar
                 tipoAccion : 0
            
        }
    },

    methods:{


    obtenerArchivo2(event){
                //Asignamos la imagen a  nuestra data
                this.file = event.target.files[0];
    },



    registrar2(){

          let me = this;

                // validamos que hallan dejado espacios en blanco
                        if(this.validarExcel()){
                                return; // si los hay se saldra y no registrara
                        } 
                        
                         if(me. validarPesoExcel() == false){ 

                               me.msjErrorPeso();

                         }else{

                                    
                            var data = new  FormData();
                            data.append('file', this.file);
                        
                                    axios.post('/archivo/importExcel',                              
                                    data       
                                                        
                                    ).then(function (response) {
                                        console.log(response.data);
                                        me. msjRegistrarExcel();
                                        me. limpiar();
                                    })
                                    .catch(function(){
                                        me.msjErrorRegistrarExcel();
                                    console.log('FAILURE!!');
                                    });

                         }
                       

    },

    validarPesoExcel() {
        
        const isLt1M = this.file.size / 1024 / 1024 < 1

        if (isLt1M) {

        return true

        }else{
            
        return false

        }

    },



    msjRegistrarExcel(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Inventario registrado con exito',
            showConfirmButton: false,
            timer: 1500
            })

    },

    msjErrorRegistrarExcel(){

             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'ERROR, al registrar Inventario',
                })      
    },

    msjErrorPeso(){

             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'ERROR, el archivo que usted acaba de intentar trepar excede el peso permitido, maximo de peso: 1 megabyte',
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

            // este msj de sweetalert esta sirviendo pero aun no lo estoy utilizando
    msjErrorConexicion(){
            Swal.fire({
            title: 'ERROR DE CONEXION, por favor actualiza el sistema y revisa luego tus datos',
            animation: false,
            customClass: 'animated tada'
            })
    },


    msjRegistrar(){

            Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Archivo de excel registrado con exito',
            showConfirmButton: false,
            timer: 1500
            })

    },

    
    msjErrorDocumental(){
            Swal.fire({
            title: 'ERROR, el documental no existe',
            animation: false,
            customClass: 'animated tada'
            })
    },


    msjErrorCaja(){
            Swal.fire({
            title: 'ERROR, la caja no existe',
            animation: false,
            customClass: 'animated tada'
            })
    },

     
    validarExcel(){

            // inicializamos de nuevo las variables
            this.errorExcel=0;
            this.errorMostrarMsjExcel = [];

            //FALTA AUN VALIDAR EL INPU NO VALLA VACIO
           
            if(!this.file) this.errorMostrarMsjExcel.push("Seleccione otro Inventario");
            //if(this.iddepartamento == 0 ) this.errorMostrarMsjExcel.push("Seleccione un departamento");
            //if(this.idpersona == 0 ) this.errorMostrarMsjExcel.push("Seleccione una persona que confecciono el archivo");
        
            if(this.errorMostrarMsjExcel.length) this.errorExcel = 1; // si hay error que la variable errorArchivo pase a 1

            return this.errorExcel; // la retornamos

    },

    limpiar(){

            this.iddepartamento=0;
            this.idpersona = 0;
            this.file = '';
            this.errorExcel=0;
    },


    },

     mounted(){

        this.selectDepartamento(); // para llamar al metodo que carga el combobox de los departamento en esta vista de caja por medio de la url
        this.selectPersona();

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
















