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
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Fecha de Ingreso</label>
                            <input type="date" class="form-control" v-model="alta.fechaIngreso">
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
                        <div class="form-group">
                            <label for="">Evento</label>
                            <input type="text" class="form-control" v-model="alta.budget_id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" @click="registrarAlta()" class="btn btn-primary">Guardar alta</button>
            </div>
        </div>
    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

export default {
    data(){
        return{
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
            }
        }
    },

    computed: {
        usuario: function(){
            return JSON.parse(user.content);
        },
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
                    this.tipo = e.target.dataset.tipo;
                    let id = e.target.dataset.id;
                    let URL = 'obtener-producto/' + id;

                    axios.get(URL).then((response) => {
                        this.producto = response.data;
                        
                    })
                });
            }
        }
    },

    methods: {
        registrarAlta: function(){
            let URL = 'registrar-alta';
            this.alta.producto = this.producto.id;
            this.alta.user_id = this.usuario.id;
            this.alta.tipo = this.tipo;

            axios.post(URL, this.alta).then((response) => {
                console.log('Alta registrada');
            }).catch((error) => {
                console.log(error.data);
            })
        }
    },
}
</script>

<style>

</style>