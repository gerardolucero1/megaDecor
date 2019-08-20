
<style>
    .registroTarea .row{
        margin-bottom: 20px;
    }

    .registroTarea input[type="date"]{
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }
   
    .registroTarea input[type="text"], 
    .registroTarea input[type="email"], 
    .registroTarea input[type="number"], 
    .registroTarea input[type="date"], 
    .registroTarea select{
        width: 100%;
        padding: 8px;
    }
    .btn-text{
        color:black;
    }
    .btn-text:hover{
        color: #2F7AD4;
        cursor: pointer;
    }
    .btn-categorias{
        cursor: pointer;
        color: #2F7AD4;
    }
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 registroTarea">
                <div class="card card-default">
                    
                    <div class="card-body">
                        <form action="POST" v-on:submit.prevent="crearCategoriaTarea()">
                            <div class="row">
                        <label for="">Nombre de categoría</label>
                        <input type="text" v-model="categoria.nombre">
                        </div>
                        
                       
                        <div class="row float-right" style="width:100%">
                            <button class="btn btn-success" type="submit">Agregar Categoria</button>
                        </div>
                        
                        </form>
                        <div class="row" style="width:100%">
                            <p v-on:click="demo()" class="btn-categorias"><i class="fa fa-list-ul"></i> Ver Categorias Guardadas</p>
                        </div>
                        <div v-if="mostrar == 0" class="row" id="lista_categorias" style="height:150px; overflow:scroll">
                            <table v-if="categoria != null" style="width:100%">
                                <tr v-for="categoria in categorias" v-bind:key="categoria.index" style="border-bottom:solid; border-color:grey; border-width:1px">
                                    <td style="padding-right:10px">{{ categoria.nombre }}</td>
                                    <td><i v-on:click.prevent="eliminarCategorias(categoria)" class="fa fa-remove" style="color:red; cursor: pointer"></i></td>
                                    
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<!--  Script para timepicker-->
   <script> 

   import { EventBus } from '../eventBus.js';

    export default {
        data(){
            return{
                categoria: {
                    nombre: '',
                },
                categorias: [],
                mostrar: 1,
            }
             
        },
        created(){
            this.obtenerCategorias();
        },
        methods: {
            demo(){
                if(this.mostrar == 1){
                    this.mostrar = 0
                }else{
                    this.mostrar = 1
                }
               console.log(this.mostrar); 
            },
    emitGlobalClickEvent() {

      EventBus.$emit('clic');
    },
            obtenerCategorias(){
                let URL = '/tareas/categorias-tareas';
                axios.get(URL).then((response) => {
                    this.categorias = response.data;
                    console.log(this.categorias);
                });
                },
            eliminarCategorias(categoria){
                var url= '/tareas/eliminar-categoria/'+categoria.id;
                axios.delete(url).then(response =>{
                    EventBus.$emit('clic');
                    this.obtenerCategorias();  
                      
                })
               
            },  
                
                crearCategoriaTarea(){
                let URL = '/tareas/createcategory';
                axios.post(URL, {
                    'nombre': this.categoria.nombre,
                    
              
                
          

                }).then((response) => {
                    this.categoria = {};
                    this.obtenerCategorias(); 
                    EventBus.$emit('clic');
                    Swal.fire({
                                title: 'Categoria registrada con exito',
                                text: "Se registro tu nueva categoria",
                                type: 'success',
                                showCancelButton: false,
                                cancelButtonColor: '#d33',
                                
                                
                            });
                }).catch((error) => {
                    console.log(error);
                });
                
            }
        }
    }
</script>
