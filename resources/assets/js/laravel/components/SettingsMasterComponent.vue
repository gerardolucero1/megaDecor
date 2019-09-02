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
                         
                               <form action="POST" v-on:submit.prevent="actualizarSettings()">
                       
                            <div class="form-group row">
                            <div class="col-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-gridf" name="material-gridf">
                                    <label for="material-gridf">Porcentaje Meta De Crecimiento En ventas</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-gridl" name="material-gridl" >
                                    <label for="material-gridl">Porcentaje Meta De Crecimiento En Utilidad</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-gridf" name="material-gridf">
                                    <label for="material-gridf">Bono monetario si se alcanza el objetivo de ventas</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-gridl" name="material-gridl" >
                                    <label for="material-gridl">Bono monetario si no se alcanza el objetivo de ventas</label>
                                </div>
                            </div>
                        </div>
                     
                                </form>
                                
                                
              
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
                
            }
             
        },
        created(){
            this.obtenerTareas();
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
