<style>

</style>

<template>
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <table style="width:100%">
                    <tr>
                        <td># Personas</td>
                        <td><input v-model="personas" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Numero de bocadillos</td>
                        <td><input v-model="bocadillos" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Servilleta</td>
                        <td><input v-model="servilleta" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Plato Pastelero</td>
                        <td><input v-model="platoPastelero" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                    </tr>
                </table>
                <table style="width:40%; margin-top:20px">
                    <tr>
                        <td>#bocadillos</td>
                        <td><input type="text" :value="personas*bocadillos"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-7">
            <div class="col-md-12">
            <buscador-component
                :limpiar="limpiar"
                placeholder="Buscar Productos"
                event-name="results"
                :list="inventario"
                :keys="['servicio', 'id', 'familia']"
            ></buscador-component>

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
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> En Bodega: {{ producto.cantidad }} <span>Exhibición: {{producto.exhibicion}}</span></p>
                            </div>
                            <div  class="col-md-2" style="padding-top:15px"><i v-on:click="agregarProducto(producto)" style="color:#B2B2B2; cursor:pointer; font-size:26px" class="fa fa-plus-circle"></i></div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover" style="font-size:12px">
                <thead>
                    <tr style="color:white; background:#FE6E4F">
                        <th scope="col" @click="demo()">#</th>
                        <th scope="col">IMAGEN</th>
                        <th scope="col">POSTRE</th>
                        <th scope="col">BOCADILLOS POR MESA</th>
                        <th scope="col">PRECIO PAQUETE</th>
                        <th scope="col">#</th>
                        
                    </tr>
                </thead>
                <tbody v-if="inventarioLocal.length != 0">
                    <tr v-for="(item, index) in inventarioLocal" :key="index">
                        <th scope="row">{{ index }}</th>
                        <td>
                            <img :src="item.imagen" width="60px" alt="">
                        </td>
                        <td>{{ item.servicio }}</td>
                        <td><input v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" v-on:change="updateCantidad(index)" v-model="cantidadActualizada">
                        <span v-else v-on:click="editarCantidad(index, Object.keys(item))">{{ item.cantidad }}</span></td>
                        
                        <td><input v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" v-on:change="updateCantidad(index)" v-model="cantidadActualizada">
                        <span v-else v-on:click="editarCantidad(index, Object.keys(item))">{{ item.cantidad }}</span></td>
                        <td>
                           <button @click="eliminarProducto(index)" style="background:red"><i class="fa fa-remove" style="color:white"></i></button> 
                        </td>
                    </tr>
                </tbody>
            </table>


                
                <table style="width:50%; font-weight:bold">
                <tr>
                <td>bocadillos: </td>
                <td>$0.00 </td>
                </tr>
                <tr>
                <td>Servilletas: </td>
                <td>$0.00 </td>
                </tr>
                <tr>
                <td>Platos (desechables): </td>
                <td>$0.00 </td>
                </tr>
                <tr>
                <td style="font-weight:bold">Descuento General: </td>
                <td><input type="text" value="0"> </td>
                </tr>
                
                    
                </table>
            </div>
            <div class="col-md-5">
                <table style="width:100%; text-align:center; font-size:12px; border:solid">
                    <tr  style="color:white; background:#FE6E4F">
                        <th>CANT</th>
                        <th>TOTAL DE BOCADILLOS</th>
                        <th>PRECIO PAQUETE</th>
                    </tr>
                    <tr>
                        <td><input type="text" v-model="cantBolasNuez" style="text-align:center"></td>
                        <td><input type="text" :value="cantBolasNuez*bolitasNuez" style="text-align:center"></td>
                        <td><input type="text" :value="cantBolasNuez*bolitasNuez*precioBolasNuez" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td><input type="text" v-model="cantVolovan" style="text-align:center"></td>
                        <td><input type="text" :value="cantVolovan*volovan" style="text-align:center"></td>
                        <td><input type="text" :value="cantVolovan*volovan*precioVolovan" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td><input type="text" v-model="cantBrochetasQueso" style="text-align:center"></td>
                        <td><input type="text" :value="cantBrochetasQueso*brochetasQueso" style="text-align:center"></td>
                        <td><input type="text" :value="cantBrochetasQueso*brochetasQueso*precioBrochetasQueso" style="text-align:center"></td>
                    </tr>
                    <tr style="background:orange; color:white">
                        <td>TOTAL:</td>
                        <td><input type="text" style="text-align:center" :value="(cantBrochetasQueso*brochetasQueso)+(cantVolovan*volovan)+(cantBolasNuez*bolitasNuez)"></td>
                        <td><input type="text" style="text-align:center" :value="(cantBrochetasQueso*brochetasQueso*precioBrochetasQueso)+(cantVolovan*volovan*precioVolovan)+(cantBolasNuez*bolitasNuez*precioBolasNuez)"></td>
                    </tr>
                </table>
            
            </div>
        </div>
    </section>
</template>

<script>
import BuscadorComponent from './BuscadorComponent.vue';

export default {
    name: 'Nested',

    props: [
        'producto'
    ],

    components: {
        BuscadorComponent,
    },

    data(){
        return{
            //Buscador
            limpiar: false,
            results: [],

            //Inventario de productos
            inventario: [],
            inventarioLocal: [],
            cantidadActualizada:1,
            indice:'',
            key:'',
        }
    },

    created(){
        this.obtenerInventario()
        this.obtenerNesteds()

        this.$on('results', results => {
            this.results = results
        })
    },

    methods: {
        editarCantidad(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[1];
                    console.log(index);
                    console.log(key[1]);
                       
                },
        updateCantidad(index){
            let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
            producto.cantidad = this.cantidadActualizada;
            //alert(producto.servicio);
            this.cantidadActualizada = '';
            this.key= '';
        },
        obtenerInventario(){
            let URL = '/obtener-inventario';

            axios.get(URL).then((response) => {
                this.inventario = response.data;
            }).catch((error) => {
                console.log(error.data);
            });
        
        },

        obtenerNesteds(){
            let URL = '/obtener-nesteds/' + this.producto

            axios.get(URL).then((response) => {
                response.data.forEach((doc) => {
                    this.inventarioLocal.push(doc)
                })
            }).catch((error) => {

            })
        },

        agregarProducto(producto){
            console.log(producto)

            this.limpiar = true;
            this.inventarioLocal.push(producto);

            setTimeout(() => {
                this.limpiar = false;
            }, 1000);
        },

        eliminarProducto(index){
            this.inventarioLocal.splice(index, 1)
        },

        guardarProductos(){
            let URL = '/inventario/anidados/' + this.producto
            axios.post(URL, this.inventarioLocal).then((response => {
                    
                Swal.fire(
                    'Guardado con exito!',
                    'Se han guardado los productos del servicio con exito',
                    'success'
                )

            })).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>