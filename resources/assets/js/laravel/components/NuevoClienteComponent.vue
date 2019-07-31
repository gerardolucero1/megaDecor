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
                    <div class="row">
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

                    <h4>Telefonos de contacto</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <select name="telefonoTipo" id="">
                                <option value="celular">Celular</option>
                                <option value="casa">Casa</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" placeholder="5555555555">
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" placeholder="EXT">
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-sm btn-primary">Agregar</button>
                                </div>
                            </div>
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

                    <h4>¿Como supo de nosotros?</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <select name="comoSupo" id="">
                                <option value="recomendacion">Recomendacion</option>
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
                    tipoPersona: '',
                    nombreCliente: '',
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

                }, 
            } 
        },

        methods: {
            crearCliente(){
                let URL = 'http://localhost:3000/clientes/create';
                axios.post(URL, {
                    'tipoPersona': this.cliente.tipoPersona,
                    'nombreCliente': this.cliente.nombreCliente,
                    'apellidoCliente': this.cliente.apellidoCliente,
                    'apellidoCliente2': this.cliente.apellidoCliente2,
                    'emailCliente': this.cliente.emailCliente,

                    //Facturacion

                    'nombreFacturacion': this.cliente.nombreFacturacion,
                    'direccionFacturacion': this.cliente.direccionFacturacion,
                    'coloniaFacturacion': this.cliente.coloniaFacturacion,
                    'numeroFacturacion': this.cliente.numeroFacturacion,
                    'rfcFacturacion': this.cliente.rfcFacturacion,
                    'emailFacturacion': this.cliente.emailFacturacion,
                }).then((response) => {
                    console.log(this.cliente);
                }).catch((error) => {
                    console.log(error);
                });
                
            }
        }
    }
</script>
