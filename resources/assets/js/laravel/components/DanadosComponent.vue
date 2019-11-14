<template>
    <section class="container" v-if="inventario.length != 0">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Imagen</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad saliente</th>
                            <th scope="col">Faltante</th>
                            <th scope="col">Dañados</th>
                            <th scope="col">Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in inventario[0]" :key="index">
                            <th>
                                <img :src="item.imagen" alt="" width="100px">
                            </th>
                            <th>{{ item.servicio }}</th>
                            <td>{{ item.cantidad }}</td>
                            <td>
                                <input type="text" v-model="item.faltante" class="form-comtrol">
                            </td>
                            <td>
                                <input type="text" v-model="item.danado" class="form-comtrol">
                            </td>
                            <td>
                                <textarea v-model="item.descripcion"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <h3>Paquetes</h3>
        <div class="row">
            <div class="col-md-12" v-for="(item, index) in inventario[1]" :key="index">
                <h5>{{ item.servicio }}</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Imagen</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad saliente</th>
                            <th scope="col">Faltante</th>
                            <th scope="col">Dañados</th>
                            <th scope="col">Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(element, index) in item.inventories" :key="index">
                            <th>
                                <img :src="element.imagen" alt="" width="100px">
                            </th>
                            <th>{{ element.servicio }}</th>
                            <td>{{ element.cantidad }}</td>
                            <td>
                                <input type="text" v-model="element.faltante" class="form-comtrol">
                            </td>
                            <td>
                                <input type="text" v-model="element.danado" class="form-comtrol">
                            </td>
                            <td>
                                <textarea v-model="element.descripcion"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" @click="guardarRegistro">Guardar cambios</button>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return{
            inventario: [],
        }
    },
    mounted(){
        let buttons = document.getElementsByClassName('danados')
        let ArrayButtons = Array.from(buttons);
        
        if(ArrayButtons.length != 0){
            for (var i = 0; i < ArrayButtons.length; i++) {
                ArrayButtons[i].addEventListener('click', (e) => {
                    let id = e.target.dataset.id
                    let URL = '/obtener-inventario-danados/' + id

                    axios.get(URL).then((response) => {
                        this.inventario = response.data
                        this.agregarPropiedad()
                    })
                });
            }
        }
    },
    methods: {
        agregarPropiedad: function(){
            this.inventario[0].forEach((element) => {
                Object.defineProperty(element, 'faltante', {
                    enumerable: true,
                    configurable: true,
                    writable: true,
                    value: 0,
                })

                Object.defineProperty(element, 'danado', {
                    enumerable: true,
                    configurable: true,
                    writable: true,
                    value: 0,
                })

                Object.defineProperty(element, 'descripcion', {
                    enumerable: true,
                    configurable: true,
                    writable: true,
                    value: '',
                })
            })

            this.inventario[1].forEach((element) => {
                element.inventories.forEach((item) => {
                    Object.defineProperty(item, 'faltante', {
                        enumerable: true,
                        configurable: true,
                        writable: true,
                        value: 0,
                    })

                    Object.defineProperty(item, 'danado', {
                        enumerable: true,
                        configurable: true,
                        writable: true,
                        value: 0,
                    })

                    Object.defineProperty(item, 'descripcion', {
                        enumerable: true,
                        configurable: true,
                        writable: true,
                        value: '',
                    })
                })
            })
        },

        guardarRegistro: function(){
            let URL = '/registrar-faltante'

            axios.post(URL, this.inventario).then((response) => {
                alert('Baja registrada')
            })
        }
    }
}
</script>

<style>

</style>