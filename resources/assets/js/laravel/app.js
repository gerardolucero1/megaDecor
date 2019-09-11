
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
import StoreData from './store';
import VueFuse from 'vue-fuse';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';

Vue.use(VueFuse);

Vue.use(Vuex);

const store = new Vuex.Store(StoreData);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('nuevo-cliente-component', require('./components/NuevoClienteComponent.vue').default);
Vue.component('editar-cliente-component', require('./components/EditarClienteComponent.vue').default);
Vue.component('nueva-tarea-component', require('./components/NuevaTareaComponent.vue').default);
Vue.component('categoria-tarea-component', require('./components/CategoriasTareas.vue').default);
Vue.component('categoria-evento-component', require('./components/CategoriasEvento.vue').default);
Vue.component('task-list-component', require('./components/TaskListComponent.vue').default);
Vue.component('tipo-empresa-component', require('./components/TipoEmpresaComponent.vue').default);
Vue.component('como-supo-component', require('./components/ComoSupoComponent.vue').default);
Vue.component('crear-presupuesto-component', require('./components/CrearPresupuestoComponent.vue').default);
Vue.component('settings-master-component', require('./components/SettingsMasterComponent.vue').default);
Vue.component('editar-presupuesto-component', require('./components/EditarPresupuestoComponent.vue').default);
Vue.component('ver-presupuesto-component', require('./components/VerPresupuestoComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var EventBus = new Vue;
const app = new Vue({
    el: '#app',
    store,
    
});


document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');

var calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin ],
    locales: [ esLocale],
  locale: 'es', // the initial locale. of not specified, uses the first one

  eventClick: function(info) {
    //alert('Event: ' + info.event.title);
    //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
    //alert('View: ' + info.view.type);

    // change the border color just for fun
    //info.el.style.borderColor = 'orange';

    detalleTarea(info);
  } 
});

function detalleTarea(task){
    if(task.event.groupId==2){
        var TextButton='Ver ficha de evento';
    }else{
        var TextButton='Tarea completa';
    }
Swal.fire({
                title: task.event.title,
                text: "Detalles: "+task.event.extendedProps.notas,
                type: 'info',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: TextButton,
                cancelButtonText: 'Cerrar'
                
            }).then((result) => {
            if (result.value) {
                if(task.event.groupId==1){
                    var url= '/tareas/eliminar-tarea/'+task.event.id;
                axios.delete(url).then(response =>{
                    //this.obtenerTareas();
                    location.reload();
                    }) 
                }else{
                    alert('detalles de evento');
                }
              //  console.log(task);
                
                }
          
})
}


calendar.batchRendering(function() {
    
    //Obtenemos todas las tareas
        let URL = '/tareas/obtener-tareas-todas';
        axios.get(URL).then((response) => {
        var tareas = response.data;

    //Imprimimos las tareas recuperadas en el calendario
            tareas.forEach((element) => {
            calendar.changeView('dayGridMonth');
            calendar.addEvent({id: element.id, groupId: 1, title: element.categoria, start: element.fecha, color: '#65BAF1', extendedProps: {
                notas: element.notas
              }, });  
          });  
    });

    let URL2 = '/contratos/obtener-contratos-todos';
    axios.get(URL2).then((response) => {
        var contratos = response.data;
        
    //Imprimimos los contratos recuperadas en el calendario
        contratos.forEach((element) => {
            calendar.changeView('dayGridMonth');
            calendar.addEvent({id: element.id, groupId: 2, title: element.folio, start: element.fechaEvento, color: '#F0833C', extendedProps: {
                notas: element.cliente
              }, });  
          }); 
    });
    
  });


calendar.render();

});




 

