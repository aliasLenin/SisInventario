
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery'); 

window.Vue = require('vue');
import Vue from 'vue';
//import vSelect from 'vue-select';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




Vue.component('archivo', require('./components/Archivo.vue')); // hace referencia al archivo o componente Archivo.vue que contiene la vista del centro

Vue.component('consultararchivo', require('./components/ConsultarArchivo.vue')); // hace referencia al archivo o componente Departamento.vue que contiene la vista del centro

//Vue.component('departamento',-> es el nombre que se le va a poner en el archivo contenido.blade.php para llamar al templade
Vue.component('departamento', require('./components/Departamento.vue')); // hace referencia al archivo o componente Departamento.vue que contiene la vista del centro

Vue.component('caja', require('./components/Caja.vue')); // hace referencia al archivo o componente Caja.vue que contiene la vista del centro

Vue.component('documental', require('./components/Documental.vue')); // hace referencia al archivo o componente Documental.vue que contiene la vista del centro

Vue.component('persona', require('./components/Persona.vue')); // hace referencia al archivo o componente Persona.vue que contiene la vista del centro

Vue.component('user', require('./components/User.vue')); // hace referencia al archivo o componente User.vue que contiene la vista del centro

Vue.component('rol', require('./components/Rol.vue')); // hace referencia al archivo o componente Rol.vue que contiene la vista del centro

Vue.component('bitacora', require('./components/Bitacora.vue')); // hace referencia al archivo o componente Bitacora.vue que contiene la vista del centro

//Vue.component('excel', require('./components/Excel.vue')); // hace referencia al archivo o componente InventarioExcel.vue que contiene la vista del centro

Vue.component('inventario', require('./components/Inventario.vue'));

Vue.component('boleta', require('./components/Boleta.vue')); // hace referencia al archivo o componente Boleta.vue que contiene la vista de donde se estaran prestando y devolviendo las boletas

Vue.component('escritorio', require('./components/Escritorio.vue')); // hace referencia al archivo o componente Escritorio.vue que contiene la vista de los graficos estadisticos

Vue.component('escritoriofuncionario', require('./components/EscritorioFuncionario.vue')); // hace referencia al archivo o componente Escritorio.vue que contiene la vista de los graficos estadisticos

Vue.component('notification', require('./components/Notification.vue')); // hace referencia al archivo o componente Escritorio.vue que contiene la vista de los graficos estadisticos

//Vue.component('v-select', vSelect);

const app = new Vue({
    el: '#app',

    data :{
        menu : 0,
        notifications: []
    },
    created() {
        let me = this;     
        axios.post('notification/get').then(function(response) {
           //console.log(response.data);
           me.notifications=response.data;    
        }).catch(function(error) {
            console.log(error);
        });

        // creamos el canal del lado del cliente
        var userId = $('meta[name="userId"]').attr('content');// almacena el id del usuario atravez de la etiqueta meta
        
        //escucha los eventos de tranmicion
        Echo.private('App.User.' + userId).notification((notification) => {
              //console.log(notification);
              me.notifications.unshift(notification); // cada vez que cree una nueva boleta que escanee si hay archivos vencidos
            //unshift metodo que agrega al inicio del arreglo
            }); 
        
    }        




});
