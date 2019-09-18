<style>
    .logo-presupuesto{
        width: 25%;
        height: 130px;
        background-position: center;
        background-size: cover;
    }

    .verPresupuesto .row{
        margin-bottom: 15px;
    }

    .verPresupuesto input[type="date"]{
        background-color: transparent;
        border: none;
    }

    .verPresupuesto input[type="time"]{
        width: 100%;
        background-color: transparent;
        border: none;
    }

    .modalAgregarPaquete input[type="text"],
    .verPresupuesto input[type="text"], 
    .verPresupuesto input[type="email"], 
    .verPresupuesto input[type="number"], 
    .verPresupuesto input[type="date"], 
    .verPresupuesto select{
        width: 100%;
        background-color: transparent;
        border: none;
    }

    .verPresupuesto .info p{
        line-height: 4px;
    }

    .resultadoInventario{
        position: absolute;
        z-index: 3000;
        background-color: white;
        overflow: scroll;
        max-height: 300px;
    }

    table tr td input{
        border: none;
        background-color: transparent;
    }

    .producto{
        background-color: white;
        border-bottom: 1px dotted gray;
    }

</style>

<template>
    <section class="container block mt-3">
        <div class="row">
            <div class="col-md-12">
                <h2>Estas viendo la version: {{ presupuesto.version }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 verPresupuesto">
                <div class="row">
                    <div class="col-md-8 text-left">
                        <div v-if="presupuesto.tipoEvento == 'INTERNO'" class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat">

                        </div>
                        <div v-else class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo-decor.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat">

                        </div>
                    </div>
                    <div class="col-md-4 text-right info">
                        <p>{{ obtenerFolio }}</p>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <p>Vendedor: <span>{{ vendedor.name }}</span></p>
                            </div>
                        </div>
                        <p class="mt-3">Fecha de presupuesto: <span>{{ presupuesto.created_at | formatearFecha }}</span></p>
                    </div>
                </div>
                <div class="row" style="border-bottom:solid; border-width:1px; border-style:dotted; border-top:none; border-right:none; border-left:none">
                    <div class="col-md-6">
                        <h4>Informacion del evento</h4>
                            <input id="salonMega" type="radio" name="tipoSalon" value="INTERNO" v-model="presupuesto.tipoEvento" disabled>
                            <label for="salonMega">Salon Mega Mundo</label>
                        <br>
                        <input id="salonFuera" type="radio" name="tipoSalon" value="EXTERNO" v-model="presupuesto.tipoEvento" disabled>
                        <label for="salonFuera">Evento Fuera</label>
                            <div class="text-left" v-if="presupuesto.tipoEvento == 'EXTERNO'" style="padding-left:30px;">
                                <input id="servicioFormal" type="radio" name="tipoServicio" value="FORMAL" v-model="presupuesto.tipoServicio" disabled>
                                <label for="servicioFormal">Servicio Formal</label>
                                <br>
                                <input id="servicioInfantil" type="radio" name="tipoServicio" value="INFANTIL" v-model="presupuesto.tipoServicio" disabled>
                                <label for="servicioInfantil">Servicio Infantil</label>
                            </div>
                    </div>
                    <div class="col-md-6">
                        
                        <div class="row" >
                            <div class="col-md-8 offset-md-4">
                                <h4 class="">Categoria del evento</h4>
                                <select name="categoriaEvento" id="" v-model="presupuesto.categoriaEvento" disabled>
                                    <option value="1">Boda</option>
                                    <option value="2">XV Años</option>
                                    <option value="3">Aniversario</option>
                                    <option value="4">Cumpleaños</option>
                                    <option value="5">Gala</option>
                                    <option value="6">Baile</option>
                                </select>
                                 <p class="btn-text" data-toggle="modal" data-target="#categoriaEventoModal"><i class="fa fa-edit"></i> Administrar Categorias</p>
                                
                                <div class="row mt-4">
                                    <div class="col-md-10">
                                        <input type="date" v-model="presupuesto.fechaEvento" readonly>
                                    </div>
                                    <div class="col-md-2 text-left">
                                        <i class="si si-calendar" style="font-size: 24px;"></i>
                                    </div>
                                    
                                </div>
                                <input type="checkbox" name="" value="1" id="pendienteFecha" v-model="presupuesto.pendienteFecha" disabled="disabled">
                                <label for="pendienteFecha">Pendiende</label>

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 offset-md-4 row">
                                <h4>Horario del evento</h4>
                            <div class="col-md-6" style="padding-left:0">
                                <label>Inicio del evento</label><br>
                                <input type="time" v-model="presupuesto.horaEventoInicio" readonly>
                            </div>
                           
                            <div class="col-md-6" style="padding-left:0">
                                <label>Fin del evento</label><br>
                                <input type="time" v-model="presupuesto.horaEventoFin" readonly>
                            </div>
                             <label for="pendienteHora" style="padding-top:10px">
                             <input type="checkbox" name="1" id="pendienteHora" v-model="presupuesto.pendienteHora" disabled>
                            Pendiende</label>
                            </div>
                          
                        </div>
                        
                    </div>
                </div>
                <div class="row" style="border-bottom:solid; border-width:1px; border-style:dotted; border-top:none; border-right:none; border-left:none">
                    <div class="col-md-6">
                        <h4>Cliente</h4>
                        <div class="row" style="display: none;">
                            <div class="col-md-9">
                                <buscador-component
                                    placeholder="Buscar Clientes Existentes"
                                    event-name="clientResults"
                                    :list="clientes"
                                    :keys="['nombre', 'email']"
                                    
                                ></buscador-component>
                            </div>
                        </div>
                        <div v-if="clienteSeleccionado" class="info">
                            <p>{{ clienteSeleccionado.nombre }}</p>
                            <p>{{ clienteSeleccionado.email }}</p>
                            <p v-for="telefono in clienteSeleccionado.telefonos" v-bind:key="telefono.index">
                                {{ telefono.numero }} - {{ telefono.nombre }} - {{ telefono.tipo }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 text-right mt-4" v-if="clienteSeleccionado">
                        <div class="info">
                            <p>Ultimo evento: 
                                <span v-if="clienteSeleccionado && ultimoEvento">{{ ultimoEvento.fechaEvento }}</span>
                                <span v-else>Primer Evento</span>
                            </p>
                            <p><span>{{ calcularContratos }}</span> eventos contratados</p>
                            <p><span>{{ calcularPresupuestos }}</span> presupuestos</p>
                        </div>
                    </div>
                </div>
                <h4>Lugar del Evento</h4>
                <div class="row" style="border-bottom:solid; border-width:1px; border-style:dotted; border-top:none; border-right:none; border-left:none">
                    <div class="col-md-4">
                        <input type="radio" id="lugarMismo" name="lugarEvento" value="MISMA" v-model="presupuesto.lugarEvento" disabled>
                        <label for="lugarMismo">Misma Direccion</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" id="lugarOtro" name="lugarEvento" value="OTRA" v-model="presupuesto.lugarEvento" disabled>
                        <label for="lugarOtro">Otra</label>
                    </div>
                    <div class="col-md-4">
                        <input type="checkbox" id="pendienteLugar" value="1" v-model="presupuesto.pendienteLugar" disabled>
                        <label for="pendienteLugar">Pendiente</label>
                    </div>

                    <div class="col-md-10 mt-4">
                        <input type="text" placeholder="Nombre" v-model="presupuesto.nombreLugar" readonly>
                    </div>
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Direccion" v-model="presupuesto.direccionLugar" readonly>
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="text" placeholder="Numero" v-model="presupuesto.numeroLugar" readonly>
                    </div>
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Colonia" v-model="presupuesto.coloniaLugar" readonly>
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="text" placeholder="C.P" v-model="presupuesto.CPLugar" readonly>
                    </div>
                    <div class="col-md-12 mt-4">
                        <input type="text" name="" id="" placeholder="Observaciones" v-model="presupuesto.observacionesLugar" readonly>
                    </div>

                    <div class="col-md-2 mt-4">
                        <label for=""># Invitados</label>
                        <input type="number" name="" id="" v-model="presupuesto.numeroInvitados" readonly>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Tono del evento</label>
                        <input type="text" name="" id="" v-model="presupuesto.colorEvento" readonly>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Tema del evento</label>
                        <input type="text" name="" id="" v-model="presupuesto.temaEvento" readonly>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(festejado) in festejados" v-bind:key="festejado.index">
                                    <td>{{ festejado.nombre }}</td>
                                    <td>{{ festejado.edad }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                </div>

                <!-- SECTION 2 -->

                <!-- Resultado Busqueda -->

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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(producto, index) in inventarioLocal" v-bind:key="producto.index">
                                <th scope="row">
                                    <input type="checkbox" v-model="producto.externo" disabled="disabled">
                                </th>
                                <td>
                                    <img v-bind:src="producto.imagen" alt="" width="100%">
                                </td>
                                <td>{{ producto.servicio }}</td>
                                <td data-name="cantidad">
                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="text" v-model="cantidadActualizada" v-on:keyup.enter="updateCantidad(index)">
                                    <span v-else v-on:click="editarCantidad(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                    
                                </td>
                                <td>{{ producto.precioUnitario }}</td>
                                <td>
                                    <input v-if="(producto.precioFinal == '') || (indice == index && key == 'precioFinal')" type="text" v-model="precioFinalActualizado" v-on:keyup.enter="updatePrecioFinal(index)">
                                    <span v-else v-on:click="editarPrecioFinal(index, Object.keys(producto))">{{ producto.precioFinal | decimales }}</span>
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
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <h4>Mostrar en presupuesto de cliente</h4>
                                <input type="checkbox" id="precio" v-model="presupuesto.opcionPrecio" disabled>
                                <label for="precio">Precios</label>
                                <br>
                                <input type="checkbox" id="precioUnitario" v-model="presupuesto.opcionPrecioUnitario" disabled>
                                <label for="precioUnitario">Precios Unitarios</label>
                                <br>
                                <input type="checkbox" id="descripcionPaquete" v-model="presupuesto.opcionDescripcionPaquete" disabled>
                                <label for="descripcionPaquete">Descripcion Paquetes</label>
                                <br>
                                <input type="checkbox" id="descuento" v-model="presupuesto.opcionDescuento" disabled>
                                <label for="descuento">Descuentos</label>
                                <br>
                                <input type="checkbox" id="imagenes" v-model="presupuesto.opcionImagen" disabled>
                                <label for="imagenes">Imagenes</label>
                            </div>
                            <div class="col-md-4 offset-md-3 mt-4">
                                <h5>Subtotal: $<span>{{ calcularSubtotal | decimales }}</span></h5>
                                <input type="checkbox" id="iva" v-model="presupuesto.opcionIVA" disabled>
                                <label for="iva">IVA: $<span>{{ calcularIva | decimales }}</span>
                                </label>

                                <div class="info mt-3">
                                    <p>TOTAL con IVA: $<span>{{ (calcularSubtotal + calcularIva) | decimales }}</span></p>
                                    <p>Ahorro General: $<span>{{ calcularAhorro | decimales }}</span></p>
                                    <p>Comision pagada en base a $ <span>150</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#verVersiones">Ver versiones</button>
                        
                    </div>
                    <div v-if="!original" class="col-md-4 mt-4">
                        <button class="btn btn-sm btn-block btn-success" @click="usarVersion()">Usar esta version</button>
                    </div>
                </div>
            </div>
        </div>
       
       <!-- Modal -->
        <div class="modal fade" id="verVersiones" tabindex="-1" role="dialog" aria-labelledby="verVersiones" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Versiones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Numero de versión</th>
                                <th scope="col">Folio</th>
                                <th scope="col">Fecha de creación</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="version in versiones" :key="version.index">
                                <th scope="row">{{ version.id }}</th>
                                <td>{{ version.version }}</td>
                                <td>{{ version.folio }}</td>
                                <td>{{ version.created_at}}</td>
                                <td>
                                    <button class="btm btn-success btn-sm" @click="obtenerVersion(version.id)">Ver version</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="obtenerPresupuesto()">Volver a version actual</button>
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
    import { EventBus } from '../eventBus.js';

    export default {
        components: {
            SearchComponent,
            ListaInventarioComponent,
            BuscadorComponent,
        },
        data(){
            return{
                results: [],
                resultsPaquetes: [],
                clientResults: [],
                clienteSeleccionado: {
                    id: '',
                    nombre: '',
                    email: '',
                    nombreLugar: '',
                    direccionLugar: '',
                    numeroLugar: '',
                    coloniaLugar: '',
                    telefonos: [],
                    presupuestos: [],
                },
                clienteSeleccionadoContratos: [],
                clienteSeleccionadoPresupuestos: [],
                ultimoEvento: '',

                //Usuario y usuarios
                usuarioActual: '',
                usuarios: [],

                presupuesto:{
                    id: '',
                    folio: '',
                    vendedor_id: '',
                    client_id: '',
                    tipoEvento: 'EXTERNO',
                    tipoServicio: 'FORMAL',
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

                    //Opciones presupuesto
                    opcionPrecio: '',
                    opcionPrecioUnitario: '',
                    opcionDescripcionPaquete: '',
                    opcionImagen: '',
                    opcionDescuento: '',
                    opcionIVA: '',

                    //Presupuesto o contrato
                    tipo: '',

                    //Impresion
                    impresion: false,

                    //Total
                    total: '',

                    comision: '',
                    budget_id: '',
                },
                guardarVersion: true,
                clientes: [],
                festejado: {
                    nombre: '',
                    edad: '',
                },
                inventario: [],

                //Control de elemento externo
                controlElementoExterno: false,
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

                //Edicion de paquete
                indicePaqueteEdicion: '',
                paqueteEdicion:{
                    externo: '',
                    imagen: '',
                    servicio: '',
                    cantidad: '',
                    precioUnitario: '',
                    precioFinal: '',
                    ahorro: '',
                    notas: '',
                    paquete: '',
                    tipo: '',
                    id: '',
                },

                //Control sobre las ediciones en la tabla de productos
                indice: '',
                key: '',

                cantidadActualizada: '',
                ahorroActualizado: '',
                precioFinalActualizado: '',
                notasActualizadas: '',

                //Paquetes
                paquete: {
                    servicio: '',
                    precioFinal: '',
                    guardarPaquete: false,
                    categoria: '',
                    inventario: [],
                },
                precioSugerido: 0,
                cantidadPaquete: '',

                //IVA
                iva: 16,
                verSettings: false,

                // Ultimo presupuesto
                ultimoPresupuesto: '',

                //Imprimir presupuesto
                imprimir: false,

                //Datos facturacion
                requiereFactura: false,
                facturacion: {
                    //Tiempos
                    horaInicio: '',
                    horaFin: '',
                    horaEntrega: '',
                    fechaRecoleccion: '',
                    notasFacturacion: '',

                    //Datos
                    nombreFacturacion: '',
                    direccionFacturacion: '',
                    numeroFacturacion: '',
                    coloniaFacturacion: '',
                    emailFacturacion: '',
                },

                demoP: '',

                //Versiones

                versiones: [],

                vendedor: '',

                original: true,
            }
        },
        created(){
            this.obtenerUltimoPresupuesto();
            this.obtenerUsuarios();
            //Obtenemos todos los clientes para el buscados
            this.obtenerClientes();
            this.obtenerInventario();
            this.obtenerUsuario();
            
            this.$on('results', results => {
                this.results = results
            });
            this.$on('clientResults', clientResults => {
                this.clientResults = clientResults
            });
            this.$on('resultsPaquetes', resultsPaquetes => {
                this.resultsPaquetes = resultsPaquetes
            });

            
        },
        computed:{
            obtenerVendedor: function(){

            },
            imagen: function(){
                return this.productoExterno.imagen;
            },
            calcularSubtotal: function(){
                //Arreglo javascript de objetos json
                let json = this.inventarioLocal;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += data[x].precioFinal; // Ahora que es un objeto javascript, tiene propiedades
                }

                this.presupuesto.total = suma;
                return suma;
            },
            calcularIva: function(){
                return this.calcularSubtotal * (this.iva / 100);
            },
            calcularAhorro: function(){
                let ahorro = 0;
                this.inventarioLocal.forEach(function(element){
                    let precioNormal = element.cantidad * element.precioUnitario;
                    ahorro = ahorro + (precioNormal - element.precioFinal);
                })

                return ahorro;
            },
            obtenerFecha: function(){
                let fecha = moment().format("DD/MM/YYYY");
                return fecha;
            },
            obtenerFolio: function(){
                if(this.ultimoPresupuesto.length !== 0){
                    let cadena = this.ultimoPresupuesto.folio,
                        separador = "M",
                        data = cadena.split(separador);
                    if(this.presupuesto.tipoEvento == 'EXTERNO'){
                        let nuevoFolio = ('NM' + (parseInt(data[1]) + 1));
                        return nuevoFolio
                    }else{
                        let nuevoFolio = ('M' + (parseInt(data[1]) + 1));
                        return nuevoFolio
                    }
                    //return nuevoFolio;
                }
                

            },
            calcularContratos: function(){
                let contratos = this.clienteSeleccionado.presupuestos.filter(element => element.tipo == 'CONTRATO');
                this.clienteSeleccionadoContratos = contratos;
                return this.clienteSeleccionadoContratos.length;
            },
            calcularPresupuestos: function(){
                let presupuestos = this.clienteSeleccionado.presupuestos.filter(element => element.tipo == 'PRESUPUESTO');
                this.clienteSeleccionadoPresupuestos = presupuestos;
                return this.clienteSeleccionadoPresupuestos.length;
            }
        },
        filters: {
            formatearFecha: function(data){
                let fecha = moment(data).format("DD/MM/YYYY");
                return fecha;
            },
            decimales: function (x, posiciones = 2) {
                var s = x.toString()
                var l = s.length
                var decimalLength = s.indexOf('.') + 1

                if (l - decimalLength <= posiciones){
                    return x
                }
                // Parte decimal del número
                var isNeg  = x < 0
                var decimal =  x % 1
                var entera  = isNeg ? Math.ceil(x) : Math.floor(x)
                // Parte decimal como número entero
                // Ejemplo: parte decimal = 0.77
                // decimalFormated = 0.77 * (10^posiciones)
                // si posiciones es 2 ==> 0.77 * 100
                // si posiciones es 3 ==> 0.77 * 1000
                var decimalFormated = Math.floor(
                    Math.abs(decimal) * Math.pow(10, posiciones)
                )
                // Sustraemos del número original la parte decimal
                // y le sumamos la parte decimal que hemos formateado
                var finalNum = entera + 
                    ((decimalFormated / Math.pow(10, posiciones))*(isNeg ? -1 : 1))
                
                return finalNum;
            }
        },
        watch: {
            'presupuesto.lugarEvento': function(val){
                if(val == 'MISMA'){
                    this.presupuesto.nombreLugar = this.clienteSeleccionado.nombreLugar;
                    this.presupuesto.direccionLugar = this.clienteSeleccionado.direccionLugar;
                    this.presupuesto.numeroLugar = this.clienteSeleccionado.numeroLugar;
                    this.presupuesto.coloniaLugar = this.clienteSeleccionado.coloniaLugar;

                }else{
                     this.presupuesto.nombreLugar = '';
                    this.presupuesto.direccionLugar = '';
                    this.presupuesto.numeroLugar = '';
                    this.presupuesto.coloniaLugar = '';
                }
                
            },
            'requiereFactura': function(val){
                if(val){
                    this.facturacion.nombreFacturacion = this.clienteSeleccionado.nombreLugar;
                    this.facturacion.direccionFacturacion = this.clienteSeleccionado.direccionLugar;
                    this.facturacion.numeroFacturacion = this.clienteSeleccionado.numeroLugar;
                    this.facturacion.coloniaFacturacion = this.clienteSeleccionado.coloniaLugar;
                    this.facturacion.emailFacturacion = this.clienteSeleccionado.email;

                }else{
                    this.facturacion.nombreFacturacion = '';
                    this.facturacion.direccionFacturacion = '';
                    this.facturacion.numeroFacturacion = '';
                    this.facturacion.coloniaFacturacion = '';
                    this.facturacion.emailFacturacion = '';
                }
                
            },
        },
        methods:{
            obtenerUsuario(){
                let URL = '/obtener-usuario';

                axios.get(URL).then((response) => {
                    this.usuarioActual = response.data;
                    this.presupuesto.vendedor_id = this.usuarioActual.id;
                }).catch((error) => {
                    console.log(error.data);
                })
            },
            obtenerUsuarios(){
                let URL = '/obtener-usuarios';

                axios.get(URL).then((response) => {
                    this.usuarios = response.data;
                }).catch((error) => {
                    console.log(error.data);
                })
            },
            obtenerUltimoPresupuesto(){
                let URL = '/obtener-ultimo-presupuesto';

                axios.get(URL).then((response) => {
                    this.ultimoPresupuesto = response.data;
                }).catch((error) => {
                    console.log(error.data)
                });
            },


            //Otros metodos
            obtenerInventario(){
                let URL = '/obtener-inventario';
                axios.get(URL).then((response) => {
                    this.inventario = response.data;
                }).catch((error) => {
                    console.log(error.data);
                });
            
            },

            obtenerClientes(){
                let URL = '/obtener-clientes';
                axios.get(URL).then((response) => {
                    this.clientes = response.data;
                    this.obtenerPresupuesto()
                })
            },

            obtenerPresupuesto(){
                this.original = true;
              let data = window.location.pathname.split('/');
              let path = data[3];
              let URL = '/obtener-presupuesto/' + path;

              axios.get(URL).then((response) => {
                this.presupuesto = response.data;

                let cliente = this.clientes.find(function(element){
                  return element.id == response.data.client_id;
                })

                //Obtener el cliente seleccionado
                let URL = '/obtener-cliente';
                axios.post(URL, {
                    'id': cliente.id,
                    'accion': 'telefonos',
                }).then((response) => {
                    this.clienteSeleccionado.telefonos = response.data;    
                }).catch((error) => {
                    console.log(error.data);
                });

                axios.post(URL, {
                    'id': cliente.id,
                    'accion': 'presupuestos',
                }).then((response) => {
                    this.clienteSeleccionado.presupuestos = [];
                    this.ultimoEvento = '';
                    if(response.data.length !== 0){
                        this.clienteSeleccionado.presupuestos = response.data;
                        let arreglo = response.data
                            arreglo.sort(function(a,b){
                                    return new Date(b.fechaEvento) - new Date(a.fechaEvento);
                            });
                        this.ultimoEvento = arreglo.shift();
                        this.clienteSeleccionado.presupuestos.push(this.ultimoEvento);
                    }
                }).catch((error) => {
                    console.log(error.data);
                });

                this.clienteSeleccionado.id = cliente.id;
                this.clienteSeleccionado.nombre = cliente.nombre;
                this.clienteSeleccionado.email = cliente.email;

                this.clienteSeleccionado.nombreLugar = cliente.nombreFacturacion;
                this.clienteSeleccionado.direccionLugar = cliente.direccionFacturacion;
                this.clienteSeleccionado.numeroLugar = cliente.numeroFacturacion;
                this.clienteSeleccionado.coloniaLugar = cliente.coloniaFacturacion;

                this.presupuesto.client_id = cliente.id;

                //Obtener los festejados
                let direction = '/obtener-festejados/' + this.presupuesto.id;

                axios.get(direction).then((response) => {
                  this.festejados = response.data;
                }).catch((error) => {
                  console.log(error.data);
                })

                //Obtener el inventario

                let direction2 = '/obtener-inventario-1/' + this.presupuesto.id;

                axios.get(direction2).then((response) => {
                  let arreglo = [];
                  response.data.forEach(function(element){
                    if(!element.externo){
                      let objeto = {
                        'externo': false,
                        'imagen': element.imagen,
                        'servicio': element.servicio,
                        'cantidad': element.cantidad,
                        'precioUnitario': element.precioUnitario,
                        'precioFinal': element.precioFinal,
                        'ahorro': element.ahorro,
                        'notas': element.notas,
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': element.id,
                      }
                      arreglo.push(objeto);
                    }else{
                      let objeto = {
                        'externo': true,
                        'imagen': element.imagen,
                        'servicio': element.servicio,
                        'cantidad': element.cantidad,
                        'precioUnitario': element.precioUnitario,
                        'precioFinal': element.precioFinal,
                        'ahorro': element.ahorro,
                        'notas': element.notas,
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': element.id,
                      }
                      arreglo.push(objeto);
                    }
                    
                    return arreglo;
                  });
                this.inventarioLocal = arreglo;
                })

                let direction3 = '/obtener-paquetes/' + this.presupuesto.id;

                axios.get(direction3).then((response) => {
                    
                    let arregloPaquetes = [];

                    response.data.forEach(function(element){
                        let URL = '/obtener-elementos-paquetes/' + element.id;

                        var arregloElementos = [];
                        axios.get(URL).then((response) => {
                            
                            
                            response.data.forEach(function(element){
                                if(element.externo){
                                    let demo = {
                                        'externo': true,
                                        'nombre': element.servicio,
                                        'imagen': element.imagen,
                                        'precioUnitario': element.precioUnitario,
                                        'precioFinal': element.precioFinal,
                                        'cantidad': element.cantidad,
                                        'id': '',
                                    }
                                arregloElementos.push(demo);
                                }else{
                                    let demo = {
                                        'externo': false,
                                        'nombre': element.servicio,
                                        'imagen': element.imagen,
                                        'precioUnitario': element.precioUnitario,
                                        'precioFinal': element.precioFinal,
                                        'cantidad': element.cantidad,
                                        'id': '',
                                    }
                                arregloElementos.push(demo);
                                }
                                return arregloElementos;
                            });
                           return arregloElementos; 
                        })

                        let objeto = {
                            'externo': false,
                            'imagen': 'https://webmediums.com/media/max_1600/1*-z6mbBzxB4Htfj0-5JPqIw.jpeg',
                            'servicio': element.servicio,
                            'cantidad': element.cantidad,
                            'precioUnitario': element.precioUnitario,
                            'precioFinal': element.precioFinal,
                            'ahorro': element.ahorro,
                            'notas': element.notas,
                            'paquete': {
                                'categoria': element.categoria,
                                'guardarPaquete': element.guardarPaquete,
                                'precioFinal': element.precioFinal,
                                'servicio': element.servicio,
                                'inventario': arregloElementos,
                            },
                            'tipo': 'PAQUETE',
                            'id': element.id,
                        }
                        arregloPaquetes.push(objeto);   
                    }); 
                this.inventarioLocal = this.inventarioLocal.concat(arregloPaquetes);

                }).catch((error) => {
                    console.log(error.data);
                })
                
                let vendedor_id = this.presupuesto.vendedor_id;
                this.vendedor = this.usuarios.find(function(element){
                    return element.id == vendedor_id;
                });


              }).catch((error) => {
                console.log(error.data);
              })

              //Obtener las versiones del presupuesto

              let direction4 = '/obtener-versiones/' + path;

              axios.get(direction4).then((response) => {
                  this.versiones = response.data;
              })  
            },

            obtenerVersion(id){
                
            let path = id;
            let URL = '/obtener-version/' + path;

              axios.get(URL).then((response) => {

                this.presupuesto = response.data;
                

                let cliente = this.clientResults.find(function(element){
                  return element.id == response.data.client_id;
                })


                //Obtener el cliente seleccionado
                let URL = '/obtener-cliente';
                axios.post(URL, {
                    'id': cliente.id,
                    'accion': 'telefonos',
                }).then((response) => {
                    this.clienteSeleccionado.telefonos = response.data;    
                }).catch((error) => {
                    console.log(error.data);
                });

                axios.post(URL, {
                    'id': cliente.id,
                    'accion': 'presupuestos',
                }).then((response) => {
                    this.clienteSeleccionado.presupuestos = [];
                    this.ultimoEvento = '';
                    if(response.data.length !== 0){
                        this.clienteSeleccionado.presupuestos = response.data;
                        let arreglo = response.data
                            arreglo.sort(function(a,b){
                                    return new Date(b.fechaEvento) - new Date(a.fechaEvento);
                            });
                        this.ultimoEvento = arreglo.shift();
                        this.clienteSeleccionado.presupuestos.push(this.ultimoEvento);
                    }
                }).catch((error) => {
                    console.log(error.data);
                });

                this.clienteSeleccionado.id = cliente.id;
                this.clienteSeleccionado.nombre = cliente.nombre;
                this.clienteSeleccionado.email = cliente.email;

                this.clienteSeleccionado.nombreLugar = cliente.nombreFacturacion;
                this.clienteSeleccionado.direccionLugar = cliente.direccionFacturacion;
                this.clienteSeleccionado.numeroLugar = cliente.numeroFacturacion;
                this.clienteSeleccionado.coloniaLugar = cliente.coloniaFacturacion;

                this.presupuesto.client_id = cliente.id;

                //Obtener los festejados
                let direction = '/obtener-festejados-version/' + this.presupuesto.id;

                axios.get(direction).then((response) => {
                  this.festejados = response.data;
                }).catch((error) => {
                  console.log(error.data);
                })

                //Obtener el inventario

                let direction2 = '/obtener-inventario-version-1/' + this.presupuesto.id;

                axios.get(direction2).then((response) => {
                  let arreglo = [];
                  response.data.forEach(function(element){
                    if(!element.externo){
                      let objeto = {
                        'externo': false,
                        'imagen': element.imagen,
                        'servicio': element.servicio,
                        'cantidad': element.cantidad,
                        'precioUnitario': element.precioUnitario,
                        'precioFinal': element.precioFinal,
                        'ahorro': element.ahorro,
                        'notas': element.notas,
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': element.id,
                      }
                      arreglo.push(objeto);
                    }else{
                      let objeto = {
                        'externo': true,
                        'imagen': element.imagen,
                        'servicio': element.servicio,
                        'cantidad': element.cantidad,
                        'precioUnitario': element.precioUnitario,
                        'precioFinal': element.precioFinal,
                        'ahorro': element.ahorro,
                        'notas': element.notas,
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': element.id,
                      }
                      arreglo.push(objeto);
                    }
                    
                    return arreglo;
                  });
                this.inventarioLocal = arreglo;
                })

                let direction3 = '/obtener-paquetes-version/' + this.presupuesto.id;

                axios.get(direction3).then((response) => {
                    
                    let arregloPaquetes = [];

                    response.data.forEach(function(element){
                        let URL = '/obtener-elementos-paquetes/' + element.id;

                        var arregloElementos = [];
                        axios.get(URL).then((response) => {
                            
                            
                            response.data.forEach(function(element){
                                if(element.externo){
                                    let demo = {
                                        'externo': true,
                                        'nombre': element.servicio,
                                        'imagen': element.imagen,
                                        'precioUnitario': element.precioUnitario,
                                        'precioFinal': element.precioFinal,
                                        'cantidad': element.cantidad,
                                        'id': '',
                                    }
                                arregloElementos.push(demo);
                                }else{
                                    let demo = {
                                        'externo': false,
                                        'nombre': element.servicio,
                                        'imagen': element.imagen,
                                        'precioUnitario': element.precioUnitario,
                                        'precioFinal': element.precioFinal,
                                        'cantidad': element.cantidad,
                                        'id': '',
                                    }
                                arregloElementos.push(demo);
                                }
                                return arregloElementos;
                            });
                           return arregloElementos; 
                        })

                        let objeto = {
                            'externo': false,
                            'imagen': 'https://webmediums.com/media/max_1600/1*-z6mbBzxB4Htfj0-5JPqIw.jpeg',
                            'servicio': element.servicio,
                            'cantidad': element.cantidad,
                            'precioUnitario': element.precioUnitario,
                            'precioFinal': element.precioFinal,
                            'ahorro': element.ahorro,
                            'notas': element.notas,
                            'paquete': {
                                'categoria': element.categoria,
                                'guardarPaquete': element.guardarPaquete,
                                'precioFinal': element.precioFinal,
                                'servicio': element.servicio,
                                'inventario': arregloElementos,
                            },
                            'tipo': 'PAQUETE',
                            'id': element.id,
                        }
                        arregloPaquetes.push(objeto);   
                    }); 
                this.inventarioLocal = this.inventarioLocal.concat(arregloPaquetes);

                })

                this.original = false;
                this.presupuesto.guardarVersion = true;
              })
            },

            usarVersion(){
                this.presupuesto.tipo = 'PRESUPUESTO';
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                let URL = '/presupuestos/create/version';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                    'guardarVersion': this.guardarVersion,
                }).then((response) => {
                    this.imprimir = true;
                    let URL = '/enviar-email';

                    axios.post(URL, {
                        'presupuesto': this.presupuesto,
                        'festejados': this.festejados,
                        'inventario': this.inventarioLocal,
                    }).then((response) => {
                        console.log('Email Enviado');
                    }).catch((error) => {
                        console.log(error.data);
                    });
                    
                    if(response.data == 1){
                        Swal.fire(
                            'Error!',
                            'No puede haber dos eventos en salon en la misma fecha',
                            'error'
                        );
                    }else{
                        Swal.fire(
                            'Creado!',
                            'El presupuesto ha sido creado',
                            'success'
                        );
                    }   
                    
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                        'Error!',
                        'Algo ha ocurrido mal',
                        'error'
                    );
                });
            },
        },
    }
</script>

