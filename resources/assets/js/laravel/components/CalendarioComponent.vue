<style>
       .row-tasks{
          color:black; 
       }
       .row-tasks:hover{
           background:#F5F5F5;
       }
   </style> 
<template>
    <div class="js-appear-enabled animated fadeIn" data-toggle="appear" style="z-index: 50000;">  
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Tareas</h3>
                <div class="block-options">
                    <div class="block-options-item js-appear-enabled">
                        <button class="btn btn-success" data-toggle="modal" data-target="#nuevaTareaModal">Nueva Tarea</button>
                        <button class="btn btn-info" data-toggle="modal" data-target="#filtroTareas"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="row" style="background:#FBFBFB; padding-top:10px; padding-bottom:10px; display:none">
                <label for="Filtrar"></label>
                <div class="col-md-4">
                    <select name="" id="">
                        <Option>Categoria</Option>
                    </select>
                </div> 
                <div class="col-md-4">
                    <select name="" id="">
                        <Option>Vendedor</Option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-sm btn-primary">Filtrar</button>
                </div>
            </div>
            <div class="block-content" style="height:513px; overflow:scroll;">
                <div id="calendar"></div>
                    
                </div>
            </div>
        </div>
</template>

<script>
import { EventBus } from '../eventBus.js';
    export default {
        data(){
            return{
                tarea: {
                    vendedor_id: '',
                },
                tareas: [],
                comentario: {
                    task_id: null,
                    comment: '',
                },
                comentarios: [],
                
            }
             
        },
        created(){
        this.calendarioFunciones();
           
        },
        filters: {
            formatearFecha2: function(data){
                moment.locale('es'); 
                let fecha = moment(data).format('MMMM Do YYYY');
                return fecha;
            },
        },
        methods: {

    calendarioFunciones: function(){
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    

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
            var TextButton = 'Tarea completa';
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

    calendar.render();
    

});
        }
                
        }
    }
</script>
