/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueFuse from 'vue-fuse';
import { Calendar, WindowScrollController } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';
import Vuelidate from 'vuelidate';
import VueCurrencyFilter from 'vue-currency-filter'
Vue.use(VueCurrencyFilter, {
    symbol: '$', // El símbolo, por ejemplo €
    thousandsSeparator: ',', // Separador de miles
    fractionCount: 2, // ¿Cuántos decimales mostrar?
    fractionSeparator: '.', // Separador de decimales
    symbolPosition: 'front', // Posición del símbolo. Puede ser al inicio ('front') o al final ('') es decir, si queremos que sea al final, en lugar de front ponemos una cadena vacía ''
    symbolSpacing: true // Indica si debe poner un espacio entre el símbolo y la cantidad
})

Vue.use(VueFuse);
Vue.config.devtools = true
Vue.config.debug = true
Vue.config.silent = true

import store from './store'
Vue.use(Vuelidate);

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
Vue.component('crear-contrato-component', require('./components/CrearContratoComponent.vue').default);
Vue.component('settings-master-component', require('./components/SettingsMasterComponent.vue').default);
Vue.component('editar-presupuesto-component', require('./components/EditarPresupuestoComponent.vue').default);
Vue.component('ver-presupuesto-component', require('./components/VerPresupuestoComponent.vue').default);
Vue.component('calendario-component', require('./components/CalendarioComponent.vue').default);
Vue.component('caja-component', require('./components/CajaComponent.vue').default);
Vue.component('contabilidad-component', require('./components/ContabilidadComponent.vue').default);
Vue.component('altas-component', require('./components/AltasComponent.vue').default);
Vue.component('editar-paquete-component', require('./components/EditarPaqueteComponent.vue').default);
Vue.component('productos-danados-component', require('./components/DanadosComponent.vue').default);
Vue.component('proveedores-component', require('./components/ProveedoresComponent.vue').default);
Vue.component('editar-proveedor-component', require('./components/EditarProveedorComponent.vue').default);
Vue.component('nested-component', require('./components/NestedComponent.vue').default);
Vue.component('bocadillos-component', require('./components/BocadillosComponent.vue').default);
Vue.component('gasolina-component', require('./components/GasolinaComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var EventBus = new Vue;
const app = new Vue({
    el: '#app',
    store,
    methods: {
        obtenerPresupuestos: function(id) {
            alert(id);
        }
    },

});

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendarAl = document.getElementById('calendar2');
    var calendarBl = document.getElementById('calendar3');
    var calendarCl = document.getElementById('calendar4');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        locales: [esLocale],
        locale: 'es', // the initial locale. of not specified, uses the first one

        eventMouseEnter: function(info) {

        },

        eventClick: function(info) {
            detalleTarea(info);
        }
    });

    var calendar2 = new Calendar(calendarAl, {
        plugins: [dayGridPlugin],
        locales: [esLocale],
        locale: 'es', // the initial locale. of not specified, uses the first one

        eventClick: function(info) {
            detalleTarea(info);
        }
    });

    var calendar3 = new Calendar(calendarBl, {
        plugins: [dayGridPlugin],
        locales: [esLocale],
        locale: 'es', // the initial locale. of not specified, uses the first one

        eventClick: function(info) {
            detalleTarea(info);
        }
    });

    var calendar4 = new Calendar(calendarCl, {
        plugins: [dayGridPlugin],
        locales: [esLocale],
        locale: 'es', // the initial locale. of not specified, uses the first one

        eventClick: function(info) {
            detalleTarea(info);
        }
    });

    function detalleTarea(task) {
        if (task.event.groupId == 2) {
            var TextButton = 'Ver ficha de evento';
            Swal.fire({
                title: task.event.title,

                html: "<b>" + task.event.extendedProps.servicio + "</b> <br> Notas: " + task.event.extendedProps.notasPresupuesto + "<br> Horario: " + task.event.extendedProps.horario,
                type: 'info',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: TextButton,
                cancelButtonText: 'Cerrar'

            }).then((result) => {
                if (result.value) {
                    if (task.event.groupId == 1) {
                        var url = '/tareas/eliminar-tarea/' + task.event.id;
                        axios.delete(url).then(response => {
                            //this.obtenerTareas();
                            location.reload();
                        })
                    } else {
                        let URL = 'presupuestos/ver/' + task.event.id;
                        window.location.href = URL;
                    }
                    //  console.log(task);

                }

            })
        } else {
            var TextButton = 'Marcar como vista';
            Swal.fire({
                title: task.event.title,

                html: 'Cliente: ' + task.event.extendedProps.cliente + '<br>Detalles: ' + task.event.extendedProps.notas,
                type: 'info',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: TextButton,
                cancelButtonText: 'Cerrar'

            }).then((result) => {
                if (result.value) {
                    if (task.event.groupId == 1) {
                        var url = '/tareas/eliminar-tarea/' + task.event.id;
                        axios.delete(url).then(response => {
                            //this.obtenerTareas();
                            location.reload();
                        })
                    } else {
                        let URL = 'presupuestos/ver/' + task.event.id;
                        window.location.href = URL;
                    }
                    //  console.log(task);

                }

            })
        }

    }


    calendar.batchRendering(function() {

        //Obtenemos todas las tareas
        let URL = '/tareas/obtener-tareas-todas';
        axios.get(URL).then((response) => {
            var tareas = response.data;

            //Imprimimos las tareas recuperadas en el calendario
            tareas.forEach((element) => {
                calendar.changeView('dayGridMonth');
                calendar.addEvent({
                    id: element.id,
                    groupId: 1,
                    title: element.categoria,
                    start: element.fecha,
                    color: '#F2E06E',
                    extendedProps: {
                        tipo: 'tarea',
                        notas: element.notas,
                        cliente: element.cliente
                    },
                });
            });
        });

        let URL2 = '/contratos/obtener-contratos-todos';
        axios.get(URL2).then((response) => {
            var contratos = response.data;

            //Imprimimos los contratos recuperadas en el calendario
            contratos.forEach((element) => {
                calendar.changeView('dayGridMonth');
                calendar.addEvent({
                    id: element.id,
                    groupId: 2,
                    title: element.folio + " - " + element.cliente,
                    start: element.fechaEvento,
                    color: '#91DFEB',
                    extendedProps: {
                        tipo: 'evento',
                        notas: element.cliente,
                        servicio: element.servicio,
                        notasPresupuesto: element.notasPresupuesto,
                        horario: element.horaEventoInicio + "-" + element.horaEventoFin,
                    },
                });
            });
        });

        let URL3 = '/contratos/obtener-presupuestos-todos';
        axios.get(URL3).then((response) => {
            var presupuestos = response.data;

            //Imprimimos los contratos recuperadas en el calendario
            presupuestos.forEach((element) => {
                calendar.changeView('dayGridMonth');
                calendar.addEvent({
                    id: element.id,
                    groupId: 2,
                    title: element.folio + " - " + element.cliente,
                    start: element.fechaEvento,
                    color: '#ECABF9',
                    extendedProps: {
                        tipo: 'evento',
                        notas: element.cliente,
                        servicio: element.servicio,
                        notasPresupuesto: element.notasPresupuesto,
                        horario: element.horaEventoInicio + "-" + element.horaEventoFin,
                    },
                });
            });
        });

    });

    calendar2.batchRendering(function() {

        //Obtenemos todas las tareas
        let URL = '/tareas/obtener-tareas-todas';
        axios.get(URL).then((response) => {
            var tareas = response.data;

            //Imprimimos las tareas recuperadas en el calendario
            tareas.forEach((element) => {
                calendar2.changeView('dayGridMonth');
                calendar2.addEvent({
                    id: element.id,
                    groupId: 1,
                    title: element.categoria,
                    start: element.fecha,
                    color: '#F2E06E',
                    extendedProps: {
                        tipo: 'tarea',
                        notas: element.notas,
                        cliente: element.cliente
                    },
                });
            });
        });

    });
    calendar3.batchRendering(function() {

        //Obtenemos todos los presupuestos
        let URL3 = '/contratos/obtener-presupuestos-todos';
        axios.get(URL3).then((response) => {
            var presupuestos = response.data;

            //Imprimimos los contratos recuperadas en el calendario
            presupuestos.forEach((element) => {
                calendar3.changeView('dayGridMonth');
                calendar3.addEvent({
                    id: element.id,
                    groupId: 2,
                    title: element.folio + " - " + element.cliente,
                    start: element.fechaEvento,
                    color: '#ECABF9',
                    extendedProps: {
                        tipo: 'evento',
                        notas: element.cliente,
                        servicio: element.servicio,
                        notasPresupuesto: element.notasPresupuesto,
                        horario: element.horaEventoInicio + "-" + element.horaEventoFin,
                    },
                });
            });
        });

    });

    calendar4.batchRendering(function() {

        //Obtenemos todos los contratos
        let URL2 = '/contratos/obtener-contratos-todos';
        axios.get(URL2).then((response) => {
            var contratos = response.data;

            //Imprimimos los contratos recuperadas en el calendario
            contratos.forEach((element) => {
                calendar4.changeView('dayGridMonth');
                calendar4.addEvent({
                    id: element.id,
                    groupId: 2,
                    title: element.folio + " - " + element.cliente,
                    start: element.fechaEvento,
                    color: '#91DFEB',
                    extendedProps: {
                        tipo: 'evento',
                        notas: element.cliente,
                        servicio: element.servicio,
                        notasPresupuesto: element.notasPresupuesto,
                        horario: element.horaEventoInicio + "-" + element.horaEventoFin,
                    },
                });
            });
        });

    });


    calendar.render();
    calendar2.render();
    calendar3.render();
    calendar4.render();


});