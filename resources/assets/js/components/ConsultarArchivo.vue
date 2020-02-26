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
                        <i class="fa fa-align-justify"></i> Consultar Archivos 
                    </div>
                    <div class="card-body">
                      <div class="panel-body table-responsive">  
                      
   
                    <!-- Formulario --> 

                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            
                                    <!--combobx para seleccionar un archivo a buscar -->
                                    <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Buscar Archivos:</label>
                                            <div class="col-md-9">
                                                <select  v-model="idarchivo" class="form-control" >
                                                    <option value="0" disabled>Seleccione</option>
                                                    <option v-for="archivo in arrayArchivo" :key="archivo.id" :value="archivo.id" v-text="'Viejo #: '+archivo.viejo_num_expediente+'   Nuevo #: '+ archivo.nuevo_num_expediente +'   Estado:'+ archivo.estado      "></option>
                                                </select>


                                            </div>
                                    </div>


                                </form>
                          
                    </div>
                  </div>
                </div>  <!-- Fin ejemplo de tabla Listado -->              
            </div><!-- Fin ventana -->





</main>     
      
</template>




<script>


export default {


            data(){
                return {
                    
                    idarchivo : 0,                      
                    viejo_num_expediente :'',  
                    nuevo_num_expediente : '',           
                    estado : '',
                   
                    arrayArchivo : [], // se almacenaran el lista de todos los departamentos para mostrar en el combobox para ello se creo una funcion aca abajo para llamar al metodo selectDepartamento del controlador departamento
              
                    bloquearBtnLimpiar : ''
               }
            }, // final de la data

            methods : {


                selectArchivo(){
                            // copiado de listarCaja
                            let me= this; // declaramos una variable auxiliar "me" la cual sera para pasar todos esos datos o llamar metodos js aqui mismo
                            var url='/archivo/selectArchivo';
                            //tomado de github axios se lo envia al metodo selectDepartamento
                            axios.get(url) // URL cuando abra que cargue todos los registros de la tabla departamento
                            .then(function (response) {
                        //console.log(response) probe con la consola en el navegador para ver si devolvia los objetos
                            var respuesta= response.data;           
                            me.arrayArchivo = respuesta.archivos; // paso todos los datos al arrayDepartamento
                        

                            })
                            .catch(function (error) {
                                // en caso de error mostrar en la consola del navegador
                                console.log(error);
                            });

                    },


            },

            mounted() {
            this.selectArchivo();
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










