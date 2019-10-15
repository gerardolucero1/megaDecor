<style scoped>
    .caja-1 input{
        width: 100%;
        padding: 2px;
    }

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

    .registrosPagos{
        width: 90%;
        margin: 0 auto;
        border-radius: 15px;
        background-color: rgba(240, 242, 245, 1);
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    select{
        width: 100%;
    }

    .abonarPresupuesto{
        background-color: rgba(66, 117, 194, 1);
        padding: 5px;
        padding-bottom: 10px;
    }

    .infoPresupuesto p{
        line-height: 6px;
    }

    .registrosPagos p{
        line-height: 6px;
    }
</style>

<template>
    <section class="container">
        <div class="row" v-if="mostrarAbrirCaja">
            <div class="col-md-4">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Apertura de caja</h3>
                        <div class="block-options">
                            
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://www.alaingarcia.net/conozca/i/billete_1000_pesos_holograma.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete1000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="http://cdn.kaltura.com/p/0/thumbnail/entry_id/1_m98xxec5/quality/80/width/800/height/349" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete500">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="http://eltrochilero.com/wp-content/uploads/2018/02/Billete200anverso.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete200">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="http://www.unionpuebla.mx/sites/default/files/styles/galeria/public/field/image/billete-100_pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete100">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://i.pinimg.com/originals/a4/07/21/a4072113bae69abe37ac3d547f6b60f9.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete50">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://vanguardia.com.mx/sites/default/files/styles/paragraph_image_large_desktop_1x/public/mexico-20-pesos-benito-juarez-aztec-city-2012-p-image-88084-grande.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete20">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Apertura de caja</h3>
                        <div class="block-options">
                            
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <img src="https://i.colnect.net/f/3336/608/10-Pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.moneda10">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <img src="https://i.colnect.net/f/3336/603/5-Nuevos-Pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.moneda5">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <img src="https://i.colnect.net/f/3782/629/2-Pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.moneda2">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <img src="https://i.colnect.net/f/3444/383/1-Peso.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.moneda1">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <img src="https://i.colnect.net/f/3019/209/50-Centavos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.centavo50">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Apertura de caja</h3>
                        <div class="block-options">
                            
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">Cantidad total</label>
                            <input type="number" class="form-control" v-model="sumarCantidad">
                        </div>
                        <div class="form-group">
                            <label for="">Cantidad al momento de apertura</label>
                            <input type="number" class="form-control" v-model="cantidadRealApertura">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-block btn-info" @click="abrirCaja()">Abrir Caja 1</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-md-12">
                <ul class="nav nav-pills mb-3 ml-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#presupuestos" role="tab" aria-controls="pills-home" aria-selected="true">Registrar pagos presupuestos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#otros" role="tab" aria-controls="pills-profile" aria-selected="false">Registrar otros ingresos</a>
                    </li>
                </ul> 
            
        
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="presupuestos" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-6 caja-1">
                                    <div class="block">
                                        <div class="col-md-12 p-2">
                                            <buscador-component
                                                :limpiar="limpiar"
                                                placeholder="Buscar presupuesto"
                                                event-name="presupuestosResults"
                                                :list="presupuestos"
                                                :keys="['folio', 'fechaEvento', 'cliente']"
                                                
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
                                            <!-- Fin resultado busqueda -->

                                            <div class="col-md-12 p-2 mt-2 infoPresupuesto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>
                                                            <strong>Nombre cliente: </strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>{{ this.presupuestoSeleccionado.cliente }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>
                                                            <strong>Fecha del evento: </strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>{{ this.presupuestoSeleccionado.fechaEvento }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 text-center">
                                                        <p>
                                                            <strong>Total: </strong>
                                                        </p>
                                                        <p>$ {{ this.presupuestoSeleccionado.total }}</p>
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <p>
                                                            <strong>Total abonado</strong>
                                                        </p>
                                                        <p>$ {{ totalAbonado }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 offset-md-2 abonarPresupuesto">
                                                        <div class="col-md-12 mt-3">
                                                            <select name="" id="" v-model="pago.method">
                                                                <option value="EFECTIVO">Efectivo</option>
                                                                <option value="CHEQUE">Cheque</option>
                                                                <option value="TRANSFERENCIA">Transferencia</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <input type="number" v-model="pago.amount">
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <button class="btn btn-sm btn-info btn-block" @click="registrarPago()">Registrar pago</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 caja-2">
                                    <div class="block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="registrosPagos" v-for="(item, index) in presupuestoSeleccionado.payments" :key="index">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Fecha de pago:</strong></p>
                                                            <p>{{ item.created_at | formatearFecha }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Hora de pago:</strong></p>
                                                            <p>{{ item.created_at | formatearHora }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Metodo de pago:</strong></p>
                                                            <p>{{ item.method }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Cantidad abonada</strong></p>
                                                            <p>${{ item.amount }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p><strong>Saldo pendiente: </strong> ${{ presupuestoSeleccionado.total - item.amount }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="otros" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="block col-md-12 p-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Egreso/Ingreso</label>
                                                    <select class="form-control" v-model="movimiento.tipo">
                                                        <option value="INGRESO">Ingreso</option>
                                                        <option value="EGRESO">Egreso</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Motivo</label>
                                                    <input class="form-control" type="text" v-model="movimiento.motivo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Cantidad</label>
                                                    <input class="form-control" type="number" v-model="movimiento.cantidad">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Datos extras</label>
                                                    <textarea class="form-control" v-model="movimiento.descripcion"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                                <button class="btn btn-sm btn-block btn-info" @click="registrarMovimiento()">Registrar movimiento</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="block col-md-12 caja-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="registrosPagos" v-for="(item, index) in presupuestoSeleccionado.payments" :key="index">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Fecha de pago:</strong></p>
                                                            <p>{{ item.created_at | formatearFecha }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Hora de pago:</strong></p>
                                                            <p>{{ item.created_at | formatearHora }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Metodo de pago:</strong></p>
                                                            <p>{{ item.method }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Cantidad abonada</strong></p>
                                                            <p>${{ item.amount }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p><strong>Saldo pendiente: </strong> ${{ presupuestoSeleccionado.total - item.amount }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import BuscadorComponent from './BuscadorComponent.vue';

export default {
    components: {
        BuscadorComponent,
    },
    data(){
        return{
            mostrarAbrirCaja: true,
            sesion: null,
            presupuestos: [],
            clientes: [],
            presupuestosResults: [],
            limpiar: false,
            cantidad: {
                billete1000: 0,
                billete500: 0,
                billete200: 0,
                billete100: 0,
                billete50: 0,
                billete20: 0,
                moneda10: 0,
                moneda5: 0,
                moneda2: 0,
                moneda1: 0,
                centavo50: 0,
            },
            movimiento: {
                tipo: '',
                cantidad: '',
                motivo: '',
                descripcion: ''
            },
            cantidadApertura: null,
            cantidadRealApertura: null,
            presupuestoSeleccionado: '',
            pago: {
                budget_id: '',
                method: '',
                amount: '',
            },
            otrosPagos: [],
        }
    },
    created(){
        this.obtenerSesion();
        this.obtenerPresupuestos();
        this.obtenerOtrosPagos();

        //Buscadores
        this.$on('presupuestosResults', presupuestosResults => {
            this.presupuestosResults = presupuestosResults
        });
    },
    computed: {
        sumarCantidad: function(){
            let billete = (parseInt(this.cantidad.billete1000) * 1000) + (parseInt(this.cantidad.billete500) * 500) + (parseInt(this.cantidad.billete100) * 100) + (parseInt(this.cantidad.billete50) * 50) + (parseInt(this.cantidad.billete20) * 20);
            let monedas = (parseInt(this.cantidad.moneda10) * 10) + (parseInt(this.cantidad.moneda5) * 5) + (parseInt(this.cantidad.moneda2) * 2) + (parseInt(this.cantidad.moneda1) * 1) + (parseInt(this.cantidad.centavo50) * 0.50);
            let suma = billete + monedas;
            return suma;
        },

        usuario: function(){
            return JSON.parse(user.content);
        },

        totalAbonado: function(){
            if(this.presupuestoSeleccionado.length != 0){
                let suma = 0;
                this.presupuestoSeleccionado.payments.forEach((element) => {
                    suma += element.amount;
                })

                return suma;
            }
        },
    },
    directives: {
        focus: {
            inserted: function (el) {
                el.focus()
            }
        }
    },
    filters: {
        formatearFecha: function(val){
            moment.locale('es');
            let fecha = moment(val).format('MMMM Do YYYY');
            return fecha;
        },

        formatearHora: function(val){
            moment.locale('es');
            let hora = moment(val).format('h:mm:ss a');
            return hora;
        }
    },
    methods: {
        obtenerOtrosPagos: function(){
            let URL = 'pagos';

            axios.get(URL).then((response) => {
                this.otrosPagos = response.data;
            })
        },

        registrarMovimiento: function(){
            let URL = 'pagos';

            axios.post(URL, this.movimiento).then((response) => {
                this.obtenerOtrosPagos();
            })
        },

        obtenerSesion: function(){
            let URL = 'obtener-sesion-caja';

            axios.get(URL).then((response) => {
                this.sesion = response.data;
                this.habilitarCaja();
            })
        },

        obtenerClientes: function(){
            let URL = 'obtener-clientes';

            axios.get(URL).then((response) => {
                this.clientes = response .data;
                 
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

                if(this.presupuestoSeleccionado.length != 0){
                    let presupuesto = this.presupuestos.find((element) => {
                        return element.id == this.presupuestoSeleccionado.id
                    })

                    this.presupuestoSeleccionado = presupuesto;
                }
            })
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

        habilitarCaja: function(){
            if(this.sesion == ''){
                this.mostrarAbrirCaja = true;
            }else if((this.sesion.user_id == this.usuario.id) && (this.sesion.estatus == true)){
                this.mostrarAbrirCaja = false;
            }
        },

        obtenerPresupuesto: function(presupuesto){
            this.limpiar = true;
            this.presupuestoSeleccionado = presupuesto;

            setTimeout(() => {
                this.limpiar = false;
            }, 1000);
        },

        abrirCaja: function(){
            let URL = 'caja';

            axios.post(URL, {
                cantidadRealApertura: this.cantidadRealApertura,
                cantidadApertura: this.sumarCantidad,
                billetes: this.cantidad,
            }).then((response) => {
                let timerInterval
                Swal.fire({
                title: 'Abriendo caja',
                html: 'Espere un momento porfavor...',
                timer: 2000,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                    Swal.getContent().querySelector('strong')
                        .textContent = Swal.getTimerLeft()
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval);
                    this.mostrarAbrirCaja = false;
                }
                }).then((result) => {
                if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    console.log('I was closed by the timer')
                }
                })
            })
        },

        registrarPago(){
            let URL = '/registrar-pago';
            
            this.pago.budget_id = this.presupuestoSeleccionado.id;
            axios.post(URL, this.pago).then((response) => {
                alert('Pago registrado');

                this.obtenerPresupuestos();
            }).catch((error) => {
                console.log(error.data)
            })
        },
    },
}

</script>