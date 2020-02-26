<template>
    

<main class="main">
            <!-- Breadcrumb  -->
            <ol class="breadcrumb">            
                <li class="breadcrumb-item"><a href="/">Inicio Principal</a></li> <!--  href="/" con hacemos referencia a la raiz de todas las vista--> 
            </ol>
            <div class="container-fluid"><!-- comienzo ventana -->
               <div class="card">
                        <div class="card-header">
                           
                        </div>
                        <div class="car-body">
                           <div class="row">



                              <div class="col-md-6">
                                    <div class="card card-chart">

                                       <div class="card-header">
                                          <h4>Ingresos Archivos</h4>
                                       </div>

                                       <div class="card-content">
                                          <div class="ct-chart">
                                                <canvas id="archivos">                                                
                                                </canvas>
                                          </div>
                                       </div>

                                       <div class="card-footer">
                                          <p>Ingresos de los últimos meses.</p>
                                       </div>

                                    </div>
                              </div>



                              <div class="col-md-6">
                                    <div class="card card-chart">
                                       
                                       <div class="card-header">
                                          <h4>Salida de archivos</h4>
                                       </div>

                                       <div class="card-content">
                                          <div class="ct-chart">
                                                <canvas id="detalles">                                                
                                                </canvas>
                                          </div>
                                       </div>

                                       <div class="card-footer">
                                          <p>Salidas de los últimos meses.</p>
                                       </div>

                                       
                                    </div>
                              </div>




                           </div>
                        </div>

                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>


                  </div>
            </div><!-- Fin ventana -->


</main>     
      
</template>


<script>

export default {
 props : ['ruta'],
 data (){
            return {
                varArchivo:null, // valor del id donde vamos a mostrar el grafico
                charArchivo:null, // crea el grafico
                archivos:[], // array que contendra el listado de ingresos con la informacion necesaria
                varTotalArchivo:[],// almacenara el total de los archivos ingresados de cada mes
                varMesArchivo:[], // almacenara los nombres de los meses que se van a ir mostrando conforme valla pasando el tiempo
                
                varDetalle:null,
                charDetalle:null,
                detalles:[],
                varTotalDetalle:[],
                varMesDetalle:[],
            }
        },

   methods : {
            getArchivos(){
                let me=this;
                 var url='http://localhost:8000/main';
                 var url='/escritorio';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.archivos = respuesta.archivos; // almacena los resultados en el array 
                    //cargamos los datos del chart
                    me.loadArchivos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            loadArchivos(){
                let me=this;
                let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; 
                me.archivos.map(function(x){
                    me.varMesArchivo.push(meses[x.mes-1]);
                    me.varTotalArchivo.push(x.total);
                });
                me.varArchivo=document.getElementById('archivos').getContext('2d');

                me.charArchivo = new Chart(me.varArchivo, {
                    type: 'bar',
                    data: {
                        labels: me.varMesArchivo,
                        datasets: [{
                            label: 'Cantidad',
                            data: me.varTotalArchivo,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },


// SE HACE EL GRAFICO CON LA TABLA DETALLES DE BOLETA POR QUE ALLI ES DONDE SE VA ALMACENADO LA VERDADERA CANTIDAD DE ARCHIVOS QUE VAN SALIENDO DEL
//DEPARTAMENTO
             getDetalles(){
                let me=this;
                 var url='http://localhost:8000/main';
                 var url='/escritorio';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.detalles = respuesta.detalles; // almacena los resultados en el array 
                    //cargamos los datos del chart
                    me.loadDetalles();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


             loadDetalles(){
                let me=this;
                let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; 
                me.detalles.map(function(x){
                    me.varMesDetalle.push(meses[x.mes-1]);
                    me.varTotalDetalle.push(x.total);
                });
                me.varDetalle=document.getElementById('detalles').getContext('2d'); // el id del camvas de la vista

                me.charDetalle = new Chart(me.varDetalle, {
                    type: 'bar',
                    data: {
                        labels: me.varMesDetalle,
                        datasets: [{
                            label: 'Cantidad',
                            data: me.varTotalDetalle,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },







   },

   mounted() {
        
            this.getArchivos();
            this.getDetalles();
        }



}


</script>




