<style>
       .row-tasks{
          color:black; 
       }
       .row-tasks:hover{
           background:#F5F5F5;
       }
   </style> 
<template>
        <div class="js-appear-enabled animated fadeIn" data-toggle="appear">
                              
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
                                <div class="block-content" style="height:350px; overflow:scroll;">
                                       
                                        <div v-if="tareas == 0">No hay Tareas para hoy</div>
                                       
                                    <table id="example"  class="table table-vcenter">
                                        <thead>
                                            <tr style="font-size:11px">
                                                <th>Cliente</th>
                                                <th>Vendedor</th>
                                                <th class="d-none d-sm-table-cell" style="width: 15%;">Categoría</th>
                                                <th class="text-center" style="width: 100px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                                <tr style="font-size:11px" class="row-tasks" v-for="tarea in tareas" v-bind:key="tarea.index">
                                                <td>{{ tarea.cliente }}</td>
                                                <td>{{ tarea.vendedor }}</td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="">{{ tarea.categoria }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button v-if="tarea.completa==0" v-on:click.prevent="detalleTarea(tarea)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                            <i class="si si-eye"></i>
                                                        </button>
                                                        <i v-if="tarea.completa==1" style="color:#2A9050" class="fa fa-check"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                           
                                                            </tbody>
                                    </table>
                                   
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
                usuarios: [],
                
            }
             
        },
        created(){
            this.obtenerTareas();
            this.obtenerUsuarios();
    EventBus.$on('nuevaTarea', funcion => {
  this.obtenerTareas();
});
        },
        methods: {
            obtenerTareas(){
                let URL = '/tareas/obtener-tareas';
                axios.get(URL).then((response) => {
                    this.tareas = response.data;
                    console.log(this.tareas);
                    
                });
                },
                obtenerUsuarios(){
                let URL = '/obtener-usuarios';

                axios.get(URL).then((response) => {
                    this.usuarios = response.data;
                    console.log(this.usuarios)
                }).catch((error) => {
                    console.log(error);
                })
            },
                detalleTarea(task){
    Swal.fire({
                                title: task.categoria+" "+task.cliente,
                                text: "Detalles: "+task.notas,
                                type: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Tarea Finalizada',
                                cancelButtonText: 'Cerrar'
                                
                            }).then((result) => {
                            if (result.value) {
                                console.log(task);
                                var url= '/tareas/eliminar-tarea/'+task.id;
                                axios.delete(url).then(response =>{
                                    this.obtenerTareas();
                                    }) 
                                }
                          
})
   }
                
        }
    }
</script>
