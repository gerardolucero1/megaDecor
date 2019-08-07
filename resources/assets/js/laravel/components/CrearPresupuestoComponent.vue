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
                                <input type="text" placeholder="Buscar">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-primary">Agregar Elemento</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-secondary">Agregar Paquete</button>
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
                                <th scope="col">Notas</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <input type="checkbox">
                                </th>
                                <td>Nope</td>
                                <td>Mesa</td>
                                <td>20</td>
                                <td>50</td>
                                <td>540</td>
                                <td>0</td>
                                <td>Mesa de dulces</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">Editar</button>
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
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
                        <button class="btn btn-sm btn-block btn-success">Guardar Presupuesto</button>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button class="btn btn-sm btn-block btn-secondary">Guardar Contrato</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 offset-md-1">
                <search-component></search-component>
                <hr>
                <lista-inventario-component></lista-inventario-component>
            </div>
        </div>
        
    </section>
</template>

<script>
    import SearchComponent from './SearchComponent';
    import ListaInventarioComponent from './ListaInventarioComponent';

    export default {
        components: {
            SearchComponent,
            ListaInventarioComponent,
        },
        data(){
            return{
                presupuesto:{
                    vendedor_id: '',
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
                festejados: [],
            }
        },
        created(){
            this.obtenerUsuarios();
            this.obtenerClientes();
        },
        computed:{
            welcome(){
                
            }
        },
        methods:{
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
            }
        }
    }
</script>

