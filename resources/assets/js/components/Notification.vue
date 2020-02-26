<template>

           <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>
                    <!-- aqui va el largo de la notificacion-->
                    <span class="badge badge-pill badge-danger">{{notifications.length}}</span><!--   si pongo  {{notifications.length}} por cada boleta insertada aumentara la notificacion por eso se dejo -->
                </a>

                <div class="dropdown-menu dropdown-menu-right">


                    <div class="dropdown-header text-center">
                          <strong>Notificador de Archivos Expirados</strong>
                    </div>
            
            <!-- si existen notificacion las voy a mostrar-->
                    <div v-if="notifications.length">
                        <li v-for="item in listar" :key="item.id">
                                <a class="dropdown-item" href="#">
                                    <!--{{JSON.parse(item.data) }}        {{JSON.parse(item.data).datos.archivos.msj}}           para ver la cadena -->
                                    <i class="fa fa-tasks"></i> {{item.archivos.msj}}
                                    <span class="badge badge-danger">{{item.archivos.numero}}</span>
                                </a>
                        </li>
                    </div>

                      <!-- si no existen notificacion voy a mostrar el msj que dica bandeja vacia-->
                    <div v-else>
                           <a><span>No tiene notificaciones</span></a> 
                   </div>


                   
                </div>
            </li>

</template>

<script>
export default {     
	props : ['notifications'],
    data (){         
        return {
            arrayNotifications:[]
        } 
    },

    computed:{
        listar: function()  {
            //return this.notifications[0];
             this.arrayNotifications = Object.values(this.notifications[0]);
             if (this.notifications == '') {
                    return this.arrayNotifications = []; 
            } else {

                //Capturo la ultima notificación agregada 
                this.arrayNotifications = Object.values(this.notifications[0]); 
                //Validación por indice fuera de rango
                if (this.arrayNotifications.length > 3) { 
                    //Si el tamaño es > 3 Es cuando las notificaciones son obtenidas desde el mismo servidor, es decir por la consulta con AXIOS 
                    return Object.values(this.arrayNotifications[4]); 
                } else { 
                    //Si el tamaño es < 3 Es cuando las notificaciones son obtenidas desde el canal privado, es decir mediante Laravel Echo y Pusher 
                    return Object.values(this.arrayNotifications[0]);
                } 
            
            
            }
        }
    }



}

</script>







