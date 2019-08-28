<style>
    .logo-presupuesto{
        width: 25%;
        height: 130px;
        background-position: center;
        background-size: cover;
    }

    .registroPresupuesto .row{
        margin-bottom: 15px;
    }

    .registroPresupuesto input[type="date"]{
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }

    .registroPresupuesto input[type="time"]{
        width: 100%;
        border: none;
        border: 1px solid rgba(204, 204, 204, 1);
    }

    .modalAgregarPaquete input[type="text"],
    .registroPresupuesto input[type="text"], 
    .registroPresupuesto input[type="email"], 
    .registroPresupuesto input[type="number"], 
    .registroPresupuesto input[type="date"], 
    .registroPresupuesto select{
        width: 100%;
    }

    .registroPresupuesto .info p{
        line-height: 4px;
    }

    .resultadoInventario{
        position: absolute;
        z-index: 3000;
        background-color: gray;
        overflow: scroll;
        height: 300px;
    }

    table tr td input{
        border: none;
        background-color: transparent;
    }

    .producto{
        background-color: beige;
        border-bottom: 2px solid black;
    }

</style>

<template>
    <section class="container">
        <div class="row">
            <div class="col-md-12 registroPresupuesto">
                <div class="row">
                    <div class="col-md-9 text-left">
                        <div v-if="presupuesto.tipoEvento == 'INTERNO'" class="img-fluid logo-presupuesto" style="background-image: url('https://thebiaslistcom.files.wordpress.com/2019/07/nature-im-so-pretty.jpg')">

                        </div>
                        <div v-else class="img-fluid logo-presupuesto" style="background-image: url('https://4.bp.blogspot.com/-h2GiZzyOE5Q/WKzED4RMxWI/AAAAAAAAFpA/V3KRWZd8AY80Wa7JsBWHBzYb5G-8aUjDQCLcB/s1600/01-1483422852234.jpg')">

                        </div>
                    </div>
                    <div class="col-md-3 text-right info">
                        <p>{{ obtenerFolio }}</p>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                <label>Vendedor: </label>
                            </div>
                            <div class="col-md-8">
                                <select name="vendedor" id="" v-model="presupuesto.vendedor_id">
                                    <option v-for="usuario in usuarios" :value="usuario.id" :key="usuario.index" :selected="usuarioActual.id">{{ usuario.name }}</option>
                                </select>
                            </div>
                        </div>
                        <p class="mt-3">Fecha de presupuesto: <span>{{ obtenerFecha }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informacion del evento</h4>
                            <input id="salonMega" type="radio" name="tipoSalon" value="INTERNO" v-model="presupuesto.tipoEvento">
                            <label for="salonMega">Salon Mega Mundo</label>
                        <br>
                        <input id="salonFuera" type="radio" name="tipoSalon" value="EXTERNO" v-model="presupuesto.tipoEvento">
                        <label for="salonFuera">Evento Fuera</label>
                            <div class="text-center" v-if="presupuesto.tipoEvento == 'EXTERNO'">
                                <input id="servicioFormal" type="radio" name="tipoServicio" value="FORMAL" v-model="presupuesto.tipoServicio">
                                <label for="servicioFormal">Servicio Formal</label>
                                <br>
                                <input id="servicioInfantil" type="radio" name="tipoServicio" value="INFANTIL" v-model="presupuesto.tipoServicio">
                                <label for="servicioInfantil">Servicio Infantil</label>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-right">Categoria del evento</h4>
                        <div class="row">
                            <div class="col-md-8 offset-md-4">
                                <select name="categoriaEvento" id="" v-model="presupuesto.categoriaEvento">
                                    <option value="1">Boda</option>
                                    <option value="2">XV Años</option>
                                    <option value="3">Aniversario</option>
                                </select>
                                
                                <div class="row mt-4">
                                    <div class="col-md-10">
                                        <input type="date" v-model="presupuesto.fechaEvento">
                                    </div>
                                    <div class="col-md-2 text-left">
                                        <i class="si si-calendar" style="font-size: 24px;"></i>
                                    </div>
                                    
                                </div>
                                <input type="checkbox" name="" value="1" id="pendienteFecha" v-model="presupuesto.pendienteFecha">
                                <label for="pendienteFecha">Pendiende</label>

                            </div>
                        </div>
                        <h4>Hora del evento</h4>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <input type="time" v-model="presupuesto.horaEventoInicio">
                            </div>
                            <div class="col-md-6">
                                <input type="time" v-model="presupuesto.horaEventoFin">
                            </div>
                        </div>
                        <input type="checkbox" name="1" id="pendienteHora" v-model="presupuesto.pendienteHora">
                        <label for="pendienteHora">Pendiende</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Cliente</h4>
                        <div class="row">
                            <div class="col-md-9">
                                <buscador-component
                                    placeholder="Buscar Clientes"
                                    event-name="clientResults"
                                    :list="clientes"
                                    :keys="['nombre', 'email']"
                                    
                                ></buscador-component>

                                <!-- Resultado Busqueda -->
                                <div class="row" v-if="clientResults.length < clientes.length">
                                    <div v-if="clientResults.length !== 0" class="col-md-6 resultadoInventario">
                                        <div class="list-group" v-for="cliente in clientResults" :key="cliente.id">
                                            <div class="row producto" v-on:click="obtenerCliente(cliente)">
                                                <div class="col-md-7">
                                                    <p>{{ cliente.nombre }}</p>
                                                    <span class="badge badge-info">
                                                        {{ cliente.email }}
                                                    </span>
                                                </div>
                                                <div class="col-md-5">
                                                    <img class="img-fluid" src="https://i.redd.it/m2jtpv0kdff11.jpg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                <select name="" id="" v-model="presupuesto.client_id">
                                    <option v-bind:value="cliente.id" v-for="cliente in clientes" v-bind:key="cliente.index">{{ cliente.nombre }}</option>
                                </select>
                                -->
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-sm btn-primary">Agregar</button>
                            </div>
                        </div>
                        <div v-if="clienteSeleccionado" class="info">
                            <p>{{ clienteSeleccionado.nombre }}</p>
                            <p>{{ clienteSeleccionado.email }}</p>
                            <p v-for="telefono in clienteSeleccionado.telefonos" v-bind:key="telefono.index">
                                {{ telefono.numero }} - {{ telefono.nombre }} - {{ telefono.tipo }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 text-right" v-if="clienteSeleccionado">
                        <div class="info">
                            <p>Ultimo evento: 
                                <span v-if="clienteSeleccionado && ultimoEvento">{{ ultimoEvento.fechaEvento }}</span>
                                <span v-else>Primer Evento</span>
                            </p>
                            <p><span>{{ calcularContratos }}</span> eventos contratados</p>
                            <p><span>{{ calcularPresupuestos }}</span> presupuestos</p>
                                <button v-if="calcularContratos" class="btn btn-sm btn-primary d-inline-block" data-toggle="modal" data-target="#verContratos">Ver Contratos</button>
                                <button v-if="calcularPresupuestos" class="btn btn-sm btn-info d-inline-block" data-toggle="modal" data-target="#verPresupuestos">Ver Presupuestos</button>
                        </div>
                    </div>
                </div>
                <h4>Lugar del Evento</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" id="lugarMismo" name="lugarEvento" value="MISMA" v-model="presupuesto.lugarEvento">
                        <label for="lugarMismo">Misma Direccion</label>
                    </div>
                    <div class="col-md-4">
                        <input type="radio" id="lugarOtro" name="lugarEvento" value="OTRA" v-model="presupuesto.lugarEvento">
                        <label for="lugarOtro">Otra</label>
                    </div>
                    <div class="col-md-4">
                        <input type="checkbox" id="pendienteLugar" value="1" v-model="presupuesto.pendienteLugar">
                        <label for="pendienteLugar">Pendiente</label>
                    </div>

                    <div class="col-md-10 mt-4">
                        <input type="text" placeholder="Nombre" v-model="presupuesto.nombreLugar">
                    </div>
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Direccion" v-model="presupuesto.direccionLugar">
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="text" placeholder="Numero" v-model="presupuesto.numeroLugar">
                    </div>
                    <div class="col-md-4 mt-4">
                        <input type="text" placeholder="Colonia" v-model="presupuesto.coloniaLugar">
                    </div>
                    <div class="col-md-2 mt-4">
                        <input type="text" placeholder="C.P" v-model="presupuesto.CPLugar">
                    </div>
                    <div class="col-md-12 mt-4">
                        <input type="text" name="" id="" placeholder="Observaciones" v-model="presupuesto.observacionesLugar">
                    </div>

                    <div class="col-md-2 mt-4">
                        <label for=""># Invitados</label>
                        <input type="number" name="" id="" v-model="presupuesto.numeroInvitados">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Tono del evento</label>
                        <input type="text" name="" id="" v-model="presupuesto.colorEvento">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Tema del evento</label>
                        <input type="text" name="" id="" v-model="presupuesto.temaEvento">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label for="">Festejado(s)</label>
                        <input type="text" name="" id="" v-model="festejado.nombre">
                        <input class="mt-2" type="number" name="" id="" v-model="festejado.edad">
                    </div>
                    <div class="col-md-1 mt-4">
                        <button class="btn btn-sm btn-primary mt-4" v-on:click.prevent="agregarFestejado()">Mas</button>
                    </div>
                </div>
                <!-- Tabla de festejados -->
                <div class="row" v-if="festejados.length !== 0">
                    <div class="col-md-6 offset-md-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">EDAD</th>
                                    <th scope="col" class="text-center">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(festejado, index) in festejados" v-bind:key="festejado.index">
                                    <td>{{ festejado.nombre }}</td>
                                    <td>{{ festejado.edad }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarFestejado(index)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                </div>
                <h4>Archivos de Referencia</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" name="" id="">
                    </div>
                </div>

                <hr>

                <!-- SECTION 2 -->
                <div class="row">
                    <div class="col-md-10 offset-md-2">
                        <div class="row">
                            <div class="col-md-4">
                                <buscador-component
                                    placeholder="Buscar Productos"
                                    event-name="results"
                                    :list="inventario"
                                    :keys="['servicio', 'id']"
                                    
                                ></buscador-component>

                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = false">Agregar Elemento</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#agregarPaquete">Agregar Paquete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Resultado Busqueda -->
                <div class="row" v-if="results.length < inventario.length">
                    <div v-if="results.length !== 0" class="col-md-6 resultadoInventario">
                        <div class="list-group" v-for="producto in results" :key="producto.id">
                            <div class="row producto" v-on:click="agregarProducto(producto)">
                                <div class="col-md-7">
                                    <p>{{ producto.servicio }}</p>
                                    <span class="badge badge-info">
                                        {{ producto.precioUnitario }}
                                    </span>
                                </div>
                                <div class="col-md-5">
                                    <img class="img-fluid" src="https://i.redd.it/m2jtpv0kdff11.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Table-->
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Externo</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Precio Final</th>
                                <th scope="col">Ahorro</th>
                                <th scope="col" width="252">Notas</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(producto, index) in inventarioLocal" v-bind:key="producto.index">
                                <th scope="row">
                                    <input type="checkbox" v-model="producto.externo" disabled="disabled">
                                </th>
                                <td>
                                    <img v-bind:src="producto.imagen" alt="" width="100%">
                                </td>
                                <td>{{ producto.servicio }}</td>
                                <td>
                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="text" v-model="cantidadActualizada" v-on:keyup.enter="updateCantidad(index)">
                                    <span v-else v-on:click="editarCantidad(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                    
                                </td>
                                <td>{{ producto.precioUnitario }}</td>
                                <td>
                                    <input v-if="(producto.precioFinal == '') || (indice == index && key == 'precioFinal')" type="text" v-model="precioFinalActualizado" v-on:keyup.enter="updatePrecioFinal(index)">
                                    <span v-else v-on:click="editarPrecioFinal(index, Object.keys(producto))">{{ producto.precioFinal | decimales }}</span>
                                </td>
                                <td>
                                    <input v-if="(producto.ahorro == '') || (indice == index && key == 'ahorro')" type="text" v-model="ahorroActualizado" v-on:keyup.enter="updateAhorro(index)">
                                    <span v-else v-on:click="editarAhorro(index, Object.keys(producto))">{{ producto.ahorro }}</span>
                                </td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="2" v-if="(producto.notas == '') || (indice == index && key == 'notas')" v-model="notasActualizadas" v-on:keyup.enter="updateNotas(index)">
                                        
                                    </textarea>
                                    <span v-else v-on:click="editarNotas(index, Object.keys(producto))">
                                        {{ producto.notas }}
                                    </span>
                                    

                                </td>
                                <td class="text-center">
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-primary">Editar</button>
                                    <button class="btn btn-sm btn-danger" @click="eliminarProductoLocal(index)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <h4>Mostrar en presupuesto de cliente</h4>
                                <input type="checkbox" id="precio" v-model="presupuesto.opcionPrecio">
                                <label for="precio">Precios</label>
                                <br>
                                <input type="checkbox" id="precioUnitario" v-model="presupuesto.opcionPrecioUnitario">
                                <label for="precioUnitario">Precios Unitarios</label>
                                <br>
                                <input type="checkbox" id="descripcionPaquete" v-model="presupuesto.opcionDescripcionPaquete">
                                <label for="descripcionPaquete">Descripcion Paquetes</label>
                                <br>
                                <input type="checkbox" id="descuento" v-model="presupuesto.opcionDescuento">
                                <label for="descuento">Descuentos</label>
                                <br>
                                <input type="checkbox" id="imagenes" v-model="presupuesto.opcionImagen">
                                <label for="imagenes">Imagenes</label>
                            </div>
                            <div class="col-md-3">
                                <input v-if="verIVA" type="text" v-model="iva" width="20%">
                            </div>
                            <div class="col-md-4 mt-4">
                                <h5>Subtotal: $<span>{{ calcularSubtotal | decimales }}</span></h5>
                                <input type="checkbox" id="iva" v-model="presupuesto.opcionIVA">
                                <label for="iva">IVA: $<span>{{ calcularIva | decimales }}</span>
                                </label>

                                <div class="info mt-3">
                                    <p>TOTAL con IVA: $<span>{{ (calcularSubtotal + calcularIva) | decimales }}</span></p>
                                    <p>Ahorro General: $<span>{{ calcularAhorro | decimales }}</span></p>
                                    <p>Comision pagada en base a $ <span>150</span></p>

                                    <button class="btn btn-sm btn-primary" @click="mostrarIVA()"><i class="si si-pencil"></i> Editar iva</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <button class="btn btn-sm btn-block btn-primary" @click="imprimirPDF()">Imprimir</button>
                    </div>
                    <div class="col-md-4 offset-md-2 mt-4">
                        <button class="btn btn-sm btn-block btn-success" @click="guardarPresupuesto()">Guardar Presupuesto</button>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#guardarContrato">Guardar Contrato</button>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-md-9 offset-md-1">
                
                <search-component></search-component>
                <hr>
                <lista-inventario-component></lista-inventario-component>
                
                <hr>
                
            </div>
        </div>
        -->

        

        <!-- Modal agregar paquete -->
        <div class="modal fade modalAgregarPaquete" id="agregarPaquete" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true" style="overflow-y: scroll;">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Armar paquete</h5>
                    <button type="button" class="close" onClick="$('#agregarPaquete').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <buscador-component
                                    placeholder="Buscar Productos"
                                    event-name="resultsPaquetes"
                                    :list="inventario"
                                    :keys="['servicio', 'id']"
                                    
                                ></buscador-component>
                                        </div>
                                    </div>
                                    <!-- Resultado Busqueda -->
                                    <div class="row" v-if="resultsPaquetes.length < inventario.length">
                                        <div v-if="resultsPaquetes.length !== 0" class="col-md-6 resultadoInventario">
                                            <div class="list-group" v-for="producto in resultsPaquetes" :key="producto.id">
                                                <div class="row producto" v-on:click="agregarProductoPaquete(producto)">
                                                    <div class="col-md-7">
                                                        <p>{{ producto.servicio }}</p>
                                                        <span class="badge badge-info">
                                                            {{ producto.precioUnitario }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <img class="img-fluid" src="https://i.redd.it/m2jtpv0kdff11.jpg" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = true">Agregar producto</button>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Primer columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Servicio</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Servicio" v-model="paquete.servicio">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio final</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio unitario" v-model="paquete.precioFinal">
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <h4>Precio sugerido: $<span v-text="precioSugerido"></span></h4>
                                    <input type="checkbox" id="guardarPaquete" v-model="paquete.guardarPaquete">
                                    <label for="guardarPaquete">Guardar paquete</label>

                                    <div class="form-group row">
                                        <label class="col-12" for="categoriaPaquete">Categoria</label>
                                        <div class="col-md-12">
                                            <select id="categoriaPaquete" name="categoriaPaquete" v-model="paquete.categoria">
                                                <option value="BODA">Boda</option>
                                                <option value="CUMPLEANOS">Cumpleaños</option>
                                                <option value="XV">XV Años</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio unitario</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paquete.inventario">
                                            <tr v-for="(producto, index) in paquete.inventario" v-bind:key="producto.index">
                                                <th scope="row">
                                                    <img :src="producto.imagen" width="100%">
                                                </th>
                                                <td>{{ producto.nombre }}</td>
                                                <td>
                                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="number" v-model="cantidadPaquete" v-on:keyup.enter="updateCantidadPaquete(index)">
                                                    <span v-else v-on:click="editarCantidadPaquete(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                                </td>
                                                <td>{{ producto.precioUnitario }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-danger" @click="eliminarProductoPaquete(index)">Eliminar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#agregarPaquete').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" @click="guardarPaquete()">Guardar paquete</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal agregar elemento -->
        <div class="modal fade" id="agregarElemento" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar elementos</h5>
                    <button type="button" class="close" onClick="$('#agregarElemento').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="row">
                                <!-- Primer columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Servicio</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Servicio" v-model="productoExterno.servicio">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio unitario</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio unitario" v-model="productoExterno.precioUnitario">
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12">Imagen</label>
                                        <div class="col-12">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input js-custom-file-input-enabled" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input" @change="obtenerImagen">
                                                <label class="custom-file-label" for="example-file-input-custom" style="overflow-x: hidden;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <figure>
                                            <img :src="imagen" width="100%" alt="Thumbnail">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#agregarElemento').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" @click="agregarProductoExterno()">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal ver contratos -->
        <div class="modal fade" id="verContratos" tabindex="-1" role="dialog" aria-labelledby="verContratos" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Contratos</h5>
                    <button type="button" class="close" onClick="$('#verContratos').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" v-if="clienteSeleccionadoContratos.length !== 0">
                        <div class="col-md-12">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Lista de contratos</h3>
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <code></code>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <table class="table table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>FECHA</th>
                                            <th class="d-none d-sm-table-cell" style="width: 15%;">EVENTO</th>
                                            <th class="text-center" style="width: 100px;">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="contrato in clienteSeleccionadoContratos" :key="contrato.index">
                                            <th class="text-center" scope="row">1</th>
                                            <td>{{ contrato.fechaEvento }}</td>
                                            <td class="d-none d-sm-table-cell">
                                                <span class="badge badge-primary">{{ contrato.tipoEvento }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#verContratos').modal('hide')">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal ver presupuestos -->
        <div class="modal fade" id="verPresupuestos" tabindex="-1" role="dialog" aria-labelledby="verPresupuestos" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Presupuestos</h5>
                    <button type="button" class="close" onClick="$('#verPresupuestos').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" v-if="clienteSeleccionadoPresupuestos.length !== 0">
                        <div class="col-md-12">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Lista de presupuestos</h3>
                                <div class="block-options">
                                    <div class="block-options-item">
                                        <code></code>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content">
                                <table class="table table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th>FECHA</th>
                                            <th class="d-none d-sm-table-cell" style="width: 15%;">EVENTO</th>
                                            <th class="text-center" style="width: 100px;">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="presupuesto in clienteSeleccionadoPresupuestos" :key="presupuesto.index">
                                            <th class="text-center" scope="row">1</th>
                                            <td>{{ presupuesto.fechaEvento }}</td>
                                            <td class="d-none d-sm-table-cell">
                                                <span class="badge badge-primary">{{ presupuesto.tipoEvento }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#verPresupuestos').modal('hide')">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal ver presupuestos -->
        <div class="modal fade" id="guardarContrato" tabindex="-1" role="dialog" aria-labelledby="guardarContrato" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Guardar Contrato</h5>
                    <button type="button" class="close" onClick="$('#guardarContrato').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="hora-1">Hora de inicio</label>
                            <input type="time" id="hora-1" class="form-control" v-model="facturacion.horaInicio">
                        </div>
                        <div class="col-md-4">
                            <label for="hora-2">Hora de fin</label>
                            <input type="time" id="hora-2" class="form-control" v-model="facturacion.horaFin">
                        </div>
                        <div class="col-md-4">
                            <label for="hora-2">Hora de entrega</label>
                            <select name="horaEntrega" id="" class="form-control" v-model="facturacion.horaEntrega">
                                <option value="MAÑANA">Mañana</option>
                                <option value="TARDE">Tarde</option>
                                <option value="MEDIO DIA">Medio dia</option>
                                <option value="NOCHE">Noche</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label form="fecha-hora">Fecha y hora de recoleccion</label>
                            <input id="fecha-hora" type="datetime-local" name="fecha-hora" class="form-control" v-model="facturacion.fechaRecoleccion">
                        </div>
                        <div class="col-md-6 mt-4">
                            <input id="requireFactura" type="checkbox" name="requireFactura" v-model="requiereFactura">
                            <label form="requireFactura">Factura</label>
                        </div>
                        <div class="col-md-12">
                            <label form="notasFactura">Notas facturacion</label>
                            <textarea id="notasFactura" class="form-control" width="100%" v-model="facturacion.notasFacturacion"></textarea>
                        </div>
                        <div class="col-md-12 mt-4">
                            <input class="form-control" type="text" placeholder="Nombre" v-model="facturacion.nombreFacturacion">
                        </div>
                        <div class="col-md-5 mt-4">
                            <input class="form-control" type="text" placeholder="Direccion" v-model="facturacion.direccionFacturacion">
                        </div>
                        <div class="col-md-2 mt-4">
                            <input class="form-control" type="text" placeholder="Numero" v-model="facturacion.numeroFacturacion">
                        </div>
                        <div class="col-md-5 mt-4">
                            <input class="form-control" type="text" placeholder="Colonia" v-model="facturacion.coloniaFacturacion">
                        </div>
                        <div class="col-md-6 mt-4">
                            <input class="form-control" type="email" placeholder="Email" v-model="facturacion.emailFacturacion">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#guardarContrato').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" @click="guardarContrato()">Save</button>
                </div>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
    import SearchComponent from './SearchComponent';
    import ListaInventarioComponent from './ListaInventarioComponent';
    import BuscadorComponent from './BuscadorComponent.vue';
    // Importamos el evento Bus.
    import { EventBus } from '../eventBus.js';

    export default {
        components: {
            SearchComponent,
            ListaInventarioComponent,
            BuscadorComponent,
        },
        data(){
            return{
                results: [],
                resultsPaquetes: [],
                clientResults: [],
                clienteSeleccionado: {
                    id: '',
                    nombre: '',
                    email: '',
                    nombreLugar: '',
                    direccionLugar: '',
                    numeroLugar: '',
                    coloniaLugar: '',
                    telefonos: [],
                    presupuestos: [],
                },
                clienteSeleccionadoContratos: [],
                clienteSeleccionadoPresupuestos: [],
                ultimoEvento: '',

                //Usuario y usuarios
                usuarioActual: '',
                usuarios: [],

                presupuesto:{
                    vendedor_id: '',
                    client_id: '',
                    tipoEvento: 'EXTERNO',
                    tipoServicio: 'FORMAL',
                    categoriaEvento: '',
                    fechaEvento: '',
                    pendienteFecha: '',
                    horaEventoInicio: '',
                    horaEventoFin: '',
                    pendienteHora: '',

                    //Lugar del Evento
                    lugarEvento: '',
                    pendienteLugar: '',
                    nombreLugar: '',
                    direccionLugar: '',
                    numeroLugar: '',
                    coloniaLugar: '',
                    CPLugar: '',
                    observacionesLugar: '',

                    //Informacion del Evento
                    numeroInvitados: '',
                    colorEvento: '',
                    temaEvento: '',

                    //Opciones presupuesto
                    opcionPrecio: '',
                    opcionPrecioUnitario: '',
                    opcionDescripcionPaquete: '',
                    opcionImagen: '',
                    opcionDescuento: '',
                    opcionIVA: '',

                    //Presupuesto o contrato
                    tipo: '',

                    //Impresion
                    impresion: false,
                },
                clientes: [],
                festejado: {
                    nombre: '',
                    edad: '',
                },
                inventario: [],

                //Control de elemento externo
                controlElementoExterno: false,
                //Agregar al invenatrio producto externo
                thumbnail: '',
                productoExterno: {
                    'externo': true,
                    'imagen': '',
                    'servicio': '',
                    'precioUnitario': '',
                },
                
                inventarioLocal: [],
                festejados: [],

                //Control sobre las ediciones en la tabla de productos
                indice: '',
                key: '',

                cantidadActualizada: '',
                ahorroActualizado: '',
                precioFinalActualizado: '',
                notasActualizadas: '',

                //Paquetes
                paquete: {
                    servicio: '',
                    precioFinal: '',
                    guardarPaquete: false,
                    categoria: '',
                    inventario: [],
                },
                precioSugerido: 0,
                cantidadPaquete: '',

                //IVA
                iva: 16,
                verIVA: false,

                // Ultimo presupuesto
                ultimoPresupuesto: '',

                //Imprimir presupuesto
                imprimir: false,

                //Datos facturacion
                requiereFactura: false,
                facturacion: {
                    //Tiempos
                    horaInicio: '',
                    horaFin: '',
                    horaEntrega: '',
                    fechaRecoleccion: '',
                    notasFacturacion: '',

                    //Datos
                    nombreFacturacion: '',
                    direccionFacturacion: '',
                    numeroFacturacion: '',
                    coloniaFacturacion: '',
                    emailFacturacion: '',
                }
            }
        },
        created(){
            this.obtenerUltimoPresupuesto();
            this.obtenerClientes();
            this.obtenerInventario();
            this.obtenerUsuario();
            this.obtenerUsuarios();
            
            this.$on('results', results => {
                this.results = results
            });
            this.$on('clientResults', clientResults => {
                this.clientResults = clientResults
            });
            this.$on('resultsPaquetes', resultsPaquetes => {
                this.resultsPaquetes = resultsPaquetes
            });    

        },
        computed:{
            imagen: function(){
                return this.productoExterno.imagen;
            },
            calcularSubtotal: function(){
                //Arreglo javascript de objetos json
                let json = this.inventarioLocal;
                //convirtiendo a json
                json = JSON.stringify(json);
                //Convirtiendo a objeto javascript
                let data = JSON.parse(json);
                var suma= 0;
                //Recorriendo el objeto
                for(let x in data){
                    suma += data[x].precioFinal; // Ahora que es un objeto javascript, tiene propiedades
                }

                return suma;
            },
            calcularIva: function(){
                return this.calcularSubtotal * (this.iva / 100);
            },
            calcularAhorro: function(){
                let ahorro = 0;
                this.inventarioLocal.forEach(function(element){
                    let precioNormal = element.cantidad * element.precioUnitario;
                    ahorro = ahorro + (precioNormal - element.precioFinal);
                })

                return ahorro;
            },
            obtenerFecha: function(){
                let fecha = moment().format("DD/MM/YYYY");
                return fecha;
            },
            obtenerFolio: function(){
                if(this.ultimoPresupuesto.length !== 0){
                    let cadena = this.ultimoPresupuesto.folio,
                        separador = "M",
                        data = cadena.split(separador);
                        console.log(data[1]);
                    if(this.presupuesto.tipoEvento == 'EXTERNO'){
                        let nuevoFolio = ('NM' + (parseInt(data[1]) + 1));
                        return nuevoFolio
                    }else{
                        let nuevoFolio = ('M' + (parseInt(data[1]) + 1));
                        return nuevoFolio
                    }
                    //return nuevoFolio;
                }
                

            },
            calcularContratos: function(){
                let contratos = this.clienteSeleccionado.presupuestos.filter(element => element.tipo == 'CONTRATO');
                this.clienteSeleccionadoContratos = contratos;
                return this.clienteSeleccionadoContratos.length;
            },
            calcularPresupuestos: function(){
                let presupuestos = this.clienteSeleccionado.presupuestos.filter(element => element.tipo == 'PRESUPUESTO');
                this.clienteSeleccionadoPresupuestos = presupuestos;
                return this.clienteSeleccionadoPresupuestos.length;
            }
        },
        filters: {
            decimales: function (x, posiciones = 2) {
                var s = x.toString()
                var l = s.length
                var decimalLength = s.indexOf('.') + 1

                if (l - decimalLength <= posiciones){
                    return x
                }
                // Parte decimal del número
                var isNeg  = x < 0
                var decimal =  x % 1
                var entera  = isNeg ? Math.ceil(x) : Math.floor(x)
                // Parte decimal como número entero
                // Ejemplo: parte decimal = 0.77
                // decimalFormated = 0.77 * (10^posiciones)
                // si posiciones es 2 ==> 0.77 * 100
                // si posiciones es 3 ==> 0.77 * 1000
                var decimalFormated = Math.floor(
                    Math.abs(decimal) * Math.pow(10, posiciones)
                )
                // Sustraemos del número original la parte decimal
                // y le sumamos la parte decimal que hemos formateado
                var finalNum = entera + 
                    ((decimalFormated / Math.pow(10, posiciones))*(isNeg ? -1 : 1))
                
                return finalNum;
            }
        },
        watch: {
            'presupuesto.lugarEvento': function(val){
                if(val == 'MISMA'){
                    this.presupuesto.nombreLugar = this.clienteSeleccionado.nombreLugar;
                    this.presupuesto.direccionLugar = this.clienteSeleccionado.direccionLugar;
                    this.presupuesto.numeroLugar = this.clienteSeleccionado.numeroLugar;
                    this.presupuesto.coloniaLugar = this.clienteSeleccionado.coloniaLugar;

                }else{
                     this.presupuesto.nombreLugar = '';
                    this.presupuesto.direccionLugar = '';
                    this.presupuesto.numeroLugar = '';
                    this.presupuesto.coloniaLugar = '';
                }
                
            },
            'requiereFactura': function(val){
                if(val){
                    this.facturacion.nombreFacturacion = this.clienteSeleccionado.nombreLugar;
                    this.facturacion.direccionFacturacion = this.clienteSeleccionado.direccionLugar;
                    this.facturacion.numeroFacturacion = this.clienteSeleccionado.numeroLugar;
                    this.facturacion.coloniaFacturacion = this.clienteSeleccionado.coloniaLugar;
                    this.facturacion.emailFacturacion = this.clienteSeleccionado.email;

                }else{
                    this.facturacion.nombreFacturacion = '';
                    this.facturacion.direccionFacturacion = '';
                    this.facturacion.numeroFacturacion = '';
                    this.facturacion.coloniaFacturacion = '';
                    this.facturacion.emailFacturacion = '';
                }
                
            },
        },
        methods:{
            obtenerUsuario(){
                let URL = '/obtener-usuario';

                axios.get(URL).then((response) => {
                    this.usuarioActual = response.data;
                    this.presupuesto.vendedor_id = this.usuarioActual.id;
                    console.log(this.usuarioActual);
                }).catch((error) => {
                    console.log(error.data);
                })
            },
            obtenerUsuarios(){
                let URL = '/obtener-usuarios';

                axios.get(URL).then((response) => {
                    this.usuarios = response.data;
                    console.log(this.usuarios)
                }).catch((error) => {
                    console.log(error);
                })
            },
            obtenerUltimoPresupuesto(){
                let URL = '/obtener-ultimo-presupuesto';

                axios.get(URL).then((response) => {
                    this.ultimoPresupuesto = response.data;
                    console.log(this.ultimoPresupuesto);
                }).catch((error) => {
                    console.log(error.data)
                });
            },
            //Mostrar el IVA
            mostrarIVA(){
                if(this.verIVA){
                    this.verIVA = false;
                }else{
                    this.verIVA = true;
                }
            },
            //Metodos para los paquetes
            agregarProductoPaquete(producto){
                this.paquete.inventario.push({
                    'externo': false,
                    'nombre': producto.servicio,
                    'imagen': producto.imagen,
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '',
                    'cantidad': '',
                    'id': producto.id,
                });
                console.log(this.paquete.inventario);
            },
                    actualizarPrecioSugerido(){
                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            this.precioSugerido+= this.paquete.inventario[i].precioFinal;
                        }
                    },
                    //Eliminar producto de paquete
                    eliminarProductoPaquete(index){
                        this.paquete.inventario.splice(index, 1);

                        this.precioSugerido = 0;

                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            
                            this.precioSugerido+= this.paquete.inventario[i].precioFinal;
                        }
                    },
                    //Actualizar la cantidad del paquete
                    editarCantidadPaquete(index, key){
                        console.log(key);
                        this.indice = index;
                        this.key = key[5];
                        console.log(index);
                        console.log(this.key);
                       
                    },
                    updateCantidadPaquete(index){
                        this.precioSugerido = 0;
                        let producto = this.paquete.inventario.find(function(element, indice){
                            return (indice == index);
                        });

                        producto.cantidad = this.cantidadPaquete;
                        producto.precioFinal = producto.cantidad * producto.precioUnitario;
                        this.paquete.inventario.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.cantidadPaquete = '';
                        this.key = '';
                        this.indice = '100000000';

                        this.actualizarPrecioSugerido();
                        
                    },
            guardarPaquete(){
                this.inventarioLocal.push({
                    'externo': false,
                    'imagen': 'https://i.redd.it/a0pfd0ajy5t01.jpg',
                    'servicio': this.paquete.servicio,
                    'cantidad': '',
                    'precioUnitario': this.paquete.precioFinal,
                    'precioFinal': '',
                    'ahorro': '',
                    'notas': '',
                    'paquete': this.paquete,
                    'tipo': 'PAQUETE',
                    'id': '',
                });
                console.log(this.inventarioLocal);


            },
            // Metodo para obtener el cliente seleccionado
            obtenerCliente(cliente){
                //let URL = '/obtener-cliente/' + cliente.id;
                let URL = '/obtener-cliente';
                axios.post(URL, {
                    'id': cliente.id,
                    'accion': 'telefonos',
                }).then((response) => {
                    this.clienteSeleccionado.telefonos = response.data;    
                }).catch((error) => {
                    console.log(error.data);
                });

                axios.post(URL, {
                    'id': cliente.id,
                    'accion': 'presupuestos',
                }).then((response) => {
                    this.clienteSeleccionado.presupuestos = [];
                    this.ultimoEvento = '';
                    if(response.data.length !== 0){
                        this.clienteSeleccionado.presupuestos = response.data;
                        let arreglo = response.data
                            arreglo.sort(function(a,b){
                                    return new Date(b.fechaEvento) - new Date(a.fechaEvento);
                            });
                        this.ultimoEvento = arreglo.shift();
                        this.clienteSeleccionado.presupuestos.push(this.ultimoEvento);
                    }
                }).catch((error) => {
                    console.log(error.data);
                });

                this.clienteSeleccionado.id = cliente.id;
                this.clienteSeleccionado.nombre = cliente.nombre;
                this.clienteSeleccionado.email = cliente.email;

                this.clienteSeleccionado.nombreLugar = cliente.nombreFacturacion;
                this.clienteSeleccionado.direccionLugar = cliente.direccionFacturacion;
                this.clienteSeleccionado.numeroLugar = cliente.numeroFacturacion;
                this.clienteSeleccionado.coloniaLugar = cliente.coloniaFacturacion;

                this.presupuesto.client_id = cliente.id;
            },
            //Metodos para procesar la imagen de prodcuto extero
            obtenerImagen(e){
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;

                this.cargarImagen(files[0]);
            },
            cargarImagen(file){
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    //this.thumbnail = e.target.result;
                    this.productoExterno.imagen = e.target.result;
                };

                reader.readAsDataURL(file);

            },
            //Agregar producto externo a la tabla de productos
            agregarProductoExterno(){
                if(this.controlElementoExterno){
                    this.paquete.inventario.push({
                        'externo': true,
                        'nombre': this.productoExterno.servicio,
                        'imagen': this.productoExterno.imagen,
                        'precioUnitario': this.productoExterno.precioUnitario,
                        'precioFinal': '',
                        'cantidad': '',
                        'id': '',
                    });
                }else{
                    this.inventarioLocal.push({
                        'externo': true,
                        'imagen': this.productoExterno.imagen,
                        'servicio': this.productoExterno.servicio,
                        'cantidad': '',
                        'precioUnitario': this.productoExterno.precioUnitario,
                        'precioFinal': '',
                        'ahorro': '',
                        'notas': '',
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': '',
                    });
                }
                
                this.productoExterno = {'externo': true, 'imagen': '', 'servicio': '', 'precioUnitario': '', 'paquete': ''};
            },
            // Bus para comunicar controladores
            busEvent() {
                // Enviar el evento por el canal click
                EventBus.$emit('click');
            },
            //Metodos dentro de la tabla productos
                // Eliminar
                eliminarProductoLocal(index){
                    this.inventarioLocal.splice(index, 1);
                },

                // Cantidad
                editarCantidad(index, key){
                    this.indice = index;
                    this.key = key[3];
                    console.log(index);
                    console.log(this.key);
                       
                },
                updateCantidad(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    producto.cantidad = this.cantidadActualizada;
                    producto.precioFinal = producto.cantidad * producto.precioUnitario;
                    this.inventarioLocal.splice(index, 1, producto);
                    console.log(this.inventarioLocal);
                    this.cantidadActualizada = '';
                    this.key = '';
                    this.indice = '100000000';
                },

                //Ahorro
                editarAhorro(index, key){
                    this.indice = index;
                    this.key = key[6]; 
                    console.log(index);
                    console.log(this.key);  
                },
                updateAhorro(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    if(producto.cantidad == ''){
                        alert('Primero define una cantidad');
                        return;
                    }else{
                        producto.precioFinal = producto.cantidad * producto.precioUnitario;
                        producto.precioFinal = producto.precioFinal - (producto.precioFinal * (this.ahorroActualizado / 100));
                        producto.ahorro = this.ahorroActualizado;
                        this.inventarioLocal.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.ahorroActualizado = '';
                        this.key = '';
                        this.indice = '100000000';
                    }
                    
                },

                //Precio Final
                editarPrecioFinal(index, key){
                    this.indice = index;
                    this.key = key[5];
                    console.log(index);
                    console.log(this.key);  
                },
                updatePrecioFinal(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    if(producto.cantidad == ''){
                        alert('Primero define una cantidad');
                        return;
                    }else{
                        let precioNormal = producto.cantidad * producto.precioUnitario;
                        let descuento = precioNormal - this.precioFinalActualizado;
                        producto.precioFinal = this.precioFinalActualizado;
                        producto.ahorro = (descuento / precioNormal) * 100;
                        
                        this.inventarioLocal.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.precioFinalActualizado = '';
                        this.key = '';
                        this.indice = '100000000';
                    }
                    
                },

                //Notas
                editarNotas(index, key){
                    this.indice = index; 
                    this.key = key[7];
                    console.log(index);
                    console.log(this.key); 
                },
                updateNotas(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    
                        producto.notas = this.notasActualizadas;
                        this.inventarioLocal.splice(index, 1, producto);
                        console.log(this.inventarioLocal);
                        this.notasActualizadas = '';
                        this.key = '';
                        this.indice = '100000000';
                    
                },

            //Otros metodos
            obtenerInventario(){
                let URL = '/obtener-inventario';
                axios.get(URL).then((response) => {
                    this.inventario = response.data;
                    console.log(this.inventario);
                }).catch((error) => {
                    console.log(error.data);
                });
            
            },
            agregarProducto(producto){
                this.inventarioLocal.push({
                    'externo': false,
                    'imagen': producto.imagen,
                    'servicio': producto.servicio,
                    'cantidad': '',
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '',
                    'ahorro': '',
                    'notas': '',
                    'paquete': '',
                    'tipo': 'PRODUCTO',
                    'id': producto.id,
                });
                console.log(this.inventarioLocal);
                
            },
            obtenerClientes(){
                let URL = '/obtener-clientes';
                axios.get(URL).then((response) => {
                    this.clientes = response.data;
                    console.log(this.clientes);
                })
            },
            agregarFestejado(){
                this.festejados.push({'nombre': this.festejado.nombre, 'edad': this.festejado.edad});
                //this.festejados.push({'nombre': this.festejado.nombre, 'edad': this.festejado.edad});
            },
            eliminarFestejado(index){
                this.festejados.splice(index, 1);
            },

            // Guardar como presupuesto
            guardarPresupuesto(){
                this.presupuesto.tipo = 'PRESUPUESTO';
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                let URL = '/presupuestos/create';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                }).then((response) => {
                    this.imprimir = true;
                    let URL = '/enviar-email';

                    axios.post(URL, {
                        'presupuesto': this.presupuesto,
                        'festejados': this.festejados,
                        'inventario': this.inventarioLocal,
                    }).then((response) => {
                        console.log('Email Enviado');
                    }).catch((error) => {
                        console.log(error.data);
                    });
                    
                    if(response.data == 1){
                        Swal.fire(
                            'Error!',
                            'No puede haber dos eventos en salon en la misma fecha',
                            'error'
                        );
                    }else{
                        Swal.fire(
                            'Creado!',
                            'El presupuesto ha sido creado',
                            'success'
                        );
                    }   
                    
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                        'Error!',
                        'Algo ha ocurrido mal',
                        'error'
                    );
                });
            },
            // Guardar como contrato
            guardarContrato(){
                this.presupuesto.tipo = 'CONTRATO';
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                if(this.requiereFactura){
                    for (const prop in this.facturacion) {
                        
                        if(this.facturacion[prop] == ''){
                            Swal.fire(
                                'Error',
                                'Los datos de facturacion deben ser completados',
                                'error'
                            );
                            return;
                        }
                        
                        
                    }
                }
                let URL = '/presupuestos/create';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                    'facturacion': this.facturacion,
                }).then((response) => {
                    this.imprimir = true;
                    
                    if(response.data == 1){
                        Swal.fire(
                            'Error!',
                            'No puede haber dos eventos en salon en la misma fecha',
                            'error'
                        );
                    }else{
                        Swal.fire(
                            'Creado!',
                            'El presupuesto ha sido creado',
                            'success'
                        );
                    }   
                    
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                        'Error!',
                        'Algo ha ocurrido mal',
                        'error'
                    );
                });
            },
            imprimirPDF(){
                if(!this.imprimir){
                    Swal.fire(
                        'Error!',
                        'Primero guarda el presupuesto',
                        'error'
                    );
                }else{
                    let URL = '/obtener-ultimo-presupuesto';

                    axios.get(URL).then((response) => {
                        this.imprimir = false;
                        let data = response.data;

                        //window.location.href = '/presupuestos/generar-pdf/' + data.id;
                        window.open('/presupuestos/generar-pdf/' + data.id);
                    }).catch((error) => {
                        console.log(error.data);
                    })
                }
            },
        }
    }
</script>

