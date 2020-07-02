<style>
    .logo-presupuesto{
        width: 25%;
        height: 130px;
        background-position: center;
        background-size: cover;
    }

    .registroPresupuesto .row{
        margin-bottom: 0px;
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
        background-color: white;
        overflow: scroll; 
        max-height: 300px;
        -webkit-box-shadow: 0px 5px 5px -2px rgba(38,38,38,1);
-moz-box-shadow: 0px 5px 5px -2px rgba(38,38,38,1);
box-shadow: 0px 5px 5px -2px rgba(38,38,38,1);
padding: 0;

    }

    table tr td input{
        border: none;
        background-color: transparent;
    }
    .contenedor-producto{
        border-bottom:none;
        padding-top: 8px;
        padding-bottom: 8px;
        height: 100%;
        margin-bottom: 0;
        font-size: 14px;
    }
    .contenedor-producto:hover{
        border-bottom:none; 
        padding-top: 8px;
        padding-bottom: 8px;
        background:#F2F2F2;
        cursor: pointer;
        margin-bottom: 0;
        font-size: 14px;
    }

    .nested{
        background-color: antiquewhite;
    }

</style>

<template>
    <section class="container">
        <div class="row">
            
        </div>
        <div class="row">
            <form action="POST" v-on:submit.prevent="guardarPresupuesto()">
            <div class="col-md-12 registroPresupuesto">
                <div class="row">
                    <div class="col-md-8 text-left">
                        <div v-if="presupuesto.tipoEvento == 'INTERNO' || presupuesto.tipoServicio == 'INFANTIL'" class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat; margin-top:-40px">

                        </div>
                        <div v-else class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo-decor.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat; margin-top:-40px">

                        </div>
                    </div>
                    <div class="col-md-3 text-right info">
                        <p style="font-size:25px; font-weight:bold">Folio: {{ obtenerFolio }}</p>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                <label>Vendedor: </label>
                            
                                
                            </div>
                            
                            <div class="col-md-8">
                                <select required name="vendedor" id="" v-model="presupuesto.vendedor_id">
                                    <option value="" selected>Seleccionar usuario</option>
                                    <option v-for="usuario in usuarios" :value="usuario.id" :key="usuario.index" >{{ usuario.name }}</option>
                                </select>
                            </div>
                        </div>
                        <p class="mt-3">Fecha de creación: <span>{{ obtenerFecha }}</span></p>
                    </div>
                </div>
                <div class="row" style="border-bottom:solid; border-width:1px; border-top:none; border-right:none; border-left:none; padding:5px;">
                    <div class="col-md-4">
                        <h4>Informacion del evento</h4>
                            <input id="salonMega" type="radio" name="tipoSalon" value="INTERNO" v-model="presupuesto.tipoEvento">
                            <label for="salonMega">Salon Mega Mundo</label>
                        <br>
                        <input id="salonFuera" type="radio" name="tipoSalon" value="EXTERNO" v-model="presupuesto.tipoEvento">
                        <label for="salonFuera">Evento Fuera</label>
                            <div class="text-left" v-if="presupuesto.tipoEvento == 'EXTERNO'" style="padding-left:30px;">
                                <input id="servicioFormal" type="radio" name="tipoServicio" value="FORMAL" v-model="presupuesto.tipoServicio">
                                <label for="servicioFormal">Servicio Formal</label>
                                <br>
                                <input id="servicioInfantil" type="radio" name="tipoServicio" value="INFANTIL" v-model="presupuesto.tipoServicio">
                                <label for="servicioInfantil">Servicio Infantil</label>
                            </div>
                    </div>
                    <div class="col-md-4 row">
                                <h4>Horario del evento</h4>
                            <div class="col-md-6" style="padding-left:0">
                                <label>Inicio del evento</label><br>
                                <input required type="time" v-if="presupuesto.pendienteHora==false" v-model="presupuesto.horaEventoInicio" id="inicioEvento">
                                <span v-if="presupuesto.pendienteHora==false">-AM</span> <input type="radio" v-if="presupuesto.pendienteHora==false" required value="AM" name="inicioAmPm" v-model="presupuesto.inicioAmPm"> 
                                <span v-if="presupuesto.pendienteHora==false">-PM</span> <input type="radio" v-if="presupuesto.pendienteHora==false" required value="PM" name="inicioAmPm" v-model="presupuesto.inicioAmPm"> 
                            </div>
                           
                            <div class="col-md-6" style="padding-left:0">
                                <label>Fin del evento</label><br>
                                <input v-if="presupuesto.pendienteHora==false" required type="time" v-model="presupuesto.horaEventoFin" id="finEvento">
                                <span v-if="presupuesto.pendienteHora==false">-AM</span> <input type="radio" v-if="presupuesto.pendienteHora==false" required value="AM" name="finAmPm" v-model="presupuesto.finAmPm"> 
                                <span v-if="presupuesto.pendienteHora==false">-PM</span> <input type="radio" v-if="presupuesto.pendienteHora==false" required value="PM" name="finAmPm" v-model="presupuesto.finAmPm"> 
                            </div>
                             <label for="pendienteHora" style="padding-top:10px">
                             <input type="checkbox" name="1" id="pendienteHora" v-model="presupuesto.pendienteHora">
                            Pendiente</label>
                            </div>
                    <div class="col-md-4">
                        
                        <div class="row" >
                            <div class="col-md-12">
                                <h4 class="">Categoria del evento</h4>
                                <select v-if="categorias.length != 0" required name="categoriaEvento" id="" v-model="presupuesto.categoriaEvento">
                                    <option v-for="(item, index) in categorias" :key="index" :value="item.nombre">
                                        {{ item.nombre }}
                                    </option>
                                </select>
                                 <p v-if="permisos.creacionAdministrarCategorias==1" style="" class="btn-text" data-toggle="modal" data-target="#agregarCategoria"><i class="fa fa-edit"></i> Administrar Categorias</p>
                                
                                <div class="row mt-4">
                                    <div class="col-md-10">
                                        <label v-if="presupuesto.pendienteFecha" for="">Fecha del evento pendiente</label>
                                        <input v-if="presupuesto.pendienteFecha==false" type="date" required v-model="presupuesto.fechaEvento">
                                    </div>
                                    <div class="col-md-2 text-left">
                                        <i class="si si-calendar" style="font-size: 24px;"></i>
                                    </div>
                                    
                                </div>
                                <input type="checkbox" name="" value="1" id="pendienteFecha" v-model="presupuesto.pendienteFecha">
                                <label for="pendienteFecha">Pendiende</label>

                            </div>
                        </div>
                        
                        <div class="row">
                            
                          
                        </div>
                        
                    </div>
                </div>

                
                <div class="row" style="border-bottom:solid; border-width:1px; padding:5px; border-top:none; border-right:none; border-left:none">
                    <div class="col-md-8">
                        <h4>Cliente</h4>
                        <div class="row">
                            <div class="col-md-7" style="">
                                <buscador-component
                                    :limpiar="limpiar"
                                    placeholder="Buscar Clientes Existentes"
                                    event-name="clientResults"
                                    :list="clientes"
                                    :keys="['nombre', 'email', 'telefono', 'apellidoPaterno' , 'apellidoMaterno']" 
                                ></buscador-component><i class="si si-refresh" v-on:click="refrescarClientes()"  style="color:green; position:absolute; right:0; top:5px; cursor:pointer"></i>

                                <!-- Resultado Busqueda -->
                                <div class="row" v-if="clientResults.length < clientes.length">
                                    <div v-if="clientResults.length !== 0" class="col-md-12 resultadoInventario">
                                        <div v-for="cliente in clientResults.slice(0,35)" :key="cliente.id">
                                            <div class="row contenedor-producto" v-on:click="obtenerCliente(cliente)" style="margin:0">
                                               <div class="col-md-3">
                                                    <img class="img-fluid" src="https://i.stack.imgur.com/l60Hf.png" alt="">
                                                </div>
                                                <div class="col-md-8">
                                                    <p style="padding:0; margin:0; line-height:14px; font-size:13px; "><span style="font-weight:bolder"> {{ cliente.nombre }} {{ cliente.apellidoPaterno }} {{ cliente.apellidoMaterno }}</span></p>
                                                    <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ cliente.email }}</p>
                                                    <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ cliente.telefono }}</p>
                                                    
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
                            <div class="col-md-5">
                                <div v-if="permisos.creacionNuevoCliente==1" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevoClienteModal"><span class="fa fa-user-plus"></span> Registrar Nuevo Cliente</div>
                            </div>
                        </div>
                        <div v-if="clienteSeleccionado.length != 0" class="info" style="padding-top:15px;">
                            <p>{{ clienteSeleccionado.nombre }}</p>
                            <p>
                                <span class="badge badge-pill badge-info">Persona {{ clienteSeleccionado.tipo }}</span>
                            </p>
                            <p>{{ clienteSeleccionado.email }}</p>
                            <p v-for="telefono in clienteSeleccionado.telefonos" v-bind:key="telefono.index">
                                <label>
                                    <input type="radio" name="email" @change="presupuesto.emailEnvio = telefono.email"> 
                                    {{ telefono.email }} - {{ telefono.numero }} - {{ telefono.nombre }} - {{ telefono.tipo }} - {{ telefono.departamento }}
                                </label>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 text-right" v-if="clienteSeleccionado">
                        <div class="info">
                            <p>Ultimo evento: 
                                <span v-if="clienteSeleccionado && ultimoEvento">{{ ultimoEvento.fechaEvento }}</span>
                                <span v-else>Primer Evento</span>
                            </p>
                            <p><span>{{ calcularContratos }}</span> eventos contratados</p>
                            <p><span>{{ calcularPresupuestos }}</span> presupuestos</p>
                                <div v-if="calcularContratos" class="btn btn-sm btn-primary d-inline-block" data-toggle="modal" data-target="#verContratos">Ver Contratos</div>
                                <div v-if="calcularPresupuestos" class="btn btn-sm btn-info d-inline-block" data-toggle="modal" data-target="#verPresupuestos">Ver Presupuestos</div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-4">
                        <label>Requiere factura:</label> 
                        -SI <input type="radio" required value="SI" name="requiereFactura" v-model="presupuesto.requiereFactura"> 
                        -NO <input type="radio" value="NO" name="requiereFactura" v-model="presupuesto.requiereFactura"> 
                    </div>
                    <div class="col-md-4">
                        <label>Requiere montaje:</label>
                        -SI <input type="radio" required value="SI" name="requiereMontaje" v-model="presupuesto.requiereMontaje">
                        -NO <input type="radio" value="NO" name="requiereMontaje" v-model="presupuesto.requiereMontaje"> 
                    </div>
                </div>
                </div>
                
                <h4>Lugar del Evento</h4>
                <div class="row" style="border-bottom:solid; border-width:1px; border-top:none; border-right:none; border-left:none; padding-bottom:20px">
                    <div class="col-md-3">
                        <input type="radio" id="lugarMismo" name="lugarEvento" value="MISMA" v-model="presupuesto.lugarEvento">
                        <label for="lugarMismo">Misma Direccion</label>
                    </div>
                    <div class="col-md-3">
                        <input type="radio" id="lugarOtro" name="lugarEvento" value="OTRA" v-model="presupuesto.lugarEvento">
                        <label for="lugarOtro">Otra</label>
                    </div>
                    <div class="col-md-3">
                        <input type="radio" id="lugarBodega" name="lugarEvento" value="BODEGA" v-model="presupuesto.lugarEvento">
                        <label for="lugarBodega">Recoleccion en bodega</label>
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" id="pendienteLugar" value="1" v-model="presupuesto.pendienteLugar">
                        <label for="pendienteLugar">Pendiente</label>
                    </div>

                    <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar==false" class="col-md-10 mt-4">
                        <input required type="text" placeholder="Nombre del lugar" v-model="presupuesto.nombreLugar">
                    </div>
                    <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar==false" class="col-md-10 mt-4">
                        <input required type="text" placeholder="Direccion" v-model="presupuesto.direccionLugar">
                    </div>
                    <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar==false" class="col-md-2 mt-4">
                        <input required type="text" placeholder="Numero" v-model="presupuesto.numeroLugar">
                    </div>
                    <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar==false" class="col-md-4 mt-4">
                        <input required type="text" placeholder="Colonia" v-model="presupuesto.coloniaLugar">
                    </div>
                    <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar==false" class="col-md-2 mt-4">
                        <input type="text" placeholder="C.P" v-model="presupuesto.CPLugar">
                    </div>
                    <div class="col-md-12 mt-4">
                        <input type="text" name="" id=""  style="background:#FFFDC8; border:none;  padding:2px;" placeholder="Observaciones" v-model="presupuesto.observacionesLugar">
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
                        <input type="text" placeholder="Nombre del festejado" v-model="festejado.nombre">
                        <input class="mt-2" type="text" placeholder="Edad o motivo de festejo" v-model="festejado.edad">
                    </div>
                    <div class="col-md-1 mt-4" style="padding-top:15px;">
                        <div class="btn btn-sm btn-primary mt-4" v-on:click.prevent="agregarFestejado()"><i class="fa fa-plus-circle
"></i>Agregar</div>
                    </div>

                <!-- Tabla de festejados -->
                
                <div class="col-md-4 offset-md-8" v-if="festejados.length !== 0">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead style="font-size:12px;">
                                <tr style="font">
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col">Guardar</th>
                                    <th scope="col" class="text-center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(festejado, index) in festejados" v-bind:key="festejado.index">
                                    <td>{{ festejado.nombre }}</td>
                                    <td>{{ festejado.edad }}</td>
                                    <td><input type="checkbox"></td>
                                    <td class="text-center">
                                        <div class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarFestejado(index)"><i class="fa fa-remove"></i></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                </div>
<div class="col-md-6">
                         <label>Comentarios de presupuesto (No visibles para cliente)</label>
                       
                <textarea name="" id="" style="width:100%" rows="5" placeholder="Notas" v-model="presupuesto.notasPresupuesto"></textarea>

                     </div>
                </div>
                
                <h4>Archivos de Referencia</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" accept=".pdf" name="referencias" id="">
                    </div>
                </div>

                <hr>

                <!-- SECTION 2 -->
                <div class="row">
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-4">
                                <buscador-component
                                    :limpiar="limpiar"
                                    placeholder="Buscar Productos"
                                    event-name="results"
                                    :list="inventario"
                                    :keys="['servicio', 'id', 'familia']"
                                    
                                ></buscador-component><span><i class="fa fa-remove" @click="limpiarInput()" style="color:red; position:absolute; right:0;"></i></span>

                            </div>
                            <div class="col-md-7">
                                <div class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#agregarPaquete"><span class="fa fa-plus-circle"></span> Nuevo Paquete</div>
                                <div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = false"><span class="fa fa-plus-circle"></span> Nuevo Elemento</div>
                                <div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bocadillosModal"><span class="fa fa-plus-circle"></span> Mesa de bocadillos</div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- Resultado Busqueda items -->
                <div class="row" v-if="results.length < inventario.length">
                    <div v-if="results.length !== 0" class="col-md-4 resultadoInventario">
                        <div class="list-group" v-for="producto in results.slice(0,40)" :key="producto.id">
                            <div class="row contenedor-producto" style="cursor:auto;" >
                                <div class="col-md-3" >
                                    <img class="img-fluid" style="margin-left:10px;" :src="producto.imagen" alt="">
                                </div>
                                <div class="col-md-7">
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">{{ producto.servicio }}</span></p>
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span>Precio: ${{ producto.precioUnitario }}</p>
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> Familia: {{ producto.familia }}</p>
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> En Bodega: {{ producto.cantidad }} <span>Exhibición: {{producto.exhibicion}}</span></p>
                                </div>
                                <div  class="col-md-2" style="padding-top:15px"><i v-on:click="agregarProducto(producto)" style="color:#B2B2B2; cursor:pointer; font-size:26px" class="fa fa-plus-circle"></i></div>
                                
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
                                <th scope="col">Imagen</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Cantidad</th>
                                
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Precio Especial Unitario</th>
                                <th scope="col">Total con descuento</th>
                                <th scope="col">Ahorro Unitario</th>
                                <th scope="col" width="252">Notas</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(producto, index) in inventarioLocal" v-bind:key="producto.index" v-bind:style="[{ 'background-color': producto.anidado ? 'antiquewhite' : '' }]">
                                <td style="width:120px; position:relative;">
                                    <img v-bind:src="producto.imagen" alt="" width="100%">
                                    <div style="position:absolute; font-size:10px; background:green; color:white; width:100%; border-radius:5px; top:0; text-align:center">Aun Disponible: {{producto.disponible}}</div>
                                </td>
                                <td>{{ producto.servicio }}<br>
                                <span style="font-size:10px; font-style:italic">Proveedor: {{producto.proveedor}}</span><br>
                                <span style="font-size:10px; font-style:italic">Costo: {{producto.precioVenta}}</span><br>
                                </td>
                                <td>
                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="text" v-model="cantidadActualizada" v-on:change="updateCantidad(index)">
                                    <span v-else v-on:click="editarCantidad(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                    
                                </td>
                                
                                <td>
                                    
                                    <input v-if="(producto.precioUnitario == '') || (indice == index && key == 'precioUnitario')" type="text" v-model="precioUnitarioActualizada"  v-on:change="updatePrecioUnitario(index)">
                                    <span v-else  v-on:click="editarPrecioUnitario(index, Object.keys(producto))">{{ producto.precioUnitario | currency}}</span>
                                    <del v-if="(indice == index && key == 'precioUnitario')">{{ producto.precioAnterior }}</del>
                                 </td>
                                 <th scope="row">
                                    <input v-if="(producto.precioEspecial == '') || (indice == index && key == 'precioEspecial')" type="text" v-model="precioEspecialActualizado" v-on:change="updatePrecioEspecial(index)">
                                    <span v-else v-on:click="editarPrecioEspecial(index, Object.keys(producto), producto)">{{ producto.precioEspecial | currency}}</span>
                                </th>
                                <td>
                                    <input v-if="(producto.precioFinal == '') || (indice == index && key == 'precioFinal')" type="text" v-model="precioFinalActualizado" v-on:change="updatePrecioFinal(index)">
                                    <span v-else >{{ producto.precioFinal | currency }}</span>
                                </td>
                                <td>
                                    <input v-if="(producto.ahorro == '') || (indice == index && key == 'ahorro')" type="text" v-model="ahorroActualizado" v-on:change="updateAhorro(index)">
                                    <span v-else v-on:click="editarAhorro(index, Object.keys(producto))">{{ producto.ahorro | currency}}</span>
                                </td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="2" v-if="(producto.notas == '' && indice == index && key == 'notas') || indice == index && key == 'notas'" v-model="notasActualizadas" v-on:change="updateNotas(index)">
                                        
                                    </textarea>
                                    <p style="background:#E4F9DB; widht:100%; min-height:10px; border-radius:5px" v-else v-on:click="editarNotas(index, Object.keys(producto), producto.notas)">
                                        {{ producto.notas }}
                                    </p>
                                    

                                </td>
                                <td class="text-center">
                                    <!--
                                    <div v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-primary" @click="editarPaquete(producto, index)">Editar</div>
                                    -->
                                    <div v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-info" @click="verPaquete(producto, index)">Ver</div>
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-success" @click="editarPaquete(producto)">Editar</button>
                                    <div class="btn btn-sm btn-danger" @click="eliminarProductoLocal(index)">Eliminar</div>
                                    <div v-if="producto.externo" class="btn btn-sm btn-primary" @click="editarProductoExterno(producto, index)">Editar</div>
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
                                <input hidden  type="checkbox" id="precio" v-model="presupuesto.opcionPrecio">
                                <label hidden for="precio">Precios Totales</label>
                                <br>
                                <input hidden   type="checkbox" id="precioUnitario" v-model="presupuesto.opcionPrecioUnitario">
                                <label hidden for="precioUnitario">Precios Unitarios</label>
                                <br>
                                <input type="checkbox" id="descripcionPaquete" v-model="presupuesto.opcionDescripcionPaquete">
                                <label for="descripcionPaquete">Descripcion Paquetes</label>
                                <br>
                                <input type="checkbox" id="imagenes" v-model="presupuesto.opcionImagen">
                                <label for="imagenes">Imagenes</label>
                                <input style="display:none"  checked type="checkbox" id="descuento" v-model="presupuesto.opcionDescuento">
                                <label style="display:none" for="descuento">Descuento General</label>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-4 mt-4">
                                <h5 style="color:grey">Subtotal: <span>{{ calcularSubtotal | currency }}</span></h5>
                                <input type="checkbox" id="iva" v-model="presupuesto.opcionIVA">
                                <label for="iva">IVA: <span>{{ calcularIva | currency }}</span>
                                </label>

                                <div class="info mt-3">
                                    <H5 v-if="presupuesto.opcionIVA==true">TOTAL + IVA: <span>{{ (calcularSubtotal + calcularIva) | currency }}</span></H5>
                                    <H5 v-else>TOTAL: <span>{{ (calcularSubtotal) | currency }}</span></H5>
                                    <p>Ahorro General: <span>{{ calcularAhorro | currency }}</span></p>

                                </div>
                            </div>
                        </div>
                    </div>
                     
                </div>

                <div class="">
                        <div style="display:none" class="btn btn-primary" @click="imprimirPDF()"><i class="si si-printer"></i> Imprimir</div>
                        <!--
                        <div class="btn btn-primary" @click="guardarPresupuesto()"><i class="fa fa-save"></i> Guardar como presupuesto</div>
                        -->
                        <img src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif" id="LoadingImage" style="width:100px; display:none">
                        <!--<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar como presupuesto</button>-->
                        <div v-if="permisos.creacionGuardarComoContrato==1" class="btn btn-primary" @click="ModalGuardarContrato()"><i class="fa fa-check"></i> Guardar como contrato</div>
                        <div v-if="permisos.creacionSettings==1" class="btn btn-secondary" @click="mostrarSettings()"><i class="si si-settings"></i> Settings</div>
                </div>
                <div class="col-md-4" style="padding-top:20px">
                    <h2 v-if="verSettings">Settings </h2>
                    <label v-if="verSettings">Seleccionar comisión de presupuesto</label><br>
                                <select v-if="verSettings" type="text" v-model="presupuesto.comision" width="20%">
                                    <option value="100">Comision completa</option>
                                    <option value="50">Comision a la mitad</option>
                                    <option value="0">Introducir manualmente</option>
                                </select>
                    <label v-if="verSettings">IVA establecido</label>
                    <input v-if="verSettings" type="text" v-model="iva" width="20%">
                </div>
            </div>
            </form>
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
            <div id="app" class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Crear nuevo paquete</h5>
                    <div  class="close" onClick="$('#agregarPaquete').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-10 offset-md-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-12" style="border:solid; border-width:1px; border-radius:3px; background:#D0FAF2">
                                            <buscador-component
                                            :limpiar="limpiar"
                                    placeholder="Buscar Productos Existentes"
                                    event-name="resultsPaquetes"
                                    :list="inventario"
                                    :keys="['servicio', 'id', 'familia']"
                                    
                                ></buscador-component>
                                        </div>
                                    </div>
                                    <!-- Resultado Busqueda paquetes-->
                                    <div class="row" v-if="resultsPaquetes.length < inventario.length">
                                        <div v-if="resultsPaquetes.length !== 0" class="col-md-12 resultadoInventario">
                                            <div class="list-group" v-for="producto in resultsPaquetes.slice(0,20)" :key="producto.id">
                                                <div class="row contenedor-producto" v-on:click="agregarProductoPaquete(producto)">
                                                    <div class="col-md-9">
                                                        
                                                        <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">Servicio:</span> {{ producto.servicio }}</p>
                                                        <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">Precio Unitario:</span> ${{ producto.precioUnitario }}</p>
                                                        <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">Categoría:</span> {{ producto.familia }}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img class="img-fluid" :src="producto.imagen" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = true">Agregar nuevo producto</div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Primer columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Servicio</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Servicio" v-model="paquete.servicio" style="background:#FFECA7">
                                        </div>
                                    </div>

                                    <div class="form-group row" >
                                        <label class="col-12" for="example-text-input">Precio del paquete</label>
                                        <div class="col-md-12">
                                            <input type="text"  class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio de paquete" v-model="paquete.precioFinal" style="background:#FFECA7">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="display:none">
                                        <label class="col-12" for="example-text-input">Costo total de proveedores</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Costo de proveedores" v-model="paquete.precioVenta" style="background:#FFECA7">
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <h4>Precio sugerido: $<span v-text="precioSugerido"></span></h4>
                                    <h4>Utilidad: $<span v-text="utilidad"></span></h4>
                                    <h4>Costo total proveedor: $<span v-text="costoProveedor"></span></h4>
                                    <input type="checkbox" id="guardarPaquete" v-model="paquete.guardarPaquete">
                                    <label for="guardarPaquete">Guardar paquete</label>

                                    <div class="form-group row">
                                        <label class="col-12" for="categoriaPaquete">Categoria</label>
                                        <div class="col-md-12">
                                            <select id="categoriaPaquete" name="categoriaPaquete" v-model="paquete.categoria">
                                                <option value="Manteleria">Manteleria</option>
                                                <option value="Toboganes">Toboganes</option>
                                                <option value="Mobiliario">Mobiliario</option>
                                                <option value="Floristeria">Floristeria</option>
                                                <option value="Comida">Comida</option>
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
                                                <th scope="col">Precio especial unitario</th>
                                                <th scope="col">Total con descuento</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paquete.inventario">
                                            <tr v-for="(producto, index) in paquete.inventario" v-bind:key="producto.index">
                                                <th scope="row">
                                                    <img :src="producto.imagen" width="100px">
                                                </th>
                                                <td>{{ producto.nombre }}
                                                     <br><span style="font-size:10px; line-height:8px;">Costo Proveedor: ${{producto.precioVenta}}</span>
                                                </td>
                                                
                                                <td>
                                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="number" v-model="cantidadPaquete" v-on:change="updateCantidadPaquete(index)">
                                                    <span v-else v-on:click="editarCantidadPaquete(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                                </td>
                                                <td>
                                                    <input v-if="(producto.precioUnitario == '') || (indice == index && key == 'precioUnitario')" type="number" v-model="precioUnitarioPaquete" v-on:change="updatePrecioUnitarioPaquete(index)">
                                                    <span v-else v-on:click="editarPrecioUnitarioPaquete(index, Object.keys(producto), producto)">{{ producto.precioUnitario }}</span>
                                                </td>
                                                <td>
                                                    <input v-if="(producto.precioEspecial == '') || (indice == index && key == 'precioEspecial')" type="number" v-model="precioEspecialPaquete" v-on:change="updatePrecioEspecialPaquete(index)">
                                                    <span v-else v-on:click="editarPrecioEspecialPaquete(index, Object.keys(producto), producto)">{{ producto.precioEspecial }}</span>
                                                </td>
                                                <td>{{ producto.precioFinal }}</td>
                                                <td class="text-center">
                                                    <div class="btn btn-sm btn-danger" @click="eliminarProductoPaquete(index)">Eliminar</div>
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
                    <div  class="btn btn-secondary" onClick="$('#agregarPaquete').modal('hide')">Close</div>
                    <div  class="btn btn-primary" @click="guardarPaquete()">Guardar paquete</div>
                </div>
                </div>
            </div>
        </div>

<div  class="modal fade" id="bocadillosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div  class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div style="border:solid; border-color:gray" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mesas de bocadillos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <bocadillos-component @guardarMesa="recuperarMesaDulces"></bocadillos-component>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onClick="$('#bocadillosModal').modal('hide')">Cancelar</button>
                     
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
                    <div  class="close" onClick="$('#agregarElemento').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
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
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Servicio" v-model="productoExterno.servicio">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="proveedor" placeholder="Proveedor" v-model="productoExterno.proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Costo Unitario Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Costo Proveedor" v-model="productoExterno.precioVenta">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio unitario publico</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Precio unitario" v-model="productoExterno.precioUnitario">
                                        </div>
                                    </div> 
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12">Imagen</label>
                                        <div class="col-12">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input js-custom-file-input-enabled" id="file-image-externo" name="example-file-input-custom" data-toggle="custom-file-input" @change="obtenerImagen">
                                                <label class="custom-file-label" for="example-file-input-custom" style="overflow-x: hidden;"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <figure>
                                            <img :src="imagen" width="100%" alt="Thumbnail">
                                        </figure>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="custom-file">
                                                <input type="checkbox" name="autorizado" id="" v-model="productoExterno.autorizado">
                                            Guardar en inventario
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div  class="btn btn-secondary" onClick="$('#agregarElemento').modal('hide')">Cerrar</div>
                    <div  class="btn btn-primary" @click="agregarProductoExterno()">Guardar</div>
                </div>
                </div>
            </div>
        </div>

        <!-- Editar producto externo -->
        <div v-if="editarElementoExt != null" class="modal fade" id="editarElementoExterno" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar elementos</h5>
                    <div  class="close" onClick="$('#editarElementoExterno').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
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
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Servicio" v-model="editarElementoExt.servicio">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="proveedor" placeholder="Proveedor" v-model="editarElementoExt.proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Costo Unitario Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Costo Proveedor" v-model="editarElementoExt.precioVenta">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio unitario publico</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Precio unitario" v-model="editarElementoExt.precioUnitario">
                                        </div>
                                    </div> 
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12">Imagen</label>
                                        <div class="col-12">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input js-custom-file-input-enabled" id="file-image-externo" name="example-file-input-custom" data-toggle="custom-file-input" @change="obtenerImagen">
                                                <label class="custom-file-label" for="example-file-input-custom" style="overflow-x: hidden;"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <figure>
                                            <img :src="imagen" width="100%" alt="Thumbnail">
                                        </figure>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="custom-file">
                                                <input type="checkbox" name="autorizado" id="" v-model="editarElementoExt.autorizado">
                                            Guardar en inventario
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div  class="btn btn-secondary" onClick="$('#editarElementoExterno').modal('hide')">Cerrar</div>
                    <div  class="btn btn-primary" onClick="$('#editarElementoExterno').modal('hide')">Guardar</div>
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
                    <div  class="close" onClick="$('#verContratos').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
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
                                            <th>FECHA EVENTO</th>
                                            <th>VENDEDOR</th>
                                            <th class="d-none d-sm-table-cell" style="width: 15%;">EVENTO</th>
                                            <th>TOTAL</th>
                                            <th class="text-center" style="width: 100px;">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="contrato in clienteSeleccionadoContratos" :key="contrato.index">
                                            <th class="text-center" scope="row">1</th>
                                            <td>{{ contrato.fechaEvento }}</td>
                                            <td>{{ contrato.vendedor_id }}</td>
                                            <td class="d-none d-sm-table-cell">
                                                <span class="badge badge-primary">{{ contrato.tipoEvento }}</span>
                                            </td>
                                            <td>{{ contrato.total }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a target="_blank" :href="'/presupuestos/ver/' + contrato.id" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
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
                    <div  class="btn btn-secondary" onClick="$('#verContratos').modal('hide')">Cerrar</div>
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
                    <div  class="close" onClick="$('#verPresupuestos').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
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
                                            <th>FECHA EVENTO</th>
                                            <th>VENDEDOR</th>
                                            <th class="d-none d-sm-table-cell" style="width: 15%;">EVENTO</th>
                                            <td>TOTAL</td>
                                            <th class="text-center" style="width: 100px;">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="presupuesto in clienteSeleccionadoPresupuestos" :key="presupuesto.index">
                                            <th class="text-center" scope="row">1</th>
                                            <td>{{ presupuesto.fechaEvento }}</td>
                                            <td>{{ presupuesto.nombreVendedor }}</td>
                                            <td class="d-none d-sm-table-cell">
                                                <span class="badge badge-primary">{{ presupuesto.tipoEvento }}</span>
                                            </td>
                                            <td>{{ presupuesto.total }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a target="_blank" :href="'/presupuestos/ver/' + presupuesto.id"  class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
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
                    <div  class="btn btn-secondary" onClick="$('#verPresupuestos').modal('hide')">Cerrar</div>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal guardar contrato -->
        <div class="modal fade" id="guardarContrato" tabindex="-1" role="dialog" aria-labelledby="guardarContrato" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Guardar Contrato</h5>
                    <div  class="close" onClick="$('#guardarContrato').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body">
                    <label>Hora de entrega de mobiliario</label><br>
                    <div class="col-md-12">
                    <label style="font-weight:bold; color:blue" for="" v-if="presupuesto.lugarEvento=='BODEGA'">Recolección en bodega</label>
                    <label style="font-weight:bold; color:blue" for="" v-if="presupuesto.pendienteLugar">Pendiente Lugar de entrega</label>
                    </div>
                    <div class="row">
                        
                        <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar!=true" class="col-md-4">
                            <label for="hora-1">Desde</label>
                            <input type="time" id="hora-1" class="form-control" v-model="facturacion.horaInicio">
                        </div>
                        <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar!=true" class="col-md-4">
                            <label for="hora-2">Hasta</label>
                            <input type="time" id="hora-2" class="form-control" v-model="facturacion.horaFin">
                        </div>
                        <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar!=true" class="col-md-4">
                            <label for="hora-2">Entrega preferente</label>
                            <select name="horaEntrega" id="" class="form-control" v-model="facturacion.horaEntrega" @change="modificarHoraEntrega()">
                                <option selected value="OTRO">Otra</option>
                                <option value="NO APLICA">NO APLICA</option>
                                <option value="MISMO DIA">MISMO DIA</option>
                                <option value="LA MAÑANA">Por la mañana</option>
                                <option value="LA TARDE">Por la tarde</option>
                                <option value="MEDIO DIA">A medio dia</option>
                                <option value="LA NOCHE">Por la noche</option>
                                <option value="PENDIENTE">Pendiente por confirmar cliente</option>
                                <option value="SIEMPRE HAY ALGUIEN">Siempre hay alguien</option>
                                <option value="UN DIA ANTES">Un Dia Antes</option>
                                <option value="DOS DIAS ANTES">Dos Dias Antes</option>
                            </select>
                        </div>
                        <br>
                        <div class="col-md-12">
                        <label>Fecha y Hora de retorno de mobiliario</label><br></div>
                        <div v-if="facturacion.entregaEnBodega!=true" class="col-md-4" style="padding-top:20px">
                            <label form="fecha-hora">Fecha de recoleccion</label>
                            <input id="recoleccionFecha" type="date" name="recoleccionFecha" class="form-control" v-model="facturacion.fechaRecoleccion">
                        </div>
                        <div v-if="facturacion.entregaEnBodega!=true" class="col-md-4" style="padding-top:20px">
                            <label form="fecha-hora">Hora de recoleccion</label>
                            <input id="recoleccionHora" type="time" name="recoleccionHora" class="form-control" v-model="facturacion.horaRecoleccion">
                        </div>
                        <div v-if="facturacion.entregaEnBodega!=true" class="col-md-4" style="padding-top:20px">
                            <label for="hora-2">Recolección preferente</label>
                            <select id="" class="form-control" v-model="facturacion.recoleccionPreferente" @change="modificarHoraRecoleccion()">
                                <option selected value="OTRO">Otra</option>
                                <option value="NO APLICA">NO APLICA</option>
                                <option value="MISMO DIA">MISMO DIA</option>
                                <option value="LA MAÑANA">Por la mañana</option>
                                <option value="LA TARDE">Por la tarde</option>
                                <option value="MEDIO DIA">A medio dia</option>
                                <option value="LA NOCHE">Por la noche</option>
                                <option value="PENDIENTE">Pendiente por confirmar cliente</option>
                                <option value="SIEMPRE HAY ALGUIEN">Siempre hay alguien</option>
                                <option value="UN DIA ANTES">Un Dia Antes</option>
                                <option value="DOS DIAS ANTES">Dos Dias Antes</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                        <label for=""><input type="checkbox" v-model="facturacion.entregaEnBodega"> Cliente entrega mobiliario en bodega</label>
                        </div>
                        <div class="col-md-6 mt-4">
                            <input id="requireFactura" type="checkbox" name="requireFactura" v-model="requiereFactura">
                            <label form="requireFactura">Factura</label>
                        </div>
                        <div class="col-md-12" style="padding-top:20px">
                            <label form="notasFactura">Notas de Facturación</label>
                            <textarea id="notasFactura" class="form-control" width="100%" v-model="facturacion.notasFacturacion"></textarea>
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <label>Datos de facturación</label>
                            <input class="form-control" type="text" placeholder="Nombre" v-model="facturacion.nombreFacturacion">
                        </div>
                        <div class="col-md-12 mt-4">
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
                        <div class="col-md-4 mt-4">
                            <input class="form-control" type="text" placeholder="RFC" v-model="facturacion.rfcFacturacion">
                        </div>
                        <div class="col-md-2 mt-4">
                            <input class="form-control" type="text" placeholder="C.P" v-model="facturacion.codigoPostal">
                        </div>
                        <div class="col-md-4">
                            <select>
                                <option value="1">Efectivo</option>
                                <option value="2">Cheque nominativo</option>
                                <option value="3">Transferencia electrónica de fondos</option>
                                <option value="4">Tarjeta de crédito</option>
                                <option value="5">Monedero Electronico</option>
                                <option value="6">Dinero Electronico</option>
                                <option value="7">Vales de despensa</option>
                                <option value="8">Dación en pago</option>
                                <option value="9">Pago por subrogación</option>
                                <option value="10">Pago por consignación</option>
                                <option value="11">Condonación</option>
                                <option value="12">Compensación</option>
                                <option value="13">Novación</option>
                                <option value="14">Confusión</option>
                                <option value="15">Remisión de deuda</option>
                                <option value="16">Prescripción o caducidad</option>
                                <option value="17">Tarjeta de debito</option>
                                <option value="18">Tarjeta de de servicios</option>
                                <option value="19">Aplicación de anticipos</option>
                                <option value="20">Intermediario pagos</option>
                                <option value="21">Por definir</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div  class="btn btn-secondary" onClick="$('#guardarContrato').modal('hide')">Cerrar</div>
                    <div  class="btn btn-primary" @click="guardarContrato()">Guardar</div>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal editar paquete -->
        <div class="modal fade modalAgregarPaquete" id="editarPaquete" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true" style="overflow-y: scroll;">
            <div id="app" class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar paquete</h5>
                    <div  class="close" onClick="$('#editarPaquete').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-10 offset-md-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-12" style="border:solid; border-width:1px; border-radius:3px; background:#D0FAF2">
                                            <buscador-component
                                            :limpiar="limpiar"
                                    placeholder="Buscar Productos Existentes"
                                    event-name="resultsPaquetes"
                                    :list="inventario"
                                    :keys="['servicio', 'id', 'familia']"
                                    
                                ></buscador-component>
                                        </div>
                                    </div>
                                    <!-- Resultado Busqueda paquetes-->
                                    <div class="row" v-if="resultsPaquetes.length < inventario.length">
                                        <div v-if="resultsPaquetes.length !== 0" class="col-md-12 resultadoInventario">
                                            <div class="list-group" v-for="producto in resultsPaquetes.slice(0,20)" :key="producto.id">
                                                <div class="row contenedor-producto" v-on:click="agregarProductoPaqueteEdicion(producto)">
                                                    <div class="col-md-9">
                                                        
                                                        <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">Servicio:</span> {{ producto.servicio }}</p>
                                                        <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">Precio Unitario:</span> ${{ producto.precioUnitario }}</p>
                                                        <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">Categoría:</span> {{ producto.familia }}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img class="img-fluid" :src="producto.imagen" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = true">Agregar nuevo producto</div>
                                </div> -->
                            </div>
                            <div class="row">
                                <!-- Primer columna -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Servicio</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Servicio" v-model="paqueteEdicion.servicio" style="background:#FFECA7">
                                        </div>
                                    </div>

                                    <div class="form-group row" >
                                        <label class="col-12" for="example-text-input">Precio del paquete</label>
                                        <div class="col-md-12">
                                            <input type="text"  class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio de paquete" v-model="paqueteEdicion.precioFinal" style="background:#FFECA7">
                                        </div>
                                    </div>

                                    <div class="form-group row" style="display:none">
                                        <label class="col-12" for="example-text-input">Costo total de proveedores</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Costo de proveedores" v-model="paqueteEdicion.precioVenta" style="background:#FFECA7">
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <h4>Precio sugerido: $<span v-text="precioSugeridoEdicion"></span></h4>
                                    <h4>Utilidad: $<span v-text="utilidadEdicion"></span></h4>
                                    <h4>Costo total proveedor: $<span v-text="costoProveedorEdicion"></span></h4>
                                    <input type="checkbox" id="guardarPaquete" v-model="paqueteEdicion.guardarPaquete">
                                    <label for="guardarPaquete">Guardar paquete</label>

                                    <div class="form-group row">
                                        <label class="col-12" for="categoriaPaquete">Categoria</label>
                                        <div class="col-md-12">
                                            <select id="categoriaPaquete" name="categoriaPaquete" v-model="paqueteEdicion.categoria">
                                                <option value="Manteleria">Manteleria</option>
                                                <option value="Toboganes">Toboganes</option>
                                                <option value="Mobiliario">Mobiliario</option>
                                                <option value="Floristeria">Floristeria</option>
                                                <option value="Comida">Comida</option>
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
                                                <th scope="col">Precio especial unitario</th>
                                                <th scope="col">Total con descuento</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paqueteEdicion.paquete">
                                            <tr v-for="(producto, index) in paqueteEdicion.paquete.inventario" v-bind:key="producto.index">
                                                <th scope="row">
                                                    <img :src="producto.imagen" width="100px">
                                                </th>
                                                <td>{{ producto.nombre }}
                                                     <br><span style="font-size:10px; line-height:8px;">Costo Proveedor: ${{producto.precioVenta}}</span>
                                                </td>
                                                
                                                <td>
                                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="number" v-model="cantidadPaquete" v-on:change="updateCantidadPaqueteEdicion(index)">
                                                    <span v-else v-on:click="editarCantidadPaquete(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                                </td>
                                                <td>
                                                    <input v-if="(producto.precioUnitario == '') || (indice == index && key == 'precioUnitario')" type="number" v-model="precioUnitarioPaquete" v-on:change="updatePrecioUnitarioPaqueteEdicion(index)">
                                                    <span v-else v-on:click="editarPrecioUnitarioPaquete(index, Object.keys(producto), producto)">{{ producto.precioUnitario }}</span>
                                                </td>
                                                <td>
                                                    <input v-if="(producto.precioEspecial == '') || (indice == index && key == 'precioEspecial')" type="number" v-model="precioEspecialPaquete" v-on:change="updatePrecioEspecialPaqueteEdicion(index)">
                                                    <span v-else v-on:click="editarPrecioEspecialPaquete(index, Object.keys(producto), producto)">{{ producto.precioEspecial }}</span>
                                                </td>
                                                <td>{{ producto.precioFinal }}</td>
                                                <td class="text-center">
                                                    <div class="btn btn-sm btn-danger" @click="eliminarProductoPaqueteEdicion(index)">Eliminar</div>
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
                    <div  class="btn btn-secondary" onClick="$('#editarPaquete').modal('hide')">Close</div>
                    <div  class="btn btn-primary" onClick="$('#editarPaquete').modal('hide')">Guardar paquete</div>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="verPaquete" tabindex="-1" role="dialog" aria-labelledby="verPaquete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Paquete</h5>
                    <div  class="close" onClick="$('#verPaquete').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body" v-if="viendoPaquete.length != 0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Cantidad Charolas</th>
                                <th scope="col">Bocadillos Charola</th>
                                <th scope="col">Precio Charola</th>
                                <th scope="col">Precio Final</th>
                                <th scope="col">Total Bocadillos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in viendoPaquete.paquete" :key="index">
                                <td><img v-bind:src="item.imagen" alt="" width="50px"></td>
                                <td>{{ item.servicio }}</td>
                                <td>{{ item.cantidadPaquetes }}</td>
                                <td>{{ item.cantidad }}</td>
                                <td>${{ item.precioUnitario }}</td>
                                <td>${{ item.precioUnitario*item.cantidadPaquetes }}</td>
                                <td>{{ item.cantidadTotal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div  class="btn btn-secondary" onClick="$('#verPaquete').modal('hide')">Cerrar</div>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="agregarCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar nueva categoria</h5>
                    <button type="button" class="close" onClick="$('#agregarCategoria').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" v-model="nombreCategoria" width="100%">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-sm btn-info btn-block" @click="agregarCategoria()">Agregar</button>
                        </div>
                    </div>

                    <div class="row" v-if="categorias.length != 0">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in categorias" :key="index">
                                        <th scope="row">{{ item.id }}</th>
                                        <td>{{ item.nombre }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger btn-block" @click="eliminarCategoria(item)">Eliminar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#agregarCategoria').modal('hide')">Close</button>
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
                nestedClass: 'nested',
                limpiar: false,
                viendoPaquete: [],
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
                    tipo: '',
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
                    emailEnvio: '',
                    folio: '',
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

                    //am-pm
                    inicioAmPm:'',
                    finAmPm:'',

                    //Informacion del Evento
                    numeroInvitados: '',
                    colorEvento: '',
                    temaEvento: '',

                    //Opciones presupuesto
                    opcionPrecio: '1',
                    opcionPrecioUnitario: '1',
                    opcionDescripcionPaquete: '',
                    opcionImagen: '',
                    opcionDescuento: '1',
                    opcionIVA: '',

                    //Presupuesto o contrato
                    tipo: '',

                    //Impresion
                    impresion: false,

                    //Version
                    version: 1,

                    //Total
                    total: '',

                    tipoComision: 100,
                    comision: '',

                    //Notas
                    notasPresupuesto: '',

                    requiereFactura: '',
                    requiereMontaje: '',
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
                    'precioVenta': '',
                    'proveedor': '',
                    'autorizado': false,
                    'precioEspecial': '',
                },
                
                inventarioLocal: [],
                festejados: [],

                //Edicion de paquete
                indicePaqueteEdicion: '',
                paqueteEdicion:{
                    externo: '',
                    imagen: '',
                    servicio: '',
                    cantidad: '',
                    precioUnitario: '',
                    precioFinal: '',
                    ahorro: '',
                    notas: '',
                    paquete: '',
                    tipo: '',
                    id: '',
                },

                //Control sobre las ediciones en la tabla de productos
                indice: '',
                key: '',

                precioEspecialActualizado: '',
                cantidadActualizada: '',
                ahorroActualizado: '',
                precioFinalActualizado: '',
                notasActualizadas: '--',
                cantidad_disponible:'',
                //Paquetes
                paquete: {
                    servicio: '',
                    precioFinal: '',
                    precioVenta: '',
                    guardarPaquete: false,
                    categoria: '',
                    imagen:'',
                    inventario: [],
                },
                precioSugerido: 0,
                utilidad: 0,
                costoProveedor: 0,

                cantidadPaquete: '',
                precioUnitarioPaquete: '',
                precioEspecialPaquete: '',

                //IVA
                iva: 16,
                verSettings: false,

                // Ultimo presupuesto
                ultimoPresupuesto: '',

                //Imprimir presupuesto
                imprimir: false,

                //Datos facturacion
                requiereFactura: false,
                     //Permisos
                permisos:'',
                facturacion: {
                    //Tiempos
                    horaInicio: '',
                    horaFin: '',
                    horaEntrega: '',
                    fechaRecoleccion: '',
                    horaRecoleccion: '',
                    recoleccionPreferente: '',
                    notasFacturacion: '',
                    entregaEnBodega:'',

               
                    

                    //Datos
                    nombreFacturacion: '',
                    direccionFacturacion: '',
                    numeroFacturacion: '',
                    coloniaFacturacion: '',
                    emailFacturacion: '',
                    rfcFacturacion: '',
                },
                configuraciones: '',
                ultimoPresupuesto: '',

                nombreCategoria: '',
                categorias: [],

                editarElementoExt: null,
                editarElementoExtIndex: null,
            }
        },
        created(){
            this.obtenerUltimoPresupuesto();
            this.obtenerUsuarios();
            //Obtenemos todos los clientes para el buscados
            this.obtenerClientes();
            this.obtenerPermisos();
            this.obtenerInventario();
            this.obtenerUsuario();
            this.obtenerUsuarios();
            this.obtenerConfiguraciones();
            this.obtenerCategorias();
            
            this.$on('results', results => {
                this.results = results
            });
            this.$on('clientResults', clientResults => {
                this.clientResults = clientResults
            });
            this.$on('resultsPaquetes', resultsPaquetes => {
                this.resultsPaquetes = resultsPaquetes
            });
            EventBus.$emit('nuevoCliente', funcion => {
  alert('busfunciona');
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
                    suma += parseInt(data[x].precioFinal); // Ahora que es un objeto javascript, tiene propiedades
                }

                this.presupuesto.total = suma;
                return suma;
            },
            calcularIva: function(){
                return this.calcularSubtotal * (this.iva / 100);
            },
            calcularAhorro: function(){
                let ahorro = 0;
                this.inventarioLocal.forEach(function(element){
                    let precioNormal = parseInt(element.cantidad * element.precioUnitario);
                    ahorro = parseInt(ahorro + (precioNormal - element.precioFinal));
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
                        let nuevoFolio = ('SM' + (parseInt(data[1]) + 1));
                        this.presupuesto.folio = nuevoFolio;
                        return nuevoFolio
                    }
                    //return nuevoFolio;
                }
                

            },
            calcularContratos: function(){
                let contratos = this.clienteSeleccionado.presupuestos.filter(element => element.tipo == 'CONTRATO');
                this.clienteSeleccionadoContratos = contratos;

                this.clienteSeleccionadoContratos.forEach((element) => {
                    let vendedor = this.usuarios.find((item) => {
                        return item.id == element.vendedor_id;
                    })
                    Object.defineProperty(element, 'nombreVendedor', {
                        value: vendedor.name,
                        writable: true,
                        enumerable: true,
                        configurable: true
                    })
                });
                return this.clienteSeleccionadoContratos.length;
            },
            calcularPresupuestos: function(){
                let presupuestos = this.clienteSeleccionado.presupuestos.filter(element => element.tipo == 'PRESUPUESTO');
                this.clienteSeleccionadoPresupuestos = presupuestos;

                this.clienteSeleccionadoPresupuestos.forEach((element) => {
                    let vendedor = this.usuarios.find((item) => {
                        return item.id == element.vendedor_id;
                    })
                    Object.defineProperty(element, 'nombreVendedor', {
                        value: vendedor.name,
                        writable: true,
                        enumerable: true,
                        configurable: true
                    })
                });
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
            'presupuesto.pendienteHora': function(val){
                if(val){
                    this.presupuesto.horaEventoInicio = '00:00';
                    this.presupuesto.horaEventoFin = '00:00';
                }
            },
            'presupuesto.iva': function(val){
                if(val){
                    this.presupuesto.total = (this.presupuesto.total * (this.iva / 100));
                }
            },
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
            'paquete.precioFinal': function(val){
                if(val){
                   this.paquete.precioFinal =this.precioSugerido;
                }
            },
            'presupuesto.requiereFactura': function(val){
                if(val=='SI'){
                    this.presupuesto.opcionIVA = true;
                    this.requiereFactura = true;
                    this.facturacion.nombreFacturacion = this.clienteSeleccionado.nombreLugar;
                    this.facturacion.direccionFacturacion = this.clienteSeleccionado.direccionLugar;
                    this.facturacion.numeroFacturacion = this.clienteSeleccionado.numeroLugar;
                    this.facturacion.coloniaFacturacion = this.clienteSeleccionado.coloniaLugar;
                    this.facturacion.emailFacturacion = this.clienteSeleccionado.email;
                    this.facturacion.rfcFacturacion = this.clienteSeleccionado.rfc;
                    this.facturacion.codigoPostal = this.clienteSeleccionado.codigoPostal;

                }else{
                    this.facturacion.nombreFacturacion = '';
                    this.facturacion.direccionFacturacion = '';
                    this.facturacion.numeroFacturacion = '';
                    this.facturacion.coloniaFacturacion = '';
                    this.facturacion.rfcFacturacion = '';
                    this.facturacion.emailFacturacion = '';
                    this.facturacion.codigoPostal = '';
                }
                
            },
        },
        methods:{
            editarProductoExterno(paquete, index){
                this.editarElementoExt = paquete
                this.editarElementoIndex = index
                $('#editarElementoExterno').modal('show')
            },

            agregarProductoExternoEditado(){
                this.inventarioLocal.splice(this.editarElementoIndex, 1, editarElementoExt)
            },

            modificarHoraEntrega(){
                if(this.facturacion.horaEntrega != 'OTRO'){
                    this.facturacion.horaInicio = '00:00';
                    this.facturacion.horaFin = '00:00';

                    document.getElementById('hora-1').setAttribute('disabled', '');
                    document.getElementById('hora-2').setAttribute('disabled', '');
                }else{
                    document.getElementById('hora-1').removeAttribute('disabled');
                    document.getElementById('hora-2').removeAttribute('disabled'); 
                }
                
            },

            modificarHoraRecoleccion(){
                if(this.facturacion.recoleccionPreferente != 'OTRO'){
                    this.facturacion.fechaRecoleccion = '2019-12-18';
                    this.facturacion.horaRecoleccion = '00:00';

                    document.getElementById('recoleccionFecha').setAttribute('disabled', '');
                    document.getElementById('recoleccionHora').setAttribute('disabled', '');
                }else{
                    document.getElementById('recoleccionFecha').removeAttribute('disabled');
                    document.getElementById('recoleccionHora').removeAttribute('disabled'); 
                }
            },

            obtenerCategorias(){
                let URL = 'budget-categorias';

                axios.get(URL).then((response) => {
                    this.categorias = response.data;
                    
                })
            },
            agregarCategoria(){
                let URL = 'budget-categorias';

                axios.post(URL, {
                    nombre: this.nombreCategoria,
                }).then((response) => {
                    this.obtenerCategorias();
                })
            },
            eliminarCategoria(item){
                let URL = 'budget-categorias/' + item.id;

                axios.delete(URL).then((response) => {
                    this.obtenerCategorias();
                })
            },
            onFileSelected (event) {
                return;
            },

            verPaquete(paquete){
                this.viendoPaquete = paquete;
                $('#verPaquete').modal('show');
            },
            obtenerConfiguraciones: function(){
                let URL = '/configuraciones';

                axios.get(URL).then((response) => {
                    this.configuraciones = response.data;
                }).catch((error) => {
                    console.log(error.data);
                })
            },
            //Edicion paquetes
            editarPaquete: function(producto){
                this.paqueteEdicion = producto
                $('#editarPaquete').modal('show');
            },

            updateCantidadPaqueteEdicion(index){
                this.indice = '';
                this.key = '';
                this.precioSugerido = 0;
                this.utilidad = 0;
                this.costoProveedor = 0;
                let producto = this.paqueteEdicion.paquete.inventario.find(function(element, indice){
                    return (indice == index);
                });

                producto.cantidad = this.cantidadPaquete;
                producto.precioFinal = producto.cantidad * producto.precioEspecial;
                this.paqueteEdicion.paquete.inventario.splice(index, 1, producto);
                this.cantidadPaquete = '';
                this.key = '';
                this.indice = '100000000';

                this.actualizarPrecioSugeridoEdicion();
                
            },

            updatePrecioUnitarioPaqueteEdicion(index){
                this.indice = '';
                this.key = '';
                let producto = this.paqueteEdicion.paquete.inventario.find(function(element, indice){
                    return (indice == index);
                });

                producto.precioUnitario = this.precioUnitarioPaquete;
                producto.precioEspecial = this.precioUnitarioPaquete;
                producto.precioFinal = producto.cantidad * producto.precioEspecial;
                this.paqueteEdicion.paquete.inventario.splice(index, 1, producto);
                this.precioUnitarioPaquete = '',
                this.key = '',
                this.indice = '100000000';

                this.actualizarPrecioSugeridoEdicion();
            },

            updatePrecioEspecialPaqueteEdicion(index){
                this.indice = '';
                this.key = '';
                this.precioSugerido = 0;
                this.utilidad = 0;
                let producto = this.paqueteEdicion.paquete.inventario.find(function(element, indice){
                    return (indice == index);
                });

                producto.precioEspecial = this.precioEspecialPaquete;
                producto.precioFinal = producto.cantidad * this.precioEspecialPaquete;
                this.paqueteEdicion.paquete.inventario.splice(index, 1, producto);

                this.precioEspecialPaquete = '';
                this.key = '';
                this.indice = '100000000';
                this.actualizarPrecioSugeridoEdicion();
            },

            actualizarPrecioSugeridoEdicion(){
                this.precioSugeridoEdicion=0;
                this.utilidadEdicion=0;
                this.costoProveedorEdicion=0;
                for (var i = 0; i < this.paqueteEdicion.paquete.inventario.length; i++) {
                    this.precioSugeridoEdicion+= parseInt(this.paqueteEdicion.paquete.inventario[i].precioFinal);
                    this.utilidadEdicion+= parseInt(this.paqueteEdicion.paquete.inventario[i].precioFinal)-(parseInt(this.paqueteEdicion.paquete.inventario[i].precioVenta)*parseInt(this.paqueteEdicion.paquete.inventario[i].cantidad));
                    this.costoProveedorEdicion+= parseInt(this.paqueteEdicion.paquete.inventario[i].precioVenta);
                }
                this.paqueteEdicion.paquete.precioFinal = this.precioSugeridoEdicion;
                this.paqueteEdicion.precioFinal = this.precioSugeridoEdicion;
            },

            eliminarProductoPaqueteEdicion(index){
                console.log(index)
                this.paqueteEdicion.paquete.inventario.splice(index, 1);

                this.precioSugerido = 0;
                this.utilidad = 0;
                this.costoProveedor = 0;

                for (var i = 0; i < this.paqueteEdicion.paquete.inventario.length; i++) {
                    
                    this.precioSugerido+= this.paqueteEdicion.paquete.inventario[i].precioFinal;
                    this.utilidad+= parseInt(this.paqueteEdicion.paquete.inventario[i].precioFinal)-(parseInt(this.paqueteEdicion.paquete.inventario[i].precioVenta)*parseInt(this.paqueteEdicion.paquete.inventario[i].cantidad));
                    this.costoProveedor+= parseInt(this.paqueteEdicion.paquete.inventario[i].precioVenta);
                }
            },

            agregarProductoPaqueteEdicion(producto){
                this.limpiar = true;
                this.paqueteEdicion.paquete.inventario.push({
                    'externo': false,
                    'nombre': producto.servicio,
                    'imagen': producto.imagen,
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '0',
                    'cantidad': '0',
                    'id': producto.id,
                    'precioVenta': producto.precioVenta,
                    'proveedor': '',
                    'precioEspecial': producto.precioUnitario,
                    'precioAnterior': producto.precioUnitario,
                });

                setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
               
            },
            recuperarMesaDulces(args, invlocal, comentarios){
                //console.log(args);

                let paquete = JSON.parse( JSON.stringify(invlocal) );
                
                    console.log(paquete);
                    this.inventarioLocal.push({
                        externo: false,
                        imagen: 'https://www.sweets.com.sv/img_decorados/ICON%20mesa%20de%20postres-01.png',
                        servicio: 'Mesa de dulces',
                        cantidad: 1,
                        precioUnitario: args,
                        precioFinal: args,
                        precioAnterior: '0',
                        ahorro: '0',
                        notas: comentarios,
                        paquete: paquete,
                        tipo: 'PAQUETE',
                        id: '',
                        precioVenta: '0',
                        precioEspecial: '0',
                        precioAnterior: '0',
                    });
                    this.inventarioLocal = this.inventarioLocal.reverse();
                    
                
                $('#bocadillosModal').modal('hide');
                    Swal.fire(
                        'Listo!',
                        'Paquete agregado con exito a presupuesto',
                        'success'
                        ) ;
            },

            agregarProductoPaqueteEditado(producto){
                this.paqueteEdicion.paquete.inventario.push({
                    'externo': false,
                    'nombre': producto.servicio,
                    'imagen': producto.imagen,
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '',
                    'cantidad': '0',
                    'id': producto.id,
                });
                //this.actualizarPrecioSugerido();
            },
            guardarPaqueteEdicion(){
                this.inventarioLocal.splice(this.indicePaqueteEdicion, 1, this.paqueteEdicion);
                this.paqueteEdicion.externo = '';
                this.paqueteEdicion.imagen = '';
                this.paqueteEdicion.servicio = '';
                this.paqueteEdicion.cantidad = '';
                this.paqueteEdicion.precioUnitario = '';
                this.paqueteEdicion.precioFinal = '';
                this.paqueteEdicion.ahorro = '';
                this.paqueteEdicion.notas = '';
                this.paqueteEdicion.paquete = '';
                this.paqueteEdicion.tipo = '';
                this.paqueteEdicion.id = '';
                this.indicePaqueteEdicion = '';
            },
            obtenerUsuario(){
                let URL = '/obtener-usuario';

                axios.get(URL).then((response) => {
                    this.usuarioActual = response.data;
                    //this.presupuesto.vendedor_id = this.usuarioActual.id;
                   
                }).catch((error) => {
                   
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
            mostrarSettings(){
                if(this.verSettings){
                    this.verSettings = false;
                }else{
                    this.verSettings = true;
                }
            },
            //Metodos para los paquetes
            agregarProductoPaquete(producto){
                console.log(producto);
                this.limpiar = true;
                this.paquete.inventario.push({
                    'externo': false,
                    'nombre': producto.servicio,
                    'imagen': producto.imagen,
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '0',
                    'cantidad': '0',
                    'id': producto.id,
                    'precioVenta': producto.precioVenta,
                    'proveedor': '',
                    'precioEspecial': producto.precioUnitario,
                    'precioAnterior': producto.precioUnitario,
                });

                setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
            },
                    actualizarPrecioSugerido(){
                         this.precioSugerido=0;
                        this.utilidad=0;
                        this.costoProveedor=0;
                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            this.precioSugerido+= this.paquete.inventario[i].precioFinal;
                            this.utilidad+= parseInt(this.paquete.inventario[i].precioFinal)-(parseInt(this.paquete.inventario[i].precioVenta)*parseInt(this.paquete.inventario[i].cantidad));
                            this.costoProveedor+= parseInt(this.paquete.inventario[i].precioVenta);
                        }

                        this.paquete.precioFinal = this.precioSugerido;
                    },
                    //Eliminar producto de paquete
                    eliminarProductoPaquete(index){
                        this.paquete.inventario.splice(index, 1);

                        this.precioSugerido = 0;
                        this.utilidad = 0;
                        this.costoProveedor = 0;

                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            
                            this.precioSugerido+= this.paquete.inventario[i].precioFinal;
                            this.utilidad+= parseInt(this.paquete.inventario[i].precioFinal)-(parseInt(this.paquete.inventario[i].precioVenta)*parseInt(this.paquete.inventario[i].cantidad));
                            this.costoProveedor+= parseInt(this.paquete.inventario[i].precioVenta);
                        }
                    },

                    //Actualizar los datos del paquete
                    editarCantidadPaquete(index, key){
                        this.indice = index;
                        this.key = key[5];                       
                    },

                    editarPrecioEspecialPaquete(index, key, producto){
                        if(producto.externo){
                            this.key = key[10]; 
                        }else{
                            this.key = key[9]; 
                        }
                        this.indice = index;
                    },

                    editarPrecioUnitarioPaquete(index, key, producto){
                        console.log(key);
                        if(producto.externo){
                            this.key = key[3]; 
                        }else{
                            this.key = key[3]; 
                        }
                        this.indice = index;
                    },

                    updateCantidadPaquete(index){
                        this.precioSugerido = 0;
                        this.utilidad = 0;
                        let producto = this.paquete.inventario.find(function(element, indice){
                            return (indice == index);
                        });

                        producto.cantidad = this.cantidadPaquete;
                        producto.precioFinal = producto.cantidad * producto.precioEspecial;
                        this.paquete.inventario.splice(index, 1, producto);
                        this.cantidadPaquete = '';
                        this.key = '';
                        this.indice = '100000000';

                        this.actualizarPrecioSugerido();
                        
                    },

                    updatePrecioUnitarioPaquete(index){
                        let producto = this.paquete.inventario.find(function(element, indice){
                            return (indice == index);
                        });

                        producto.precioUnitario = this.precioUnitarioPaquete;
                        producto.precioEspecial = this.precioUnitarioPaquete;
                        producto.precioFinal = producto.cantidad * producto.precioEspecial;
                        this.paquete.inventario.splice(index, 1, producto);
                        this.precioUnitarioPaquete = '',
                        this.key = '',
                        this.indice = '100000000';

                        this.actualizarPrecioSugerido();
                    },

                    updatePrecioEspecialPaquete(index){
                        this.precioSugerido = 0;
                        this.utilidad = 0;
                        let producto = this.paquete.inventario.find(function(element, indice){
                            return (indice == index);
                        });

                        producto.precioEspecial = this.precioEspecialPaquete;
                        producto.precioFinal = producto.cantidad * this.precioEspecialPaquete;
                        this.paquete.inventario.splice(index, 1, producto);

                        this.precioEspecialPaquete = '';
                        this.key = '';
                        this.indice = '100000000';
                        this.actualizarPrecioSugerido();
                    },

            refrescarClientes(){
                this.obtenerClientes();
                alert('Lista de clientes actualizada');
            },
            guardarPaquete(){
                let count;
                if(this.paquete.servicio != '') {}else{
                    alert('Ingresa un nombre de paquete');
                    return
                }
                if(this.inventarioLocal.some((element) => {
                    return element.servicio == this.paquete.servicio;
                })){
                    Swal.fire(
                        'Registro duplicado',
                        'Ya existe un paquete con el nombre ' + this.paquete.servicio,
                        'warning'
                        )
                }else{
                    let paquete = JSON.parse( JSON.stringify(this.paquete) );
                    console.log(this.precioSugerido);
                    this.inventarioLocal.push({
                        externo: false,
                        imagen: this.paquete.imagen,
                        servicio: this.paquete.servicio,
                        cantidad: 1,
                        precioUnitario: this.precioSugerido,
                        precioFinal: this.precioSugerido,
                        precioAnterior: '0',
                        ahorro: '0',
                        notas: '',
                        paquete: paquete,
                        tipo: 'PAQUETE',
                        id: '',
                        precioVenta: this.costoProveedor,
                        precioEspecial: this.precioSugerido,
                        precioAnterior: this.precioSugerido,
                    });
                    this.inventarioLocal = this.inventarioLocal.reverse();
                    
                this.paquete.externo = '';
                this.paquete.imagen = '';
                this.paquete.servicio = '';
                this.paquete.cantidad = '';
                this.paquete.precioUnitario = '';
                this.paquete.precioFinal = '';
                this.paquete.ahorro = '';
                this.paquete.inventario= [];
                $('#agregarPaquete').modal('hide');
                    Swal.fire(
                        'Listo!',
                        'Paquete agregado con exito a presupuesto',
                        'success'
                        ) ;
                
                }

            },
            // Metodo para obtener el cliente seleccionado
            obtenerCliente(cliente){
                this.limpiar = true;
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
                if(cliente.apellidoPaterno==undefined && cliente.apellidoMaterno==undefined){
                this.clienteSeleccionado.nombre = cliente.nombre;
              }else{
                this.clienteSeleccionado.nombre = cliente.nombre+" "+cliente.apellidoPaterno+" "+cliente.apellidoMaterno;}
                this.clienteSeleccionado.email = cliente.email;
                this.clienteSeleccionado.rfc = cliente.rfcFacturacion;
                this.clienteSeleccionado.tipo = cliente.tipoPersona;

                this.clienteSeleccionado.nombreLugar = cliente.nombreFacturacion;
                this.clienteSeleccionado.direccionLugar = cliente.direccionFacturacion;
                this.clienteSeleccionado.numeroLugar = cliente.numeroFacturacion;
                this.clienteSeleccionado.coloniaLugar = cliente.coloniaFacturacion;

                this.presupuesto.client_id = cliente.id;

                setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
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
                            'precioFinal': '0',
                            'cantidad': '0',
                            'id': '',
                            'precioVenta': this.productoExterno.precioVenta,
                            'proveedor': this.productoExterno.proveedor,
                            'autorizado': this.productoExterno.autorizado,
                            'precioEspecial': this.productoExterno.precioUnitario,
                            'precioAnterior' : this.productoExterno.precioUnitario,
                        });
                        //this.actualizarPrecioSugerido();
                    
                    
                }else{
                    if(this.inventarioLocal.some((element) => {
                        return element.servicio == this.productoExterno.servicio
                    })){
                        Swal.fire(
                            'Registro duplicado',
                            'Ya existe un producto con el nombre ' + this.productoExterno.servicio,
                            'warning'
                            )
                    }else{
                        this.inventarioLocal = this.inventarioLocal.reverse();
                        this.inventarioLocal.push({
                            'externo': true,
                            'imagen': this.productoExterno.imagen,
                            'servicio': this.productoExterno.servicio,
                            'cantidad': 1,
                            'precioUnitario': this.productoExterno.precioUnitario,
                            'precioFinal': this.productoExterno.precioUnitario,
                            'ahorro': 0,
                            'notas': '',
                            'paquete': '',
                            'tipo': 'PRODUCTO',
                            'id': '',
                            'precioVenta': this.productoExterno.precioVenta,
                            'proveedor': this.productoExterno.proveedor,
                            'autorizado': this.productoExterno.autorizado,
                            'precioEspecial': this.productoExterno.precioUnitario,
                            'precioAnterior' : this.productoExterno.precioUnitario,
                        });
                        this.inventarioLocal = this.inventarioLocal.reverse();
                    }
                    
                }

                document.getElementById('file-image-externo').value = '';
                
                this.productoExterno = {'externo': true, 'imagen': '', 'servicio': '', 'precioUnitario': '', 'paquete': '', 'precioVenta': '', 'proveedor': '', 'autorizado': false};
                $('#agregarElemento').modal('hide');
            },
            // Bus para comunicar controladores
            busEvent() {
                // Enviar el evento por el canal click
                EventBus.$emit('click');
            },
            limpiarInput(){
                        this.limpiar=true;
                        setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
                    },
            //Metodos dentro de la tabla productos
                // Eliminar
                eliminarProductoLocal(index){
                    this.inventarioLocal.splice(index, 1);
                },

                //precioEspecial
                editarPrecioEspecial(index, key, producto){
                    console.log(key.length);
                    if(key.length == 15){
                        this.key = key[13];
                    }else if(key.length == 16){
                        this.key = key[14];
                    }else{
                        this.key = key[12];
                    }
                    this.indice = index;
                    
                },

                // Cantidad
                editarCantidad(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[3];
                    console.log(index);
                    console.log(this.key);
                       
                },
                editarPrecioUnitario(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[4];
                    console.log(index);
                    console.log(this.key);
                       
                },

                updatePrecioEspecial(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    producto.precioEspecial = this.precioEspecialActualizado;
                    producto.precioFinal = producto.cantidad * producto.precioEspecial;
                    producto.ahorro = producto.precioUnitario - producto.precioEspecial;
                    this.inventarioLocal.splice(index, 1, producto);
                    this.precioEspecialActualizado = '';
                    this.key = '';
                    this.indice = '1000000000';
                },

                updateCantidad(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    producto.cantidad = this.cantidadActualizada;
                    producto.precioFinal = producto.cantidad * producto.precioEspecial;
                    this.inventarioLocal.splice(index, 1, producto);
                    console.log(this.inventarioLocal);
                    this.cantidadActualizada = '';
                    this.key = '';
                    this.indice = '100000000';
                },
                 updatePrecioUnitario(index){
                    let producto = this.inventarioLocal.find(function(element, indice){
                        return (indice == index);
                    });
                    producto.precioUnitario = this.precioUnitarioActualizada;
                    producto.precioEspecial = this.precioUnitarioActualizada;
                    producto.precioFinal = producto.cantidad * producto.precioEspecial;
                    producto.ahorro = producto.precioUnitario - producto.precioEspecial;
                    this.inventarioLocal.splice(index, 1, producto);
                    console.log(this.inventarioLocal);
                    this.precioUnitarioActualizada = '';
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
                        producto.precioEspecial = producto.precioUnitario - this.ahorroActualizado;
                        producto.precioFinal = producto.cantidad * producto.precioEspecial;
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
                editarNotas(index, key, notas){
                    this.notasActualizadas = notas;
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

                let URL = '/obtener-disponibles';
                axios.post(URL, {id:producto.servicio, fecha:this.presupuesto.fechaEvento}).then((response) => {
                    this.cantidad_disponible = response.data;
                    
                if(producto.anidado){
                    let producto_anidado = {
                        'externo': false,
                        'imagen': producto.imagen,
                        'servicio': producto.servicio,
                        'cantidad': '1',
                        'precioUnitario': producto.precioUnitario,
                        'precioFinal': producto.precioUnitario,
                        'precioAnterior':producto.precioUnitario,
                        'ahorro': '0',
                        'notas': '-',
                        'paquete': '',
                        'disponible': this.cantidad_disponible,
                        'tipo': 'PRODUCTO',
                        'id': producto.id,
                        'precioVenta': producto.precioVenta,
                        'proveedor': '',
                        'precioEspecial': producto.precioUnitario,
                        
                    }

                    this.obtenerNesteds(producto_anidado)
                    this.limpiar = true;
                    return
                }

                this.limpiar = true;
                
                if(producto.precioVenta==null){
                producto.precioVenta=0;}
                this.inventarioLocal = this.inventarioLocal.reverse();
                this.inventarioLocal.push({
                    'externo': false,
                    'imagen': producto.imagen,
                    'servicio': producto.servicio,
                    'cantidad': '1',
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': producto.precioUnitario,
                    'ahorro': '0',
                    'notas': '-',
                    'paquete': '',
                    'disponible': this.cantidad_disponible,
                    'tipo': 'PRODUCTO',
                    'id': producto.id,
                    'precioVenta': producto.precioVenta,
                    'proveedor': '',
                    'precioEspecial': producto.precioUnitario,
                    'precioAnterior': producto.precioUnitario,
                });
                    this.inventarioLocal = this.inventarioLocal.reverse();
                })

                setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
                
            },

            obtenerNesteds(producto){

                this.precioSugerido = producto.precioUnitario;
                console.log(producto.precioUnitario);
                console.log(this.precioSugerido);

                this.paquete.imagen = producto.imagen;
                this.paquete.servicio = producto.servicio;
                this.paquete.precioFinal = producto.precioUnitario;
                this.paquete.precioAnterior = producto.precioUnitario;
                this.paquete.precioVenta = producto.PrecioVenta;
                this.paquete.guardarPaquete = false;
                this.paquete.categoria = 'Anidado';



                let URL = '/obtener-nesteds/' + producto.id

                axios.get(URL).then((response) => {
                    
                    response.data.forEach((doc) => {
                        this.paquete.inventario.push({
                            'externo': false,
                            'nombre': doc.servicio,
                            'imagen': doc.imagen,
                            'precioUnitario': doc.precioUnitario,
                            'precioFinal': doc.precioUnitario,
                            'cantidad': doc.cantidad,
                            'id': doc.id,
                            'precioVenta': doc.precioVenta,
                            'proveedor': '',
                            'precioEspecial': doc.precioUnitario,
                            'precioAnterior': doc.precioUnitario,
                        });
                        
                    })
                    
                this.guardarPaquete()
                }).catch((error) => {

                })
            },

            obtenerClientes(){
                let URL = '/obtener-clientes';
                axios.get(URL).then((response) => {
                    this.clientes = response.data;
                })
            },
            obtenerPermisos(){
                let URL = '/obtener-permisos';
                axios.get(URL).then((response) => {
                    this.permisos = response.data;
                })
            },
            agregarFestejado(){
                this.festejados.push({'nombre': this.festejado.nombre, 'edad': this.festejado.edad});
                this.festejado.nombre='';
                this.festejado.edad='';
                //this.festejados.push({'nombre': this.festejado.nombre, 'edad': this.festejado.edad});
            },
            eliminarFestejado(index){
                this.festejados.splice(index, 1);
            },

            obtenerUltimoPresupuesto(){
                let URL = 'obtener-ultimo-presupuesto';

                axios.get(URL).then((response) => {
                    this.ultimoPresupuesto = response.data;

                    let URL = 'enviar-email/' + this.ultimoPresupuesto.id;

                    axios.get(URL).then((response) => {
                        console.log('email enviado');
                    })

                });
            },

            // Guardar como presupuesto
            guardarPresupuesto(){
                if(this.presupuesto.pendienteFecha=="" && this.presupuesto.fechaEvento=="" ){
                    alert('selecciona una fecha o marcala como pendiente para continuar');
                    return;
                }
                if(this.presupuesto.pendienteHora=="" && this.presupuesto.inicioAmPm=="" && this.presupuesto.finAmPm=="" ){
                    alert('selecciona una hora o marcala como pendiente para continuar');
                    return
                }

                if(this.inventarioLocal.length == 0){
                    Swal.fire(
                            'Elementos',
                            'Agrega Elementos a tu presupuesto para continuar',
                            'error'
                        );
                         
                    }else{
                if(this.festejados.length == 0){
                    Swal.fire(
                            'Festejados',
                            'Agrega almenos un festejado para continuar',
                            'error'
                        );
                         
                    }else{
                this.presupuesto.tipo = 'PRESUPUESTO';
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                if(this.presupuesto.tipoComision == 0){
                    this.presupuesto.comision = this.presupuesto.comision
                }else{
                    this.presupuesto.comision = this.presupuesto.tipoComision
                }

                if(this.presupuesto.total <= this.configuraciones.minimoVentaComision){
                    this.presupuesto.comision = 0;
                }

                if(this.presupuesto.pendienteFecha){
                    this.presupuesto.fechaEvento = ''
                }

                let URL = '/presupuestos/create';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                }).then((response) => {
                    this.imprimir = true;
                    /*
                    this.obtenerUltimoPresupuesto()
                    */
                   
                    
                    
                    if(response.data == 1){
                        Swal.fire(
                            'Error!',
                            'El salon de eventos ya esta ocupado en esta fecha',
                            'error'
                        );
                    }else{
                        Swal.fire({
                        title: 'Exito',
                        text: "Presupuesto creado",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }else{
                                location.reload();
                            }
                        })
                      
                    }   
                    
                }).catch((error) => {
                   console.log(error.response);
                    if(error.response.data.message=='Unauthenticated.'){
                        error.message='';
                        window.open('login',"ventana1","width=350,height=350,scrollbars=NO");
                    }else{
                     Swal.fire(
                            'Error!',
                            'Verifica que agregaste un cliente o categoria a tu presupuesto',
                            'error'
                        );
                        }
                });
            } } 
            
            },
            // Guardar como contrato
            guardarContrato(){
                
                if(this.presupuesto.pendienteFecha=="" && this.presupuesto.fechaEvento=="" ){
                    alert('selecciona una fecha o marcala como pendiente para continuar');
                    return
                }
                

                if(!this.facturacion.entregaEnBodega){
                if(isNaN(parseInt(this.facturacion.fechaRecoleccion))){
                   
                    Swal.fire(
                            'Hora de recolección',
                            'Especifica una hora de recoleccion y selecciona una opcion de recolección preferente',
                            'error'
                        );
                }else{
                   
               
                if(this.inventarioLocal.length == 0){
                    Swal.fire(
                            'Elementos',
                            'Agrega Elementos a tu contrato para continuar',
                            'error'
                        );
                         
                    }else{
                if(this.festejados.length == 0){
                    Swal.fire(
                            'Festejados',
                            'Agrega almenos un festejado para continuar',
                            'error'
                        );
                         
                    }else{
                this.presupuesto.tipo = 'CONTRATO';
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                if(this.requiereFactura){
                    /*for (const prop in this.facturacion) {
                        
                        if(this.facturacion[prop] == ''){
                            alert(this.facturacion[prop]);
                            Swal.fire(
                                'Error',
                                'Verifica que completaste todos los campos correctamente antes de continuar',
                                'error'
                            );
                            return;
                        }
                        
                        
                    }*/
                }

                if(this.presupuesto.tipoComision == 0){
                    this.presupuesto.comision = this.presupuesto.comision
                }else{
                    this.presupuesto.comision = this.presupuesto.tipoComision
                }

                if(this.presupuesto.total <= this.configuraciones.minimoVentaComision){
                    this.presupuesto.comision = 0;
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
                            'El salon de eventos ya esta ocupado para esta fecha',
                            'error'
                        );
                    }else{
                        Swal.fire({
                        title: 'Exito',
                        text: "Contrato creado",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }else{
                                location.reload();
                            }
                        })
                         guardarPresupuesto();
                    }   
                    
                }).catch((error) => {
                   console.log(error.response);
                    if(error.response.data.message=='Unauthenticated.'){
                        error.message='';
                        window.open('login',"ventana1","width=350,height=350,scrollbars=NO");
                    }else{
                        alrt(error.response.data.message);
                     Swal.fire(
                            'Error!',
                            'Verifica que agregaste un cliente o categoria a tu presupuesto',
                            'error'
                        );
                        }
                });
            }
        }
    
            }}else{

                this.presupuesto.tipo = 'CONTRATO';
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                

                if(this.presupuesto.tipoComision == 0){
                    this.presupuesto.comision = this.presupuesto.comision
                }else{
                    this.presupuesto.comision = this.presupuesto.tipoComision
                }

                if(this.presupuesto.total <= this.configuraciones.minimoVentaComision){
                    this.presupuesto.comision = 0;
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
                            'El salon de eventos ya esta ocupado para esta fecha',
                            'error'
                        );
                    }else{
                        Swal.fire({
                        title: 'Exito',
                        text: "Contrato creado",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }else{
                                location.reload();
                            }
                        })
                         guardarPresupuesto();
                    }   
                    
                }).catch((error) => {
                   console.log(error.response);
                    if(error.response.data.message=='Unauthenticated.'){
                        error.message='';
                        window.open('login',"ventana1","width=350,height=350,scrollbars=NO");
                    }else{
                     Swal.fire(
                            'Error!',
                            'Verifica que agregaste un cliente o categoria a tu presupuesto',
                            'error'
                        );
                        }
                });


            }
           
            },

    MesaDulcesGuardada(){
                    Swal.fire(
                        'Listo!',
                        'Mesa de dulces agregada con exito a presupuesto',
                        'success'
                        ) ;
    },
    ModalGuardarContrato(){

        if(this.presupuesto.vendedor_id==""){
                    alert('selecciona un vendedor para continuar');
                    return
                }

        if(this.presupuesto.pendienteFecha=="" && this.presupuesto.fechaEvento=="" ){
                    alert('selecciona una fecha o marcala como pendiente para continuar');
                    return
                }
                
                if(this.presupuesto.pendienteHora=="" && this.presupuesto.inicioAmPm=="" && this.presupuesto.finAmPm=="" ){
                    alert('selecciona una hora o marcala como pendiente para continuar');
                    return
                }
        if(this.festejados.length == 0){
                    Swal.fire(
                            'Festejados',
                            'Agrega almenos un festejado para continuar',
                            'error'
                        );
                         
                    }else{
    $('#guardarContrato').modal('show');
                    }

    },
            imprimirPDF(){
                if(!this.imprimir){
                    Swal.fire(
                        'Error!',
                        'Antes de imprimir es necesario guardar el presupuesto o contrato',
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
