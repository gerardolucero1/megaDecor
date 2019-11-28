<template>
    <section>
        <div v-if="tipo == 'alta'">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Dar de alta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Cantidad</label>
                            <input type="number" class="form-control" v-model="alta.cantidad">
                        </div>
                        <div class="form-group">
                            <label for="">Fecha de Compra</label>
                            <input type="date" class="form-control" v-model="alta.fechaCompra">
                        </div>
                        <div class="form-group">
                            <label for="">Proveedor</label>
                            <select name="" id="" v-model="alta.proveedor" class="form-control">
                                <option value="ELEKTRA">Elektra</option>
                                <option value="WALMART">Walmart</option>
                            </select>
                            <p style="font-size: 11px;" data-toggle="modal" data-target="#addProveedor">Añadir nuevo proveedor</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="display: none;">
                            <label for="">Fecha de Ingreso</label>
                            <input id="fechaIngreso" type="date" class="form-control" v-model="alta.fechaIngreso">
                        </div>
                        <div class="form-group">
                            <label for="">Precio</label>
                            <input type="number" class="form-control" v-model="alta.precio">
                        </div>
                        <div class="form-group">
                            <label for="">Factura</label>
                            <input type="text" class="form-control" v-model="alta.factura">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" @click="registrarAlta()" class="btn btn-primary">Guardar alta</button>
            </div>
        </div>
        <div v-else>
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Dar de baja</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Evento</label>
                            <buscador-component
                                :limpiar="limpiar"
                                placeholder="Buscar presupuesto"
                                event-name="presupuestosResults"
                                :list="presupuestos"
                                :keys="['folio', 'fechaEvento', 'cliente']"
                                class="form-control"
                            ></buscador-component>

                            <!-- Resultado Busqueda -->
                            <div class="row" v-if="presupuestosResults.length < presupuestos.length">
                                <div v-if="presupuestosResults.length !== 0" class="col-md-12 resultadoInventario">
                                    <div v-for="presupuesto in presupuestosResults.slice(0,20)" :key="presupuesto.id">
                                        <div class="row contenedor-producto" v-on:click="obtenerPresupuesto(presupuesto)" style="margin:0">
                                            <div class="col-md-3">
                                                <img class="img-fluid" src="https://i.stack.imgur.com/l60Hf.png" alt="">
                                            </div>
                                            <div class="col-md-8">
                                                <p style="padding:0; margin:0; line-height:14px; font-size:13px; "><span style="font-weight:bolder"> {{ presupuesto.cliente }}</span></p>
                                                <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ presupuesto.folio }}</p>
                                                <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ presupuesto.fechaEvento }}</p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="background-color: rgba(240, 242, 245, 1); margin-top: 8px; padding: 5px;">
                                <p class="text-danger">{{ presupuestoSeleccionado.folio }}</p>
                                <h4 style="line-height: 2px;">{{ presupuestoSeleccionado.cliente }}</h4>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Cantidad</label>
                            <input type="number" class="form-control" v-model="alta.cantidad">
                        </div>
        
                        <div class="form-group">
                            <label for="">Motivo</label>
                            <select name="" id="" v-model="alta.motivo" class="form-control">
                                <option value="QUEBRADO">Quebrado</option>
                                <option value="PREDEFINIDO">Predefinido</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Fecha de baja del sistema</label>
                            <input type="date" class="form-control" v-model="alta.fechaCompra">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" @click="registrarAlta()" class="btn btn-primary">Guardar alta</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document" style="border: 2px solid black;">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar proveedor</h5>
                    <button type="button" class="close" onClick="$('#addProveedor').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nombre del proveedor</label>
                                <input type="text" class="form-control" v-model="proveedor">
                            </div>
                            <div class="form-group">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in proveedores" :key="index">
                                            <th scope="row">{{ item.id }}</th>
                                            <td>{{ item.nombre }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" @click="eliminarProveedores(item)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#addProveedor').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" @click="agregarProveedores()">Agregar proveedor</button>
                </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');
import BuscadorComponent from './BuscadorComponent.vue';
import moment from 'moment';

export default {
    components: {
        BuscadorComponent,
    },
    data(){
        return{
            proveedores: '',
            proveedor: '',
            producto: '',
            tipo: '',
            alta: {
                cantidad: '',
                proveedor: '',
                fechaCompra: '',
                fechaIngreso: '',
                precio: '',
                factura: '',
                producto: '',
                user_id: '',
                budget_id: '',
                cantidad: '',
                motivo: '',
                tipo: '',
            },
            presupuestos: [],
            presupuestosResults: [],
            presupuestoSeleccionado: '',
            limpiar: false,
            clientes: [],
            cantidadBodega: '',
            fechaHoy: '',
        }
    },

    computed: {
        usuario: function(){
            return JSON.parse(user.content);
        },

        nuevaCantidad: function(){
            let cantidadOriginal = this.cantidadBodega.innerHTML;

            if(this.tipo.length != 0){
                if(this.tipo == 'alta'){
                    let cantidadReal = parseInt(cantidadOriginal) + parseInt(this.alta.cantidad);
                    return cantidadReal
                }else{
                    let cantidadReal = parseInt(cantidadOriginal) - parseInt(this.alta.cantidad);
                    return cantidadReal
                }
            }
        }
    },

    created(){
        this.obtenerPresupuestos();
        this.obtenerProveedores();

        //Buscadores
        this.$on('presupuestosResults', presupuestosResults => {
            this.presupuestosResults = presupuestosResults
        });

    },

    mounted(){
        let botonesAlta = document.getElementsByClassName('altas');
        let botonesBaja = document.getElementsByClassName('bajas');
        let demo1 = Array.from(botonesAlta);
        let demo2 = Array.from(botonesBaja);

        let botones = demo1.concat(demo2);

        if(botones.length != 0){
            for (var i = 0; i < botones.length; i++) {
                botones[i].addEventListener('click', (e) => {
                    let cantidadBodega = e.target.dataset.cantidad;
                    this.tipo = e.target.dataset.tipo;
                    let id = e.target.dataset.id;
                    let URL = 'obtener-producto/' + id;

                    this.cantidadBodega = document.getElementById(cantidadBodega);

                    axios.get(URL).then((response) => {
                        this.producto = response.data;
                        
                    })
                });
            }
        }
    },

    methods: {
        async obtenerProveedores(){
            try {
                let URL = '/obtener-otros-proveedores'

                const response = await axios.get(URL)
                this.proveedores = response.data
            } catch (e) {
                console.log(e.data)
            }
        },
        async agregarProveedores(){
            try {
                let URL = '/agregar-otros-proveedores'

                const response = await axios.post(URL, {
                    'proveedor': this.proveedor,
                })
                this.obtenerProveedores()
            } catch (e) {
                console.log(e.data)
            }
        },
        async eliminarProveedores(item){
            try {
                let URL = '/eliminar-otros-proveedores/' + item.id

                const response = await axios.delete(URL)
                this.obtenerProveedores()
            } catch (e) {
                console.log(e.data)
            }
        },
        obtenerPresupuestos: function(){
            let URL = 'caja/obtener-presupuestos';

            axios.get(URL).then((response) => {
                this.presupuestos = response.data;
                this.obtenerClientes();
            }).catch((error) => {
                console.log(error.data);
            })
        },

        obtenerClientes: function(){
            let URL = 'obtener-clientes';

            axios.get(URL).then((response) => {
                this.clientes = response.data;
                 
                 //Asignamos una nueva propiedad a los presupuestos con su respectivo cliente
                 this.presupuestos.forEach((element) => {
                     this.clientes.forEach((item) => {
                         if(item.id == element.client_id){
                            if(item.hasOwnProperty('apellidoPaterno')){
                                Object.defineProperty(element, 'cliente', {
                                    value: item.nombre + ' ' + item.apellidoPaterno + ' ' + item.apellidoMaterno,
                                    writable: true,
                                    enumerable: true,
                                    configurable: true
                                });
                            }else{
                                Object.defineProperty(element, 'cliente', {
                                    value: item.nombre,
                                    writable: true,
                                    enumerable: true,
                                    configurable: true
                                });
                            }
                         }
                     })
                 })
            })
        },

        registrarAlta: function(){
            let URL = 'registrar-alta';
            this.alta.producto = this.producto.id;
            this.alta.user_id = this.usuario.id;
            this.alta.tipo = this.tipo;
            this.alta.evento = this.presupuestoSeleccionado.id;

            axios.post(URL, this.alta).then((response) => {
                console.log('Alta registrada');
                $('#asignarAlta').modal('hide');

                    this.presupuestoSeleccionado.id='';
                    this.tipo='';
                    this.usuario.id='';
                    this.producto.id='';
                    this.producto.cantidad='';
                this.cantidad = '',
                this.proveedor = '',
                this.fechaCompra = '',
                this.fechaIngreso = '',
                this.precio = '',
                this.factura = '',
                this.producto = '',
                this.user_id = '',
                this.budget_id = '',
                this.cantidad = '',
                this.motivo = '',
                this.tipo = '',

                this.cantidadBodega.innerHTML = this.nuevaCantidad;
            }).catch((error) => {
                console.log(error.data);
            })
        },

        obtenerPresupuesto: function(presupuesto){
            this.limpiar = true;
            this.presupuestoSeleccionado = presupuesto;

            setTimeout(() => {
                this.limpiar = false;
            }, 1000);
        },
    },
}
</script>

<style scooped>
    .resultadoInventario{
        position: absolute;
        z-index: 3000;
        background-color: white;
        overflow: scroll; 
        max-height: 300px;
        -webkit-box-shadow: 0px 5px 5px -2px rgba(38,38,38,1);
        -moz-box-shadow: 0px 5px 5px -2px rgba(38,38,38,1);
        box-shadow: 0px 5px 5px -2px rgba(38,38,38,1);
        padding: 0;
    }
</style>