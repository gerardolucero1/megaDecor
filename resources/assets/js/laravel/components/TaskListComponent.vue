<template>
   
        <div class="js-appear-enabled animated fadeIn" data-toggle="appear">
                               
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Tareas</h3>
                                    <div class="block-options">
                                        <div class="block-options-item js-appear-enabled">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#nuevaTareaModal">Nueva Tarea</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                       
                                        <div v-if="tareas == 0">No hay Tareas para hoy</div>
                                       
                                    <table  class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th class="d-none d-sm-table-cell" style="width: 15%;">Categoría</th>
                                                <th class="text-center" style="width: 100px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                                <tr v-for="tarea in tareas" v-bind:key="tarea.index">
                                                <td>{{ tarea.id }}</td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="">{{ tarea.categoria }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button v-on:click.prevent="detalleTarea(tarea.id)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                            <i class="si si-eye"></i>
                                                        </button>
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
function hola(){
    alert('estas dentro');
}
    export default {
        data(){
            return{
                tarea: {
                    vendedor_id: '',
                },
                tareas: [],
                
            }
             
        },
        created(){
            this.obtenerTareas();
        },
        methods: {
            obtenerTareas(){
                let URL = '/tareas/obtener-tareas';
                axios.get(URL).then((response) => {
                    this.tareas = response.data;
                    console.log(this.tareas);
                });
                },
                detalleTarea(task){
    Swal.fire({
                                title: '¿Terminaste esta tarea?',
                                text: "Esta accion no se puede revertir",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Confirmar'
                                
                            }).then((result) => {
                            if (result.value) {
                                var url= '/tareas/eliminar-tarea/'+task;
                                axios.delete(url).then(response =>{
                                    this.obtenerTareas();
                                    }) 
                                }
                          
})
   }
                
        }
    }
</script>
