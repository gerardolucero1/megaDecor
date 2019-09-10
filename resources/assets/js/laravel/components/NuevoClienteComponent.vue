<style>
    .registroCliente .row{
        margin-bottom: 20px;
    }

    .registroCliente input[type="date"]{
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }

    .registroCliente input[type="text"], 
    .registroCliente input[type="email"], 
    .registroCliente input[type="number"], 
    .registroCliente input[type="date"], 
    .registroCliente select{
        width: 100%;
    }
</style>


<template>
    <div class="container">
        <div class="row">
            <form action="POST" v-on:submit.prevent="crearCliente()">
                <div class="col-md-10 offset-md-1 registroCliente">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <input type="radio" name="typePerson" value="fisica" id="personaFisica" v-model="cliente.tipoPersona">
                            <label for="personaFisica" style="padding-left:10px;"> Persona Fisica</label>
                        </div>
                        <div class="col-md-6 d-flex">
                            <input type="radio" name="typePerson" value="moral" id="personaMoral" v-model="cliente.tipoPersona">
                            <label for="personaMoral" style="padding-left:10px;"> Persona Moral</label>
                        </div>
                    </div>
                    <!-- Personas Fisicas -->
                    <div class="row" v-if="cliente.tipoPersona == 'fisica'">
                        <div class="col-md-4">
                            <input type="text" required="required" placeholder="Nombre(s)" v-model="cliente.nombreCliente">
                        </div>
                        <div class="col-md-4">
                            <input type="text" required="required" placeholder="Apellido Paterno" v-model="cliente.apellidoCliente">
                        </div>
                        <div class="col-md-4">
                            <input type="text" required="required" placeholder="Apellido Materno" v-model="cliente.apellidoCliente2">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="email" @change="emailClick" id="emailPF" placeholder="Email" v-model="cliente.emailCliente">
                        </div>
                    </div>
                    <!-- Personas Morales -->
                    <div class="row" v-if="cliente.tipoPersona == 'moral'">
                        <div class="col-md-6">
                            <label for="">Nombre de la empresa</label>
                            <input type="text" placeholder="Nombre" v-model="cliente.nombreCliente">
                        </div>
                        <div class="col-md-6">
                            <label for="">Tipo de Empresa</label>
                            <select name="categoria"  v-model="cliente.categoriaCliente">
                                <option v-for="tipoE in tiposE" :value="tipoE.id" v-bind:key="tipoE.index">{{ tipoE.nombre }}</option>  
                            </select>
                            <p style="cursor:pointer; padding-top:5px" data-toggle="modal" data-target="#tipoEmpresaModal"><i class="fa fa-edit" style="color:#2F7AD4; padding-right:5px;"></i>Administrar Tipos de empresa</p>

                        </div>
                        <div class="col-md-12">
                            <label for="">Direccion de la empresa</label>
                            <input type="text" placeholder="Nombre" v-model="cliente.direccionEmpresa">
                        </div>
                    </div>
                    
                    <!-- Tabla de telefonos -->
                    
                    

                    <h4>Telefonos de contacto</h4>
                    <div class="row" v-if="telefonos.length !== 0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" v-if="cliente.tipoPersona == 'moral'">NOMBRE</th>
                                    <th scope="col" v-if="cliente.tipoPersona == 'moral'">EMAIL</th>
                                    <th scope="col">TIPO</th>
                                    <th scope="col">NUMERO</th>
                                    <th scope="col">EXT</th>
                                    <th scope="col" class="text-center">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(telefono, index) in telefonos" v-bind:key="telefono.index">
                                    <td v-if="cliente.tipoPersona == 'moral'">{{ telefono.nombre }}</td>
                                    <td v-if="cliente.tipoPersona == 'moral'">{{ telefono.email }}</td>
                                    <td>{{ telefono.tipo }}</td>
                                    <td>{{ telefono.numero }}</td>
                                    <td>{{ telefono.ext }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarTelefono(index)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                    </div> 
                    <div class="row" v-if="telefonos.length == 0">
                        <p style="text-align:center">"Sin contactos registrados"</p>
                        </div>

                    <div class="row">
                        <div class="col-md-4">
                            <select name="telefonoTipo" id="" v-model="telefono.tipo">
                                <option value="CELULAR">Celular</option>
                                <option value="CASA">Casa</option>
                                <option value="OFICINA">Oficina</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" placeholder="5555555555" v-model="telefono.numero">
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6" v-if="telefono.tipo=='OFICINA'">
                                    <input type="text" placeholder="EXT" v-model="telefono.ext">
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-sm btn-primary" v-on:click.prevent="agregarTelefono()">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" v-if="cliente.tipoPersona == 'moral'">
                            <input type="text" placeholder="Nombre" v-model="telefono.nombre">
                        </div>
                        <div class="col-md-4" v-if="cliente.tipoPersona == 'moral'">
                            <input type="text" placeholder="Apellido Paterno" v-model="telefono.app">
                        </div>
                        <div class="col-md-4" v-if="cliente.tipoPersona == 'moral'">
                            <input type="text" placeholder="Apellido Materno" v-model="telefono.apm">
                        </div>
                        <div class="col-md-4" style="padding-top:10px" v-if="cliente.tipoPersona == 'moral'">
                            <input type="email" id="email" placeholder="Email" v-model="telefono.email">
                        </div>
                    </div>

                    <h4>Datos de facturacion</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" placeholder="Nombre" v-model="cliente.nombreFacturacion">
                        </div>

                        <div class="col-md-4 mt-4">
                            <input type="text" placeholder="Direccion" v-model="cliente.direccionFacturacion">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="text" placeholder="Colonia" v-model="cliente.coloniaFacturacion">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="text" placeholder="Numero" v-model="cliente.numeroFacturacion">
                        </div>
                        <div class="col-md-7 mt-4">
                            <input type="text" name="" id="" placeholder="RFC" v-model="cliente.rfcFacturacion">
                        </div>
                        <div class="col-md-7 mt-4">
                            <input type="email" name="" id="emailDF" placeholder="Email" v-model="cliente.emailFacturacion">
                        </div>
                       
                    </div>

                    <h4>Tipo de credito</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <select name="creditoCliente" id="" v-model="cliente.creditoCliente">
                                <option value="SIN CREDITO">Sin Credito</option>
                                <option value="ORDINARIO">Ordinario</option>
                                <option value="LABORAL">Laboral</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" placeholder="Dias de credito">
                        </div>
                    </div>

                    <h4>¿Como supo de nosotros?</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <select name="comoSupo" id="" >
                                <option v-for="tipo in tipos" v-bind:key="tipo.index">{{ tipo.nombre }}</option>
                            </select>
                            <p data-toggle="modal" data-target="#comoSupoModal" style="cursor:pointer; padding-top:5px"><i class="fa fa-edit" style="color:#2F7AD4; padding-right:5px;"></i>Administrar "¿Como Supo de nosotros?"</p>

                        </div>
                       
                    </div>
                     <div class="row float-right">
                            <button style="margin-right:10px" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-success" type="submit">Agregar Cliente</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
function emailCopy(){
    var emailpf = document.getElementById('emailPF').value;
    alert(emailpf);
    }
</script>

<script>
// Import the EventBus.
    import { EventBus } from '../eventBus.js';

    export default {
        data(){
            return {
                //Como lo supo
                tipo: {
                    nombre: '',
                },
                tipos: [],
                mostrar: 1,
                //Tipo empresa
                tipoE: {
                    nombre: '',
                },
                tiposE: [],
                mostrarE: 1,
        
                cliente: {
                    tipoPersona: 'fisica',
                    nombreCliente: '',
                    
                    // Persona Moral
                    categoriaCliente: '',

                    // Persona Fisica
                    apellidoCliente: '',
                    apellidoCliente2: '',
                    emailCliente: '',


                    //Facturacion
                    nombreFacturacion: '',
                    direccionFacturacion: '',
                    coloniaFacturacion: '',
                    numeroFacturacion: '',
                    rfcFacturacion: '',
                    emailFacturacion: '',

                    // Credito
                    creditoCliente: 'SIN CREDITO',

                    // Como supo
                    categoriaAbout: '1',

                },
                telefono:{
                    tipo: 'CELULAR',
                    numero: '',
                    ext: '',
                    nombre: '',
                    email: '',
                },
                telefonos: [],
                physicalTelephones: [],
                categorias: [],
                aboutCategorias: [],
                
            } 
        },
        created: function(){
       this.obtenerComoSupo();
       this.obtenerTipoEmpresa();

EventBus.$on('nuevaComoSupo', funcion => {
  this.obtenerComoSupo();
});


EventBus.$on('nuevoTipoEmpresa', funcion => {
  this.obtenerTipoEmpresa();
});
           
        },
        
        mounted(){
            this.obtenerTelefonos();
            this.obtenerCategorias();
            this.obtenerCategoriasNosotros();
            
        },
        methods: {
            emailClick(){
    var emailpf = document.getElementById('emailPF').value;
    document.getElementById('emailDF').value=emailpf;
    },
    obtenerTipoEmpresa(){
                let URL = '/clientes/tipo-empresa';
                axios.get(URL).then((response) => {
                    this.tiposE = response.data;
                   // console.log(this.tiposE);
                });
                },
            obtenerCategoriasNosotros(){
                let URL = '/about-categorias';
                axios.get(URL).then((response) => {
                    this.aboutCategorias = response.data;
                 //   console.log(this.aboutCategorias);
                });
            },
            obtenerComoSupo(){
                let URL = '/clientes/comoSupo';
                axios.get(URL).then((response) => {
                    this.tipos = response.data;
                  //  console.log(this.tipos);
                });
                },
            obtenerCategorias(){
                let URL = '/categorias';
                axios.get(URL).then((response) => {
                    this.categorias = response.data;
                  //  console.log(this.categorias);
                });
            },
            obtenerTelefonos(){
                let URL = '/telefonos';
                axios.get(URL).then((response) => {
                    this.physicalTelephones = response.data;
                  //  console.log(this.physicalTelephones);
                });
            },
            agregarTelefono(){
                let existe = false;
                if(this.telefono.tipo == 'CELULAR' || this.telefono.tipo == 'CASA'){
                 //   console.log('celular o casa');
                    let numero = this.telefono.numero;
                  //  console.log(numero);

                    //Verificamos primero en el array de la BDD
                    if(this.physicalTelephones.some(function(element){
                        
                        return (numero == element.numero && (element.tipo == 'CELULAR' || element.tipo == 'CASA'));
            
                    })){
                        existe = true;
                       // console.log('existe');
                        
                        // Buscamos el elemento con el cual coincidio
                        let encontrado = this.physicalTelephones.find(function(element) {
                            return (numero == element.numero && (element.tipo == 'CELULAR' || element.tipo == 'CASA'));
                        });

                        moment.locale('es');
                        let tiempo = moment(encontrado.created_at).fromNow();
                      //  console.log(tiempo);
                        let URL = '/viejo-telefono';
                        axios.post(URL, {
                            'id': encontrado.id,
                        }).then((response) => {
                        //    console.log(response.data[0].nombre);

                            Swal.fire({
                                title: 'El telefono ya existe!',
                                text: "Este telefono esta registrado desde " + tiempo + ' a nombre de ' + response.data[0].nombre,
                                type: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Eliminar telefono antiguo'
                            }).then((result) => {
                                if(result.value) {
                                    //Eliminar Telefono
                                    Swal.fire({
                                        title: '¿Deseas eliminar este telefono?',
                                        text: "No podras deshacer esta accion!",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Eliminar telefono'
                                    }).then((result) => {
                                        if(result.value){
                                            let URL = '/viejo-telefono/' + encontrado.id;
                                            axios.delete(URL).then((response) => {
                                                Swal.fire(
                                                    'Eliminado!',
                                                    'El telefono ha sido eliminado',
                                                    'success'
                                                );
                                            this.obtenerTelefonos();
                                            }).catch((error) => {
                                                console.log(error.data);
                                            });
                                        }
                                    })
                                }
                            })
                        });


                    }
                    
                    // Verificamos despues en nuestro array local
                    if(this.telefonos.some(function(element){
                        
                        return (numero == element.numero && (element.tipo == 'CELULAR' || element.tipo == 'CASA'));
            
                    })){
                        existe = true;
                       // console.log('existe');
                        Swal.fire(
                        'Numero duplicado!',
                        'Ya ingresaste un telefono con este numero.',
                        'warning'
                        )
                    }
                    
                
                }else if(this.telefono.tipo == 'OFICINA'){
                   // console.log('oficina');
                    let ext = this.telefono.ext;

                    //Verificamos primero en el array de la BDD
                    if(this.physicalTelephones.some(function(element){
                        
                        return (ext == element.ext && (element.tipo == 'OFICINA'));
            
                    })){
                        existe = true;
                     //   console.log('existe');

                        // Buscamos el elemento con el cual coincidio
                        let encontrado = this.physicalTelephones.find(function(element) {
                            return (ext == element.ext && (element.tipo == 'OFICINA'));
                        });
                       // console.log(encontrado);

                        moment.locale('es');
                        let tiempo = moment(encontrado.created_at).fromNow();
                     //   console.log(tiempo);
                        let URL = '/viejo-telefono';
                        axios.post(URL, {
                            'id': encontrado.id,
                        }).then((response) => {
                        //    console.log(response.data[0].nombre);

                            Swal.fire({
                                title: 'El telefono ya existe!',
                                text: "Este telefono esta registrado desde " + tiempo + ' a nombre de ' + response.data[0].nombre,
                                type: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Eliminar telefono antiguo'
                            }).then((result) => {
                                if(result.value) {
                                    //Eliminar Telefono
                                    Swal.fire({
                                        title: '¿Deseas eliminar este telefono?',
                                        text: "No podras deshacer esta accion!",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Eliminar telefono'
                                    }).then((result) => {
                                        if(result.value){
                                            let URL = '/viejo-telefono/' + encontrado.id;
                                            axios.delete(URL).then((response) => {
                                                Swal.fire(
                                                    'Eliminado!',
                                                    'El telefono ha sido eliminado',
                                                    'success'
                                                );
                                            this.obtenerTelefonos();
                                            }).catch((error) => {
                                                console.log(error.data);
                                            });
                                        }
                                    })
                                }
                            })
                        });

                    }

                    // Verificamos despues en nuestro array local
                    if(this.telefonos.some(function(element){
                        
                        return (ext == element.ext && (element.tipo == 'OFICINA'));
            
                    })){
                        existe = true;
                      //  console.log('existe');
                        Swal.fire(
                        'Numero duplicado!',
                        'Ya ingresaste un telefono con esta extencion.',
                        'warning'
                        )
                    }
                
                }

                if(!existe){
                    this.telefonos.push({'nombre': this.telefono.nombre, 'email': this.telefono.email, 'tipo': this.telefono.tipo , 'numero' : this.telefono.numero, 'ext': this.telefono.ext});
                }


                
                
                
            },
            crearCliente(){
                let URL = '/clientes/create';
                axios.post(URL, {
                    'tipoPersona': this.cliente.tipoPersona,
                    'nombreCliente': this.cliente.nombreCliente,
                    
                    // Persona Moral
                    'categoriaCliente': this.cliente.categoriaCliente,

                    // Persona Fisica
                    'apellidoCliente': this.cliente.apellidoCliente,
                    'apellidoCliente2': this.cliente.apellidoCliente2,
                    'emailCliente': this.cliente.emailCliente,

                    // Facturacion
                    'nombreFacturacion': this.cliente.nombreFacturacion,
                    'direccionFacturacion': this.cliente.direccionFacturacion,
                    'coloniaFacturacion': this.cliente.coloniaFacturacion,
                    'numeroFacturacion': this.cliente.numeroFacturacion,
                    'rfcFacturacion': this.cliente.rfcFacturacion,
                    'emailFacturacion': this.cliente.emailFacturacion,

                    // Credito
                    'creditoCliente': this.cliente.creditoCliente,

                    // Como supo
                    'categoriaAbout': this.cliente.categoriaAbout,

                    // Telefonos
                    'telefonos': this.telefonos,
                }).then((response) => {
                    this.cliente = {};
                   // console.log(this.cliente);
                    Swal.fire({
                                title: 'Cliente Registrado con exito',
                                text: "",
                                type: 'success',
                                showCancelButton: false,
                                cancelButtonColor: '#d33',
                                
                            })
                }).catch((error) => {
                    console.log(error);
                });
                
            },
            eliminarTelefono(index){
              //  console.log(index);
                this.telefonos.splice(index, 1);
            }
        }
    }
</script>
