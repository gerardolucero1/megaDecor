
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
    .btn-tipos{
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
                        <form action="POST" v-on:submit.prevent="crearTipoEmpresa()">
                            <div class="row">
                        <label for="">Tipo de Empresa</label>
                        <input type="text" v-model="tipo.nombre">
                        </div>
                        
                       
                        <div class="row float-right" style="width:100%">
                            <button class="btn btn-success" type="submit">Agregar Tipo de Empresa</button>
                        </div>
                        
                        </form>
                        <div class="row" style="width:100%">
                            <p v-on:click="demo()" class="btn-tipos"><i class="fa fa-list-ul"></i> Ver tipos Guardadas</p>
                        </div>
                        <div v-if="mostrar == 0" class="row" id="lista_tipos" style="height:150px; overflow:scroll">
                            <table v-if="tipo != null" style="width:100%">
                                <tr v-for="tipo in tipos" v-bind:key="tipo.index" style="border-bottom:solid; border-color:grey; border-width:1px">
                                    <td style="padding-right:10px">{{ tipo.nombre }}</td>
                                    <td><i v-on:click.prevent="eliminarTipoEmpresa(tipo)" class="fa fa-remove" style="color:red; cursor: pointer"></i></td>
                                    
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
<script type="text/javascript">
// Importamos el evento Bus.
    
            
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
   <script> 

   import { EventBus } from '../eventBus.js';

    export default {
        data(){
            return{
                tipo: {
                    nombre: '',
                },
                tipos: [],
                mostrar: 1,
            }
             
        },
        created(){
            this.obtenerTipoEmpresa();
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
      EventBus.$emit('nuevoTipoEmpresa');
    },
            obtenerTipoEmpresa(){
                let URL = '/clientes/tipo-empresa';
                axios.get(URL).then((response) => {
                    this.tipos = response.data;
                    console.log(this.tipos);
                });
                },
            eliminarTipoEmpresa(tipo){
                var url= '/clientes/eliminar-tipo-empresa/'+tipo.id;
                axios.delete(url).then(response =>{
                    EventBus.$emit('nuevoTipoEmpresa');
                    this.obtenerTipoEmpresa();  
                      
                })
               
            },  
                
                crearTipoEmpresa(){
                let URL = '/clientes/crearTipoEmpresa';
                axios.post(URL, {
                    'nombre': this.tipo.nombre,
                    
              
                
          

                }).then((response) => {
                    this.tipo = {};
                    this.obtenerTipoEmpresa(); 
                    EventBus.$emit('nuevoTipoEmpresa');
                    Swal.fire({
                                title: 'tipo registrado con exito',
                                text: "Se registro tu nuevo tipo de empresa",
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
