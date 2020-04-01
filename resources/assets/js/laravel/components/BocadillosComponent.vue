<style>

</style>

<template>
    <section class="container">
        <div class="row">
            <div class="col-md-12" style="border-bottom:solid; padding-bottom:15px; border-color:gray; margin-bottom:10px">
                <table style="width:100%">
                    <tr>
                        <td># Personas</td>
                        <td><input v-model="personas" v-on:change="updatePersonas()" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Numero de bocadillos <br> {{personas*bocadillos}}</td>
                        <td><input v-model="bocadillos" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Servilleta (Papel)</td>
                        <td><input v-model="servilleta" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Plato Pastelero 7.5 pulgadas<br><span style="font-style:italic; font-size:10px;" >Precio Unitario $3</span></td>
                        <td><input v-model="platoPastelero" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                    </tr>
                </table>
                <table style="width:40%; margin-top:20px">
                    <tr>
                        <td>#bocadillos Restantes</td>
                        <td><input style="color:red" type="text" :value="personas*bocadillos"></td>
                    </tr>
                </table>
                 <buscador-component
                :limpiar="limpiar"
                placeholder="Buscar Productos"
                event-name="results"
                :list="inventario"
                :keys="['servicio', 'id', 'familia']"
            ></buscador-component>
            </div>
            <div class="col-md-7">
           
            <div class="col-md-12">
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
                            </div>
                            <div  class="col-md-2" style="padding-top:15px"><i v-on:click="agregarProducto(producto)" style="color:#B2B2B2; cursor:pointer; font-size:26px" class="fa fa-plus-circle"></i></div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover" style="font-size:12px">
                <thead>
                    <tr style="color:white; background:blue">
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
                        
                        <td><input v-if="(item.precioUnitario == '') || (indice == index && key == 'precioUnitario')" v-on:change="updatePrecio(index)" v-model="precioUnitario">
                        <span v-else v-on:click="editarPrecio(index, Object.keys(item))">${{ item.precioUnitario }}</span></td>
                        <td>
                           <button @click="eliminarProducto(index)" style="background:red"><i class="fa fa-remove" style="color:white"></i></button> 
                        </td>
                    </tr>
                </tbody>
            </table>


                
                <table style="width:50%; font-weight:bold">
                <tr>
                <td>bocadillos: </td>
                <td>{{calcularTotalBocadillos | currency}} </td>
                </tr>
                <tr>
                <td>Servilletas (Papel): </td>
                <td>{{servilleta*precioServilleta | currency}} </td>
                </tr>
                <tr>
                <td>Platos: </td>
                <td>{{platoPastelero*precioPlatoPastelero | currency}}</td>
                </tr>
                <tr>
                <td style="font-weight:bold">Decoracion: $</td>
                <td><input type="text" value="0"> </td>
                </tr>
                <tr>
                <td style="font-weight:bold">Subtotal: $</td>
                <td>{{calcularSubtotal | currency}}</td>
                </tr>
                <tr>
                <td style="font-weight:bold">Total: $</td>
                <td><input type="text" value="0"> </td>
                </tr>
                
                    
                </table>
            </div>
            <div class="col-md-5">
                
                <table class="table table-hover" style="font-size:12px">
                <thead>
                    <tr style="color:white; background:blue">
                        <th scope="col" @click="demo()">#</th>
                        <th scope="col">CANT</th>
                        <th scope="col">TOTAL DE BOCADILLOS</th>
                        <th scope="col">PRECIO PAQUETE</th>
                    </tr>
                </thead>
                <tbody v-if="inventarioLocal.length != 0">
                    <tr v-for="(item, index) in inventarioLocal" :key="index" style="text-align:center">
                        <th scope="row">{{ index }}</th>
                        <td><input v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" disabled v-on:change="updateCantidad(index)" v-model="cantidadActualizada">
                        <span v-else>{{ item.cantidadTotal }}</span></td>
                        
                        <td><input v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" v-on:change="updateCantidad(index)" v-model="totalBocadillos">
                        <span v-else>{{ item.cantidad }}</span></td>
                        
                         <td><input v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" v-on:change="updateCantidad(index)" v-model="precioPaquete">
                        <span v-else>${{ item.precioTotal }}</span></td>
                        
                    </tr>
                    <tr style="text-align:center; color:white; background:blue; font-weight:bold">
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    </tr>
                </tbody>
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
            personas:0,
            bocadillos:0,
            platoPastelero:0,
            precioPlatoPastelero:3,
            precioServilleta:1,
            servilleta:0,
            totalBocadillos:0,
        }
    },

    created(){
        this.obtenerInventario()
        this.obtenerNesteds()

        this.$on('results', results => {
            this.results = results
        })
    },
    computed: {
        calcularSubtotal: function(){
           let  total = (this.platoPastelero*this.precioPlatoPastelero)+(this.servilleta*precioServilleta);
           return total;
        },
        calcularTotalBocadillos: function(){
            let total=0;
                this.inventarioLocal.forEach(function(element){
                    total = parseInt(total + (element.cantidadTotal));
                })

                return total;
            
        },
    },
    methods: {
        editarCantidad(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[1];
                    console.log(index);
                    console.log(key[1]);
                       
                },
        updatePersonas(){
            this.servilleta = this.personas;
            this.platoPastelero = this.personas;
        },
        updateCantidad(index){
            let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
            producto.cantidad = this.cantidadActualizada;
            producto.cantidadTotal = this.cantidadActualizada*this.personas;
            producto.precioTotal = producto.precioUnitario*producto.cantidadTotal;
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