<style>
    .registroPresupuesto .row{
        margin-bottom: 15px;
    }

    .registroPresupuesto input[type="date"]{
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }

    .registroPresupuesto input[type="time"]{
        width: 100%;
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }

    .registroPresupuesto input[type="text"], 
    .registroPresupuesto input[type="email"], 
    .registroPresupuesto input[type="number"], 
    .registroPresupuesto input[type="date"], 
    .registroPresupuesto select{
        width: 100%;
    }

    .registroPresupuesto .info p{
        line-height: 4px;
    }

    .resultadoInventario{
        position: absolute;
        z-index: 3000;
        background-color: gray;
        overflow: scroll;
        height: 300px;
    }

    table tr td input{
        border: none;
        background-color: transparent;
    }

    .producto{
        background-color: beige;
        border-bottom: 2px solid black;
    }

</style>

<template>
    <section class="container">
        <div class="row">
            <div class="col-md-12 registroPresupuesto">
                <div class="row">
                    <div class="col-md-4 offset-md-8 text-right info">
                        <p>PNM 0000</p>
                        <p>Vendedor: <span>Gerardo Lucero</span></p>
                        <p>Fecha de presupuesto: <span>23/08/2019</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informacion del evento</h4>
                            <input id="salonMega" type="radio" name="tipoSalon" value="INTERNO" v-model="presupuesto.tipoEvento">
                            <label for="salonMega">Salon Mega Mundo</label>
                        <br>
                        <input id="salonFuera" type="radio" name="tipoSalon" value="EXTERNO" v-model="presupuesto.tipoEvento">
                        <label for="salonFuera">Evento Fuera</label>
                            <div class="text-center" v-if="presupuesto.tipoEvento == 'EXTERNO'">
                                <input id="servicioFormal" type="radio" name="tipoServicio" value="FORMAL" v-model="presupuesto.tipoServicio">
                                <label for="servicioFormal">Servicio Formal</label>
                                <br>
                                <input id="servicioInfantil" type="radio" name="tipoServicio" value="INFANTIL" v-model="presupuesto.tipoServicio">
                                <label for="servicioInfantil">Servicio Infantil</label>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-right">Categoria del evento</h4>
                        <div class="row">
                            <div class="col-md-8 offset-md-4">
                                <select name="categoriaEvento" id="" v-model="presupuesto.categoriaEvento">
                                    <option value="1">Boda</option>
                                    <option value="2">XV Años</option>
                                    <option value="3">Aniversario</option>
                                </select>
                                
                                <div class="row mt-4">
                                    <div class="col-md-10">
                                        <input type="date" v-model="presupuesto.fechaEvento">
                                    </div>
                                    <div class="col-md-2 text-left">
                                        <i class="si si-calendar" style="font-size: 24px;"></i>
                                    </div>
                                    
                                </div>
                                <input type="checkbox" name="" value="1" id="pendienteFecha" v-model="presupuesto.pendienteFecha">
                                <label for="pendienteFecha">Pendiende</label>

                            </div>
                        </div>
                        <h4>Hora del evento</h4>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <input type="time" v-model="presupuesto.horaEventoInicio">
                            </div>
                            <div class="col-md-6">
                                <input type="time" v-model="presupuesto.horaEventoFin">
                            </div>
                        </div>
                        <input type="checkbox" name="1" id="pendienteHora" v-model="presupuesto.pendienteHora">
                        <label for="pendienteHora">Pendiende</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Cliente</h4>
                        <div class="row">
                            <div class="col-md-9">
                                <select name="" id="" v-model="presupuesto.cliente_id">
                                    <option v-bind:value="cliente.id" v-for="cliente in clientes" v-bind:key="cliente.index">{{ cliente.nombre }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-sm btn-primary">Agregar</button>
                            </div>
                        </div>
                        <div class="info">
                            <p>Mina Sharon</p>
                            <p>6141278851</p>
                            <p>mina_twice@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="info">
                            <p>Ultimo evento: <span>23/08/2019</span></p>
                            <p><span>5</span> eventos contratados</p>
                            <p><span>3</span> presupuestos</p>
                        </div>
                    </div>
                </div>
                <h4>Lugar del Evento</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" id="lugarMismo" name="lugarEvento" value="MISMA" v-model="presupuesto.lugarEvento">
                        <label for="lugarMismo">Misma Direccion</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" id="lugarOtro" name="lugarEvento" value="OTRA" v-model="presupuesto.lugarEvento">
                        <label for="lugarOtro">Otra</label>
                    </div>
                    <div class="col-md-4">
                        <input type="checkbox" id="pendienteLugar" value="1" v-model="presupuesto.pendienteLugar">
                        <label for="pendienteLugar">Pendiente</label>
                    </div>

                    <div class="col-md-10 mt-4">
                        <input type="text" placeholder="Nombre" v-model="presupuesto.nombreLugar">
                    </div>
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Direccion" v-model="presupuesto.direccionLugar">
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="text" placeholder="Numero" v-model="presupuesto.numeroLugar">
                    </div>
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Colonia" v-model="presupuesto.coloniaLugar">
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="text" placeholder="C.P" v-model="presupuesto.CPLugar">
                    </div>
                    <div class="col-md-12 mt-4">
                        <input type="text" name="" id="" placeholder="Observaciones" v-model="presupuesto.observacionesLugar">
                    </div>

                    <div class="col-md-2 mt-4">
                        <label for=""># Invitados</label>
                        <input type="number" name="" id="" v-model="presupuesto.numeroInvitados">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Tono del evento</label>
                        <input type="text" name="" id="" v-model="presupuesto.colorEvento">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Tema del evento</label>
                        <input type="text" name="" id="" v-model="presupuesto.temaEvento">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Festejado(s)</label>
                        <input type="text" name="" id="" v-model="festejado.nombre">
                        <input class="mt-2" type="number" name="" id="" v-model="festejado.edad">
                    </div>
                    <div class="col-md-1 mt-4">
                        <button class="btn btn-sm btn-primary mt-4" v-on:click.prevent="agregarFestejado()">Mas</button>
                    </div>
                </div>
                <!-- Tabla de festejados -->
                <div class="row" v-if="festejados.length !== 0">
                    <div class="col-md-6 offset-md-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">EDAD</th>
                                    <th scope="col" class="text-center">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(festejado, index) in festejados" v-bind:key="festejado.index">
                                    <td>{{ festejado.nombre }}</td>
                                    <td>{{ festejado.edad }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarFestejado(index)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                </div>
                <h4>Archivos de Referencia</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" name="" id="">
                    </div>
                </div>

                <hr>

                <!-- SECTION 2 -->
                <div class="row">
                    <div class="col-md-10 offset-md-2">
                        <div class="row">
                            <div class="col-md-4">
                                <buscador-component
                                    placeholder="Buscar Productos"
                                    event-name="results"
                                    :list="inventario"
                                    :keys="['servicio', 'id']"
                                    
                                ></buscador-component>

                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#agregarElemento">Agregar Elemento</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-secondary">Agregar Paquete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Resultado Busqueda -->
                <div class="row" v-if="results.length < inventario.length">
                    <div v-if="results.length !== 0" class="col-md-6 resultadoInventario">
                        <div class="list-group" v-for="producto in results" :key="producto.id">
                            <div class="row producto" v-on:click="agregarProducto(producto)">
                                <div class="col-md-7">
                                    <p>{{ producto.servicio }}</p>
                                    <span class="badge badge-info">
                                        {{ producto.precioUnitario }}
                                    </span>
                                </div>
                                <div class="col-md-5">
                                    <img class="img-fluid" src="https://i.redd.it/m2jtpv0kdff11.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Table-->
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Externo</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Precio Final</th>
                                <th scope="col">Ahorro</th>
                                <th scope="col" width="252">Notas</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(producto, index) in inventarioLocal" v-bind:key="producto.index">
                                <th scope="row">
                                    <input type="checkbox" v-model="producto.externo">
                                </th>
                                <td>
                                    <img v-bind:src="producto.imagen" alt="" width="100%">
                                </td>
                                <td>{{ producto.servicio }}</td>
                                <td>
                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="text" v-model="cantidadActualizada" v-on:keyup.enter="updateCantidad(index)">
                                    <span v-else v-on:click="editarCantidad(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                    
                                </td>
                                <td>{{ producto.precioUnitario }}</td>
                                <td>
                                    <input v-if="(producto.precioFinal == '') || (indice == index && key == 'precioFinal')" type="text" v-model="precioFinalActualizado" v-on:keyup.enter="updatePrecioFinal(index)">
                                    <span v-else v-on:click="editarPrecioFinal(index, Object.keys(producto))">{{ producto.precioFinal }}</span>
                                </td>
                                <td>
                                    <input v-if="(producto.ahorro == '') || (indice == index && key == 'ahorro')" type="text" v-model="ahorroActualizado" v-on:keyup.enter="updateAhorro(index)">
                                    <span v-else v-on:click="editarAhorro(index, Object.keys(producto))">{{ producto.ahorro }}</span>
                                </td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="2" v-if="(producto.notas == '') || (indice == index && key == 'notas')" v-model="notasActualizadas" v-on:keyup.enter="updateNotas(index)">
                                        
                                    </textarea>
                                    <span v-else v-on:click="editarNotas(index, Object.keys(producto))">
                                        {{ producto.notas }}
                                    </span>
                                    

                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">Editar</button>
                                    <button class="btn btn-sm btn-danger" @click="eliminarProductoLocal(index)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Mostrar en presupuesto de cliente</h4>
                                <input type="checkbox" id="precioUnitario">
                                <label for="precioUnitario">Precios Unitarios</label>
                                <br>
                                <input type="checkbox" id="descripcionPaquete">
                                <label for="descripcionPaquete">Descripcion Paquetes</label>
                                <br>
                                <input type="checkbox" id="imagenes">
                                <label for="imagenes">Imagenes</label>
                            </div>
                            <div class="col-md-4 mt-4">
                                <h5>Subtotal: $<span>1300</span></h5>
                                <input type="checkbox" id="iva">
                                <label for="iva">IVA: $<span>150</span></label>

                                <div class="info mt-3">
                                    <p>TOTAL con IVA: $<span>1300</span></p>
                                    <p>Ahorro General: $<span>100</span></p>
                                    <p>Comision pagada en base a $ <span>150</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <button class="btn btn-sm btn-block btn-primary">Imprimir</button>
                    </div>
                    <div class="col-md-4 offset-md-2 mt-4">
                        <button class="btn btn-sm btn-block btn-success" @click="guardarPresupuesto()">Guardar Presupuesto</button>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button class="btn btn-sm btn-block btn-secondary">Guardar Contrato</button>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-md-9 offset-md-1">
                
                <search-component></search-component>
                <hr>
                <lista-inventario-component></lista-inventario-component>
                
                <hr>
                
            </div>
        </div>
        -->

        <!-- Modal agregar elemento -->
        <div class="modal fade" id="agregarElemento" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar elementos</h5>
                    <button type="button" class="close" onClick="$('#agregarElemento').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="row">
                                <!-- Primer columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Servicio</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Servicio" v-model="productoExterno.servicio">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio unitario</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio unitario" v-model="productoExterno.precioUnitario">
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12">Imagen</label>
                                        <div class="col-12">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input js-custom-file-input-enabled" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input" @change="obtenerImagen">
                                                <label class="custom-file-label" for="example-file-input-custom" style="overflow-x: hidden;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <figure>
                                            <img :src="imagen" width="100%" alt="Thumbnail">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#agregarElemento').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" @click="agregarProductoExterno()">Save changes</button>
                </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import SearchComponent from './SearchComponent';
    import ListaInventarioComponent from './ListaInventarioComponent';
    import BuscadorComponent from './BuscadorComponent.vue';
    // Importamos el evento Bus.
    import { EventBus } from '../event-bus.js';

    export default {
        components: {
            SearchComponent,
            ListaInventarioComponent,
            BuscadorComponent,
        },
        data(){
            return{
                results: [],
                presupuesto:{
                    vendedor_id: '1',
                    cliente_id: '',
                    tipoEvento: '',
                    tipoServicio: '',
                    categoriaEvento: '',
                    fechaEvento: '',
                    pendienteFecha: '',
                    horaEventoInicio: '',
                    horaEventoFin: '',
                    pendienteHora: '',

                    //Lugar del Evento
                    lugarEvento: '',
                    pendienteLugar: '',
                    nombreLugar: '',
                    direccionLugar: '',
                    numeroLugar: '',
                    coloniaLugar: '',
                    CPLugar: '',
                    observacionesLugar: '',

                    //Informacion del Evento
                    numeroInvitados: '',
                    colorEvento: '',
                    temaEvento: '',
                },
                usuarios: [],
                clientes: [],
                festejado: {
                    nombre: '',
                    edad: '',
                },
                inventario: [],

                //Agregar al invenatrio producto externo
                thumbnail: '',
                productoExterno: {
                    'externo': true,
                    'imagen': '',
                    'servicio': '',
                    'precioUnitario': '',
                },
                
                inventarioLocal: [],
                festejados: [],

                //Control sobre las ediciones en la tabla de productos
                indice: '',
                key: '',

                cantidadActualizada: '',
                ahorroActualizado: '',
                precioFinalActualizado: '',
                notasActualizadas: '',
            }
        },
        created(){
            this.obtenerUsuarios();
            this.obtenerClientes();
            this.obtenerInventario();
            this.$on('results', results => {
                this.results = results
            });
        },
        computed:{
            imagen(){
                return this.productoExterno.imagen;
            }
        },
        filters: {
            decimales: function(value){
                if (!value) return '';
                value = value.toFixed(2);
                return value;
            }
        },
        methods:{
            //Metodos para procesar la imagen de prodcuto extero
            obtenerImagen(e){
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;

                this.cargarImagen(files[0]);
            },
            cargarImagen(file){
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    //this.thumbnail = e.target.result;
                    this.productoExterno.imagen = e.target.result;
                };

                reader.readAsDataURL(file);

            },
            //Agregar producto externo a la tabla de productos
            agregarProductoExterno(){
                console.log(this.productoExterno);
                this.inventarioLocal.push({
                    'externo': true,
                    'imagen': this.productoExterno.imagen,
                    'servicio': this.productoExterno.servicio,
                    'cantidad': '',
                    'precioUnitario': this.productoExterno.precioUnitario,
                    'precioFinal': '',
                    'ahorro': '',
                    'notas': '',
                    'id': '',
                });
                this.productoExterno = {'externo': true, 'imagen': '', 'servicio': '', 'precioUnitario': ''};
            },
            // Bus para comunicar controladores
            busEvent() {
                // Enviar el evento por el canal click
                EventBus.$emit('click');
            },
            //Metodos dentro de la tabla productos
                // Eliminar
                eliminarProductoLocal(index){
                    this.inventarioLocal.splice(index, 1);
                },

                // Cantidad
                editarCantidad(index, key){
                    this.indice = index;
                    this.key = key[3];
                    console.log(index);
                    console.log(this.key);
                       
                },
                updateCantidad(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    producto.cantidad = this.cantidadActualizada;
                    producto.precioFinal = producto.cantidad * producto.precioUnitario;
                    this.inventarioLocal.splice(index, 1, producto);
                    console.log(this.inventarioLocal);
                    this.cantidadActualizada = '';
                    this.key = '';
                    this.indice = '100000000';
                },

                //Ahorro
                editarAhorro(index, key){
                    this.indice = index;
                    this.key = key[6]; 
                    console.log(index);
                    console.log(this.key);  
                },
                updateAhorro(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    if(producto.cantidad == ''){
                        alert('Primero define una cantidad');
                        return;
                    }else{
                        producto.precioFinal = producto.cantidad * producto.precioUnitario;
                        producto.precioFinal = producto.precioFinal - (producto.precioFinal * (this.ahorroActualizado / 100));
                        producto.ahorro = this.ahorroActualizado;
                        this.inventarioLocal.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.ahorroActualizado = '';
                        this.key = '';
                        this.indice = '100000000';
                    }
                    
                },

                //Precio Final
                editarPrecioFinal(index, key){
                    this.indice = index;
                    this.key = key[5];
                    console.log(index);
                    console.log(this.key);  
                },
                updatePrecioFinal(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    if(producto.cantidad == ''){
                        alert('Primero define una cantidad');
                        return;
                    }else{
                        let precioNormal = producto.cantidad * producto.precioUnitario;
                        let descuento = precioNormal - this.precioFinalActualizado;
                        producto.precioFinal = this.precioFinalActualizado;
                        producto.ahorro = (descuento / precioNormal) * 100;
                        
                        this.inventarioLocal.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.precioFinalActualizado = '';
                        this.key = '';
                        this.indice = '100000000';
                    }
                    
                },

                //Notas
                editarNotas(index, key){
                    this.indice = index; 
                    this.key = key[7];
                    console.log(index);
                    console.log(this.key); 
                },
                updateNotas(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    
                        producto.notas = this.notasActualizadas;
                        this.inventarioLocal.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.notasActualizadas = '';
                        this.key = '';
                        this.indice = '100000000';
                    
                },

            //Otros metodos
            obtenerInventario(){
                let URL = '/obtener-inventario';
                axios.get(URL).then((response) => {
                    this.inventario = response.data;
                    console.log(this.inventario);
                }).catch((error) => {
                    console.log(error.data);
                });
            
            },
            agregarProducto(producto){
                this.inventarioLocal.push({
                    'externo': false,
                    'imagen': producto.imagen,
                    'servicio': producto.servicio,
                    'cantidad': '',
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '',
                    'ahorro': '',
                    'notas': '',
                    'id': producto.id,
                });
                console.log(this.inventarioLocal);
                
            },
            obtenerUsuarios(){
                let URL = '/usuarios';
                axios.get(URL).then((response) => {
                    this.usuarios = response.data;
                    console.log(this.usuarios);
                })
            },
            obtenerClientes(){
                let URL = '/obtener-clientes';
                axios.get(URL).then((response) => {
                    this.clientes = response.data;
                    console.log(this.clientes);
                })
            },
            agregarFestejado(){
                this.festejados.push({'nombre': this.festejado.nombre, 'edad': this.festejado.edad});
                //this.festejados.push({'nombre': this.festejado.nombre, 'edad': this.festejado.edad});
            },
            eliminarFestejado(index){
                this.festejados.splice(index, 1);
            },

            // Guardar presupuesto
            guardarPresupuesto(){
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                let URL = '/presupuestos/create';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                }).then((response) => {
                    console.log(response);
                }).catch((error) => {
                    console.log(error.data);
                });
            }
        }
    }
</script>

