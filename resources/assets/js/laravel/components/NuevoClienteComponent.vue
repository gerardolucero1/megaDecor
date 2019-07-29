<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3 float-left">
                <div class="">
                    <input type="radio" name="moral" id="fisica">
                    <label for="fisica">
                        Persona Fisica
                    </label>
                </div>
            </div>
            <div class="col-md-3 float-left"> 
                <div class="ml-5">
                    <input type="radio" name="moral" id="moral">
                    <label for="moral">
                        Persona Moral
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <input type="text" width="100%">
            </div>
            <div class="col-md-4">
                <input type="text" width="100%">
            </div>
            <div class="col-md-4">
                <input type="text" width="100%">
            </div>
            <div class="col-md-4">
                <input type="text" width="100%">
            </div>
        </div>
        <h4>Telefonos de Contacto</h4>
        <div class="row mt-5">
            <div class="col-md-3">
                <input type="text">
            </div>
            <div class="col-md-3">
                <input type="text">
            </div>
            <div class="col-md-6">
                <input type="text">
                <button class="btn btn-sm btn-success">Agregar</button>
            </div>
        </div>
        <h4>Datos de facturacion</h4>
        <div class="row">
            <div class="col-md-12">
                <input type="text">
            </div>
            <div class="col-md-3">
                <input type="text">
            </div>
            <div class="col-md-3">
                <input type="text">
            </div>
            <div class="col-md-3">
                <input type="text">
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <input type="text">
            </div>
            <div class="col-md-7">
                <input type="text">
            </div>
            <div class="col-md-3">
                <button class="btn btn-success">
                    Guardar
                </button> 
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
