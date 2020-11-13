<style>
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

    table tr td input{
        border: none;
        background-color: transparent;
    }
    .contenedor-producto{
        border-bottom:none;
        padding-top: 8px;
        padding-bottom: 8px;
        height: 100%;
        margin-bottom: 0;
        font-size: 14px;
    }
    .contenedor-producto:hover{
        border-bottom:none; 
        padding-top: 8px;
        padding-bottom: 8px;
        background:#F2F2F2;
        cursor: pointer;
        margin-bottom: 0;
        font-size: 14px;
    }
</style>

<template>
    <section class="row">
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
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" @click="demo()">#</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Servicio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody v-if="inventarioLocal.length != 0">
                    <tr v-for="(item, index) in inventarioLocal" :key="index">
                        <th scope="row">{{ index }}</th>
                        <td>
                            <img :src="item.imagen" width="100px" alt="">
                        </td>
                        <td>{{ item.servicio }}</td>
                        <td><input style="background:#FBEE83; border-radius:3px;" v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" v-on:change="updateCantidad(index)" v-model="cantidadActualizada">
                        <span v-else v-on:click="editarCantidad(index, Object.keys(item))">{{ item.cantidad }}</span></td>
                        <td><input style="background:#FBEE83; border-radius:3px;" v-if="(item.precioUnitario == '') || (indice == index && key == 'precioUnitario')" v-on:change="updatePrecio(index)" v-model="cantidadActualizada">
                        <span v-else v-on:click="editarPrecio(index, Object.keys(item))">{{ item.precioUnitario | currency}}</span></td>
                        <td>
                           <button @click="eliminarProducto(index)">Eliminar</button> 
                        </td>
                    </tr>
                    <tr>
                    <td colspan="5"></td>
                    <td colspan="1" style="font-weight:bold">TOTAL: {{calcularTotalServicio | currency}}</td>
                    </tr>
                </tbody>
            </table>

            <button class="btn btn-sm btn-success" @click="guardarProductos()">Guardar</button>
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
    computed:{
        calcularTotalServicio: function(){
            //Arreglo javascript de objetos json
                let json = this.inventarioLocal;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += parseInt(data[x].cantidad*data[x].precioUnitario); // Ahora que es un objeto javascript, tiene propiedades
                }
                //alert(suma);
              
                return suma;
             }
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
         editarPrecio(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[5];
                    console.log(index);
                    console.log(key[4]);
                       
                },
        updatePrecio(index){
            let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
            producto.precioUnitario = this.cantidadActualizada;
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
            producto.cantidad=1;
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