<template>
    <section>
        <div class="container p-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Servicio</label>
                        <input class="form-control" type="text" v-model="paquete.servicio">
                    </div>

                    <div class="form-group">
                        <label for="">Precio Unitario</label>
                        <input class="form-control" type="text" v-model="paquete.precioUnitario">
                    </div>

                    <div class="form-group">
                        <label for="">Precio Final</label>
                        <input class="form-control" type="text" v-model="paquete.precioFinal">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Precio Venta</label>
                        <input class="form-control" type="text" v-model="paquete.precioVenta">
                    </div>
                
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select class="form-control" name="" id="" v-model="paquete.categoria">
                            <option value="Mobiliario">Mobiliario</option>
                            <option value="Floristeria">Floristeria</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- SECTION 2 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <buscador-component
                                :limpiar="limpiar"
                                placeholder="Buscar Productos"
                                event-name="results"
                                :list="inventario"
                                :keys="['servicio', 'id', 'familia']"
                                class="form-control"
                            ></buscador-component>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Resultado Busqueda items -->
            <div class="row" v-if="results.length < inventario.length">
                <div v-if="results.length !== 0" class="col-md-4 resultadoInventario">
                    <div class="list-group" v-for="producto in results.slice(0,40)" :key="producto.id">
                        <div class="row contenedor-producto" style="cursor:auto;" >
                            <div class="col-md-3" >
                                <img class="img-fluid" style="margin-left:10px;" :src="producto.imagen" alt="">
                            </div>
                            <div class="col-md-7">
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">{{ producto.servicio }}</span></p>
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span>Precio: ${{ producto.precioUnitario }}</p>
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> Familia: {{ producto.familia }}</p>
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> Existencia: {{ producto.disponible }}</p>
                            </div>
                            <div  class="col-md-2" style="padding-top:15px"><i v-on:click="agregarProducto(producto)" style="color:#B2B2B2; cursor:pointer; font-size:26px" class="fa fa-plus-circle"></i></div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Servicio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Precio Final</th>
                                <th scope="col">Precio Venta</th>
                                <th scope="col">Precio Especial</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in paquete.inventories" :key="index">
                                <td>{{ item.servicio }}</td>
                                <td>{{ item.cantidad }}</td>
                                <td>{{ item.precioUnitario }}</td>
                                <td>{{ item.precioFinal }}</td>
                                <td>{{ item.precioVenta }}</td>
                                <td>{{ item.precioEspecial }}</td>
                                <td>{{ item.proveedor }}</td>
                                <td>
                                    <button @click="editarProducto(item, index)" class="btn btn-sm btn-info">Editar</button>
                                    <button @click="eliminarProducto(index)" class="btn btn-sm btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button @click="guardarPaquete()" class="btn btn-sm btn-success">Guardar</button>
                </div>
            </div>
        </div>

        <!-- Modal Editar Producto-->
        <div class="modal fade" id="editarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Servicio</label>
                                <input class="form-control" type="text" v-model="productoEditar.servicio">
                            </div>

                            <div class="form-group">
                                <label for="">Cantidad</label>
                                <input class="form-control" type="text" v-model="productoEditar.cantidad">
                            </div>

                            <div class="form-group">
                                <label for="">Precio Unitario</label>
                                <input class="form-control" type="text" v-model="productoEditar.precioUnitario">
                            </div>

                            <div class="form-group">
                                <label for="">Precio Final</label>
                                <input class="form-control" type="text" v-model="productoEditar.precioFinal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Precio Venta</label>
                                <input class="form-control" type="text" v-model="productoEditar.precioVenta">
                            </div>

                            <div class="form-group">
                                <label for="">Precio Especial</label>
                                <input class="form-control" type="text" v-model="productoEditar.precioEspecial">
                            </div>

                            <div class="form-group">
                                <label for="">Proveedor</label>
                                <input class="form-control" type="text" v-model="productoEditar.proveedor">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="cancelarEdicion" type="button" class="btn btn-secondary">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import BuscadorComponent from './BuscadorComponent.vue';

export default {
    components: {
        BuscadorComponent,
    },
    props: {
        paquete2: {
            type: Object,
            required: true,
        }
    },
    data(){
        return{
            paquete: '',
            productoEditar: '',
            historial: '',
            index: '',
            inventario: [],
            results: [],
            resultsPaquetes: [],
            limpiar: false,
        }
    },
    created(){
        this.$on('results', results => {
            this.results = results
        });
    },
    mounted(){
        this.paquete = this.paquete2
        this.obtenerInventario()
    },
    methods: {
        editarProducto: function(item, index){
            this.productoEditar = item
            this.index = index

            this.historial = JSON.parse( JSON.stringify( item ) );
            $('#editarProducto').modal('show')
        },

        cancelarEdicion: function(){
            this.paquete.inventories.splice(this.index, 1, this.historial)
            $('#editarProducto').modal('hide')
        },

        eliminarProducto: function(index){
            this.paquete.inventories.splice(index, 1) 
        },

        obtenerInventario(){
            let URL = '/obtener-inventario';
            axios.get(URL).then((response) => {
                this.inventario = response.data;
            }).catch((error) => {
                console.log(error.data);
            })
        },

        agregarProducto(producto){
            this.limpiar = true;
            this.paquete.inventories.push({
                'budget_pack_id': this.paquete.id,
                'imagen': 'https://www.salonlfc.com/wp-content/uploads/2018/01/image-not-found-1.png',
                'servicio': producto.servicio,
                'cantidad': '1',
                'precioUnitario': producto.precioUnitario,
                'precioFinal': producto.precioUnitario,
                'precioVenta': '',
                'proveedor': '',
                'precioEspecial': producto.precioUnitario,
            })

            this.paquete.inventories = this.paquete.inventories.reverse()
            
            setTimeout(() => {
                this.limpiar = false
            }, 1000);
        },

        guardarPaquete: function(){
            let URL = '/actualizar-paquete/' + this.paquete.id

            axios.put(URL, this.paquete).then((response) => {
                Swal.fire(
                    'Paquete guardado',
                    'El paquete ha sido editado',
                    'success'
                )
            }).catch((error) => {
                console.log(error.data)
            })
        }
    },
}
</script>

<style>

</style>