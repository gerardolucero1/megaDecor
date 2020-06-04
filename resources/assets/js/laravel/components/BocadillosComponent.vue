<style>

</style>

<template>
    <section class="container">
        <div id="contenedorGeneral">
        <div class="row">
            <div class="col-md-12" style="border-bottom:solid; padding-bottom:15px; border-color:gray; margin-bottom:10px">
                <table style="width:70%">
                    <tr>
                        <td># Personas<br><br><input v-model="personas" v-on:change="updatePersonas()" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"> X </td>
                        <td>Numero de bocadillos x persona <br><span style="font-style:italic"></span><br><input v-model="bocadillos" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"> = {{bocadillos*personas}} Pzs.</td>
                        <td>Servilleta (Papel)<br><span style="font-style:italic; font-size:10px;" >Precio Unitario ${{precioServilleta}} <i style="color:blue" v-on:click="updatePrecioServilleta()" class="fa fa-edit"></i></span><br><input v-model="servilleta" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                        <td>Plato Pastelero 7.5 pulgadas<br><span style="font-style:italic; font-size:10px;" >Precio Unitario ${{precioPlatoPastelero}} <i style="color:blue" v-on:click="updatePrecioPlato()" class="fa fa-edit"></i></span><br><input v-model="platoPastelero" style="width:100%; border:solid; border-width:1px; border-radius:5px; text-align:center; width:60px" type="text"></td>
                    </tr>
                </table>
                <table style="width:40%; margin-top:20px">
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <label for="">Buscadores de postres y bocadillos</label> <br>
            <buscador-component
                :limpiar="limpiar"
                placeholder="Buscar Postres"
                event-name="results"
                :list="inventario"
                :keys="['servicio', 'id', 'familia']"
            ></buscador-component> <i style="color:blue; margin-left:5px; margin-right:10px" class="fa fa-eye" data-toggle="modal" data-target="#catalogoPostres"></i>

            <buscador-component
                :limpiar="limpiar"
                placeholder="Buscar Bocadillos"
                event-name="results"
                :list="inventarioBotanas"
                :keys="['servicio', 'id', 'familia']"
            ></buscador-component> <i style="color:blue; margin-left:5px; margin-right:10px" class="fa fa-eye" data-toggle="modal" data-target="#catalogoBocadillos"></i>

            <div class="col-md-12">
            <!-- Resultado Busqueda items -->
            <div class="row" v-if="results.length < inventario.length">
                <div v-if="results.length !== 0" class="col-md-4 resultadoInventario">
                    <div class="list-group" v-for="producto in results.slice(0,40)" :key="producto.id">
                        <div v-on:click="agregarProducto(producto)" class="row contenedor-producto" style="cursor:auto;" >
                            <div class="col-md-3" >
                                <img class="img-fluid" style="margin-left:10px;" :src="producto.imagen" alt="">
                            </div>
                            <div class="col-md-9">
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">{{ producto.servicio }}</span></p>
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span>Precio: ${{ producto.precioUnitario }}</p>
                                <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> Familia: {{ producto.familia }}</p>
                            </div>
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

            </div>
            <div class="col-md-12">
                <table style="width:100%;">
                   
                   <tbody v-if="inventarioLocal.length != 0">
                        <tr style="background:blue; color:white;">
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Postre</th>
                        <th>Bocadillos x Paquete</th>
                        <th># Paquetes</th>
                        <th>Precio Paquete</th>
                        <th>Total bocadillos</th>
                        <th>Precio Total</th>
                    </tr>
                    <tr v-for="(item, index) in inventarioLocal" :key="index" style="border-bottom: solid; border-width: 1px;">
                        <th scope="row"><button @click="eliminarProducto(index)" style="background:red"><i class="fa fa-remove" style="color:white"></i></button> </th>
                        <td>
                            <img :src="item.imagen" width="60px" alt="">
                        </td>
                        <td>{{ item.servicio }}</td>
                        <td><input style="text-align:center; background:#FAE586; border-radius:3px; width:100%; margin-top:-15px" v-if="(item.cantidad == '') || (indice == index && key == 'cantidad')" v-on:change="updateCantidad(index)" v-model="cantidadActualizada">
                        <p style="text-align:center; background:#FAE586; border-radius:3px; width:100%" v-else v-on:click="editarCantidad(index, Object.keys(item))">{{ item.cantidad }}</p>
                        <label><input style="display:none" type="checkbox">Precio por bocadillo</label></td>

                        <td><input style="text-align:center; background:#FAE586; border-radius:3px; width:100%; margin-top:-15px" v-if="(item.cantidadPaquetes == '') || (indice == index && key == 'servicio')" v-on:change="updateCantidadPaquetes(index)" v-model="cantidadPaquetesActualizada">
                        <p style="text-align:center; background:#FAE586; border-radius:3px; width:100%" v-else v-on:click="editarCantidadPaquetes(index, Object.keys(item))">{{ item.cantidadPaquetes }}</p>
                        <label><input style="display:none" type="checkbox">Precio Por paquete</label></td>

                        <td><input style="text-align:center; background:#FAE586; border-radius:3px; width:100%; margin-top:-15px" v-if="(item.precioUnitario == '') || (indice == index && key == 'precioUnitario')" v-on:change="updatePrecioUnitario(index)" v-model="precioActualizado">
                        <p style="text-align:center; background:#FAE586; border-radius:3px; width:100%" v-else v-on:click="editarPrecio(index, Object.keys(item))">{{ item.precioUnitario | currency}}</p></td>
                        
                        
                        <td>
                            <p style="width:100%; font-weight:bold; text-align:center">{{item.cantidadTotal}}</p>
                        </td>
                        <td>
                            <p style="width:100%; font-weight:bold; text-align:center">{{item.precioTotal | currency}}</p>
                           
                           
                        </td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="background:red; color:white; text-align:center">{{calcularTotalBocadillos}}</td>
                        <td style="background:red; color:white; text-align:center">{{calcularTotalCostoBocadillos| currency}}</td>
                    </tr>
                    <tr></tr>
                </tbody>
                </table>
                <div>
                    <div class="row">
                    <div class="col-md-4">
                    <table style="width:300px">
                        <tr style="border-bottom:solid; border-weight:1px">
                            <td><p style="margin:0; padding:0">Bocadillos:</p></td>
                            <td>{{calcularTotalCostoBocadillos | currency}}</td>
                        </tr>
                        <tr style="border-bottom:solid; border-weight:1px">
                            <td><p style="margin:0; padding:0">Servilletas: </p></td>
                            <td>{{precioServilleta*servilleta | currency}}</td>
                        </tr>
                        <tr style="border-bottom:solid; border-weight:1px">
                            <td><p style="margin:0; padding:0">Platos:</p></td>
                            <td>{{precioPlatoPastelero*platoPastelero | currency}}</td>
                        </tr>
                        <tr style="border-bottom:solid; border-weight:1px">
                            <td><label>Decoración: </label></td>
                            <td>$<input v-model="decoracion" style="width:100px"><input type="checkbox"></td>
                        </tr>
                        <tr style="border-bottom:solid; border-weight:1px">
                            <td><label>Descuento: </label></td>
                            <td>$<input style="width:100px" v-model="descuento"></td>
                        </tr>
                        <tr style="border-bottom:solid; border-weight:1px">
                            <td><label style="font-weight:bold">Subtotal: </label></td>
                            <td>{{calcularSubtotal | currency}}</td>
                        </tr>
                         <tr style="border-bottom:solid; border-weight:1px">
                            <td><div  style="font-size:16px; font-weight:bold"><label>TOTAL: </label></div></td>
                            <td>$<input style="width:100px" v-model="totalFinal"></td>
                        </tr>
                         <tr style="border-bottom:solid; border-weight:1px">
                            <td><div style="font-size:16px; font-weight:bold"><label>TOTAL AJUSTADO: </label></div></td>
                            <td>$<input style="width:100px" v-model="totalFinalAjustado"></td>
                        </tr>
                    </table>
                    </div>
                    <div class="col-md-8" style="padding-top:40px">
                        <p style="font-weight:bold">Comentarios</p>
                        <textarea v-model="comentarios" style="width:100%"></textarea>
                    </div>
                    </div>
                    
 
                    <div style=" padding-top:10px; positio: relative">
                    <a style="display:none" target="_blank" :href="'mesa-bocadillos/pdf/'" class="btn btn-primary" disabled><i class="si si-printer"></i> Imprimir cliente</a>
                    <a  style="display:none" target="_blank" :href="'mesa-bocadillos/pdf/'" class="btn btn-primary"><i class="si si-printer" disabled></i> Imprimir interna</a>
                    <button @click="printDiv('contenedorGeneral')" class="btn btn-primary"><i class="si si-printer"></i> Imprimir</button>
                    <button @click="guardarMesa1()" class="btn btn-success">Guardar</button>
                    <div style="color:red; position:absolute; z-index:10; right:30px; font-size:20px; top:-50px">#bocadillos Restantes {{bocadillosRestantes}}</div>
                    </div>

                </div>
            </div>
            
        </div>

        <div class="modal fade" id="catalogoBocadillos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Catalogo Bocadillos</h5>
                    <button type="button" class="close" onClick="$('#catalogoBocadillos').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  v-for="(item, index) in inventarioBotanas" :key="index">
                                        <td><img :src="item.imagen" style="width:70px"></td>
                                        <td>{{item.servicio}}</td>
                                        <td>{{item.precioUnitario | currency}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#catalogoBocadillos').modal('hide')">Close</button>
                </div>
                </div>
            </div>
        </div>


         <div class="modal fade" id="catalogoPostres" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Catalogo Postres</h5>
                    <button type="button" class="close" onClick="$('#catalogoPostres').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  v-for="(item, index) in inventario" :key="index">
                                        <td><img :src="item.imagen" style="width:70px"></td>
                                        <td>{{item.servicio}}</td>
                                        <td>{{item.precioUnitario | currency}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#catalogoPostres').modal('hide')">Close</button>
                </div>
                </div>
            </div>
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
            inventarioBotanas: [],
            inventarioLocal: [],
            totalFinalAjustado:0,
            cantidadActualizada:1,
            cantidadPaquetesActualizada:1,
            precioActualizado:1,
            decoracion:0,
            descuento:0,
            indice:'',
            key:'',
            personas:0,
            bocadillos:0,
            platoPastelero:0,
            precioPlatoPastelero:3,
            precioServilleta:1,
            servilleta:0,
            totalBocadillos:0,
            bocadillosRestantes:0,
            totalPrecioBocadillos:0,
            totalFinal:0,
            comentarios:'',
        }
    },

    created(){
        this.obtenerInventarioPostres()
        this.obtenerInventarioBotanas()
        this.obtenerNesteds()

        this.$on('results', results => {
            this.results = results
        })
    },
    computed: {
        calcularSubtotal: function(){
            
           let  total = parseInt(this.platoPastelero*this.precioPlatoPastelero)+parseInt(this.servilleta*this.precioServilleta)+parseInt(this.totalPrecioBocadillos)-parseInt(this.descuento)+parseInt(this.decoracion);
           this.totalFinal=total;
           this.totalAjustado=total;
           return total;
        },
       

        calcularTotalBocadillos: function(){
            //Arreglo javascript de objetos json
                let json = this.inventarioLocal;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += parseInt(data[x].cantidadTotal); // Ahora que es un objeto javascript, tiene propiedades
                }

                this.totalBocadillos = suma;
                this.bocadillosRestantes = parseInt(this.personas*this.bocadillos)-parseInt(suma);
                return suma;
            
        },
        calcularTotalCostoBocadillos: function(){
            //Arreglo javascript de objetos json
                let json = this.inventarioLocal;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += parseInt(data[x].precioTotal); // Ahora que es un objeto javascript, tiene propiedades
                }

                this.totalPrecioBocadillos = suma;
                return suma;
            
        },
    },
    methods: {
        editarCantidad(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[1];
                    console.log(index);
                    //alert(key[1]);
                       
                },
        editarPrecio(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[3];
                    console.log(index);
                    //alert(key[3]);     
                },
        guardarMesa1(){
            this.$emit('guardarMesa', this.totalFinalAjustado, this.inventarioLocal, this.comentarios);
        },
        editarCalculoPrecio(index, key){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                if(producto.calculoPrecio==2){
                    producto.calculoPrecio=1;
                    producto.precioTotal = producto.cantidadPaquetes*producto.precioUnitario;
                }else{
                    producto.calculoPrecio=2;
                    producto.precioTotal = producto.cantidadPaquetes*producto.precioUnitario;
                }   
                        
                },
        
        editarCantidadPaquetes(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[2];
                    console.log(index);
                    //alert(key[2]);
                       
                },

     printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
},
        updatePersonas(){
            this.servilleta = this.personas;
            this.platoPastelero = this.personas;
            this.bocadillosRestantes = this.personas*this.bocadillos;
        },

        updateCantidad(index){
            let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
            producto.cantidad = this.cantidadActualizada;
            producto.cantidadTotal = producto.cantidad*producto.cantidadPaquetes;
            producto.precioTotal = producto.cantidadPaquetes*producto.precioUnitario;
            
            this.cantidadActualizada = '';
            this.key= '';
        },

        updatePrecioUnitario(index){
            let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    
                    
            producto.precioUnitario = this.precioActualizado;
            producto.precioTotal = producto.cantidadPaquetes*producto.precioUnitario;
            
            this.precioActualizado = '';
            this.key= '';
        },

        updateCantidadPaquetes(index){
            let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
            producto.cantidadPaquetes = this.cantidadPaquetesActualizada;
            producto.cantidadTotal = producto.cantidad*producto.cantidadPaquetes;
            producto.precioTotal = producto.cantidadPaquetes*producto.precioUnitario;
            
            this.cantidadPaquetesActualizada = '';
            this.key= '';
        },
        obtenerInventarioPostres(){
            let URL = '/obtener-inventario-postres';

            axios.get(URL).then((response) => {
                this.inventario = response.data;
            }).catch((error) => {
                console.log(error.data);
            });
        
        },
        updatePrecioPlato(){
            let precioActualizado = prompt('Ingrear costo de plato pastelero');
            this.precioPlatoPastelero = precioActualizado;
        },
        updatePrecioServilleta(){
            let precioActualizado = prompt('Ingrear costo de Servilleta');
            this.precioServilleta = precioActualizado;
        },

        obtenerInventarioBotanas(){
            let URL = '/obtener-inventario-botanas';

            axios.get(URL).then((response) => {
                this.inventarioBotanas = response.data;
            }).catch((error) => {
                console.log(error.data);
            });
        
        },

        

        obtenerInventarioBocadillos(){
            let URL = '/obtener-inventarioBocadillos';

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
            producto.cantidadPaquetes = 1;
            producto.cantidad = producto.pzsPaquete;
            producto.precioTotal = producto.precioUnitario*1;
            producto.cantidadTotal = 1;
            producto.calculoPrecio = 1;
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