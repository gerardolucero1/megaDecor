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
                <div v-if="tareas == 0">No hay Tareas para hoy</div>
                    <div v-if="tareas != 0" class="accordion" id="accordionExample">
                        <div class="card container">
                            <div class="card-header" id="headingOne">
                                <div class="row">
                                    <div class="col-md-5">
                                        <p><strong>Usuario</strong></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Categoria</strong></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>Acciones</strong></p>
                                    </div>
                                </div>
                                <div class="row" v-for="tarea in tareas" v-bind:key="tarea.index" style="border-bottom: 1px solid black; margin-top: 5px;">
                                    <div v-if="tarea.vendedor_id!=2" class="col-md-5">
                                        <p>{{ tarea.vendedor }}</p>
                                    </div>
                                    <div v-if="tarea.vendedor_id==2" class="col-md-4">
                                        <p>Todos</p>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="" data-toggle="tooltip" title="Prospecto"><i  class="fa fa-star-half" style="color:#34A1E4" ></i> {{ tarea.categoria }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" :data-target="'#box' + tarea.id" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="si si-note"></i>
                                            </button>
                                            <button v-if="tarea.completa==0" v-on:click.prevent="detalleTarea(tarea)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                <i class="si si-eye"></i>
                                            </button>
                                            <i v-if="tarea.completa==1"  style="color:#2A9050" class="fa fa-check"></i>
                                            <i v-if="tarea.completa==1" data-toggle="tooltip" title="Como vamos con eso?" style="color:#2A9050" class="si si-info"></i>
                                        </div>
                                    </div>

                                    <div :id="'box' + tarea.id" class="collapse col-md-12" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <textarea class="form-control mt-1" name="" id="" rows="3" width="100%" v-model="comentario.comment" @keypress.enter="comentarTarea(tarea)"></textarea>
                                            </div>
                                            <div class="row">
                                                <div v-for="(comment, index) in tarea.comments" :key="index" class="col-md-12" style="background-color: rgba(252, 248, 227, 1); padding: 10px; text-align: justify; margin-top: 5px; position: relative;">
                                                    <p>{{ comment.comment }}</p>
                                                    <span class="badge badge-pill badge-info" style="position: absolute; bottom: 0; right: 0;">{{ comment.created_at | formatearFecha2 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <table v-if="tareas != 0" id="example"  class="table table-vcenter">
                        <thead>
                            <tr style="font-size:11px">
                                <th>Usuario</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Categoría</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="accordion">
                            <tr style="font-size:11px" class="row-tasks" v-for="tarea in tareas" v-bind:key="tarea.index">
                                <td v-if="tarea.vendedor_id!=2">{{ tarea.vendedor }}</td>
                                <td v-if="tarea.vendedor_id==2">Todos</td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="" data-toggle="tooltip" title="Prospecto"><i  class="fa fa-star-half" style="color:#34A1E4" ></i> {{ tarea.categoria }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="si si-note"></i>
                                        </button>
                                        <button v-if="tarea.completa==0" v-on:click.prevent="detalleTarea(tarea)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                            <i class="si si-eye"></i>
                                        </button>
                                        <i v-if="tarea.completa==1"  style="color:#2A9050" class="fa fa-check"></i>
                                        <i v-if="tarea.completa==1" data-toggle="tooltip" title="Como vamos con eso?" style="color:#2A9050" class="si si-info"></i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    -->
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
            this.obtenerTareas();
                EventBus.$on('nuevaTarea', funcion => {
            this.obtenerTareas();
            });
        },
        filters: {
            formatearFecha2: function(data){
                moment.locale('es'); 
                let fecha = moment(data).format('MMMM Do YYYY');
                return fecha;
            },
        },
        methods: {
            comentarTarea(task){
                let URL = '/comentar-tarea/' + task.id;
                this.comentario.task_id = task.id;

                axios.post(URL, this.comentario).then((response) => {
                    console.log('Comentario agregado');
                    this.obtenerTareas();

                    this.comentario.comment = '';
                }).catch((error) => {
                    console.log(error.data);
                })
            },

            obtenerTareas(){
                let URL = '/tareas/obtener-tareas';
                axios.get(URL).then((response) => {
                    this.tareas = response.data;
                  //  console.log(this.tareas);
                    
                });
                },
                detalleTarea(task){
                    if(task.vendedor_id==2){
                        var condicion = false;
                    }else{
                        var condicion = true;
                    }
                    if(task.cliente==null){
                        task.cliente=" ";
                    }
    Swal.fire({
                                title: task.categoria+" - "+task.cliente,
                                text: "Detalles: "+task.notas,
                                type: 'info',
                                showCancelButton: true,
                                showConfirmButton: condicion,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Agregar Comentario',
                                cancelButtonText: 'Cerrar'
                                
                            }).then((result) => {
                            if (result.value) {
                               var txt;
  var person = prompt("Agregar Comentario a tarea", "");
  if (person == null || person == "") {
    
  } else {
    alert('Comentario agregado');
  }
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
