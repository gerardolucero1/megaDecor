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
                        <div class="col-md-12" style="padding-top:10px">
                        <label for="">Dirección </label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" required="required" placeholder="Dirección" v-model="cliente.direccionEmpresa">
                        </div>
                        <div class="col-md-12" style="height:10px"></div>
                        <div class="col-md-4">
                            <input type="text" required="required" placeholder="Numero" v-model="cliente.numeroEmpresa">
                        </div>
                        <div class="col-md-4">
                            <input type="text" required="required" placeholder="Colonia" v-model="cliente.coloniaEmpresa">
                        </div>
                        
                     
                        <div class="col-md-12 mt-4" style="display:inline">
                            <label for="">Email</label><br>   
                            <input type="text" required="required" @change="emailClick" id="emailPF" placeholder="Ejemplo" v-model="cliente.emailCliente" style="width:auto"> @ <input required="required" type="text" style="width:auto" @change="emailClick" id="emailTPF" placeholder="ejemplo.com" v-model="cliente.emailClienteTerminacion" >
                        </div>
                        
                        
                    </div>
                    <!-- Personas Morales -->
                    <div class="row" v-if="cliente.tipoPersona == 'moral'">
                        <div class="col-md-6">
                            <label for="">Nombre de la empresa</label>
                            <input required type="text" placeholder="Nombre" v-model="cliente.nombreCliente">
                        </div>
                        <div class="col-md-6">
                            <label for="">Tipo de Empresa</label>
                            <select required name="categoria"  v-model="cliente.categoriaCliente">
                                <option v-for="tipoE in tiposE" :value="tipoE.id" v-bind:key="tipoE.index">{{ tipoE.nombre }}</option>  
                            </select>
                            <p style="cursor:pointer; padding-top:5px" data-toggle="modal" data-target="#tipoEmpresaModal"><i class="fa fa-edit" style="color:#2F7AD4; padding-right:5px;"></i>Administrar Tipos de empresa</p>

                        </div>
                        <div class="col-md-12">
                            <label for="">Direccion de la empresa</label>
                            <input required type="text" placeholder="Direccion" v-model="cliente.direccionEmpresa">
                        </div>
                        <div class="col-md-4">
                            <label for="">Numero de la empresa</label>
                            <input required type="text" placeholder="Numero" v-model="cliente.numeroEmpresa">
                        </div>
                        <div class="col-md-4">
                            <label for="">Colonia de la empresa</label>
                            <input required type="text" placeholder="Colonia" v-model="cliente.coloniaEmpresa">
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <label for="">Email de la empresa</label><br>
                            <input required type="text" @change="emailClick" id="emailPF" placeholder="Ejemplo" v-model="cliente.emailCliente" style="width:auto"> @ <input required @change="emailClick" id="emailTPF" type="text"  style="width:auto"  placeholder="ejemplo.com" v-model="cliente.emailClienteTerminacion" >
                        </div>
                    </div>
                    
                    <!-- Tabla de telefonos -->
                    
                    

                    <h4>Teléfonos de contacto</h4>
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
                            <input type="text" placeholder="Apellido Paterno" v-model="telefono.apellidoPaterno">
                        </div>
                        <div class="col-md-4" v-if="cliente.tipoPersona == 'moral'">
                            <input type="text" placeholder="Apellido Materno" v-model="telefono.apellidoMaterno">
                        </div>
                        <div class="col-md-8 mt-4" v-if="cliente.tipoPersona == 'moral'">
                            <input type="email" placeholder="Email" v-model="telefono.email">
                        </div>
                        <div class="col-md-4 mt-4" v-if="cliente.tipoPersona == 'moral'">
                            <input type="text"  placeholder="Departamento" v-model="telefono.departamento">
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
                        <div class="col-md-5 mt-4">
                            <input type="text" name="" id="" placeholder="Codigo Postal" v-model="cliente.codigoPostal">
                        </div>
                        <div class="col-md-7 mt-4">
                       <input type="text" id="emailDF" placeholder="Ejemplo" v-model="cliente.emailFacturacion" style="width:auto"> @ <input type="text" style="width:auto" id="emailTDF" placeholder="ejemplo.com" v-model="cliente.emailFacturacionTerminacion"  >
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
                            <input type="text" v-model="cliente.diasCredito"  placeholder="Dias de credito">
                        </div>
                    </div>

                    <h4>¿Como supo de nosotros?</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <select required="required" name="comoSupo" id="" >
                                <option value=""></option>
                                <option v-for="tipo in tipos" v-bind:key="tipo.index">{{ tipo.nombre }}</option>
                            </select>
                            <p data-toggle="modal" data-target="#agregarComoSupo" style="cursor:pointer; padding-top:5px"><i class="fa fa-edit" style="color:#2F7AD4; padding-right:5px;"></i>Administrar "¿Como Supo de nosotros?"</p>

                        </div>
                       
                    </div>
                     <div class="row float-right">
                            <button style="margin-right:10px" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-success" type="submit" v-if="!creando">Agregar Cliente</button>
                        </div>
                </div>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="agregarComoSupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border: solid; border-color: grey">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" onClick="$('#agregarComoSupo').modal('hide')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <input type="text" name="comoSupo" id="" class="form-control" placeholder="Agregar categoria" aria-describedby="helpId" v-model="comoSupo">
                    </div>
                    <div class="col-md-3 text-center">
                        <button class="btn btn-sm btn-info" @click="agregarComoSupo()">Agregar</button>
                    </div>
                </div>
                
                <div class="row mt-4" v-if="tipos.length != 0">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in tipos" :key="index">
                                    <th scope="row">{{ item.id }}</th>
                                    <td>{{ item.nombre }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" @click="eliminarComoSupo(item)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onClick="$('#agregarComoSupo').modal('hide')">Close</button>
            </div>
            </div>
        </div>
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
                creando: false,
                comoSupo: '',
                comoSupoArray: [],
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

                    // Persona Fisica y Moral
                    apellidoCliente: '',
                    apellidoCliente2: '',
                    emailCliente: '',
                    direccionEmpresa: '',
                    coloniaEmpresa: '',
                    numeroEmpresa: '',


                    //Facturacion
                    nombreFacturacion: '',
                    direccionFacturacion: '',
                    coloniaFacturacion: '',
                    numeroFacturacion: '',
                    rfcFacturacion: '',
                    emailFacturacion: '',

                    // Credito
                    creditoCliente: 'SIN CREDITO',
                    diasCredito: '',

                    // Como supo
                    categoriaAbout: '1',

                },
                telefono:{
                    tipo: 'CELULAR',
                    numero: '',
                    ext: '',
                    nombre: '',
                    apellidoPaterno: '',
                    apellidoMaterno: '',
                    email: '',
                    departamento: '',
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
        watch:{
            'cliente.direccionEmpresa': function(val){
                this.cliente.direccionFacturacion = this.cliente.direccionEmpresa;
            },

            'cliente.coloniaEmpresa': function(val){
                this.cliente.coloniaFacturacion = this.cliente.coloniaEmpresa;
            },

            'cliente.numeroEmpresa': function(val){
                this.cliente.numeroFacturacion = this.cliente.numeroEmpresa;
            }
        },
        mounted(){
            this.obtenerTelefonos();
            this.obtenerCategorias();
            this.obtenerCategoriasNosotros();
            this.obtenerComoSupo(); 
        },
        methods: {
            obtenerComoSupo(){
                let URL = '/clientes/comoSupo';
                axios.get(URL).then((response) => {
                    this.tipos = response.data;
                  //  console.log(this.tipos);
                });
            },
    emitGlobalClickEvent() {
      EventBus.$emit('nuevoCliente');
    },

            eliminarComoSupo(item){
                var url= '/clientes/eliminar-comoSupo/'+item.id;
                axios.delete(url).then(response =>{
                    this.obtenerComoSupo();    
                })
            },

            agregarComoSupo(){
                let URL = '/clientes/crearComoSupo';

                axios.post(URL, {
                    'nombre': this.comoSupo,
                }).then((response) => { 
                    Swal.fire({
                        title: 'Elemento registrado con exito',
                        text: "Se registro tu nueva opción",
                        type: 'success',
                        showCancelButton: false,
                        cancelButtonColor: '#d33',  
                    });
                    this.obtenerComoSupo();
                }).catch((error) => {
                   // console.log(error.data);
                });
            },
            emailClick(){
    var emailpf = document.getElementById('emailPF').value;
    var emailtpf = document.getElementById('emailTPF').value;
    document.getElementById('emailDF').value=emailpf;
    document.getElementById('emailTDF').value=emailtpf;
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
                        console.log('Se encontro el numero: ', encontrado);

                        moment.locale('es');
                        let tiempo = moment(encontrado.created_at).fromNow();
                      //  console.log(tiempo);
                        let URL = '/viejo-telefono';
                        axios.post(URL, {
                            'id': encontrado.client_id,
                        }).then((response) => {
                            console.log(response.data);

                            Swal.fire({
                                title: 'El telefono ya existe!',
                                text: "Este telefono esta registrado desde " + tiempo + ' a nombre de ' + response.data.nombre,
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
                            'id': encontrado.client_id,
                        }).then((response) => {
                        //    console.log(response.data[0].nombre);

                            Swal.fire({
                                title: 'El telefono ya existe!',
                                text: "Este telefono esta registrado desde " + tiempo + ' a nombre de ' + response.data.nombre,
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
                    this.telefonos.push({'nombre': this.telefono.nombre, 'apellidoPaterno': this.telefono.apellidoPaterno, 'apellidoMaterno': this.telefono.apellidoMaterno, 'email': this.telefono.email, 'tipo': this.telefono.tipo , 'numero' : this.telefono.numero, 'ext': this.telefono.ext, 'departamento': this.telefono.departamento});
                }


                this.telefono.numero="";
                this.telefono.nombre="";
                this.telefono.apellidoPaterno="";
                this.telefono.apellidoMaterno="";
                this.telefono.ext="";
                this.telefono.email="";
                this.telefono.tipo="CELULAR";
                this.telefono.departamento="";
                
                
            },
            crearCliente(){
                this.creando = true;
                let URL = '/clientes/create';

                   
                if(this.telefonos.length>0){
                    
                let diascredito=parseInt(this.cliente.diasCredito);  
                if(isNaN(diascredito)){
                    this.cliente.diasCredito=0;
                } 
                
                axios.post(URL, {
                    'tipoPersona': this.cliente.tipoPersona,
                    'nombreCliente': this.cliente.nombreCliente,
                    'direccionEmpresa': this.cliente.direccionEmpresa,
                    'coloniaEmpresa': this.cliente.coloniaEmpresa,
                    'numeroEmpresa': this.cliente.numeroEmpresa,
                    
                    // Persona Moral
                    'categoriaCliente': this.cliente.categoriaCliente,

                    // Persona Fisica
                    'apellidoCliente': this.cliente.apellidoCliente,
                    'apellidoCliente2': this.cliente.apellidoCliente2,
                    'emailCliente': this.cliente.emailCliente+'@'+this.cliente.emailClienteTerminacion,

                    // Facturacion
                    'nombreFacturacion': this.cliente.nombreFacturacion,
                    'direccionFacturacion': this.cliente.direccionFacturacion,
                    'coloniaFacturacion': this.cliente.coloniaFacturacion,
                    'numeroFacturacion': this.cliente.numeroFacturacion,
                    'rfcFacturacion': this.cliente.rfcFacturacion,
                    'emailFacturacion': this.cliente.emailFacturacion+'@'+this.cliente.emailFacturacionTerminacion,

                    // Credito
                    'creditoCliente': this.cliente.creditoCliente,
                    'diasCredito': this.cliente.diasCredito,

                    // Como supo
                    'categoriaAbout': this.cliente.categoriaAbout,

                    // Telefonos
                    'telefonos': this.telefonos,

                }).then((response) => {
                    this.cliente = {};
                    EventBus.$emit('nuevoCliente');
                   // console.log(this.cliente);
                    Swal.fire({
                                title: 'Cliente Registrado con exito',
                                text: "",
                                type: 'success',
                                showCancelButton: false,
                                cancelButtonColor: '#d33',
                                
                            })
                            this.creando = false;
                            this.telefonos = [];
                            $('#nuevoClienteModal').modal('hide')
                            
                }).catch((error) => {
                    this.creando = false;
                    console.log(error);
                });
                }else{alert('No hay telefonos registrados, recuerda presionar "Agregar" para insertar un numero');
                this.creando = false;}
            },
            eliminarTelefono(index){
              //  console.log(index);
                this.telefonos.splice(index, 1);
            }
        }
    }
</script>
