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
            <div class="block">
                <div class="row">
                    <div class="col-md-6">
                        <buscador-component
                                    :limpiar="limpiar"
                                    placeholder="Buscar presupuesto"
                                    event-name="clientResults"
                                    :list="presupuestos"
                                    :keys="['nombre', 'email', 'telefono', 'apellidoPaterno' , 'apellidoMaterno']"
                                    
                                ></buscador-component>
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
            cantidadApertura: null,
            cantidadRealApertura: null,
        }
    },
    created(){
        this.obtenerSesion();
        this.obtenerPresupuestos();
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
        }
    },
    directives: {
        focus: {
            inserted: function (el) {
                el.focus()
            }
        }
    },
    methods: {
        obtenerSesion: function(){
            let URL = 'obtener-sesion-caja';

            axios.get(URL).then((response) => {
                this.sesion = response.data;
                this.habilitarCaja();
            })
        },

        obtenerPresupuestos: function(){
            let URL = 'caja/otener-presupuestos';

            axios.get(URL).then((response) => {
                this.presupuestos = response.data;
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
        }
    },
}
</script>

<style>

</style>