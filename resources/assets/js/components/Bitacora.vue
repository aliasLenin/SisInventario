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
                        <i class="fa fa-align-justify"></i> Listado de Bitacora de movimientos
                    </div>
                    <div class="card-body">
                      <div class="panel-body table-responsive">
                      

                       <table id="example" class="table table-bordered table-striped table-sm table-condensed table-hover" >
                            <thead>
                                <tr>
                                  
                                    <th>Usuario</th>
                                    <th>Accion/Fecha</th>
                                    <th>Descripción</th>
                                    <th>Modulo</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                                  <tr v-for= "bitacora in arrayBitacora" :key = "bitacora.id">
                                   
                               
                                   <!-- y que valla cargando cada uno de los datos encontrados en la tabla-->
                                    <td v-text="bitacora.usuario"></td>  
                                    <td v-text="bitacora.accion"></td>          
                                    <td v-text="bitacora.descripcion"></td>
                                    <td v-text="bitacora.modulo"></td>
                        
                                      
                                    
                                </tr>
                              
                            </tbody>
                            
                            <thead>
                                <tr>
                              

                                    <th>Usuario</th>
                                    <th>Accion/Fecha</th>
                                    <th>Descripción</th>
                                    <th>Modulo</th>
                                   


                                </tr>
                            </thead>

                        </table>



                        
                      
                    </div>
                </div> <!-- Fin ejemplo de tabla Listado -->
              </div>   
            </div><!-- Fin ventana --> 




</main>
      
</template>

<script>

//exporto la clase del jtable para hacer uso de ella 
import datables from 'datatables'


export default {


    data(){
        return {
            
            bitacora_id : 0, // variable auxiliar que servira para almacenar momentaneamente cual es el id que quiero actualizar

            usuario :'', 
            accion :'',              
            descripcion : '',
            modulo : '',

            arrayBitacora : [] // array que optiene todos los objetos de la bd
           

        }
    },



 methods:{
           
        mytable(){
            $(function(){
                $('#example').DataTable();
            });
        },


        listarBitacora(){ 
                    let me= this;
                    axios.get('/bitacora').then(response => {
                        me.arrayBitacora = response.data;
                        this.mytable();
                    })
                    .catch(function (error) {
                        //en caso de error que lo muestre en la consola del navegador 
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
        },



        },

        
        mounted() {
           this.listarBitacora();
        }



}



</script>




<style>


/* SE PUEDE QUITAR PRIMERO PROBARLO ESO SI*/
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





