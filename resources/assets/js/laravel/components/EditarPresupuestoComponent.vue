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

</style>

<template>
    <section class="container" v-if="unlock">
        <div class="row">
            
        </div>
        <div class="row mt-4">
            <div class="col-md-12 registroPresupuesto">
                <div class="row">
                    <div class="col-md-8 text-left">
                        <div v-if="presupuesto.tipoEvento == 'INTERNO' || presupuesto.tipoServicio == 'INFANTIL'" class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat">

                        </div>
                        <div v-else class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo-decor.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat">

                        </div>
                    </div>
                    <div class="col-md-3 text-right info">
                        <p style="font-size:25px; font-weight:bold">Folio: {{ presupuesto.folio }}</p>
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
                                <input type="time" v-model="presupuesto.horaEventoInicio">
                            </div>
                           
                            <div class="col-md-6" style="padding-left:0">
                                <label>Fin del evento</label><br>
                                <input type="time" v-model="presupuesto.horaEventoFin">
                            </div>
                             <label for="pendienteHora" style="padding-top:10px">
                             <input type="checkbox" name="1" id="pendienteHora" v-model="presupuesto.pendienteHora">
                            Pendiende</label>
                            </div>
                    <div class="col-md-4">
                        
                        <div class="row" >
                            <div class="col-md-12">
                                <h4 class="">Categoria del evento</h4>
                                <select name="categoriaEvento" id="" v-model="presupuesto.categoriaEvento">
                                    <option value="1">Boda</option>
                                    <option value="2">XV Años</option>
                                    <option value="3">Aniversario</option>
                                    <option value="4">Cumpleaños</option>
                                    <option value="5">Graduación</option>
                                    <option value="6">Cena de gala</option>
                                    <option value="7">Otro</option>
                                </select>
                                 <p style="display:none" class="btn-text" data-toggle="modal" data-target="#categoriaEventoModal"><i class="fa fa-edit"></i> Administrar Categorias</p>
                                
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
                                    
                                ></buscador-component>

                                <!-- Resultado Busqueda -->
                                <div class="row" v-if="clientResults.length < clientes.length">
                                    <div v-if="clientResults.length !== 0" class="col-md-12 resultadoInventario">
                                        <div v-for="cliente in clientResults.slice(0,20)" :key="cliente.id">
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
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevoClienteModal"><span class="fa fa-user-plus"></span> Registrar Nuevo Cliente</button>
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
                    <div class="col-md-4 text-right" v-if="clienteSeleccionado">
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
                <div class="row" style="border-bottom:solid; border-width:1px; border-top:none; border-right:none; border-left:none; padding-bottom:20px">
                    <!--
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
                    -->
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
                        <input type="text" placeholder="Nombre del festejado" v-model="festejado.nombre">
                        <input class="mt-2" type="text" placeholder="Edad o motivo de festejo" v-model="festejado.edad">
                    </div>
                    <div class="col-md-1 mt-4" style="padding-top:15px;">
                        <button class="btn btn-sm btn-primary mt-4" v-on:click.prevent="agregarFestejado()"><i class="fa fa-plus-circle
"></i>Agregar</button>
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
                                        <button class="btn btn-sm btn-danger text-center" v-on:click.prevent="eliminarFestejado(index)"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
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
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-4">
                                <buscador-component
                                    :limpiar="limpiar"
                                    placeholder="Buscar Productos"
                                    event-name="results"
                                    :list="inventario"
                                    :keys="['servicio', 'id', 'familia']"
                                    
                                ></buscador-component>

                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#agregarPaquete"><span class="fa fa-plus-circle"></span> Nuevo Paquete</button>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = false"><span class="fa fa-plus-circle"></span> Nuevo Elemento</button>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- Resultado Busqueda items -->
                <div class="row" v-if="results.length < inventario.length">
                    <div v-if="results.length !== 0" class="col-md-4 resultadoInventario">
                        <div class="list-group" v-for="producto in results.slice(0,20)" :key="producto.id">
                            <div class="row contenedor-producto" style="cursor:auto;" >
                                <div class="col-md-3" >
                                    <img class="img-fluid" style="margin-left:10px;" :src="producto.imagen" alt="">
                                </div>
                                <div class="col-md-7">
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder">{{ producto.servicio }}</span></p>
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span>Precio: ${{ producto.precioUnitario }}</p>
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> Familia: {{ producto.familia }}</p>
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> Existencia: {{ producto.disponible }}</p>
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
                                <th scope="col">Precio Especial</th>
                                <th scope="col">Total</th>
                                <th scope="col">Ahorro</th>
                                <th scope="col" width="252">Notas</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(producto, index) in inventarioLocal" v-bind:key="producto.index">
                                <td>
                                    <img v-bind:src="producto.imagen" alt="" width="80px">
                                </td>
                                <td>{{ producto.servicio }}</td>
                                <td>
                                    <input v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="text" v-model="cantidadActualizada" v-on:keyup.enter="updateCantidad(index)">
                                    <span v-else v-on:click="editarCantidad(index, Object.keys(producto))">{{ producto.cantidad }}</span>
                                    
                                </td>
                                
                                <td>
                                    
                                    <input v-if="(producto.precioUnitario == '') || (indice == index && key == 'precioUnitario')" type="text" v-model="precioUnitarioActualizada" v-on:keyup.enter="updatePrecioUnitario(index)">
                                    <span v-else v-on:click="editarPrecioUnitario(index, Object.keys(producto))">{{ producto.precioUnitario | currency}}</span>
                                    <del v-if="(indice == index && key == 'precioUnitario')">{{ producto.precioAnterior | currency}}</del>
                                 </td>
                                 <th scope="row">
                                    <input v-if="(producto.precioEspecial == '') || (indice == index && key == 'precioEspecial')" type="text" v-model="precioEspecialActualizado" v-on:keyup.enter="updatePrecioEspecial(index)">
                                    <span v-else v-on:click="editarPrecioEspecial(index, Object.keys(producto), producto)">{{ producto.precioEspecial | currency}}</span>
                                </th>
                                <td>
                                    <input v-if="(producto.precioFinal == '') || (indice == index && key == 'precioFinal')" type="text" v-model="precioFinalActualizado" v-on:keyup.enter="updatePrecioFinal(index)">
                                    <span v-else v-on:click="editarPrecioFinal(index, Object.keys(producto))">{{ producto.precioFinal | currency}}</span>
                                </td>
                                <td>
                                    <input v-if="(producto.ahorro == '') || (indice == index && key == 'ahorro')" type="text" v-model="ahorroActualizado" v-on:keyup.enter="updateAhorro(index)">
                                    <span v-else v-on:click="editarAhorro(index, Object.keys(producto))">{{ producto.ahorro | currency}}</span>
                                </td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="2" v-if="(producto.notas == '') || (indice == index && key == 'notas')" v-model="notasActualizadas" v-on:keyup.enter="updateNotas(index)">
                                        
                                    </textarea>
                                    <span v-else v-on:click="editarNotas(index, Object.keys(producto))">
                                        {{ producto.notas }}
                                    </span>
                                    

                                </td>
                                <td class="text-center">
                                    <!--
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-primary" @click="editarPaquete(producto, index)">Editar</button>
                                    -->
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-info" @click="verPaquete(producto, index)">Ver</button>
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
                                <label for="precio">Precios Finales</label>
                                <br>
                                <input type="checkbox" id="precioUnitario" v-model="presupuesto.opcionPrecioUnitario">
                                <label for="precioUnitario">Precios Unitarios</label>
                                <br>
                                <input type="checkbox" id="descripcionPaquete" v-model="presupuesto.opcionDescripcionPaquete">
                                <label for="descripcionPaquete">Descripcion Paquetes</label>
                                <br>
                                <input type="checkbox" id="descuento" v-model="presupuesto.opcionDescuento">
                                <label for="descuento">Descuento General</label>
                                <br>
                                <input type="checkbox" id="imagenes" v-model="presupuesto.opcionImagen">
                                <label for="imagenes">Imagenes</label>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-4 mt-4">
                                <h5 v-if="presupuesto.tipo == 'PRESUPUESTO'">Subtotal: <span>{{ calcularSubtotal | currency }}</span></h5>
                                <h3 v-else>Subtotal: <span>{{ saldoFinal | currency }}</span><br>
                                <span style="font-style:italic; font-size:13px; font-weight:normal">Notas de contrato: $0.00</span></h3>

                                <input type="checkbox" id="iva" v-model="presupuesto.opcionIVA">
                                <label for="iva">IVA: <span>{{ calcularIva | currency }}</span>
                                </label>

                                <div class="info mt-3">
                                    <p>TOTAL con IVA: <span>{{ (calcularSubtotal + calcularIva) | currency }}</span></p>
                                    <p>Ahorro General: <span>{{ calcularAhorro | currency }}</span></p>
                                    <p v-if="presupuesto.tipo == 'CONTRATO'" style="color:green">Saldo a favor: $<span>0.00</span></p>
                                   <p style="font-size:16px; font-weight:bold;">Total: {{ calcularSubtotal + calcularIva | currency }} <i class="fa fa-edit"></i></p>

                                    <button v-if="presupuesto.tipo == 'NONE'" class="btn btn-sm btn-primary" @click="mostrarIVA()"><i class="si si-pencil"></i> Editar iva</button>
                                    <button  class="btn btn-sm btn-danger d-block" @click="reduccionDeContrato()">Notas de contrato</button>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6">
                         <label>Comentarios de presupuesto (No visibles para cliente)</label>
                       
                <textarea name="" id="" style="width:100%" rows="5" placeholder="Notas" v-model="presupuesto.notasPresupuesto"></textarea>

                     </div>
                </div>

                <div class="row">
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button class="btn btn-sm btn-block btn-success" @click="guardarPresupuesto()"><i class="fa fa-save"></i> Editar Presupuesto</button>
                        <button v-if="presupuesto.tipo == 'PRESUPUESTO'" class="btn btn-sm btn-block btn-primary mt-3" data-toggle="modal" data-target="#guardarContrato"><i class="fa fa-check"></i> Guardar como contrato</button>
                    </div>
                </div>
                
                <!--
                <div class="">
                        <button class="btn btn-primary" @click="imprimirPDF()"><i class="si si-printer"></i> Imprimir</button>
                        <button class="btn btn-primary" @click="guardarPresupuesto()"><i class="fa fa-save"></i> Guardar como presupuesto</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#guardarContrato"><i class="fa fa-check"></i> Guardar como contrato</button>
                        <button class="btn btn-secondary" @click="mostrarSettings()"><i class="si si-settings"></i> Settings</button>
                </div>
                -->
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
        </div>        

        <!-- Modal agregar paquete -->
        <div class="modal fade modalAgregarPaquete" id="agregarPaquete" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true" style="overflow-y: scroll;">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Crear nuevo paquete</h5>
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
                                                        <img class="img-fluid" :src="'/images/inventario/'+producto.imagen+'.jpg'" alt="">
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
                                        <label class="col-12" for="example-text-input">Total</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio unitario" v-model="paquete.precioFinal">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio de proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="example-text-input" name="example-text-input" placeholder="Precio unitario" v-model="paquete.precioVenta">
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <h4>Precio sugerido: $<span v-text="precioSugerido"></span></h4>
                                    <h4>Utilidad: $<span v-text="utilidad"></span></h4>
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
                                                <th scope="col">Precio especial</th>
                                                <th scope="col">Total</th>
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
                                                <td>
                                                    <input v-if="(producto.precioUnitario == '') || (indice == index && key == 'precioUnitario')" type="number" v-model="precioUnitarioPaquete" v-on:keyup.enter="updatePrecioUnitarioPaquete(index)">
                                                    <span v-else v-on:click="editarPrecioUnitarioPaquete(index, Object.keys(producto), producto)">{{ producto.precioUnitario | currency}}</span>
                                                </td>
                                                <td>
                                                    <input v-if="(producto.precioEspecial == '') || (indice == index && key == 'precioEspecial')" type="number" v-model="precioEspecialPaquete" v-on:keyup.enter="updatePrecioEspecialPaquete(index)">
                                                    <span v-else v-on:click="editarPrecioEspecialPaquete(index, Object.keys(producto), producto)">{{ producto.precioEspecial | currency}}</span>
                                                </td>
                                                <td>{{ producto.precioFinal | currency}}</td>
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
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Servicio" v-model="productoExterno.servicio">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Precio unitario publico</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Precio unitario" v-model="productoExterno.precioUnitario">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Costo Unitario</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Precio venta" v-model="productoExterno.precioVenta">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="proveedor" placeholder="Proveedor" v-model="productoExterno.proveedor">
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
                                            </div>
                                        </div>
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
                                                    <a :href="'/presupuestos/ver/' + contrato.id" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
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
                                                    <a :href="'/presupuestos/ver/' + presupuesto.id" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
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
                    <button type="button" class="btn btn-secondary" onClick="$('#verPresupuestos').modal('hide')">Close</button>
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
                    <button type="button" class="close" onClick="$('#guardarContrato').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Hora de entrega de mobiliario</label><br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="hora-1">Desde</label>
                            <input type="time" id="hora-1" class="form-control" v-model="facturacion.horaInicio">
                        </div>
                        <div class="col-md-4">
                            <label for="hora-2">Hasta</label>
                            <input type="time" id="hora-2" class="form-control" v-model="facturacion.horaFin">
                        </div>
                        <div class="col-md-4">
                            <label for="hora-2">Entrega preferente</label>
                            <select name="horaEntrega" id="" class="form-control" v-model="facturacion.horaEntrega">
                                <option value="MAÑANA">Por la mañana</option>
                                <option value="TARDE">Por la tarde</option>
                                <option value="MEDIO DIA">A medio dia</option>
                                <option value="NOCHE">Por la noche</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="padding-top:20px">
                            <label form="fecha-hora">Fecha y hora de recoleccion</label>
                            <input id="fecha-hora" type="datetime-local" name="fecha-hora" class="form-control" v-model="facturacion.fechaRecoleccion">
                        </div>
                        <div class="col-md-4" style="padding-top:20px">
                            <label for="hora-2">Recolección preferente</label>
                            <select id="" class="form-control">
                                <option value="MAÑANA">Por la mañana</option>
                                <option value="TARDE">Por la tarde</option>
                                <option value="MEDIO DIA">A medio dia</option>
                                <option value="NOCHE">Por la noche</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                            <input id="requireFactura" type="checkbox" name="requireFactura" v-model="requiereFactura">
                            <label form="requireFactura">Factura</label>
                        </div>
                        <div class="col-md-12" style="padding-top:20px">
                            <label form="notasFactura">Notas de contrato</label>
                            <textarea id="notasFactura" class="form-control" width="100%" v-model="facturacion.notasFacturacion"></textarea>
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <label>Datos de facturación</label>
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
                        <div class="col-md-4 mt-4">
                            <input class="form-control" type="text" placeholder="RFC" v-model="facturacion.rfc">
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
                            </select>
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

        <!-- Modal ver paquete -->
        <div class="modal fade" id="verPaquete" tabindex="-1" role="dialog" aria-labelledby="verPaquete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Paquete</h5>
                    <button type="button" class="close" onClick="$('#verPaquete').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="viendoPaquete.length != 0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Precio Final</th>
                                <th scope="col">Precio Venta</th>
                                <th scope="col">Proveedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in viendoPaquete.paquete.inventario" :key="index">
                                <th scope="row">{{ index }}</th>
                                <td>{{ item.nombre }}</td>
                                <td>{{ item.cantidad }}</td>
                                <td>{{ item.precioUnitario | currency}}</td>
                                <td>{{ item.precioFinal | currency}}</td>
                                <td>{{ item.precioVenta | currency}}</td>
                                <td>{{ item.proveedor }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#verPaquete').modal('hide')">Cerrar</button>
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
                unlock: false,
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
                    telefonos: [],
                    presupuestos: [],
                },
                clienteSeleccionadoContratos: [],
                clienteSeleccionadoPresupuestos: [],
                ultimoEvento: '',

                //Usuario y usuarios
                usuarioActual: '',
                usuarios: [],

                presupuesto: ''
                    /*
                    id: '',
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

                    //Version
                    version: 1,

                    //Total
                    total: '',

                    tipoComision: 100,
                    comision: '',

                    //Notas
                    notasPresupuesto: '',
                    */
                ,
                guardarVersion: false,
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
                ahorroActualizado: '0',
                precioFinalActualizado: '',
                notasActualizadas: 'N/A',

                //Paquetes
                paquete: {
                    servicio: '',
                    precioFinal: '',
                    precioVenta: '',
                    guardarPaquete: false,
                    categoria: '',
                    inventario: [],
                },
                precioSugerido: 0,
                utilidad: 0,

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
                },
                configuraciones: '',
                ultimoPresupuesto: '',
            }
        },
        created(){
            this.obtenerUltimoPresupuesto();
            this.obtenerUsuarios();
            //Obtenemos todos los clientes para el buscados
            this.obtenerClientes();
            this.obtenerInventario();
            this.obtenerUsuario();
            this.obtenerUsuarios();
            this.obtenerConfiguraciones();
            
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
            'presupuesto.iva': function(val){
                if(val){
                    this.presupuesto.total = (this.presupuesto.total * (this.iva / 100));
                }
            },
            'presupuesto.lugarEvento': function(val){
                if(val == 'MISMA'){
                    /*
                    this.presupuesto.nombreLugar = this.clienteSeleccionado.nombreLugar;
                    this.presupuesto.direccionLugar = this.clienteSeleccionado.direccionLugar;
                    this.presupuesto.numeroLugar = this.clienteSeleccionado.numeroLugar;
                    this.presupuesto.coloniaLugar = this.clienteSeleccionado.coloniaLugar;
                    */

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
                    this.facturacion.rfc = this.clienteSeleccionado.rfc;
                    this.facturacion.codigoPostal = this.clienteSeleccionado.codigoPostal;

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
            editarPaquete(producto, index){
                this.paqueteEdicion.externo = producto.externo;
                this.paqueteEdicion.imagen = producto.imagen;
                this.paqueteEdicion.servicio = producto.servicio;
                this.paqueteEdicion.cantidad = producto.cantidad;
                this.paqueteEdicion.precioUnitario = producto.precioUnitario;
                this.paqueteEdicion.precioFinal = producto.precioFinal;
                this.paqueteEdicion.ahorro = producto.ahorro;
                this.paqueteEdicion.notas = producto.notas;
                this.paqueteEdicion.paquete = producto.paquete;
                this.paqueteEdicion.tipo = producto.tipo;
                this.paqueteEdicion.id = producto.id;

                this.indicePaqueteEdicion = index;

                $('#editarPaquete').modal('show');
            },
            agregarProductoPaqueteEditado(producto){
                this.paqueteEdicion.paquete.inventario.push({
                    'externo': false,
                    'nombre': producto.servicio,
                    'imagen': producto.imagen,
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '',
                    'cantidad': '',
                    'id': producto.id,
                });
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
            mostrarSettings(){
                if(this.verSettings){
                    this.verSettings = false;
                }else{
                    this.verSettings = true;
                }
            },
            //Metodos para los paquetes
            agregarProductoPaquete(producto){
                this.paquete.inventario.push({
                    'externo': false,
                    'nombre': producto.servicio,
                    'imagen': producto.imagen,
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': '0',
                    'cantidad': '0',
                    'id': producto.id,
                    'precioVenta': '',
                    'proveedor': '',
                    'precioEspecial': producto.precioUnitario,
                    'precioAnterior': producto.precioUnitario,
                });
               
                console.log(this.paquete.inventario);
            },
                    actualizarPrecioSugerido(){
                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            this.precioSugerido+= this.paquete.inventario[i].precioFinal;
                            this.utilidad+= this.paquete.inventario[i].precioFinal-this.paquete.inventario[i].precioVenta;
                        }
                    },
                    //Eliminar producto de paquete
                    eliminarProductoPaquete(index){
                        this.paquete.inventario.splice(index, 1);

                        this.precioSugerido = 0;
                        this.utilidad = 0;

                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            
                            this.precioSugerido+= this.paquete.inventario[i].precioFinal;
                            this.utilidad+= this.paquete.inventario[i].precioFinal-this.paquete.inventario[i].precioVenta;
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

            guardarPaquete(){
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
                    this.inventarioLocal.push({
                        'externo': false,
                        'imagen': 'https://i.redd.it/a0pfd0ajy5t01.jpghttp://saveabandonedbabies.org/wp-content/uploads/2015/08/default.png',
                        'servicio': this.paquete.servicio,
                        'cantidad': 1,
                        'precioUnitario': this.paquete.precioFinal,
                        'precioFinal': this.paquete.precioFinal,
                        'ahorro': 0,
                        'notas': '',
                        'paquete': paquete,
                        'tipo': 'PAQUETE',
                        'id': '',
                        'precioVenta': this.paquete.precioVenta,
                        'precioEspecial': this.paquete.precioFinal,
                        'precioAnterior': this.paquete.precioFinal,
                    });
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
              }else{this.clienteSeleccionado.nombre = cliente.nombre+" "+cliente.apellidoPaterno+" "+cliente.apellidoMaterno;}
                this.clienteSeleccionado.email = cliente.email;
                this.clienteSeleccionado.rfc = cliente.rfc;

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
                            'precioFinal': '',
                            'cantidad': '',
                            'id': '',
                            'precioVenta': this.productoExterno.precioVenta,
                            'proveedor': this.productoExterno.proveedor,
                            'autorizado': this.productoExterno.autorizado,
                            'precioEspecial': this.productoExterno.precioUnitario,
                            'precioAnterior' : this.productoExterno.precioUnitario,
                        });
                    
                    
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
                    }
                    
                }

                document.getElementById('file-image-externo').value = '';
                
                this.productoExterno = {'externo': true, 'imagen': '', 'servicio': '', 'precioUnitario': '', 'paquete': '', 'precioVenta': '', 'proveedor': ''};
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
                this.limpiar = true;
                this.inventarioLocal.push({
                    'externo': false,
                    'imagen': producto.imagen,
                    'servicio': producto.servicio,
                    'cantidad': '1',
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': producto.precioUnitario,
                    'ahorro': '0',
                    'notas': '',
                    'paquete': '',
                    'tipo': 'PRODUCTO',
                    'id': producto.id,
                    'precioVenta': '',
                    'proveedor': '',
                    'precioEspecial': producto.precioUnitario,
                    'precioAnterior': producto.precioUnitario,
                });
                
                setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
                console.log(this.inventarioLocal);
                
            },
            obtenerClientes(){
                let URL = '/obtener-clientes';
                axios.get(URL).then((response) => {
                    this.clientes = response.data;
                    console.log('Estos son los clientes: ', this.clientes);
                    this.obtenerPresupuesto();
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
                
                if(this.presupuesto.tipoEvento == 'INTERNO'){
                    this.presupuesto.tipoServicio = ''
                }

                /*
                if(this.presupuesto.tipoComision == 0){
                    this.presupuesto.comision = this.presupuesto.comision
                }else{
                    this.presupuesto.comision = this.presupuesto.tipoComision
                }

                if(this.presupuesto.total <= this.configuraciones.minimoVentaComision){
                    this.presupuesto.comision = 0;
                }
                */

                let URL = '/presupuestos/create/version';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                    'guardarVersion': this.guardarVersion,
                }).then((response) => {                    
                    if(response.data == 1){
                        Swal.fire(
                            'Error!',
                            'El salon de eventos ya esta ocupado en esta fecha',
                            'error'
                        );
                    }else{
                        Swal.fire(
                            'Creado!',
                            'El presupuesto se creo correctamente',
                            'success'
                        );
                    }       
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                        'Algo salio mal!',
                        'Verifica que completaste todos los campos correctamente antes de continuar',
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

                let URL = '/presupuestos/create/version';
                axios.post(URL, {
                    'presupuesto': this.presupuesto,
                    'festejados': this.festejados,
                    'inventario': this.inventarioLocal,
                    'facturacion': this.facturacion,
                    'guardarVersion': this.guardarVersion,
                }).then((response) => {                    
                    if(response.data == 1){
                        Swal.fire(
                            'Error!',
                            'El salon de eventos ya esta ocupado en esta fecha',
                            'error'
                        );
                    }else{
                        Swal.fire(
                            'Creado!',
                            'El presupuesto se creo correctamente',
                            'success'
                        );
                    }       
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                        'Algo salio mal!',
                        'Verifica que completaste todos los campos correctamente antes de continuar',
                        'error'
                    );
                });
            },
            obtenerPresupuesto(){
                let data = window.location.pathname.split('/');
                let path = data[3];
                let URL = '/obtener-presupuesto/' + path;

                axios.get(URL).then((response) => {
                    this.presupuesto = response.data;
                    console.log('Este es el presupuesto: ', response.data);
                    this.saldoFinal = this.presupuesto.total;
                    let cliente = this.clientes.find(function(element){
                        return element.id == response.data.client_id;
                    })

                    console.log('Este es el cliente', cliente);

                //Obtener el cliente seleccionado
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

                //Obtener los festejados
                let direction = '/obtener-festejados/' + this.presupuesto.id;

                axios.get(direction).then((response) => {
                  this.festejados = response.data;
                }).catch((error) => {
                  console.log(error.data);
                })

                //Obtener el inventario

                let direction2 = '/obtener-inventario-1/' + this.presupuesto.id;

                axios.get(direction2).then((response) => {
                  let arreglo = [];
                  response.data.forEach(function(element){
                    if(!element.externo){
                      let objeto = {
                        'externo': false,
                        'imagen': element.imagen,
                        'servicio': element.servicio,
                        'cantidad': element.cantidad,
                        'precioUnitario': element.precioUnitario,
                        'precioFinal': element.precioFinal,
                        'ahorro': element.ahorro,
                        'notas': element.notas,
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': element.id,
                        'precioVenta': element.precioVenta,
                        'proveedor': element.proveedor,
                        'precioEspecial': element.precioEspecial,
                        'precioAnterior': element.precioAnterior,
                      }
                      arreglo.push(objeto);
                    }else{
                      let objeto = {
                        'externo': true,
                        'imagen': element.imagen,
                        'servicio': element.servicio,
                        'cantidad': element.cantidad,
                        'precioUnitario': element.precioUnitario,
                        'precioFinal': element.precioFinal,
                        'ahorro': element.ahorro,
                        'notas': element.notas,
                        'paquete': '',
                        'tipo': 'PRODUCTO',
                        'id': element.id,
                        'precioVenta': element.precioVenta,
                        'proveedor': element.proveedor,
                        'precioEspecial': element.precioEspecial,
                        'precioAnterior': element.precioAnterior,
                      }
                      arreglo.push(objeto);
                    }
                    
                    return arreglo;
                  });
                this.inventarioLocal = arreglo;
                })

                let direction3 = '/obtener-paquetes/' + this.presupuesto.id;

                axios.get(direction3).then((response) => {
                    
                    let arregloPaquetes = [];

                    response.data.forEach(function(element){
                        let URL = '/obtener-elementos-paquetes/' + element.id;

                        var arregloElementos = [];
                        axios.get(URL).then((response) => {
                            
                            
                            response.data.forEach(function(element){
                                if(element.externo){
                                    let demo = {
                                        'externo': true,
                                        'nombre': element.servicio,
                                        'imagen': element.imagen,
                                        'precioUnitario': element.precioUnitario,
                                        'precioFinal': element.precioFinal,
                                        'cantidad': element.cantidad,
                                        'id': '',
                                        'precioVenta': element.precioVenta,
                                        'proveedor': element.proveedor,
                                        'precioEspecial': element.precioEspecial,
                                        'precioAnterior': element.precioAnterior,
                                    }
                                arregloElementos.push(demo);
                                }else{
                                    let demo = {
                                        'externo': false,
                                        'nombre': element.servicio,
                                        'imagen': element.imagen,
                                        'precioUnitario': element.precioUnitario,
                                        'precioFinal': element.precioFinal,
                                        'cantidad': element.cantidad,
                                        'id': '',
                                        'precioVenta': element.precioVenta,
                                        'proveedor': element.proveedor,
                                        'precioEspecial': element.precioEspecial,
                                        'precioAnterior': element.precioAnterior,
                                    }
                                arregloElementos.push(demo);
                                }
                                return arregloElementos;
                            });
                           return arregloElementos;
                           
                        })

                        let objeto = {
                            'externo': false,
                            'imagen': 'https://www.grupomilan.com/files/imgs/blog/vendemos-cajas-carton.jpg',
                            'servicio': element.servicio,
                            'cantidad': element.cantidad,
                            'precioUnitario': element.precioUnitario,
                            'precioFinal': element.precioFinal,
                            'ahorro': element.ahorro,
                            'notas': element.notas,
                            'paquete': {
                                'categoria': element.categoria,
                                'guardarPaquete': element.guardarPaquete,
                                'precioFinal': element.precioFinal,
                                'servicio': element.servicio,
                                'inventario': arregloElementos,
                            },
                            'tipo': 'PAQUETE',
                            'id': element.id,
                            'precioVenta': element.precioVenta,
                            'proveedor': element.proveedor,
                            'precioEspecial': element.precioEspecial,
                            'precioAnterior': element.precioAnterior,
                        }
                        arregloPaquetes.push(objeto);   
                    }); 
                this.inventarioLocal = this.inventarioLocal.concat(arregloPaquetes);
                
                this.unlock = true;
                }).catch((error) => {
                    console.log(error.data);
                })
                
                
              }).catch((error) => {
                console.log(error.data);
              })
              
             
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

