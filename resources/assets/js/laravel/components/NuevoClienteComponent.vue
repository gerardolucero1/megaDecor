<style>
    .registroCliente .row{
        margin-bottom: 20px;
    }

    .registroCliente input[type="text"], 
    .registroCliente input[type="email"], 
    .registroCliente input[type="number"], 
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
                            <label for="personaFisica">Persona Fisica</label>
                        </div>
                        <div class="col-md-6 d-flex">
                            <input type="radio" name="typePerson" value="moral" id="personaMoral" v-model="cliente.tipoPersona">
                            <label for="personaMoral">Persona Moral</label>
                        </div>
                    </div>
                    <!-- Personas Fisicas -->
                    <div class="row" v-if="cliente.tipoPersona == 'fisica'">
                        <div class="col-md-4">
                            <input type="text" placeholder="Nombres" v-model="cliente.nombreCliente">
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Apellido Paterno" v-model="cliente.apellidoCliente">
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Apellido Materno" v-model="cliente.apellidoCliente2">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="email" placeholder="Email" v-model="cliente.emailCliente">
                        </div>
                    </div>
                    <!-- Personas Morales -->
                    <div class="row" v-if="cliente.tipoPersona == 'moral'">
                        <div class="col-md-6">
                            <input type="text" placeholder="Nombres" v-model="cliente.nombreCliente">
                        </div>
                        <div class="col-md-6">
                            <select name="categoria" id="" v-model="cliente.categoriaCliente">
                                <option v-bind:value="categoria.id" v-for="categoria in categorias" v-bind:key="categoria.index">{{ categoria.nombre }}</option>  
                            </select>
                        </div>
                    </div>

                    <div class="row" v-if="telefonos.length !== 0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">TIPO</th>
                                    <th scope="col">NUMERO</th>
                                    <th scope="col">EXT</th>
                                    <th scope="col" class="text-center">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(telefono, index) in telefonos" v-bind:key="telefono.index">
                                    <td>{{ telefono.tipo }}</td>
                                    <td>{{ telefono.numero }}</td>
                                    <td>{{ telefono.ext }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarTelefono(index)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                    </div> 

                    <h4>Telefonos de contacto</h4>

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
                                <div class="col-md-6">
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
                            <input type="email" placeholder="Email" v-model="telefono.email">
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
                            <input type="email" name="" id="" placeholder="Email" v-model="cliente.emailFacturacion">
                        </div>
                        <div class="col-md-5 mt-4">
                            <button type="submit" class="btn btn-success btn-sm btn-block">Agregar Contacto</button>
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
                    </div>

                    <h4>¿Como supo de nosotros?</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <select name="comoSupo" id="" v-model="cliente.categoriaAbout">
                                <option v-bind:value="como.id" v-for="como in aboutCategorias" v-bind:key="como.index">{{ como.nombre }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
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
            //obtenerTelefonos();
        },
        mounted(){
            this.obtenerTelefonos();
            this.obtenerCategorias();
            this.obtenerCategoriasNosotros();
        },
        methods: {
            demo(){
                console.log('HOLA');
            },
            obtenerCategoriasNosotros(){
                let URL = 'http://localhost:3000/about-categorias';
                axios.get(URL).then((response) => {
                    this.aboutCategorias = response.data;
                    console.log(this.aboutCategorias);
                });
            },
            obtenerCategorias(){
                let URL = 'http://localhost:3000/categorias';
                axios.get(URL).then((response) => {
                    this.categorias = response.data;
                    console.log(this.categorias);
                });
            },
            obtenerTelefonos(){
                let URL = 'http://localhost:3000/telefonos';
                axios.get(URL).then((response) => {
                    this.physicalTelephones = response.data;
                    console.log(this.physicalTelephones);
                });
            },
            agregarTelefono(){
                this.demo();
                let existe = false;
                if(this.telefono.tipo == 'CELULAR' || this.telefono.tipo == 'CASA'){
                    this.demo();
                    //console.log(this.telefono.tipo);
                    let numero = this.telefono.numero;
                    this.physicalTelephones.forEach(function(element){

                        if(numero == element.numero){
                            
                            //console.log('Ya existe');
                            existe = true;
                            moment.locale('es');
                            let tiempo = moment(element.created_at).fromNow();
                            console.log(tiempo);
                            let cliente = '';
                            let URL = 'http://localhost:3000/viejo-telefono';
    
                                axios.post(URL, {
                                    'id': element.id,
                                }).then((response) => {
                                    console.log(response.data[0].nombre);
                                    
                                    Swal.fire({
                                        title: 'El telefono ya existe!',
                                        text: "Este telefono esta registrado desde " + tiempo + ' a nombre de ' + response.data[0].nombre,
                                        type: 'info',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Eliminar telefono antiguo'
                                        }).then((result) => {
                                            if (result.value) {
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
                                                        if (result.value) {
                                                            let URL = 'http://localhost:3000/viejo-telefono/' + element.id;
                                                            axios.delete(URL).then((response) => {
                                                                Swal.fire(
                                                                'Eliminado!',
                                                                'El telefono ha sido eliminado',
                                                                'success'
                                                                );
                                                            
                                                            }).catch((error) => {
                                                                console.log(error.data);
                                                            });
                                                        
                                                        }
                                                    })
                                            }
                                        })


                                }).catch((error) => {
                                    console.log(error);
                                });
                            
                        }
                        
                    });
                    this.telefonos.forEach(function(element){
                        if(numero == element.numero){
                            //console.log('Ya existe');
                            existe = true;
                            console.log(element.created_at);
                            moment.locale('es');
                            let tiempo = moment(element.created_at).fromNow();
                            console.log(tiempo);
                        }
                        
                    });
                
                }else if(this.telefono.tipo == 'OFICINA'){
                    console.log(this.telefono.tipo);
                    let ext = this.telefono.ext;
                    this.physicalTelephones.forEach(function(element){
                        if(ext == element.ext){
                            //console.log('Ya existe');
                            existe = true;
                        }
                        
                    });
                    this.telefonos.forEach(function(element){
                        if(ext == element.ext){
                            //console.log('Ya existe');
                            existe = true;
                        }
                        
                    });
                
                }
                //console.log(existe);

                if(!existe){
                    this.telefonos.push({'nombre': this.telefono.nombre, 'email': this.telefono.email, 'tipo': this.telefono.tipo , 'numero' : this.telefono.numero, 'ext': this.telefono.ext});
                    this.telefono = {};
                    //this.obtenerTelefonos();
                }else{
                    //toastr.error('El telefono que intentas agregar ya existe.', 'ERROR');
                }
                //this.telefonos.push({'tipo': this.telefono.tipo , 'numero' : this.telefono.numero, 'ext': this.telefono.ext});  
                
            },
            crearCliente(){
                let URL = 'http://localhost:3000/clientes/create';
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
                    console.log(this.cliente);
                }).catch((error) => {
                    console.log(error);
                });
                
            },
            eliminarTelefono(index){
                console.log(index);
                this.telefonos.splice(index, 1);
            }
        }
    }
</script>
