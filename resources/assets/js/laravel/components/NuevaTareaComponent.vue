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
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 registroTarea">
                <div class="card card-default">
                    <div class="card-header" style="font-weight:bold; font-style:italic;">Completa los campos para asignar una nueva tarea<br><br></div>

                    <div class="card-body">
                        <form action="POST" v-on:submit.prevent="crearTarea()">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Selecciona un Vendedor</label>
                            <select name="vendedor" id="" v-model="presupuesto.vendedor_id">
                                    <option value="all">Todos los vendedores</option>
                                    <option v-for="usuario in usuarios" :value="usuario.id" :key="usuario.index" :selected="usuarioActual.id">{{ usuario.name }}</option>
                                </select>
                                </div>
                                 <div class="col-md-6">
                                <label for="">Selecciona un Cliente</label>
                            <select name="categoria" id="" v-model="tarea.cliente">
                                <optgroup label="Seleccionar un vendedor">
                                <option v-bind:value="cliente.id" v-for="cliente in clientesFisicos" v-bind:key="cliente.index">{{ cliente.nombre }}</option>  
                                </optgroup>
                            </select>
                            
                                </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                                <label for="">Selecciona Una Categoria </label>
                                <select name="categoria" id="" v-model="tarea.categoria">
                                    <option selected disabled>Categorias</option>
                                <option v-bind:value="categoria.nombre" v-for="categoria in categorias" v-bind:key="categoria.index">{{ categoria.nombre }}</option>  
                            </select>
                            <p class="btn-text" data-toggle="modal" data-target="#categoriaTareaModal"><i class="fa fa-edit"></i> Administrar Categorias</p>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Selecciona una Fecha</label>
                                <input required type="date" v-model="tarea.fecha">
            <div class="form-group" style="display:none">
                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                    <input v-model="tarea.fechaINABILITADO" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Notas relacionadas con la nueva tarea</label>
                                <textarea required name="" id="" style="width:100%" rows="6" v-model="tarea.notas"></textarea>
                            </div>
                            
                        </div>
                        <div class="row float-right">
                            <button style="margin-right:10px" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-success" type="submit">Crear Nueva Tarea</button>
                        </div>
                        </form>
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
                tarea: {
                    vendedor: '',
                    categoria: '',
                    cliente: '',
                    notas: '',
                    fecha: '',

                },
                clientesFisicos: [],
                categorias: [],
                
            }
             
        },
        created(){
            this.obtenerCategorias();
            this.obtenerClientesFisicos();
            
EventBus.$on('clic', funcion => {
  this.obtenerCategorias();
});
        },
        methods: {
            obtenerCategorias(){
                let URL = '/tareas/categorias-tareas';
                axios.get(URL).then((response) => {
                    this.categorias = response.data;
                    console.log(this.categorias);
                });
                },
    emitGlobalClickEvent() {

      EventBus.$emit('nuevaTarea');
    },
            obtenerClientesFisicos(){
                let URL = '/tareas/clientes-fisicos';
                axios.get(URL).then((response) => {
                    this.clientesFisicos = response.data;
                    console.log(this.clientesFisicos);
                });
                },
                
                
                crearTarea(){
                let URL = '/tareas/create';
                axios.post(URL, {
                    'idVendedor': this.tarea.vendedor,
                    'nombreCategoria': this.tarea.categoria,
                    'idCliente': this.tarea.cliente,
                    'textoNotas':  this.tarea.notas,
                    'fecha': this.tarea.fecha

                }).then((response) => {
                    this.tarea = {};
                    EventBus.$emit('nuevaTarea');
                    Swal.fire({
                                title: 'Tarea Registrada con exito',
                                text: "Se registro tu nueva tarea",
                                type: 'success',
                                showCancelButton: false,
                                cancelButtonColor: '#d33',
                                
                            })
                }).catch((error) => {
                    console.log(error);
                    Swal.fire({
                                title: 'Error al agregar tarea',
                                text: "Comprueba que completaste todos los campos correctamente o verifica tu conexión a internet",
                                type: 'error',
                                showCancelButton: false,
                                cancelButtonColor: '#d33',
                                
                            })
                });
                
            }
        }
    }
</script>
