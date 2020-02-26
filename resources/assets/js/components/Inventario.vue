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
                                
                                  <br>

                                  <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Adjuntar:</label>
                                    <div class="col-md-5"> 
                                          <input type="file" name="file" @change="obtenerArchivo" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">

                                    </div>
                                  </div>


                                  <div v-show="errorInventario" class="form-group row div-error"> <!-- si viene con un 1 la variable errorDocumental iteramos             v-on:change="handleFileUpload()"    row div-error = esta declarada en los estilos                    -->
                                     <div class="text-center text-error" >
                                         <div v-for="error in errorMostrarMsjInventario" :key="error" v-text="error"></div>
                                     </div>    
                                  </div>

                    </form>
                </div>

                <div align="center" >

                     <button type="button" class="btn btn-info" @click ="limpiar()">Limpiar</button>
                   
                      <button type="button" class="btn btn-success" @click="registrar()" >Registrar</button>
                  
                  
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
//import VueSelect from 'vue-select';

export default {


    data(){
        return {

              
                file : null,
              
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

                errorInventario : 0,
                errorMostrarMsjInventario : []
            
        }
    },

    methods:{


    obtenerArchivo(event){
                //Asignamos la imagen a  nuestra data
                this.file = event.target.files[0];
    },



    registrar(){

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
                        
                                    axios.post('/inventario/importExcel',                              
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
                    text: 'ERROR, al registrar Inventario, Por favor asegurese que todas las cajas del inventario que decea trepar, se encuentren registradas en el modulo de cajas',
                })      
    },

    msjErrorPeso(){

             swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'ERROR, el archivo que usted acaba de intentar trepar excede el peso permitido, maximo de peso: 1 megabyte',
                })      
    },

  
            // este msj de sweetalert esta sirviendo pero aun no lo estoy utilizando
    msjErrorConexicion(){
            Swal.fire({
            title: 'ERROR DE CONEXION, por favor actualiza el sistema y revisa luego tus datos',
            animation: false,
            customClass: 'animated tada'
            })
    },

     
    validarExcel(){

            // inicializamos de nuevo las variables
            this.errorInventario=0;
            this.errorMostrarMsjInventario = [];

            //FALTA AUN VALIDAR EL INPU NO VALLA VACIO
           
            if(!this.file) this.errorMostrarMsjInventario.push("Seleccione otro Inventario");
               
            if(this.errorMostrarMsjInventario.length) this.errorInventario = 1; // si hay error que la variable errorArchivo pase a 1

            return this.errorInventario; // la retornamos

    },

    limpiar(){

            this.file = '';
            this.errorInventario=0;
    },


    },


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
















