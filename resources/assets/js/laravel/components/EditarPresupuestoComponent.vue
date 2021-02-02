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
    <section class="container" v-if="unlock" style="background:white;">
        <div class="container-version" style="margin-top:-35px">
    Estas viendo la versión de <span v-if="presupuesto.tipo == 'PRESUPUESTO'" style="color:green">presupuesto</span> <span v-else style="color:green">contrato</span> {{ presupuesto.version }} de {{ presupuesto.version }}
    <br><span v-if="editado==1">Editado</span><span v-else>Sin Cambios</span>
        </div>
        <div class="row">
            
        </div>
        <div class="row mt-4">
            <div class="col-md-12 registroPresupuesto">
                <div class="row">
                    <div class="col-md-5 text-left">
                        <div v-if="presupuesto.tipoEvento == 'INTERNO' || presupuesto.tipoServicio == 'INFANTIL'" class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat">

                        </div>
                        <div v-else class="img-fluid logo-presupuesto" style="background-image: url('http://megamundodecor.com/images/mega-mundo-decor.png'); background-size:100% auto; background-position:center; background-repeat:no-repeat">

                        </div>
                    </div>
                    <div class="col-md-7 text-right info">
                        <p style="font-size:25px; font-weight:bold">Folio de <span v-if="presupuesto.tipo == 'PRESUPUESTO'" style="color:green">presupuesto</span> <span v-else style="color:green">contrato</span>: {{ presupuesto.folio }}</p>
                        <div class="row">
                            <p style="text-align:right; font-size:23px; width:100%; padding-right:25px"><span style="font-weight:bold">Fecha del evento: </span> <span >{{ mostrarFechaEvento }}</span></p>
                        </div>
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
                        <p class="mt-3">Fecha de creación: <span> {{ presupuesto.created_at }}</span></p>
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
                    <div class="col-md-4 row" >
                                <h4>Horario del evento</h4>
                            <div class="col-md-6" style="padding-left:0">
                                <label>Inicio del evento</label><br>
                                <input v-on:change="editadoFuntion()" type="time" class="form-control timepicker" v-model="presupuesto.horaEventoInicio">
                                -AM <input v-on:change="editadoFuntion()" type="radio" required value="AM" name="inicioAmPm" v-model="presupuesto.inicioAmPm"> 
                                -PM <input v-on:change="editadoFuntion()" type="radio" value="PM" name="inicioAmPm" v-model="presupuesto.inicioAmPm"> 
                            </div>
                           
                            <div class="col-md-6" style="padding-left:0">
                                <label>Fin del evento</label><br>
                                <input v-on:change="editadoFuntion()" type="time" class="form-control timepicker" v-model="presupuesto.horaEventoFin">
                                -AM <input v-on:change="editadoFuntion()" type="radio" required value="AM" name="finAmPm" v-model="presupuesto.finAmPm"> 
                                -PM <input v-on:change="editadoFuntion()" type="radio" value="PM" name="finAmPm" v-model="presupuesto.finAmPm"> 
                            </div>
                             <label for="pendienteHora" style="padding-top:10px">
                             <input type="checkbox" v-on:change="editadoFuntion()" name="1" id="pendienteHora" v-model="presupuesto.pendienteHora">
                            Pendiende</label>
                            

                            </div>
                    <div class="col-md-4">
                        
                        <div class="row" >
                            <div class="col-md-12">
                                <h4 class="">Categoria del evento</h4>
                                <p v-text="presupuesto.categoriaEvento"></p>
                                <p style="display: none;" class="btn-text" data-toggle="modal" data-target="#agregarCategoria"><i class="fa fa-edit"></i> Administrar Categorias</p>
                                
                                <div v-if="presupuesto.tipo=='PRESUPUESTO'" class="row mt-4">
                                    <div class="col-md-10">
                                        <label v-if="presupuesto.pendienteFecha" for="">Fecha Pendiente</label>
                                        <input v-if="presupuesto.pendienteFecha==false || presupuesto.pendienteFecha==null" type="date" min="2021-01-26" v-model="presupuesto.fechaEvento">
                                    </div>
                                    <div class="col-md-2 text-left">
                                        <i class="si si-calendar" style="font-size: 24px;"></i>
                                    </div>
                                    
                                </div>
                                <input  v-if="presupuesto.tipo=='PRESUPUESTO'"  type="checkbox" name="" value="1" id="pendienteFecha" v-model="presupuesto.pendienteFecha">
                                <label v-if="presupuesto.tipo=='PRESUPUESTO'" for="pendienteFecha">Pendiende</label><br>
                                
                                
                                <button class="btn btn-info" data-toggle="modal" data-target="#subirNube"><i class="fa fa-cloud"></i> Cambio Fecha</button>
                         

                            </div>
                        </div>
                        
                        <div class="row">
                            
                          
                        </div>
                        
                    </div>
                </div>
                <div  class="row" style="border-bottom:solid; border-width:1px; padding:5px; border-top:none; border-right:none; border-left:none; padding-top:25px">
                    <div class="col-md-8">
                        <h4>Cliente <span v-if="clienteSeleccionado.vetado2 == true" class="badge badge-pill badge-info" style="background:red" >CLIENTE VETADO</span></h4>
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
                            <p style="font-size:25px; color:blue; line-height:27px">{{ clienteSeleccionado.nombre }} {{clienteSeleccionado.apellidoPaterno}} {{clienteSeleccionado.apellidoMaterno}}</p>
                            <p>
                                <span class="badge badge-pill badge-info">Persona {{ clienteSeleccionado.tipo }}</span>
                            </p>
                            <p>{{ clienteSeleccionado.email }}</p>
                            <p v-for="telefono in clienteSeleccionado.telefonos" v-bind:key="telefono.index">
                                <label>
                                    <input type="radio" name="email" v-model="presupuesto.emailEnvio" :value="telefono.email"> 
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
                            <p><span>{{ }}</span> eventos contratados</p>
                            <p><span>{{  }}</span> presupuestos</p>
                                <button v-if="1==2" class="btn btn-sm btn-primary d-inline-block" data-toggle="modal" data-target="#verContratos">Ver Contratos</button>
                                <button v-if="1==2" class="btn btn-sm btn-info d-inline-block" data-toggle="modal" data-target="#verPresupuestos">Ver Presupuestos</button>
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
                <div >
                <h4 v-if="presupuesto.lugarEvento!='BODEGA'">Lugar del Evento</h4>
                <h4 v-else>Recolección en bodega</h4>
                </div>
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
                        <label for="lugarOtro">Recolección en bodega</label>
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" id="pendienteLugar" value="1" v-model="presupuesto.pendienteLugar">
                        <label for="pendienteLugar">Pendiente</label>
                    </div>
          
                    <div class="col-md-10 mt-4" v-if="presupuesto.lugarEvento!='BODEGA'">
                        <input type="text" v-on:change="editadoFuntion()" placeholder="Nombre" v-model="presupuesto.nombreLugar">
                    </div>
                    <div class="col-md-4 mt-4" v-if="presupuesto.lugarEvento!='BODEGA'">
                        <input type="text" v-on:change="editadoFuntion()" placeholder="Direccion" v-model="presupuesto.direccionLugar">
                    </div>
                    <div class="col-md-2 mt-4" v-if="presupuesto.lugarEvento!='BODEGA'">
                        <input type="text" v-on:change="editadoFuntion()" placeholder="Numero" v-model="presupuesto.numeroLugar">
                    </div>
                    <div class="col-md-4 mt-4" v-if="presupuesto.lugarEvento!='BODEGA'">
                        <input type="text" v-on:change="editadoFuntion()" placeholder="Colonia" v-model="presupuesto.coloniaLugar">
                    </div>
                    <div class="col-md-2 mt-4" v-if="presupuesto.lugarEvento!='BODEGA'">
                        <input type="text" v-on:change="editadoFuntion()" placeholder="C.P" v-model="presupuesto.CPLugar">
                    </div>
                    <div class="col-md-12 mt-4">
                        <input type="text" v-on:change="editadoFuntion()" style="background:#FFFDC8; border:none; padding:2px;" name="" id="" placeholder="Observaciones" v-model="presupuesto.observacionesLugar">
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
                

                <!-- SECTION 2 -->
                <div class="row" >
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-4">
                                <buscador-component
                                    :limpiar="limpiar"
                                    placeholder="Buscar Productos"
                                    event-name="results"
                                    :list="inventario"
                                    :keys="['servicio', 'id', 'familia']"
                                    
                                ></buscador-component><span><i class="fa fa-remove" @click="limpiarInput()" style="color:red; position:absolute; right:0"></i></span>

                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#agregarPaquete"><span class="fa fa-plus-circle"></span> Nuevo Paquete</button>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#agregarElemento" @click="controlElementoExterno = false"><span class="fa fa-plus-circle"></span> Nuevo Elemento</button>
                                </div>
                        </div>
                    </div>
                </div>

                <!-- Resultado Busqueda items -->
                <div class="row" v-if="results.length < inventario.length && presupuesto.categoriaEvento!='nube'">
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
                                    <p style="padding:0; margin:0; line-height:14px; font-size:12px; "><span style="font-weight:bolder"></span> En Bodega: {{ producto.cantidad }} En Exhibición: {{ producto.exhibicion }}</p>
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
                                    <input style="background:#F5F6E6; widht:100%; min-height:10px; border-radius:5px" v-if="(producto.cantidad == '') || (indice == index && key == 'cantidad')" type="number" v-model="cantidadActualizada" v-on:change="updateCantidad(index)">
                                    <p v-else v-on:click="editarCantidad(index, Object.keys(producto))">{{ producto.cantidad }}</p>
                                    
                                </td>
                                
                                <td>
                                    
                                    <input v-if="(producto.precioUnitario == '') || (indice == index && key == 'precioUnitario')" type="text" v-model="precioUnitarioActualizada" v-on:change="updatePrecioUnitario(index)">
                                    <span v-else v-on:click="editarPrecioUnitario(index, Object.keys(producto))">{{ producto.precioUnitario | currency}}</span>
                                    <del v-if="(indice == index && key == 'precioUnitario')">{{ producto.precioAnterior | currency}}</del>
                                 </td>
                                 <th scope="row">
                                    <input v-if="(producto.precioEspecial == '') || (indice == index && key == 'precioEspecial')" type="text" v-model="precioEspecialActualizado" v-on:change="updatePrecioEspecial(index)">
                                    <span v-else v-on:click="editarPrecioEspecial(index, Object.keys(producto), producto)">{{ producto.precioEspecial | currency}}</span>
                                </th>
                                <td>
                                    <input v-if="(producto.precioFinal == '') || (indice == index && key == 'precioFinal')" type="text" v-model="precioFinalActualizado" v-on:change="updatePrecioFinal(index)">
                                    <span v-else v-on:click="editarPrecioFinal(index, Object.keys(producto))">{{ producto.precioFinal | currency}}</span>
                                </td>
                                <td>
                                    <input v-if="(producto.ahorro == '') || (indice == index && key == 'ahorro')" type="text" v-model="ahorroActualizado" v-on:change="updateAhorro(index)">
                                    <span v-else v-on:click="editarAhorro(index, Object.keys(producto))">{{ producto.ahorro | currency}}</span>
                                </td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="2" v-if="(producto.notas == '') || (indice == index && key == 'notas')" v-model="notasActualizadas" v-on:change="updateNotas(index)">
                                        
                                    </textarea>
                                    <p style="background:#E4F9DB; widht:100%; min-height:10px; border-radius:5px" v-else v-on:click="editarNotas(index, Object.keys(producto), producto.notas)">
                                        {{ producto.notas }}
                                    </p>
                                    

                                </td>
                                <td class="text-center">
                                    <!--
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-primary" @click="editarPaquete(producto, index)">Editar</button>
                                    -->
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-info" @click="verPaquete(producto, index)">Ver</button>
                                    <button v-if="producto.tipo == 'PAQUETE'" class="btn btn-sm btn-success" @click="editarPaquete(producto)">Editar</button>
                                    <button class="btn btn-sm btn-danger" @click="eliminarProductoLocal(index)">Eliminar</button>
                                    <div v-if="producto.externo" class="btn btn-sm btn-primary" @click="editarProductoExterno(producto, index)">Editar</div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" >
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
                                <h5>Subtotal: <span>{{ calcularSubtotal | currency }}</span></h5> 
                                
                               <h3><span style="font-style:italic; font-size:13px; font-weight:normal; display:none">Notas de contrato: $0.00</span></h3>

                                <input type="checkbox" id="iva" v-model="presupuesto.opcionIVA">
                                <label for="iva">IVA: <span>{{ calcularIva | currency }}</span>
                                </label>

                                <div class="info mt-3">
                                    <H5 v-if="presupuesto.opcionIVA==true">TOTAL + IVA: <span>{{ (calcularSubtotal + calcularIva) | currency }}</span></H5>
                                    <H5 v-else>TOTAL: <span>{{ (calcularSubtotal) | currency }}</span></H5>
                                    <p>Ahorro General: <span>{{ calcularAhorro | currency }}</span></p>
                                    <p v-if="presupuesto.tipo == 'CONTRATO'" style="color:green; display:none">Saldo a favor: $<span>0.00</span></p>
                                   

                                    <button v-if="presupuesto.tipo == 'NONE'" class="btn btn-sm btn-primary" @click="mostrarIVA()"><i class="si si-pencil"></i> Editar iva</button>
                                    <button style="display:none"  class="btn btn-sm btn-danger d-block" @click="reduccionDeContrato()">Notas de contrato</button>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6">
                         <label>Comentarios de presupuesto (No visibles para cliente)</label>
                       
                <textarea name="" id="" style="width:100%" rows="5" placeholder="Notas" v-model="presupuesto.notasPresupuesto"></textarea>

                     </div>
                </div>

                <div class="row" >
                    <div class="col-md-4 offset-md-4 mt-4">
                        <button class="btn btn-sm btn-block btn-success" v-if="editado==1 && presupuesto.categoria!='nube'" @click="guardarPresupuesto()"><i class="fa fa-save"></i> Guardar</button>
                        <label for="" v-else style="text-align:center">No hay cambios para guardar</label><br><br>
                         <button style="" class="btn btn-sm btn-block btn-primary" @click="enviarCorreoCliente()"><i class="fa fa-send-o"></i> Enviar por correo</button>
                         <a target="_blank" class="btn btn-primary" style="width:100%; margin-top:15px;" :href="'/imprimir-budgetVentas/'+presupuesto.id"><i class="si si-printer"></i> Imprimir (No para cliente)</a>
                        <button v-if="presupuesto.tipo == 'PRESUPUESTO' && clienteSeleccionado.vetado2 != true && presupuesto.pendienteFecha!=true" class="btn btn-sm btn-block btn-primary mt-3" data-toggle="modal" data-target="#guardarContrato"><i class="fa fa-check"></i> Guardar como contrato</button>
                        <button v-if="presupuesto.tipo == 'CONTRATO' && presupuesto.categoria!='nube'" class="btn btn-sm btn-block btn-primary mt-3" data-toggle="modal" data-target="#guardarContrato"><i class="fa fa-check"></i> Editar datos de facturacion</button>
                        
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
                                        <label class="col-12" for="example-text-input">Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="proveedor" placeholder="Proveedor" v-model="productoExterno.proveedor">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12" for="example-text-input">Costo Unitario Proveedor</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="example-text-input" placeholder="Precio venta" v-model="productoExterno.precioVenta">
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
                    <button type="button" class="btn btn-primary" @click="agregarProductoExterno()">Guardar</button>
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
                    <div class="col-md-12">
                    <label style="font-weight:bold; color:blue" for="" v-if="presupuesto.lugarEvento=='BODEGA'">Recolección en bodega</label>
                    <label style="font-weight:bold; color:blue" for="" v-if="presupuesto.pendienteLugar">Pendiente Lugar de entrega</label>
                    </div>
                    <div class="row">
                        
                        <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar!=true" class="col-md-4">
                            <label for="hora-1">Desde</label>
                            <input v-on:change="editadoFuntion()" type="time" id="hora-1" class="form-control" v-model="facturacion.horaInicio">
                        </div>
                        <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar!=true" class="col-md-4">
                            <label for="hora-2">Hasta</label>
                            <input v-on:change="editadoFuntion()" type="time" id="hora-2" class="form-control" v-model="facturacion.horaFin">
                        </div>
                        <div v-if="presupuesto.lugarEvento!='BODEGA' && presupuesto.pendienteLugar!=true" class="col-md-4">
                            <label for="hora-2">Entrega preferente</label>
                            <select name="horaEntrega" id="" class="form-control" v-model="facturacion.horaEntrega" @change="modificarHoraEntrega()">
                                <option selected value="OTRO">Otra</option>
                                <option value="LA MAÑANA">Por la mañana</option>
                                <option value="LA TARDE">Por la tarde</option>
                                <option value="MEDIO DIA">A medio dia</option>
                                <option value="LA NOCHE">Por la noche</option>
                                <option value="PENDIENTE">Pendiente por confirmar cliente</option>
                                <option value="SIEMPRE">Siempre hay alguien</option>
                                <option value="UN DIA ANTES">Un Dia Antes</option>
                                <option value="DOS DIAS ANTES">Dos Dias Antes</option>
                                <option value="NO APLICA">No Aplica</option>
                            </select>
                        </div>
                        <br>
                        <div class="col-md-12" style="padding-top:15px">
                        <label>Fecha y Hora de retorno de mobiliario</label></div>
                        <div v-if="facturacion.entregaEnBodega!=true" class="col-md-4" style="padding-top:20px">
                            <label form="fecha-hora">Fecha de recoleccion</label>
                            <input v-on:change="editadoFuntion()" id="recoleccionFecha" type="date" name="recoleccionFecha" class="form-control" v-model="facturacion.fechaRecoleccion">
                        </div>
                        <div v-if="facturacion.entregaEnBodega!=true" class="col-md-4" style="padding-top:20px">
                            <label form="fecha-hora">Hora de recoleccion</label>
                            <input  v-on:change="editadoFuntion()" id="recoleccionHora" type="time" name="recoleccionHora" class="form-control" v-model="facturacion.horaRecoleccion">
                        </div>
                        <div v-if="facturacion.entregaEnBodega!=true" class="col-md-4" style="padding-top:20px">
                            <label for="hora-2">Recolección preferente</label>
                            <select id="" class="form-control" v-model="facturacion.recoleccionPreferente" @change="modificarHoraRecoleccion()">
                                <option value="OTRO" selected>Otra</option>
                                <option value="LA MAÑANA">Por la mañana</option>
                                <option value="LA TARDE">Por la tarde</option>
                                <option value="MEDIO DIA">A medio dia</option>
                                <option value="LA NOCHE">Por la noche</option>
                                <option value="PENDIENTE">Pendiente por confirmar cliente</option>
                                <option value="SIEMPRE">Siempre hay alguien</option>
                                <option value="UN DIA ANTES">Un Dia Antes</option>
                                <option value="DOS DIAS ANTES">Dos Dias Antes</option>
                                <option value="NO APLICA">No Aplica</option>
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
                            <label form="notasFactura">Notas de facturación</label>
                            <textarea v-on:change="editadoFuntion()" id="notasFactura" class="form-control" width="100%" v-model="facturacion.notasFacturacion"></textarea>
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <label>Datos de facturación</label>
                            <input class="form-control" v-on:change="editadoFuntion()" type="text" placeholder="Nombre" v-model="facturacion.nombreFacturacion">
                        </div>
                        <div class="col-md-5 mt-4">
                            <input class="form-control" v-on:change="editadoFuntion()" type="text" placeholder="Direccion" v-model="facturacion.direccionFacturacion">
                        </div>
                        <div class="col-md-2 mt-4">
                            <input class="form-control" v-on:change="editadoFuntion()" type="text" placeholder="Numero" v-model="facturacion.numeroFacturacion">
                        </div>
                        <div class="col-md-5 mt-4">
                            <input class="form-control" v-on:change="editadoFuntion()" type="text" placeholder="Colonia" v-model="facturacion.coloniaFacturacion">
                        </div>
                        <div class="col-md-6 mt-4">
                            <input class="form-control" v-on:change="editadoFuntion()" type="email" placeholder="Email" v-model="facturacion.emailFacturacion">
                        </div>
                        <div class="col-md-4 mt-4">
                            <input class="form-control" v-on:change="editadoFuntion()" type="text" placeholder="RFC" v-model="facturacion.rfcFacturacion">
                        </div>
                        <div class="col-md-2 mt-4">
                            <input class="form-control" v-on:change="editadoFuntion()" type="text" placeholder="C.P" v-model="facturacion.codigoPostal">
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
                    <button type="button" class="btn btn-primary"  @click="guardarContrato()">Guardar</button>
                    
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
                                                    <div class="btn btn-sm btn-danger" @click="eliminarProductoPaqueteEdicion(index)">Eliminar 2</div>
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

          <!-- Modal subir a la nube -->
        <div class="modal fade" id="subirNube" tabindex="-1" role="dialog" aria-labelledby="verContratos" aria-hidden="true">
            <div id="app" class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle" style="text-align:center; width:100%">Cambio de fecha</h5>
                    <button type="button" class="close" onClick="$('#subirNube').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                        <label for="">Nueva Fecha (Cambio con fecha definida)</label><br>
                        <input v-model="nube.newDate" class="form-control" type="date" min="2021-01-26">
                        </div>
                        <div class="form-group">
                        <label>Motivo</label>
                        <textarea required class="form-control" v-model="nube.motivo" id="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                        <h5 class="modal-title" id="exampleModalCenterTitle" style="text-align:center; width:100%">Enviar a nube (Cambio con fecha indefinida)</h5><br>
                        <label v-if="nube.newDate==null" for="">Vigencia de credito a favor</label><br>
                        <input v-if="nube.newDate==null" v-model="nube.vigencia" class="form-control" type="date">
                        </div>
                <button @click="enviarANube()" class="btn btn-info">Confirmar</button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick="$('#subirNube').modal('hide')">Cerrar</button>
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
                nube:{
                    motivo:null,
                    newDate:null,
                    vigencia:null
                },
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

                presupuesto: '',
                guardarVersion: false,
                clientes: [],
                festejado: {
                    nombre: '',
                    edad: '',
                },
                inventario: [],
                paqueteEdicion: '',

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
                editado:0,

                notasAnterior:'',

                //Edicion de paquete
                indicePaqueteEdicion: '',

                //Control sobre las ediciones en la tabla de productos
                indice: '',
                key: '',

                precioEspecialActualizado: '',
                cantidadActualizada: '',
                ahorroActualizado: '0',
                precioFinalActualizado: '',
                notasActualizadas: '--',

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
                costoProveedor:0,

                precioSugeridoEdicion: 0,
                utilidadEdicion: 0,
                costoProveedorEdicion:0,

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
                emailSeleccionado: '',
                facturacion: {
                    //Tiempos
                    horaInicio: '',
                    horaFin: '',
                    horaEntrega: '',
                    fechaRecoleccion: '',
                    horaRecoleccion: '',
                    recoleccionPreferente: '',
                    notasFacturacion: '',

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
                precioUnitarioActualizada: '',

                editarElementoExt: null,
                editarElementoExtIndex: null,

                /*
                nombreCategoria: '',
                categorias: [],
                */
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
            
            //this.obtenerCategorias();
            
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
             mostrarFechaEvento: function(){
                let fecha = this.presupuesto.fechaEvento;
                moment.locale('es'); 
                let date = moment(fecha).format('dddd, LL');
                if(date == 'Invalid date'){
                    date = 'pendiente';
                }

                return date;
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
           /* calcularContratos: function(){
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
            },*/
           /* calcularPresupuestos: function(){
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
            }*/
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
                    /*
                    this.presupuesto.nombreLugar = this.clienteSeleccionado.nombreLugar;
                    this.presupuesto.direccionLugar = this.clienteSeleccionado.direccionLugar;
                    this.presupuesto.numeroLugar = this.clienteSeleccionado.numeroLugar;
                    this.presupuesto.coloniaLugar = this.clienteSeleccionado.coloniaLugar;
                    */

                }else{
                     this.presupuesto.nombreLugar = this.presupuesto.nombreLugar;
                    this.presupuesto.direccionLugar = this.presupuesto.direccionLugar;
                    this.presupuesto.numeroLugar = this.presupuesto.numeroLugar;
                    this.presupuesto.coloniaLugar = this.presupuesto.coloniaLugar;
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
            
            editarPaquete: function(producto){
                this.paqueteEdicion = producto
                $('#editarPaquete').modal('show');
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
                this.editado=1;
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
                this.editado=1;
            },
            /*
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
            */
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
               
                console.log(this.paquete.inventario);
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
               
                console.log(this.paquete.inventario);
            },
                    actualizarPrecioSugerido(){
                        this.precioSugerido=0;
                        this.utilidad=0;
                        this.costoProveedor=0;
                        for (var i = 0; i < this.paquete.inventario.length; i++) {
                            this.precioSugerido+= parseInt(this.paquete.inventario[i].precioFinal);
                            this.utilidad+= parseInt(this.paquete.inventario[i].precioFinal)-(parseInt(this.paquete.inventario[i].precioVenta)*parseInt(this.paquete.inventario[i].cantidad));
                            this.costoProveedor+= parseInt(this.paquete.inventario[i].precioVenta);
                        }
                        this.paquete.precioFinal = this.precioSugerido;
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
                    //Eliminar producto de paquete
                    eliminarProductoPaquete(index){
                        console.log(index)
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

                    //Eliminar producto de paquete
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

                    limpiarInput(){
                        this.limpiar=true;
                        setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
                    },

                    updateCantidadPaquete(index){
                        this.precioSugerido = 0;
                        this.utilidad = 0;
                        this.costoProveedor = 0;
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

            guardarPaquete(){
                let count;
                
                
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
                        externo: false,
                        imagen: 'https://i.redd.it/a0pfd0ajy5t01.jpghttp://saveabandonedbabies.org/wp-content/uploads/2015/08/default.png',
                        servicio: this.paquete.servicio,
                        cantidad: 1,
                        precioUnitario: this.precioSugerido,
                        precioFinal: this.precioSugerido,
                        ahorro: '0',
                        notas: '',
                        paquete: paquete,
                        tipo: 'PAQUETE',
                        id: '',
                        precioVenta: this.paquete.precioVenta,
                        precioEspecial: this.precioSugerido,
                        precioAnterior: this.precioSugerido,
                    });
                    Swal.fire(
                        'Listo!',
                        'Paquete agregado con exito a presupuesto',
                        'success'
                        ) 
                }

            },
            // Metodo para obtener el cliente seleccionado
            obtenerCliente(cliente){
                this.clienteSeleccionado.apellidoPaterno = '';
                this.clienteSeleccionado.apellidoMaterno = '';
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
                this.clienteSeleccionado.vetado2 = cliente.vetado;

                if(cliente.apellidoPaterno==undefined && cliente.apellidoMaterno==undefined){
                this.clienteSeleccionado.nombre = cliente.nombre;
              }else{this.clienteSeleccionado.nombre = cliente.nombre+" "+cliente.apellidoPaterno+" "+cliente.apellidoMaterno;}
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
                            'precioFinal': '',
                            'cantidad': '',
                            'id': '',
                            'precioVenta': this.productoExterno.precioVenta,
                            'proveedor': this.productoExterno.proveedor,
                            'autorizado': this.productoExterno.autorizado,
                            'precioEspecial': this.productoExterno.precioUnitario,
                            'precioAnterior' : this.productoExterno.precioUnitario,
                        });
                    this.editado=1;
                    $('#agregarElemento').modal('hide');
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
                        $('#agregarElemento').modal('hide');
                        this.inventarioLocal = this.inventarioLocal.reverse();
                    }
                    this.editado=1;
                    
                }

                document.getElementById('file-image-externo').value = '';
                
                this.productoExterno = {'externo': true, 'imagen': '', 'servicio': '', 'precioUnitario': '', 'paquete': '', 'precioVenta': '', 'proveedor': '', 'autorizado': false};
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
                    this.editado=1;
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
                    this.editado=1;
                },

                // Cantidad
                editarCantidad(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[3];
                    //console.log(index);
                    //console.log(this.key);
                       this.editado=1;
                },
                editarPrecioUnitario(index, key){
                    //console.log(key);
                    this.indice = index;
                    this.key = key[4];
                    //console.log(index);
                    //console.log(this.key);
                       this.editado=1;
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
                    this.editado=1;
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
                    this.calcularSubtotal();
                    this.editado=1;
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
                    this.calcularSubtotal();
                    this.editado=1;
                },
                //Ahorro
                editarAhorro(index, key){
                    this.indice = index;
                    this.key = key[6]; 
                    //console.log(index);
                    //console.log(this.key); 
                    this.editado=1; 
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
                        this.editado=1;
                    }
                    
                },

                //Precio Final
                editarPrecioFinal(index, key){
                    this.indice = index;
                    this.key = key[5];
                    //console.log(index);
                    //console.log(this.key);  
                    this.editado=1;
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
                        this.editado=1;
                    }
                    
                },

                //Notas
                editarNotas(index, key, notas){
                    this.notasActualizadas= notas;
                    this.indice = index; 
                    this.key = key[7];
                    //console.log(index);
                    //console.log(this.key); 
                    this.editado=1;
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
                        this.editado=1;
                    
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
                this.inventarioLocal = this.inventarioLocal.reverse();
                this.inventarioLocal.push({
                    'externo': false,
                    'imagen': producto.imagen,
                    'servicio': producto.servicio,
                    'cantidad': '1',
                    'precioUnitario': producto.precioUnitario,
                    'precioFinal': producto.precioUnitario,
                    'ahorro': '0',
                    'notas': '--',
                    'paquete': '',
                    'tipo': 'PRODUCTO',
                    'id': producto.id,
                    'precioVenta': producto.precioVenta,
                    'proveedor': '',
                    'precioEspecial': producto.precioUnitario,
                    'precioAnterior': producto.precioUnitario,
                });

                this.inventarioLocal = this.inventarioLocal.reverse();
                
                setTimeout(() => {
                    this.limpiar = false;
                }, 1000);
                console.log(this.inventarioLocal);
                this.editado=1;
                
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
                this.editado=1;
            },
            eliminarFestejado(index){
                this.festejados.splice(index, 1);
                this.editado=1;
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
                            'El presupuesto se actualizo correctamente',
                            'success'
                        );
                        this.obtenerPresupuesto();
                    }       
                }).catch((error) => {
                    console.log(error.data);
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
                this.editado=0;
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
                            'El contrato se creo correctamente',
                            'success'
                        );
                        $('#guardarContrato').modal('hide');
                    }       
                }).catch((error) => {
                    console.log(error.data);
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
                this.editado=0;
            },
            obtenerPresupuesto(){
                let data = window.location.pathname.split('/');
                let path = data[3];
                let URL = '/obtener-presupuesto/' + path;

                axios.get(URL).then((response) => {
                    this.presupuesto = response.data;
                    this.facturacion = response.data;
                    
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
                this.clienteSeleccionado.vetado2 = cliente.vetado;
                this.clienteSeleccionado.nombre = cliente.nombre;
                this.clienteSeleccionado.apellidoPaterno = cliente.apellidoPaterno;
                this.clienteSeleccionado.apellidoMaterno = cliente.apellidoMaterno;
                this.clienteSeleccionado.email = cliente.email;
                this.clienteSeleccionado.rfc = cliente.rfcFacturacion;
                this.clienteSeleccionado.tipo = cliente.tipoPersona;
                

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
            enviarCorreoCliente(){
                let URL = '/enviar-email-cliente/'  + this.presupuesto.id + '&' + this.emailSeleccionado;

                axios.get(URL).then((response) => {
                    Swal.fire(
                            'Enviado!',
                            'El Correo se envio correctamente',
                            'success'
                        ); 
                }).catch((error) => {
                    console.log(error.data);
                })
            },

            editadoFuntion(){
                
                this.editado=1;
            },

            enviarANube(){
                let URL = '/nube/create';
                //alert('funciona');
                
                axios.post(URL, {
                    'budget_id': this.presupuesto.id,
                    'motivo':this.nube.motivo,
                    'fechaAnterior':this.presupuesto.fechaEvento,
                    'categoriaAnterior':this.presupuesto.categoria,
                    'fechaNueva':this.nube.newDate,
                    'vigencia':this.nube.vigencia,

                }).then((response) => {
        
                  $('#subirNube').modal('hide');
                   // console.log(this.cliente);
                    Swal.fire({
                                title: 'Operación Completa',
                                text: "",
                                type: 'success',
                                showCancelButton: false,
                                cancelButtonColor: '#d33',
                                
                            })
                var myParameters = window.location.search;// Get the parameters from the current page

                var URL = "/cambio-fecha/"

                var W = window.open(URL);

                W.window.print(); 
                         
                            
                }).catch((error) => {
                    console.log(error);
                });
               
            },
            
        }
    }
</script>

