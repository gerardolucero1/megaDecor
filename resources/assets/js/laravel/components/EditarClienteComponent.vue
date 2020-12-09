<template>
  <section class="container editarCliente" v-if="cliente.length !== 0"> 
        <div class="row">
            <div class="col-md-6 text-left" v-if="ultimoEvento">
                <h5>Ultimo evento: <a :href="'/presupuestos/ver/' + ultimoEvento.id"><span class="badge badge-pill badge-danger">{{ ultimoEvento.fechaEvento | dateFilter }}</span></a></h5>
            </div>
            <div class="col-md-6 text-right">
                <h5>Ultima edicion: <span class="badge badge-pill badge-info">{{ cliente.updated_at | dateFilter }}</span></h5>
            </div>
        </div>
        <div v-if="cliente.client.tipoPersona == 'FISICA'">
            <h4>Datos personales</h4>
            <div class="row">
                <div class="col-md-4">
                    <label>Nombre del cliente</label>
                    <input type="text" required="required" placeholder="Nombre(s)" v-model="cliente.nombre">
                </div>
                <div class="col-md-4">
                    <label>Apellido paterno</label>
                    <input type="text" required="required" placeholder="Apellido Paterno" v-model="cliente.apellidoPaterno">
                </div>
                <div class="col-md-4">
                    <label>Apellido materno</label>
                    <input type="text" required="required" placeholder="Apellido Materno" v-model="cliente.apellidoMaterno">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Email</label>
                    <input type="email" placeholder="Email" v-model="cliente.email">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Telefono</label>
                    <input type="text" placeholder="number" v-model="cliente.telefono">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Direccion</label>
                    <input type="text" placeholder="text" v-model="cliente.direccionEmpresa">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Colonia</label>
                    <input type="text" placeholder="text" v-model="cliente.coloniaEmpresa">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Numero</label>
                    <input type="text" placeholder="text" v-model="cliente.numeroEmpresa">
                </div>
                <div class="col-md-4" style="paading-top:30px">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#crearTelefono">
            Nuevo telefono
        </button>
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#crearTelefono">
            Nuevo correo
        </button>
                </div>
            </div>
        </div>
        <div v-else>
            <h4>Datos personales</h4>
            <div class="row">
                <div class="col-md-4">
                    <label>Nombre del la empresa</label>
                    <input type="text" required="required" placeholder="Nombre(s)" v-model="cliente.nombre">
                </div>
                <div class="col-md-4">
                    <label>Direccion de la empresa</label>
                    <input type="text" required="required" placeholder="Dirección de la empresa" v-model="cliente.direccionEmpresa">
                </div>
                <div class="col-md-4">
                    <label>Colonia de la empresa</label>
                    <input type="text" required="required" placeholder="Colonia de la empresa" v-model="cliente.coloniaEmpresa">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Telefono de la empresa</label>
                <input type="text" name="" id="" placeholder="Telefono" v-model="cliente.telefono">
            </div>
                <div class="col-md-4 mt-4">
                    <label>Numero de la empresa</label>
                    <input type="text" placeholder="Numero" v-model="cliente.numeroEmpresa">
                </div>
                <div class="col-md-4 mt-4">
                    <label>Email de la empresa</label>
                    <input type="email" placeholder="Email" v-model="cliente.email">
                </div>
                
            </div>
        </div>
        <h4 class="mt-4">Telefonos de contacto</h4>
        
        {{cliente.client.tipoPersona}}
         <div class="row" v-if="telefonos.length !== 0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" v-if="cliente.client.tipoPersona == 'MORAL'">NOMBRE</th>
                        <th scope="col" v-if="cliente.client.tipoPersona == 'MORAL'">EMAIL</th>
                        <th scope="col">TIPO</th>
                        <th scope="col">NUMERO</th>
                        <th scope="col">EXT</th>
                        <th scope="col">DEPARTAMENTO</th>
                        <th scope="col" class="text-center">OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="telefono in telefonos" v-bind:key="telefono.index">
                        <td v-if="cliente.client.tipoPersona == 'MORAL'">{{ telefono.nombre}} {{telefono.apellidoPaterno}} {{telefono.apellidoMaterno}}</td>
                        <td v-if="cliente.client.tipoPersona == 'MORAL'">{{ telefono.email }}</td>
                        <td>{{ telefono.tipo }}</td>
                        <td>{{ telefono.numero }}</td>
                        <td>{{ telefono.ext }}</td>
                        <td>{{ telefono.departamento }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info text-center" v-on:click.prevent="editarTelefono(telefono)">Editar</button>
                            <button class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarTelefono(telefono.id)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>  
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
                <select name="" id="" v-model="cliente.tipoCredito">
                    <option value="SIN CREDITO">Sin credito</option>
                    <option value="ORDINARIO">Ordinario</option>
                    <option value="LABORAL">Laboral</option>
                </select>
            </div>
            <div class="col-md-7 mt-4">
                <input type="email" name="" id="emailDF" placeholder="Email" v-model="cliente.emailFacturacion">
            </div>
            <div class="col-md-5">
                <label >Dias de credito</label>
                <input type="number" v-model="cliente.diasCredito">
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <button class="btn btn-sm btn-block btn-primary flex-1" @click="verBudgets(1)">Ver presupuestos</button>
                    </div>
                    <div class="col-md-6 mt-4">
                        <button class="btn btn-sm btn-block btn-info flex-1" @click="verBudgets(2)">Ver contratos</button>
                    </div>
                </div>
            </div>
            
        </div>
        <button class="btn btn-sm btn-success" @click="actualizarDatos()">Actualizar datos</button>

        
       

        <!-- Modal -->
        <div class="modal fade" id="verBudgets" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Teléfono</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table v-if="budgets.length !== 0" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="budget in budgets" :key="budget.index">
                                <th scope="row">{{ budget.id }}</th>
                                <td>{{ budget.fechaEvento }}</td>
                                <td>{{ budget.tipo }}</td>
                                <td>
                                    <a :href="'/presupuestos/ver/' + budget.id" class="btn btn-sm btn-info">Ver</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else>
                        <h2>Sin Datos</h2>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal editar telefono -->
        <div class="modal fade" id="editarTelefono" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCenterTitle">Editar Teléfono</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body editarCliente">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Tipo de telefono</label>
                            <select name="telefonoTipo" id="" v-model="telefono.tipo">
                                <option value="CELULAR">Celular</option>
                                <option value="CASA">Casa</option>
                                <option value="OFICINA">Oficina</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Numero de telefono</label>
                            <input type="text" v-model="telefono.numero">
                        </div>
                        <div class="col-md-2" v-if="telefono.tipo == 'OFICINA'">
                            <label for="">Extension</label>
                            <input type="text" v-model="telefono.ext">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Nombre del contacto</label>
                            <input type="text" v-model="telefono.nombre">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Apellido Paterno</label>
                            <input type="text" v-model="telefono.apellidoPaterno">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Apellido Materno</label>
                            <input type="text" v-model="telefono.apellidoMaterno">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Email del contacto</label>
                            <input type="text" v-model="telefono.email">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Departamento</label>
                            <input type="text" v-model="telefono.departamento">
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="guardarTelefono()">Guardar telefono</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal agregar telefono -->
        <div class="modal fade" id="crearTelefono" tabindex="-1" role="dialog" aria-labelledby="crearModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearModalCenterTitle">Agregar Teléfono</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body editarCliente">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Tipo de telefono</label>
                            <select name="telefonoTipo" id="" v-model="nuevoTelefono.tipo">
                                <option value="CELULAR">Celular</option>
                                <option value="CASA">Casa</option>
                                <option value="OFICINA">Oficina</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Numero de telefono</label>
                            <input type="text" v-model="nuevoTelefono.numero">
                        </div>
                        <div class="col-md-2" v-if="nuevoTelefono.tipo == 'OFICINA'">
                            <label for="">Extension</label>
                            <input type="text" v-model="nuevoTelefono.ext">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Nombre de contacto</label>
                            <input type="text" v-model="nuevoTelefono.nombre">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Apellido Paterno</label>
                            <input type="text" v-model="nuevoTelefono.apellidoPaterno">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Apellido Materno</label>
                            <input type="text" v-model="nuevoTelefono.apellidoMaterno">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Email de contacto</label>
                            <input type="text" v-model="nuevoTelefono.email">
                        </div>
                        <div class="col-md-4" v-if="cliente.client.tipoPersona == 'MORAL'">
                            <label for="">Departamento</label>
                            <input type="text" v-model="nuevoTelefono.departamento">
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="guardarNuevoTelefono()">Guardar telefono</button>
                </div>
                </div>
            </div>
        </div>
        <button onclick="alert('cliente vetado con exito!');">Vetar cliente</button>
  </section>
</template>

<script>
    export default {
        data(){
            return{
                cliente: '',
                telefonos: [],
                nuevoTelefono: {
                    'client_id': '',
                    'nombre': '',
                    'apellidoPaterno': '',
                    'apellidoMaterno': '',
                    'email': '',
                    'tipo': '',
                    'numero': '',
                    'ext': ''
                },
                telefono: '',
                budgets: [],
                ultimoEvento: '',

            }
        },
        created(){
            this.obtenerCliente();
            this.obtenerTelefonos();
        },
        filters: {
            dateFilter: function(date){
                let Fecha = moment(date).format("MMM Do YY");
                return Fecha;
            },
        },
        methods:{
            obtenerCliente: function(){
                let path = window.location.pathname.split('/');
                let URL = '/obtener-cliente-editar/' + path[3];
                 axios.get(URL).then((response) => {
                     this.cliente = response.data;
                     
                     let arreglo = this.cliente.client.budgets
                            arreglo.sort(function(a,b){
                                    return new Date(b.fechaEvento) - new Date(a.fechaEvento);
                            });
                        this.ultimoEvento = arreglo.shift();
                        this.cliente.client.budgets.push(this.ultimoEvento);
                 }).catch((error) => {
                     console.log('Error al obtener cliente: ', error.data);
                 })
            },
            obtenerTelefonos: function(){
                let path = window.location.pathname.split('/');
                let URL = '/obtener-telefonos-editar/' + path[3];

                axios.get(URL).then((response) => {
                    this.telefonos = response.data;
                    console.log('Estos son los telefonos: ', this.telefonos);
                }).catch((error) => {
                    console.log('Error al obtener telefonos: ', error.data);
                })
            },
            verBudgets: function(tipo){
                $('#verBudgets').modal('show');
                if(this.cliente.client.budgets.length !== 0){
                    if(tipo == 1){
                        this.budgets = [];
                        this.cliente.client.budgets.forEach((element) => {
                            if(element.tipo == 'PRESUPUESTO'){
                                this.budgets.push(element);
                            }
                        })
                    }else{
                        this.budgets = [];
                        this.cliente.client.budgets.forEach((element) => {
                            if(element.tipo == 'CONTRATO'){
                                this.budgets.push(element);
                            }
                        })
                    }
                }
            },
            editarTelefono: function(telefono){
                this.telefono = telefono;
                $('#editarTelefono').modal('show');
            },
            guardarTelefono: function(){
                let URL = '/guardar-nuevo-telefono/' + this.telefono.id;
                if(this.telefono.tipo !== 'OFICINA'){
                    this.telefono.ext = '';
                }

                axios.put(URL, this.telefono).then((response) => {
                    Swal.fire(
                        'Actualizado',
                        'El telefono ha sido actualizado',
                        'success'
                    )
                    this.obtenerTelefonos();
                    $('#editarTelefono').modal('hide');
                }).catch((error) => {
                    console.log('Error al actualizar telefono: ', error.data);
                })
            },
            guardarNuevoTelefono: function(){
                let URL = '/crear-nuevo-telefono';
                if(this.nuevoTelefono.tipo !== 'OFICINA'){
                    this.nuevoTelefono.ext = '';
                }

                this.nuevoTelefono.client_id = this.cliente.client_id;

                axios.post(URL, this.nuevoTelefono).then((response) => {
                    Swal.fire(
                        'Agregado',
                        'El telefono ha sido agregado',
                        'success'
                    )
                    this.obtenerTelefonos();
                    $('#crearTelefono').modal('hide');
                    this.nuevoTelefono.nombre='';
                    this.nuevoTelefono.apelldioPaterno='';
                    this.nuevoTelefono.apellidoMaterno='';
                    this.nuevoTelefono.email='';
                    this.nuevoTelefono.departamento='';
                    this.nuevoTelefono.tipo='CELULAR';
                    this.nuevoTelefono.numero='';
                    this.nuevoTelefono.ext='';
                }).catch((error) => {
                    console.log('Error al crear telefono: ', error.data);
                })
            },
            eliminarTelefono: function(id){
                let URL = '/eliminar-nuevo-telefono/' + id;

                Swal.fire({
                    title: '¿Quieres eliminar este telefono?',
                    text: "Esta accion no se puede revertir",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {
                        axios.delete(URL).then((response) => {
                            Swal.fire(
                                'Eliminado!',
                                'El telefono ha sido eliminado',
                                'success'
                            );
                            this.obtenerTelefonos();
                        }).catch((error) => {
                            console.log('Error al eliminar telefono: ', error.data);
                        })
                    }
                })
            },
            obtenerBudgets: function(){
                let URL = '/obtener-budgets-cliente/' + this.cliente.client_id;
            },
            actualizarDatos: function(){
                let URL = '/clientes/update/' + this.cliente.client_id;

                axios.put(URL, this.cliente).then((response) => {
                    Swal.fire(
                        'Actualizado',
                        'El cliente ha sido actualizado',
                        'success'
                    )
                    this.obtenerCliente();
                }).catch((error) => {
                    Swal.fire(
                        'Error',
                        'Hubo un error al actualizar el cliente ¿Completaste todos los campos?',
                        'error'
                    )
                })
            },
        }
    }
</script>


<style>
    .editarCliente .row{
        margin-bottom: 20px;
    }

    .editarCliente input[type="date"]{
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }

    .editarCliente input[type="text"], 
    .editarCliente input[type="email"], 
    .editarCliente input[type="number"], 
    .editarCliente input[type="date"], 
    .editarCliente select{
        width: 100%;
    }
</style>
