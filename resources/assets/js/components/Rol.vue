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
                        <i class="fa fa-align-justify"></i> Listado De Roles
                    </div>
                    <div class="card-body">
                       <div class="panel-body table-responsive">
                       
                       
                        <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover" >
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Condicion</th>
                                    
                                </tr>
                            </thead>


                            <tbody>
                                <tr v-for= "rol in arrayRol" :key = "rol.id">
                                      <!-- y que valla cargando cada uno de los datos encontrados en la tabla-->
                                    <td v-text="rol.nombre"></td>
                                    <td v-text="rol.descripcion"></td>
                                    <td>
                                        <div v-if="rol.condicion">
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
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Condicion</th>
                                    
                                </tr>
                            </thead>


                        </table>
                      </div>
                    </div>
                </div>  <!-- Fin ejemplo de tabla Listado -->           
             </div><!-- Fin ventana -->
        </main>
</template>



<script>


        
    //exporto la clase del jtable para hacer uso de ella 
    import datables from 'datatables'


    export default {

        data (){
            return {
                rol_id: 0,
                nombre : '',
                descripcion : '',
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0
            }
        },
       
        methods : {
           
        mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },
        
        //metodo que enlista todos los roles que viene de bd
        listarRol (){
                let me=this;
               
               axios.get('/rol').then(response => {
                    me.arrayRol = response.data;
                    this.mytable();

                })
                .catch(function (error) {
                    // en caso de error, mostrar en la consola del navegador
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
        }
          




        },
      
      
        mounted() {
            this.listarRol();
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
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>


























