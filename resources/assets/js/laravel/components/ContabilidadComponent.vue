<template>
    <section class="container">
        <div class="row">
            <div class="col-md-6">
                <a class="block" href="#">
                    <div class="block-content block-content-full">
                        <div class="text-right">
                            <i class="si si-wallet fa-2x text-body-bg-dark"></i>
                        </div>
                        <div class="row pt-10 pb-30 text-center">
                            <div class="col-6 border-r">
                                <div class="font-size-h3 font-w600">
                                    <span>{{ sumarPagos | currency }}</span><br>
                                    <span style="font-size:14px; line-height: 10px;">Egresos: {{ sumarEgresos | currency }}</span>
                                </div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Ingresos del dia</div><br>
                                <button class="btn btn-sm btn-success" style="">Nuevo Ingreso</button> <button class="btn btn-sm btn-danger" style="">Nuevo Egreso</button>
                                
                            </div>
                            <div class="col-6">
                                <div class="font-size-h3 font-w600">{{ sumarTotalCaja | currency }}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-muted"><br>Total en caja</div>
                                <button class="btn btn-sm btn-success" style="">Corte de caja</button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a class="block" href="#">
                    <div class="block-content block-content-full">
                        <div class="text-right">
                            <i class="si si-wallet fa-2x text-body-bg-dark"></i>
                        </div>
                        <div class="row pt-10 pb-30 text-left">
                            <div class="col-6  border-r">
                                <p style="font-weight: bold;">Ingresos: </p>
                                <ul style="font-size: 12px;">
                                    <li v-for="(item, index) in pagos" :key="index">Abono Contrato {{ item.budget.folio }} - {{ item.amount | currency }}</li>
                                    <li v-for="(item, index) in otrosPagos" :key="index" v-if="item.tipo == 'INGRESO'">
                                        Pago por {{ item.motivo }} - {{ item.cantidad | currency }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <p style="font-weight: bold;">Ingresos: </p>
                                <ul style="font-size: 12px;">
                                    <li v-for="(item, index) in otrosPagos" :key="index" v-if="item.tipo == 'EGRESO'">
                                        Pago {{ item.motivo }} - {{ item.cantidad | currency }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return{
            pagos: '',
            otrosPagos: '',
            sesion: '',
        }
    },

    mounted(){
        this.obtenerPagos();
    },

    computed: {
        sumarPagos: function(){
            let suma = 0;
            if(this.pagos.length != 0){
                this.pagos.forEach((element) => {
                suma += element.amount;
                })
            }

            if(this.otrosPagos.length != 0){
                this.otrosPagos.forEach((element) => {
                    if(element.tipo == 'INGRESO'){
                        suma += element.cantidad;
                    }
                })
            }

            return suma;
        },

        sumarEgresos: function(){
            let suma = 0;
            if(this.otrosPagos.length != 0){
                this.otrosPagos.forEach((element) => {
                    if(element.tipo == 'EGRESO'){
                        suma += element.cantidad;
                    }
                })
            }

            return suma;
        },

        sumarTotalCaja: function(){
            let suma = 0;
            if(this.sesion.length != 0){
                suma = this.sumarPagos + this.sesion.cantidadRealApertura;
            }

            return suma;
        }
    },

    methods: {
        obtenerPagos: function(){
            let URL = 'contabilidad/pagos';

            axios.get(URL).then((response) => {
                this.pagos = response.data[0];
                this.otrosPagos = response.data[1];
                this.sesion = response.data[2];
            })
        },
    },
}
</script>

<style>

</style>