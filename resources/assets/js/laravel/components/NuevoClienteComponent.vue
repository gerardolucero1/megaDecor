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
            <form action="POST" v-on:submit="crearCliente()">
                <div class="col-md-10 offset-md-1 registroCliente">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <input type="radio" name="personaFisica" value="fisica" id="personaFisica">
                            <label for="personaFisica">Persona Fisica</label>
                        </div>
                        <div class="col-md-6 d-flex">
                            <input type="radio" name="personaMoral" value="moral" id="personaMoral">
                            <label for="personaMoral">Persona Moral</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" placeholder="Nombres">
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Apellido Paterno">
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="Apellido Materno">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="email" placeholder="Email">
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
                            <input type="text" placeholder="Nombre">
                        </div>

                        <div class="col-md-4 mt-4">
                            <input type="text" placeholder="Direccion">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="text" placeholder="Colonia">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input type="text" placeholder="Numero">
                        </div>
                        <div class="col-md-7 mt-4">
                            <input type="text" name="" id="" placeholder="RFC">
                        </div>
                        <div class="col-md-7 mt-4">
                            <input type="email" name="" id="" placeholder="Email">
                        </div>
                        <div class="col-md-5 mt-4">
                            <button class="btn btn-success btn-sm btn-block">Agregar Contacto</button>
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
        data:{
            
        },
    }
</script>
