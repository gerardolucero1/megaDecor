<style>
@media print{
  .oculto-impresion, .oculto-impresion *{
    display: none !important;
  }
}
</style>

<template>
    <section class="container" id="contenedorGeneral2">
        <div id="contenedorGeneral">
        <div class="row">
            <div class="col-md-12" style="border-bottom:solid; padding-bottom:15px; border-color:gray; margin-bottom:10px">
                <div class="row">
                    <div class="col-md-8">
                <table style="width:70%: background:#">
                    <tr>
                        <td style="font-weight:bold; text-align:right">Gasto Flete:</td>
                        <td style="width:100px; padding-left:20px">{{gastoFlete | currency}}</td>
                        <td style="font-weight:bold; text-align:right">Gasto Viaticos:</td>
                        <td style="width:100px; padding-left:20px">{{gastoViaticos | currency}}</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold; text-align:right">Gasto Horas Viaje:</td>
                        <td style="width:100px; padding-left:20px">{{gastoHorasViaje | currency}}</td>
                        <td style="font-weight:bold; text-align:right">Gasto Casetas:</td>
                        <td style="width:100px; padding-left:20px">{{gastoCasetas | currency}}</td>
                    </tr>
                    <tr>
                        <td colspan="1"></td>
                        <th colspan="3"><p style="font-weight:bold; font-size:30px">TOTAL:{{calcularTotalGeneral | currency}}</p></th>
                    </tr>
                </table>
                    </div>
                    <div class="col-md-4" style="margin-top:-50px">
                        <input type="text" style="display:none;border:none; font-weight:bold; font-size:18px; text-align:right;" value="NM">
                        <input type="text" value="Cliente" style="display:none;border:none; font-weight:bold; font-size:18px; text-align:right"><br>
                        <label for="" style="width:100%; text-align:right">Fecha: {{fechaActual}}</label>
                        <p style="color:blue: cursor:pointer" data-toggle="modal" data-target="#agregarVehiculo">Administrar Vehiculos y Casetas <i class="fa fa-edit"></i></p>
                         <p style="color:blue: cursor:pointer" v-on:click="updatePrecioGasolina()">Precio Gasolina: {{costoGasolina | currency}} <i class="fa fa-edit"></i></p>
                         <button class="btn btn-primary oculto-impresion" v-on:click="printDiv(contenedorGeneral2)"><i class="fa fa-print"></i> Imprimir</button>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
             <table style="width:100%">
                 <tr style="text-align:center; background:#252EEE; color:white">
                     <th style="padding:3px;">Vehiculo</th>
                     <th style="padding:3px;">KM DESTINO</th>
                     <th style="padding:3px;">(/)</th>
                     <th style="padding:3px;">REND. AUTO</th>
                     <th style="padding:3px;">=</th>
                     <th style="padding:3px;">Lts x Vuelta</th>
                     <th style="padding:3px;">X</th>
                     <th style="padding:3px;">#VUELTAS</th>
                     <th style="padding:3px;">=</th>
                     <th style="padding:3px;">Lts Total</th>
                     <th style="padding:3px;">x</th>
                     <th style="padding:3px;">$GASOLINA</th>
                     <th style="padding:3px;">=</th>
                     <th style="padding:3px;">TOTAL</th>
                 </tr>

                 <tr v-for="(item, index) in vehiculos" :key="index" style="text-align:center; border-bottom:solid; border-weight:1px;">
                     <td>{{item.nombre}}</td>
                     <td><input style="border-color:red; text-align:center" type="text" v-if="(item.cantidadKm == '') || (indice == index && key == 'kmDestino')" v-on:change="updateCantidadKm(index)" v-model="cantidadKmActualizada">
                         <label style="background:#FEEE7C; border-radius:2px; min-width:80px" v-else v-on:click="editarCantidadKm(index, Object.keys(item))">{{item.kmDestino}}</label></td>
                     <td>(/)</td>
                     <td>{{item.consumo}}</td>
                     <td>=</td>
                     <td>{{item.ltsXVuelta}}</td>
                     <td>X</td>
                     <td><input style="border-color:red; text-align:center" type="text" v-if="(item.vueltas == '') || (indice == index && key == 'vueltas')" v-on:change="updateCantidadVueltas(index)" v-model="cantidadKmActualizada">
                         <label style="background:#FEEE7C; border-radius:2px; min-width:80px" v-else v-on:click="editarCantidadVueltas(index, Object.keys(item))">{{item.vueltas}}</label></td>
                     <td>=</td>
                     <td>{{item.ltsTotal}}</td>
                     <td>X</td>
                     <td>{{costoGasolina | currency}}</td>
                     <td>=</td>
                     <td>{{item.ltsTotal*costoGasolina | currency}}</td>
                 </tr>

                 <tr>
                     <td colspan="10"></td>
                     <td colspan="2" style="text-align:right">TOTAL:</td>
                     <td colspan="2">{{calcularTotalFlete | currency}}</td>
                 </tr>
             </table>

            <label style="margin-top:40px">VIATICOS</label>
             <table style="width:60%; text-align:center; border:solid;">
                 <tr style="background:#252EEE; color:white">
                     <th>$ Presupuesto</th>
                     <th>X</th>
                     <th>No. Comidas</th>
                     <th>X</th>
                     <th>No. Personas</th>
                     <th>=</th>
                     <th>TOTAL</th>
                 </tr>
                 <tr style="border-bottom:solid">
                     <td><input style="text-align:center" v-model="presupuesto"></td>
                     <td>X</td>
                     <td><input style="text-align:center" v-model="comidas"></td>
                     <td>X</td>
                     <td><input style="text-align:center" v-model="personas"></td>
                     <td>=</td>
                     <td>{{calcularViaticos | currency}}</td>
                 </tr>
             </table>


             <label style="margin-top:40px">HORAS</label>
             <table style="width:60%; text-align:center; border:solid;">
                 <tr style="background:#252EEE; color:white">
                     <th>HORAS</th>
                     <th>X</th>
                     <th>VIAJES</th>
                     <th>X</th>
                     <th>NO. PERSONAS</th>
                     <th>X</th>
                     <th>$ HORA</th>
                     <th>=</th>
                     <th>TOTAL</th>
                 </tr>
                 <tr style="border-bottom:solid">
                     <td><input style="text-align:center" v-model="horas"></td>
                     <td>X</td>
                     <td><input style="text-align:center" v-model="viajes"></td>
                     <td>X</td>
                     <td><input style="text-align:center" v-model="personas"></td>
                     <td>X</td>
                     <td><input style="text-align:center" v-model="hora"></td>
                     <td>=</td>
                     <td>{{calcularHoras | currency}}</td>
                 </tr>
             </table>

             <label style="margin-top:40px">Casetas</label>
             <input type="text" style="border:solid; display:none;" placeholder="" v-model="gastoCasetas">
              

 <p style="background:orange; color:white; padding:4px; width:60%">Tomar en cuenta numero de ejes al consultar el costo de la caseta</p>
 <button v-on:click="obtenerCasetas()" class="btn btn-info oculto-impresion">Agregar Caseta</button>
 <div class="row">
 <div class="col-md-7">
               <table style="width:100%">
                 <tr style="text-align:center; background:#252EEE; color:white">
                     <th style="padding:3px;">Caseta</th>
                     <th style="padding:3px;">Costo</th>
                     <th style="padding:3px;">Vueltas</th>
                     <th style="padding:3px;">Total</th>
                     <th style="padding:3px;">Eliminar</th>
                 </tr>

               

                 <tr v-for="(item, index) in casetas" :key="index">
                     <td style="text-align:center"><input style="border-color:red; text-align:center" type="text" v-if="(item.name == '') || (indice == index && key == 'name')" v-on:change="updateNameCaseta(index)" v-model="cantidadCostoCasetaActualizada">
                          <label style="background:#FEEE7C; border-radius:2px; min-width:80px" v-else v-on:click="editarNameCaseta(index, Object.keys(item))">{{item.name}}</label></td>
                     <td style="text-align:center"><input style="border-color:red; text-align:center" type="text" v-if="(item.costo == '') || (indice == index && key == 'costo')" v-on:change="updateCostoCaseta(index)" v-model="cantidadCostoCasetaActualizada">
                         <label style="background:#FEEE7C; border-radius:2px; min-width:80px" v-else v-on:click="editarCostoCaseta(index, Object.keys(item))">{{item.costo}}</label></td>
                     <td style="text-align:center"><input style="border-color:red; text-align:center" type="text" v-if="(item.vueltas == '') || (indice == index && key == 'vueltas')" v-on:change="updateVueltasCaseta(index)" v-model="cantidadCostoCasetaActualizada">
                         <label style="background:#FEEE7C; border-radius:2px; min-width:80px" v-else v-on:click="editarVueltasCaseta(index, Object.keys(item))">{{item.vueltas}}</label></td>
                     <td style="text-align:center">{{item.vueltas*item.costo | currency}}</td>
                     <td style="text-align:center"> <div class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarCaseta(index)"><i class="fa fa-remove"></i></div></td>
                    
                 </tr>
                 <tr style="padding-top:6px">
                     <td colspan="3" style="text-align:right">TOTAL:</td>
                     <td style="font-size:15px; font-weight:bold">{{calcularTotalCasetas | currency}}</td>
                     </tr>

                
             </table>

              <button @click="guardarFlete()" style="margin-top:50px" class="btn btn-success">Guardar y Agregar a contrato</button>
             </div>
             <div class="col-md-5">
             <table style="width:100%">
             <tr style="text-align:center; background:#252EEE; color:white">
             <th>Nombre</th>
             <th>Costo</th>
             <th>Km</th>
             <th>Opciones</th>
             </tr>
             <tr v-for="(item, index) in casetas2" :key="index">
             <td>{{item.nombre}}</td>
             <td>${{item.consumo}}</td>
             <td>{{item.combustible}} km</td>
             <td><button class="btn btn-sm btn-danger" @click="eliminarVehiculo(item)">Eliminar</button></td>
             </tr>
             </table>

             
             </div>
</div>
            </div>
            
        </div>

        </div>

        <div class="modal fade" id="agregarVehiculo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border: solid; border-color: grey">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Registrar Nuevo Vehicul o Caseta</h5>
                <button type="button" class="close" onClick="$('#agregarVehiculo').modal('hide')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <label>Selecciona lo que quieres registrar</label>
                        <select v-model="tipoRegistro" class="form-control">
                        <option value="Vehiculo">Vehiculo</option>
                        <option value="Caseta">Caseta</option>
                        </select>
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="" class="form-control" aria-describedby="helpId" v-model="nuevoNombre">
                        <label v-if="tipoRegistro=='Vehiculo'">Rendimiento</label>
                        <label v-else>Costo</label>
                        <input type="text" name="rendimiento" id="inputRendimiento" class="form-control" placeholder="" aria-describedby="helpId" v-model="nuevoRendimiento">
                        <label v-if="tipoRegistro=='Caseta'">Kilometros</label>
                        <input v-if="tipoRegistro=='Caseta'" type="number" class="form-control" v-model="nuevoCombustible" placeholder="kilometros">
                        
                    </div>
                    <div class="col-md-3 text-center">
                        <button class="btn btn-sm btn-info" @click="agregarVehiculo()">Agregar</button>
                    </div>
                </div>
                
                <div class="row mt-4" v-if="vehiculos.length != 0">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Rendimiento</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in vehiculos" :key="index">
                                    <th scope="row">{{ item.id }}</th>
                                    <td>{{ item.nombre }}</td>
                                    <td>{{ item.consumo }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" @click="eliminarVehiculo(item)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                       


                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onClick="$('#agregarVehiculo').modal('hide')">Close</button>
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
        
    },

    data(){
        return{
           gastoFlete:0,
           gastoViaticos:0,
           nuevoCombustible: '',
           gastoHorasViaje:0,
           gastoCasetas:0,
           tipoRegistro:'',
           vehiculos:[],
           casetas:[],
           casetas2:[],
           cantidadKmActualizada:0,
           cantidadCostoCasetaActualizada:0,
           key:'',
           indice:'',
           costoGasolina:16.5,
           presupuesto:0,
           comidas:0,
           personas:0,
           horas:0,
           viajes:0,
           hora:0,
           totalFinal:0,
           
           
        



        }
    },

    created(){
        this.obtenerVehiculos();
        this.obtenerCasetas();
        this.obtenerCasetasBD();
      
    },
    computed: {
        fechaActual: function(){
            var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            var f=new Date();
           return (f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
        },
        calcularTotalGeneral: function(){
            var totGral=parseInt(this.gastoFlete)+parseInt(this.gastoViaticos)+parseInt(this.gastoHorasViaje)+parseInt(this.gastoCasetas)
             this.totalFinal=totGral;
             return totGral;
        },
        calcularHoras: function(){
            var horastotal=this.horas*this.viajes*this.personas*this.hora;
            this.gastoHorasViaje=horastotal;
             return horastotal;
        },

        calcularViaticos: function(){
            var viat=this.presupuesto*this.comidas*this.personas;
            this.gastoViaticos=viat;
             return viat;
        },
        calcularTotalFlete: function(){
            //Arreglo javascript de objetos json
                let json = this.vehiculos;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += parseInt(data[x].ltsTotal*this.costoGasolina); // Ahora que es un objeto javascript, tiene propiedades
                }
                //alert(suma);
                this.gastoFlete = suma;
                return suma;
             },
        calcularTotalCasetas: function(){
            //Arreglo javascript de objetos json
                let json = this.casetas;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += parseInt(data[x].costo)*parseInt(data[x].vueltas); // Ahora que es un objeto javascript, tiene propiedades
                }
                //alert(suma);
                this.gastoCasetas = suma;
                return suma;
             },
        },
    methods: {
         guardarFlete(){
            this.$emit('guardarFlete', this.totalFinal);
        },

        editarCantidadKm(index, key){
                    //console.log(key);
                    this.indice = index;
                    
                    this.key = key[7];
                    
                    console.log(key);
                    //alert(key[2]);
                       
                },
        updateCantidadKm(index){
            let vehiculo = this.vehiculos.find(function(element, indice){
                        return (indice == index);
                    });

            if(this.cantidadKmActualizada!=''){
            vehiculo.kmDestino = this.cantidadKmActualizada;}else{vehiculo.kmDestino=0}       
            vehiculo.ltsXVuelta = this.cantidadKmActualizada/vehiculo.consumo;
            vehiculo.ltsTotal = vehiculo.ltsXVuelta * vehiculo.vueltas;
            
            this.cantidadKmActualizada = 0;
            this.key= '';
        },


        editarCostoCaseta(index, key){
                    //console.log(key);
                    this.indice = index;
                    
                    this.key = key[2];
                    
                    console.log(index);
                    //alert(key[2]);
                       
                },
        updateCostoCaseta(index){
            let caseta = this.casetas.find(function(element, indice){
                        return (indice == index);
                    });

           if(this.cantidadCostoCasetaActualizada!=''){
            caseta.costo = this.cantidadCostoCasetaActualizada;}else{caseta.costo=0}       
            
            this.cantidadCostoCasetaActualizada = 0;
            this.key= '';
        },

        editarNameCaseta(index, key){
                    //console.log(key);
                    this.indice = index;
                    
                    this.key = key[0];
                    
                    console.log(index);
                    //alert(key[1]);
                       
                },
        updateNameCaseta(index){
            let caseta = this.casetas.find(function(element, indice){
                        return (indice == index);
                    });

           if(this.cantidadCostoCasetaActualizada!=''){
            caseta.name = this.cantidadCostoCasetaActualizada;}else{caseta.name='caseta'}       
            
            this.cantidadCostoCasetaActualizada = 0;
            this.key= '';
        },

        editarVueltasCaseta(index, key){
                    //console.log(key);
                    this.indice = index;
                    
                    this.key = key[1];
                    
                    console.log(index);
                    //alert(key[1]);
                       
                },
        updateVueltasCaseta(index){
            let caseta = this.casetas.find(function(element, indice){
                        return (indice == index);
                    });

           if(this.cantidadCostoCasetaActualizada!=''){
            caseta.vueltas = this.cantidadCostoCasetaActualizada;}else{caseta.vueltas=0}       
            
            this.cantidadCostoCasetaActualizada = 0;
            this.key= '';
        },
        

        editarCantidadVueltas(index, key){
                    //console.log(key);
                    this.indice = index;
                    
                    this.key = key[10];
                    
                    console.log(index);
                    //alert(key[2]);
                       
                },
        updateCantidadVueltas(index){
            let vehiculo = this.vehiculos.find(function(element, indice){
                        return (indice == index);
                    });

            if(this.cantidadKmActualizada!=''){
            vehiculo.vueltas = this.cantidadKmActualizada;}else{vehiculo.kmDestino=0}      
            //vehiculo.ltsXVuelta = this.cantidadKmActualizada/vehiculo.consumo;
            vehiculo.ltsTotal = vehiculo.ltsXVuelta * vehiculo.vueltas;
            
            this.cantidadKmActualizada = 0;
            this.key= '';
        },
        eliminarCaseta(index){
                this.casetas.splice(index, 1);
            },

        obtenerVehiculos(){
            this.vehiculos=[];
             let URL = '/obtener-vehiculos';

            axios.get(URL).then((response) => {
                response.data.forEach((doc) => {
                    doc.kmDestino=0;
                    doc.ltsXVuelta=0;
                    doc.ltsTotal=0;
                    doc.vueltas=1;
                    doc.costoGasolina=0;
                    doc.total=0;
                    this.vehiculos.push(doc)
                })
            }).catch((error) => {
                console.log(error.data);
            });
        },

        obtenerCasetasBD(){
            this.casetas2=[];
             let URL = '/obtener-casetas';

            axios.get(URL).then((response) => {
                response.data.forEach((doc) => {
                    this.casetas2.push(doc)
                })
            }).catch((error) => {
                console.log(error.data);
            });
        },

        obtenerCasetas(){
            this.casetas.push({
                            'name': 'nueva caseta',
                            'vueltas':2,
                            'costo':1,
                        });
        },
        agregarVehiculo(){
                let URL = '/vehiculos/agregarVehiculo';

                axios.post(URL, {
                    'nombre': this.nuevoNombre,
                    'rendimiento': this.nuevoRendimiento,
                    'tipo': this.tipoRegistro,
                    'combustible': this.nuevoCombustible
                }).then((response) => { 
                    Swal.fire({
                        title: 'Elemento registrado con exito',
                        text: "Se registro un nuevo elemento",
                        type: 'success',
                        showCancelButton: false, 
                    });
                    this.obtenerVehiculos();
                    $('#agregarVehiculo').modal('hide')
                }).catch((error) => {
                   // console.log(error.data);
                });
            },
        eliminarVehiculo(item){
                var url= '/vehiculos/eliminar-vehiculo/'+item.id;
                axios.delete(url).then(response =>{
                    this.obtenerVehiculos();    
                    
                })
            },
        updatePrecioGasolina(){
            let precioActualizado = prompt('Ingrear costo de Gasolina');
            this.costoGasolina = precioActualizado;
        },

         imprimir(){
  
  window.print();
  
},

 printDiv(contenedorGeneral2) {
     var contenido= document.getElementById('contenedorGeneral2').innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}

    }
}
</script>