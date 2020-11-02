<style scoped>
    .caja-1 input{
        width: 100%;
        padding: 2px;
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

    .registrosPagos{
        width: 90%;
        margin: 0 auto;
        border-radius: 15px;
        background-color: rgba(240, 242, 245, 1);
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    select{
        width: 100%;
    }

    .abonarPresupuesto{
        background-color: rgba(66, 117, 194, 1);
        padding: 5px;
        padding-bottom: 10px;
    }

    .infoPresupuesto p{
        line-height: 6px;
    }

    .registrosPagos p{
        line-height: 6px;
    }
</style>

<template>
    <section class="container">
        <p v-if="mostrarAbrirCaja" style="color:red; font-style:italic">Ultima Apertura: {{sesion.fechaApertura | formatearFecha}}</p>
       <!-- <div v-if="mostrarAbrirCaja && cajaAbiertaPorOtroUsuario==false">
            <div >
            <p style="font-size:20px; text-align:center; width:50%; margin-left:25%; color:white; background:orange; border-radius:10px; padding:20px; margin-top:40px">Caja abierta por otro usuario, no es posible abrir 2 cajas simultaneamente</p> 
            </div>
        </div> -->
        <div class="row" v-if="mostrarAbrirCaja">
            <div class="col-md-4" v-if="sesion.length != 0">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Apertura de caja</h3>
                        <div class="block-options">
                            
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://www.alaingarcia.net/conozca/i/billete_1000_pesos_holograma.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreBillete1000}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete1000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="http://cdn.kaltura.com/p/0/thumbnail/entry_id/1_m98xxec5/quality/80/width/800/height/349" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreBillete500}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete500">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="http://eltrochilero.com/wp-content/uploads/2018/02/Billete200anverso.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreBillete200}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete200">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://www.cambiator.es/wp-content/uploads/Billete-de-100-pesos-mexicanos-100-MXN-reverso.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreBillete100}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete100">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://i.pinimg.com/originals/a4/07/21/a4072113bae69abe37ac3d547f6b60f9.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreBillete50}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete50">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <img src="https://vanguardia.com.mx/sites/default/files/styles/paragraph_image_large_desktop_1x/public/mexico-20-pesos-benito-juarez-aztec-city-2012-p-image-88084-grande.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreBillete20}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" v-model="cantidad.billete20">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Apertura de caja</h3>
                        <div class="block-options">
                            
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <img src="https://i.colnect.net/f/3336/608/10-Pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreMoneda10}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" v-model="cantidad.moneda10">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <img src="https://i.colnect.net/f/3336/603/5-Nuevos-Pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreMoneda5}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" v-model="cantidad.moneda5">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <img src="https://i.colnect.net/f/3782/629/2-Pesos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreMoneda2}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" v-model="cantidad.moneda2">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <img src="https://i.colnect.net/f/3444/383/1-Peso.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                                {{sesion.cierreMoneda1}}
                                <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" v-model="cantidad.moneda1">
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <img src="https://i.colnect.net/f/3019/209/50-Centavos.jpg" alt="" width="100%">
                            </div>
                            <div class="col-md-1 text-center">
                               {{sesion.cierreCentavo50}} <i class="fa fa-arrow-right"></i>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" v-model="cantidad.centavo50">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Apertura de caja</h3>
                        <div class="block-options">
                            
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">Suma total de efectivo en caja</label>
                            <currency-input class="form-control" v-model="sumarCantidad" currency="USD" locale="en"/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-block btn-info" @click="abrirCaja()">Abrir Caja</button>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="pagosPasados.length != 0">
                    <div class="col-md-12">
                        <h4>Dolares y Cheques</h4>
                        <label>Cheques: <span>{{ sumaPagosPasados[0] | currency }}</span></label> <br>
                        <input v-on:change="updateChequesApertura()" type="input" v-model="arrayDatos[0]"><br>
                        <label style="display:none">Transferencias: <span>{{ sumaPagosPasados[1] | currency }}</span></label> <br>
                        <input style="display:none" type="input" v-model="sumaPagosPasados[1]"><br>
                        <label>Dolares: <span>{{ sesion.cantidadDolares | currency }}</span></label><br>
                        <input v-on:change="updateDolaresApertura()" type="input" v-model="arrayDatos[1]">
                    </div>
                </div>
            </div>

            
        </div>

        

        <div class="row" v-if="mostrarAbrirCaja==false && cajaAbiertaPorOtroUsuario" >
            <div v-if="sesionActual.length != 0" class="col-md-12"><p style="border-radius:10px; padding:5px;"><span style="font-weight:bold; color:green; text-decoration:underline">*Caja Abierta</span><br> <span style="color:grey; font-style:italic">Apertura por {{ sesionActual.user.name }} - {{ sesionActual.fechaApertura | formatearFecha}} {{ sesionActual.created_at | formatearHora}}</span></p></div>
            <div class="col-md-12">
                <ul class="nav nav-pills mb-3 ml-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#presupuestos" role="tab" aria-controls="pills-home" aria-selected="true">Registrar pagos a contratos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#otros" role="tab" aria-controls="pills-profile" aria-selected="false">Registrar otros ingresos</a>
                    </li>
                    <li>
                        <button class="btn btn-info ml-2" data-toggle="modal" data-target="#cerrarCaja" @click="obtenerCorte()">Pre-corte</button>
                    </li>
                </ul> 
            
        
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="presupuestos" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-6 caja-1">
                                    <div class="block">
                                        <div class="col-md-12 p-2">
                                            <buscador-component
                                                :limpiar="limpiar"
                                                placeholder="Buscar contrato"
                                                event-name="presupuestosResults"
                                                :list="presupuestos"
                                                :keys="['folio', 'fechaEvento', 'cliente']"
                                                
                                            ></buscador-component>

                                            <!-- Resultados de Busqueda -->
                                            <div class="row" v-if="presupuestosResults.length < presupuestos.length">
                                                <div v-if="presupuestosResults.length !== 0" class="col-md-12 resultadoInventario">
                                                    <div v-for="presupuesto in presupuestosResults.slice(0,20)" :key="presupuesto.id">
                                                        <div class="row contenedor-producto" v-on:click="obtenerPresupuesto(presupuesto)" style="margin:0">
                                                            <div class="col-md-3">
                                                                <img class="img-fluid" src="https://i.stack.imgur.com/l60Hf.png" alt="">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p style="padding:0; margin:0; line-height:14px; font-size:13px; "><span style="font-weight:bold">Folio: {{ presupuesto.folio }}</span></p>
                                                                <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ presupuesto.cliente }}</p>
                                                                <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">Fecha del evento: {{ presupuesto.fechaEvento }}</p>
                                                                <p style="padding:0; margin:0; line-height:14px; font-size:11px; "><span style="font-weight:bold">Total:</span> {{ presupuesto.total | currency}}</p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fin resultados de busqueda -->

                                            <div class="col-md-12 p-2 mt-2 infoPresupuesto" v-if="presupuestoSeleccionado">
                                                <div class="row" v-if="presupuestoSeleccionado.cancelado">
                                                    <div class="col-md-4">
                                                        <p>
                                                            <span class="badge badge-pill badge-danger" style="font-size: 12px;">CANCELADO</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p>
                                                            <strong>Fecha de cancelacion:</strong> <span style="line-height:22px;">{{ presupuestoSeleccionado.fechaCancelacion | formatearFecha}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <p>
                                                            <strong>Folio de contrato:</strong> <span style="line-height:22px;">{{ this.presupuestoSeleccionado.folio }}</span><br><span style="color:blue;"><a target="_blank" :href="'/presupuestos/ver/' + presupuestoSeleccionado.id">Ver ficha tecnica</a></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <p>
                                                            <strong>Fecha del evento: </strong><span style="line-height:13px"> {{ this.presupuestoSeleccionado.fechaEvento | formatearFecha}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p>
                                                            <strong>Cliente:</strong> <span>{{ this.presupuestoSeleccionado.cliente }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12"><p><strong>Fecha Limite de pago: </strong> </p></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 text-center" style="background:#E2F9FF; padding-top:10px">
                                                        <p>
                                                            <strong style="font-weight:bold">Total a pagar: </strong>
                                                        </p>
                                                        <p>{{ totalEtiqueta | currency}}</p>
                                                    </div>
                                                    <div class="col-md-4 text-center" style=" padding-top:10px">
                                                        <p>
                                                            <strong>Total abonado:</strong>
                                                        </p>
                                                        <p>{{ totalAbonado  | currency}}</p>
                                                    </div>
                                                    <div class="col-md-4 text-center" style="background:#FFE2E2; padding-top:10px">
                                                        <p>
                                                            <strong>Saldo pendiente:</strong>
                                                        </p>
                                                        <p class="text-danger">{{ totalEtiqueta - totalAbonado | currency }}</p>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-top:15px">
                                                    <p v-if="((pago.method=='TRANSFERENCIA' | pago.method=='TARJETA') && (presupuestoSeleccionado.opcionIVA!='1'))" style="color:red; font-style:italic; padding:10px; text-align:center; line-height:16px">*Este contrato no requiere factura, por lo que al realizar pago con tarjeta o tranferencia se debera cobrar un 16% extra al abono a realizar</p>
                                                    <p v-if="((pago.method=='TRANSFERENCIA' | pago.method=='TARJETA') && (presupuestoSeleccionado.opcionIVA!='1'))" style="color:blue; font-weight:bold; font-style:normal; padding:10px; text-align:center; line-height:18px">Total a pagar: {{pago.amount*1.16 | currency}}</p>
                                                    <p v-if="((pago.method=='TRANSFERENCIA' | pago.method=='TARJETA') && (presupuestoSeleccionado.opcionIVA=='1'))" style="color:green; font-style:italic; padding:10px; text-align:center">*IVA ya incluido en total a pagar</p>
                                                    <div v-if="totalAbonado!=this.totalEtiqueta" class="col-md-8 offset-md-2 abonarPresupuesto">
                                                        <div class="col-md-12 mt-3">
                                                            <label style="width:100%; color:white" @click="liquidarBtn()">
                                                            <span><input style="width:10px" type="checkbox" v-model="liquidar"></span><span> Pagar total</span>
                                                            </label>
                                                            <select name="" id="" v-model="pago.method">
                                                                <option value="">Selecciona un metodo de pago</option>
                                                                <option value="EFECTIVO">Efectivo</option>
                                                                <option value="CHEQUE">Cheque</option>
                                                                <option value="TRANSFERENCIA">Transferencia</option>
                                                                <option value="TARJETA">Tarjeta</option>
                                                                <option value="DOLAR">Dolar</option>
                                                            </select>
                                                            
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            
                                                            <currency-input class="form-control" v-model="pago.amount" currency="USD" locale="en"/>
                                                            
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <input v-if="pago.method == 'DOLAR'" type="number" placeholder="Ingresa el tipo de cambio" v-model="pago.reference">
                                                            <input v-if="pago.method == 'TRANSFERENCIA'" type="number" placeholder="Ingresa numero referencia de transacción" v-model="pago.reference"><br>
                                                            <input type="text" placeholder="Banco / Comentarios" v-model="pago.comentarios">
                                                            <input v-if="pago.method == 'CHEQUE'" type="number" placeholder="Ingresa numero de cheque" v-model="pago.reference">
                                                            <input v-if="pago.method == 'TARJETA'" type="number" placeholder="Ingresa los ultimos 4 digitos de la tarjeta" v-model="pago.reference">
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <input v-if="pago.method == 'TARJETA' || pago.method == 'TRANSFERENCIA' || pago.method == 'CHEQUE'" type="text" placeholder="Ingresa a Cta." v-model="pago.bank">
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <button class="btn btn-sm btn-info btn-block" @click="registrarPago()">Registrar pago</button>
                                                        </div>
                                                    </div>
                                                    <div v-if="totalAbonado==this.totalEtiqueta" class="col-md-12"><p style="color:white; background:green; padding:10px; border-radius:5px; font-style:italic; text-align:center">Contrato pagado</p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block p-3" v-if="presupuestoSeleccionado">
                                        <button class="btn btn-sm btn-danger" @click="cancelarContrato">Cancelar contrato</button>
                                    </div>
                                </div>

                                <div class="col-md-6 caja-2">
                                    <div class="block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" style="font-size:15px; padding:10px">Pagos realizados al contrato: {{presupuestoSeleccionado.folio}}</label>
                                                <div class="registrosPagos" v-for="(item, index) in presupuestoSeleccionado.payments" :key="index">
                                                    
                                                    <div class="row" style="padding:10px">
                                                        <div class="col-md-12">
                                                            <span v-if="item.method != 'DOLAR'">Abono: {{ item.amount | currency}}</span><span v-else>{{ item.amount | currency}} $USD - {{ (item.amount * item.reference) | currency }}</span> - <span>{{ item.method }}</span><br>
                                                            <span v-if="(presupuestoSeleccionado.opcionIVA!=1 && item.method == 'TARJETA') || (presupuestoSeleccionado.opcionIVA!=1 && item.method == 'TRANSFERENCIA')" style="color:green">IVA: {{ item.amount*.16 | currency}}</span><br>
                                                            <span v-if="(presupuestoSeleccionado.opcionIVA!=1 && item.method == 'TARJETA') || (presupuestoSeleccionado.opcionIVA!=1 && item.method == 'TRANSFERENCIA')" style="color:blue">Total Cobrado: {{ item.amount*1.16 | currency}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p v-if="item.method == 'TRANSFERENCIA'"><strong>Referencia:</strong> {{ item.reference }}</p>
                                                            <p v-if="item.method == 'TARJETA'"><strong>Numero de tarjeta:</strong> {{ item.reference }}</p>
                                                            <p v-if="item.method == 'DOLAR'"><strong>Tipo de cambio:</strong> ${{ item.reference }}</p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p><strong>Fecha y hora de pago: </strong><span> {{ item.created_at | formatearFecha }} {{ item.created_at | formatearHora }}</span></p>
                                                            <a target="_blank" :href="'recibo-pagor/pdf/' + item.id" style="color:blue"><i class="si si-printer"></i> Reimprimir Recibo</a>                                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="otros" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="block col-md-12 p-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Egreso/Ingreso</label>
                                                    <select class="form-control" v-model="movimiento.tipo">
                                                        <option value="INGRESO">Ingreso</option>
                                                        <option value="EGRESO">Egreso</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Motivo</label>
                                                    <select class="form-control" name="" id="" v-model="movimiento.motivo">
                                                        <option v-for="(item, index) in categorias" :key="index" :value="item.nombre">{{ item.nombre }}</option>
                                                    </select>
                                                    <label style="cursor: pointer; font-size: 11px;" data-toggle="modal" data-target="#nuevaCategoria">Añadir nuevo registro</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: -15px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div v-if="movimiento.motivo == 'Proveedor'">
                                                        <label for="">Proveedores</label>
                                                        <select class="form-control" name="" id="" v-model="movimiento.responsable">
                                                            <option v-for="(item, index) in proveedores" :key="index" :value="item.nombre">{{ item.nombre }}</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div v-if="movimiento.tipo == 'EGRESO' && movimiento.motivo !== 'Proveedor'">
                                                        <label for="">Responsable</label>
                                                    <select class="form-control" name="" id="" v-model="movimiento.responsable">
                                                        <option v-for="(item, index) in responsables" :key="index" :value="item.nombre">{{ item.nombre }}</option>
                                                    </select>
                                                    <label style="cursor: pointer; font-size: 11px;" data-toggle="modal" data-target="#administrarResponsables">Añadir nuevo registro</label>
                                                    </div>
                                                    
                                                    <div v-if="movimiento.motivo == 'Contrato'">
                                                        <label for="">Contrato</label>
                                                        <buscador-component
                                                            :limpiar="limpiar"
                                                            placeholder="Buscar contrato"
                                                            event-name="presupuestosResults"
                                                            :list="presupuestos"
                                                            :keys="['folio', 'fechaEvento', 'cliente']"
                                                            class="form-control"
                                                        ></buscador-component>

                                                        <!-- Resultado Busqueda -->
                                                        <div class="row" v-if="presupuestosResults.length < presupuestos.length">
                                                            <div v-if="presupuestosResults.length !== 0" class="col-md-12 resultadoInventario">
                                                                <div v-for="presupuesto in presupuestosResults.slice(0,20)" :key="presupuesto.id">
                                                                    <div class="row contenedor-producto" v-on:click="obtenerPresupuesto(presupuesto)" style="margin:0">
                                                                        <div class="col-md-3">
                                                                            <img class="img-fluid" src="https://i.stack.imgur.com/l60Hf.png" alt="">
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <p style="padding:0; margin:0; line-height:14px; font-size:13px; "><span style="font-weight:bolder"> {{ presupuesto.cliente }}</span></p>
                                                                            <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ presupuesto.folio }}</p>
                                                                            <p style="padding:0; margin:0; line-height:14px; font-size:11px; ">{{ presupuesto.fechaEvento }}</p>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="background-color: rgba(240, 242, 245, 1); margin-top: 8px; padding: 5px;">
                                                            <p class="text-danger">{{ presupuestoSeleccionado.folio }}</p>
                                                            <h4 style="line-height: 2px;">{{ presupuestoSeleccionado.cliente }}</h4>
                                                        </div>

                                                        <!-- Fin resultado busqueda -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Metodo de pago</label>
                                                    <select name="" class="form-control" id="" v-model="movimiento.metodo">
                                                        <option value="EFECTIVO">Efectivo</option>
                                                        <option value="CHEQUE">Cheque</option>
                                                        <option value="TRANSFERENCIA">Transferencia</option>
                                                        <option value="TARJETA">Tarjeta</option>
                                                        <option value="DOLAR">Dolar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Monto</label>
                                                    
                                                    <currency-input class="form-control" v-model="movimiento.cantidad" currency="USD" locale="en"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input v-if="movimiento.metodo == 'DOLAR'" class="form-control" type="number" placeholder="Ingresa el tipo de cambio" v-model="movimiento.referencia">
                                                <input v-if="movimiento.metodo == 'TRANSFERENCIA'" class="form-control" type="number" placeholder="Ingresa los digitos de referencia" v-model="movimiento.referencia">
                                                <input v-if="movimiento.metodo == 'CHEQUE'" class="form-control" type="number" placeholder="Ingresa numero de cheque" v-model="movimiento.referencia">
                                                <input v-if="movimiento.metodo == 'TARJETA'" class="form-control" type="number" placeholder="Ingresa los ultimos 4 digitos de la tarjeta" v-model="movimiento.referencia">
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-md-12 mt-3" v-if="movimiento.metodo == 'TRANSFERENCIA' || movimiento.metodo == 'CHEQUE' || movimiento.metodo == 'TARJETA'">
                                                <input type="text" class="form-control" v-model="movimiento.banco" placeholder="Banco emisor">
                                            </div>
                                            <div class="col-md-12 mt-3" v-if="movimiento.metodo == 'TRANSFERENCIA'">
                                                <input type="date" class="form-control" v-model="movimiento.fechaTransferencia" placeholder="Fecha de la transferencia">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Comentarios</label>
                                                    <textarea class="form-control" v-model="movimiento.descripcion"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                                <button class="btn btn-sm btn-block btn-info" @click="registrarMovimiento()">Registrar movimiento</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="block col-md-12 caja-2" style="max-height:500px; overflow:scroll">
                                        <h5 style="padding-top:15px; text-align:center;">Ingresos / Egresos desde apertura de caja</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--tarjetas de ingresos y egresos-->
                                                <div class="registrosPagos" v-for="(item, index) in otrosPagos" :key="index">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 style="color:blue">{{ item.motivo }} {{ item.contrato }} - <span style="font-style:italic"></span> </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button style="position:absolute; right:10px" v-if="item.tipo=='EGRESO'" class="btn btn-sm btn-info" data-toggle="modal" data-target="#agregarCambio" @click="pagoEditado = item">Devolución</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p>
                                                            <span v-if="item.tipo=='EGRESO'" style="color:white; background:red; padding:3px; border-radius:7px; font-size:12px;">{{ item.tipo }}:</span>
                                                            <span v-if="item.tipo=='INGRESO'" style="color:white; background:green; padding:3px; border-radius:7px; font-size:12px;">{{ item.tipo }}:</span> 
                                                            <span style="margin-left:10px; font-weight:bold">{{ item.cantidad | currency}}</span>
                                                            <span v-if="item.resto>0" style="margin-left:15px;">Devolución: {{ item.resto | currency}}<br><br><br> Total egreso: <span style="font-weight:bold">{{item.cantidad-item.resto | currency}}</span></span>
                                                            -<span style="font-size:10px; font-style:italic">{{ item.metodo }} - {{ item.banco }}</span>
                                                            <span v-if="item.metodo!='EFECTIVO' && item.metodo!='DOLAR'" style="font-size:10px; font-style:italic"><br><br><br>Referencia: {{ item.referencia }} <span v-if="item.metodo=='TRANSFERENCIA'">Fecha de transferencia: {{ item.referencia }}</span></span>
                                                            <span v-if="item.metodo=='DOLAR'" style="font-size:10px; font-style:italic"><br><br><br>Tipo de cambio: {{ item.referencia | currency}}</span></p>
                                                            <span v-if="item.tipo=='EGRESO'">Entregado a: {{ item.responsable }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p style="line-height:16px"><strong>Notas: </strong><br><span style="font-style:italic">{{ item.descripcion }}</span></p>
                                                            <p style="font-style:italic; position:absolute; bottom:0; right:15px; padding-top:15px; margin-bottom:0; color:grey">{{ item.created_at | formatearHora }}</p>
                                                            <p style="position:absolute; z-index:2; bottom:-23px"><a target="_blank" :href="'/ticket-salida/' + item.id"><i class="fa fa-print"></i></a></p>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <!--tarjetas de ingresos y egresos-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agregar cambio -->
        <div class="modal fade" id="agregarCambio" tabindex="-1" role="dialog" aria-labelledby="agregarCambio" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Devolución / Cambio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="number" v-model="editarCambio" class="form-control" style="width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="editarPago()">Registrar cambio</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Cerrar caja -->
        <div class="modal fade" id="cerrarCaja" tabindex="-1" role="dialog" aria-labelledby="cerrarCaja" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Resumen de cierre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-md-12" v-if="pagosCorte.length != 0">

                            <div class="container d-flex" style="background:#FFFDC8; border-radius:7px; padding-top:16px">
                            <div class="col-md-3"><h4 class="text-danger">Pre-corte:{{ cantidadPreCorte[0] | currency }}</h4></div>        
                            <div class="col-md-2"><p style="font-size:15px; font-weight:bold" class="text-muted">Cheques:{{ cantidadPreCorte[1] | currency }}</p></div>   
                            <div class="col-md-2"><p style="font-size:15px; font-weight:bold" class="text-muted">Tarjeta:{{ cantidadPreCorte[4] | currency }}</p></div>  
                            <div class="col-md-3"><p style="font-size:15px; font-weight:bold" class="text-muted">Transferencias:{{ cantidadPreCorte[2] | currency }}</p></div>   
                            <div class="col-md-2"><p style="font-size:15px; font-weight:bold" class="text-muted">Dolar:{{ cantidadPreCorte[3] | currency }}</p></div>   
                            </div>
                            
                            
                        </div>
                    </div>
                    <div v-if="!controlDetalles" class="row">
                        <div class="col-md-4">
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Cierre de caja</h3>
                                    <div class="block-options">
                                        
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <img src="https://www.alaingarcia.net/conozca/i/billete_1000_pesos_holograma.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.billete1000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <img src="http://cdn.kaltura.com/p/0/thumbnail/entry_id/1_m98xxec5/quality/80/width/800/height/349" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.billete500">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <img src="http://eltrochilero.com/wp-content/uploads/2018/02/Billete200anverso.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.billete200">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <img src="https://www.cambiator.es/wp-content/uploads/Billete-de-100-pesos-mexicanos-100-MXN-reverso.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.billete100">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <img src="https://i.pinimg.com/originals/a4/07/21/a4072113bae69abe37ac3d547f6b60f9.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.billete50">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <img src="https://vanguardia.com.mx/sites/default/files/styles/paragraph_image_large_desktop_1x/public/mexico-20-pesos-benito-juarez-aztec-city-2012-p-image-88084-grande.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.billete20">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Cierre de caja</h3>
                                    <div class="block-options">
                                        
                                    </div>
                                </div>
                                <div class="block-content" style="padding-top:10px">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <img src="https://i.colnect.net/f/3336/608/10-Pesos.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.moneda10">
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content" style="padding-top:10px">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <img src="https://i.colnect.net/f/3336/603/5-Nuevos-Pesos.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.moneda5">
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content" style="padding-top:10px">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <img src="https://i.colnect.net/f/3782/629/2-Pesos.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.moneda2">
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content" style="padding-top:10px">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <img src="https://i.colnect.net/f/3444/383/1-Peso.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.moneda1">
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content" style="padding-top:10px">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <img src="https://i.colnect.net/f/3019/209/50-Centavos.jpg" alt="" width="100%">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <i class="fa fa-arrow-right"></i>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" class="form-control" v-model="cantidad.centavo50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Cierre de caja</h3>
                                    <div class="block-options">
                                        
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="form-group">
                                        <label for="">Suma total de efectivo en caja</label>
                                        <currency-input class="form-control" v-model="sumarCantidad" currency="USD" locale="en"/>
                                        <label style="color:green"  v-if="pagosCorte.length != 0 && cantidadPreCorte[0]==sumarCantidad" for="">La cantidad es correcta</label>
                                        <label style="color:red" v-if="pagosCorte.length != 0 && cantidadPreCorte[0]<sumarCantidad" for="">Tienes un excedente de {{ sumarCantidad - cantidadPreCorte[0] | currency}}</label>
                                        <label style="color:red"  v-if="pagosCorte.length != 0 && cantidadPreCorte[0]>sumarCantidad" for="">Tienes un faltante de {{ cantidadPreCorte[0] - sumarCantidad | currency}}</label>
                                    </div>
                                    <div class="form-group">
                                        
                                        <button class="btn btn-sm btn-block btn-info" @click="confirmarCerrarCaja()">Cerrar Caja</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-info btn-block" @click="obtenerDetalles()">Ver detalles</button>
                                </div>
                                <div class="col-md-12" style="padding-top:10px">
                                    <a target="_blank" :href="'precorte/pdf/'+ sesionActual.id" class="btn btn-sm btn-info btn-block">Imprimir Precorte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-sm btn-info" @click="controlDetalles = false">Ver vista corte</button>
                        </div>
                        <div class="col-md-12">
                            <h2>Ingresos</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                       <th scope="col">Fecha</th>
                                       <th scope="col">Contrato</th>
                                        <th scope="col">Banco</th>
                                        <th scope="col">Metodo</th>
                                        <th scope="col">Referencia</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in pagosTotalesActuales[0]" :key="index">
                                        <td>{{ item.created_at }}</td>
                                        <td>{{ item.folio }}<br><span style="font-style:italic; font-size:12px;">{{ item.cliente }}</span></td>
                                        <td>
                                            <span v-if="item.banco">{{ item.banco }}</span>
                                            <span v-else>--</span>
                                        </td>
                                        <td>{{ item.metodo }}</td>
                                        <td>
                                            <span v-if="item.referencia">{{ item.referencia }}</span>
                                            <span v-else>--</span>
                                        </td>
                                        <td>{{ item.cantidad | currency }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-12 text-right">
                               
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h2>Egresos</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                       <th scope="col">Fecha</th>
                                       <th scope="col">Contrato</th>
                                        <th scope="col">Banco</th>
                                        <th scope="col">Metodo</th>
                                        <th scope="col">Referencia</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in pagosTotalesActuales[1]" :key="index">
                                        <td>{{ item.created_at }}</td>
                                     <td>{{ item.contrato }}</td>
                                        <td>
                                            <span v-if="item.banco">{{ item.banco }}</span>
                                            <span v-else>--</span>
                                        </td>
                                        <td>{{ item.metodo }}</td>
                                        <td>
                                            <span v-if="item.referencia">{{ item.referencia }}</span>
                                            <span v-else>--</span>
                                        </td>
                                        <td>{{ item.cantidad | currency }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-12 text-right">
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Agregar categoria -->
        <div class="modal fade" id="nuevaCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar nueva categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" v-model="nuevaCategoria">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in categorias" :key="index">
                                <th scope="row">{{ item.id }}</th>
                                <td>{{ item.nombre }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" @click="eliminarCategoria(item.id)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="guardarCategoria()">Guardar</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Administrar responsables -->
        <div class="modal fade" id="administrarResponsables" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Administrar Responsable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" v-model="nuevoResponsable">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in responsables" :key="index">
                                <th scope="row">{{ item.id }}</th>
                                <td>{{ item.nombre }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" @click="eliminarResponsable(item.id)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="guardarResponsable()">Guardar</button>
                </div>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
let user = document.head.querySelector('meta[name="user"]');

import BuscadorComponent from './BuscadorComponent.vue';

export default {
    components: {
        BuscadorComponent,
    },
    data(){
        return{
            controlDetalles: false,
            mostrarAbrirCaja: true,
            cajaAbiertaPorOtroUsuario:true,
            sesion: '',
            sesionActual: '',
            presupuestos: [],
            clientes: [],
            presupuestosResults: [],
            limpiar: false,
            totalEtiqueta: 0,
            totalBuscador: 0,
            nuevaCategoria: '',
            chequesApertura:0,
            dolaresApertura:0,
            responsables:[],
            nuevoResponsable:'',
            liquidar:false,
            categorias: [],
            cantidad: {
                billete1000: 0,
                billete500: 0,
                billete200: 0,
                billete100: 0,
                billete50: 0,
                billete20: 0,
                moneda10: 0,
                moneda5: 0,
                moneda2: 0,
                moneda1: 0,
                centavo50: 0,
            },
            movimiento: {
                tipo: '',
                cantidad: '',
                motivo: '',
                descripcion: '',
                metodo: '',
                referencia: '',
                responsable: '',
                banco: '',
                contrato: '',
                fechaTransferencia: '',
            },
            cantidadApertura: null,
            cantidadRealApertura: null,

            cantidadCierre: null,
            cantidadRealCierre: null,

            presupuestoSeleccionado: '',
            pago: {
                budget_id: '',
                method: '',
                amount: '',
                reference: '',
                bank: '',
                folio:'',
                cliente:'',
                comentarios:'',
            },
            otrosPagos: [],
            ultimoPago:'',
            pagoEditado: '',
            editarCambio: 0,
            pagosCorte: '',
            pagosPasados: [],
            pagosTotalesActuales: [],
            arrayDatos: [],
            proveedores: '',
        }
    },
    created(){
        this.obtenerSesion();
        this.obtenerPresupuestos();
        this.obtenerCategorias();
        this.obtenerPagosPasados();
        this.obtenerResponsable();
        this.obtenerProveedores();

        //Buscadores
        this.$on('presupuestosResults', presupuestosResults => {
            this.presupuestosResults = presupuestosResults
        });
    },
    computed: {
        sumaIngresosActuales: function(){
            let suma = 0;
            let suma2 = 0;

            let datos = [];
            this.pagosTotalesActuales[0].forEach((element) => {
                suma = suma + parseFloat(element.cantidad);
            })

            this.pagosTotalesActuales[1].forEach((element) => {
                suma2 = suma2 + parseFloat(element.cantidad);
            })

            datos.push(suma, suma2);
            return datos;
        },
        sumaPagosPasados: function(){
            let pagos = [];
            let cheques = 0;
            let transferencias = 0;
            let dolar = 0;
            let suma = 0;

            if(this.pagosPasados.length != 0){
                this.pagosPasados[0].forEach((element) => {
                    if(element.method == 'CHEQUE'){
                        cheques = cheques + parseFloat(element.amount);
                    }else if(element.method == 'TRANSFERENCIA' || element.method == 'TARJETA'){
                        transferencias = transferencias + parseFloat(element.amount);
                    }else{
                        if(element.method == 'DOLAR'){
                            dolar = dolar + (parseFloat(element.cantidad));
                        }else{
                            suma = suma + parseFloat(element.amount);
                        }
                    }
                });

                this.pagosPasados[1].forEach((element) => {
if(element.tipo == 'INGRESO'){
                    switch(element.metodo){
                        case 'TRANSFERENCIA':
                            transferencias = transferencias + parseFloat(element.cantidad);
                            alert
                            break;
                        case 'TARJETA':
                            transferencias = transferencias + parseFloat(element.cantidad);
                            break;
                        case 'CHEQUE':
                            cheques = cheques + parseFloat(element.cantidad);
                            break;
                        case 'EFECTIVO':
                             suma = suma + parseFloat(element.cantidad);
                            break;
                        case 'DOLAR':
                             dolar = dolar + (parseFloat(element.cantidad));
                            break;  
                    }
}else{
    
                    switch(element.metodo){
                        case 'TRANSFERENCIA':
                            transferencias = transferencias - parseFloat(element.cantidad);
                            suma = suma + parseFloat(element.resto);
                            break;
                        case 'TARJETA':
                            transferencias = transferencias - parseFloat(element.cantidad);
                            suma = suma + parseFloat(element.resto);
                            break;
                        case 'CHEQUE':
                            cheques = cheques - parseFloat(element.cantidad);
                            suma = suma + parseFloat(element.resto);
                            break;
                        case 'EFECTIVO':
                             suma -= parseFloat(element.cantidad);
                             suma = suma + parseFloat(element.resto);
                            break;
                        case 'DOLAR':
                             dolar = dolar - (parseFloat(element.cantidad));
                             dolar = dolar + parseFloat(element.resto);
                            break;  
                    }

}

                });

                pagos.push(cheques, transferencias, dolar);
                return pagos;
            }
        },

        cantidadPreCorte: function(){
            if(this.pagosCorte.length != 0){
                let arrayDeDatos = [];
                let suma = 0;
                let cheques = 0;
                let dolar = 0;
                let transferencias = 0;
                let Ptarjeta = 0;


                this.pagosCorte[0].forEach((element) => {
                    if(element.method == 'CHEQUE'){
                        cheques = cheques + parseFloat(element.amount) + this.chequesApertura;
                    }else if(element.method == 'TRANSFERENCIA'){
                        transferencias = transferencias + parseFloat(element.amount);
                    }else if(element.method == 'TARJETA'){
                        Ptarjeta = Ptarjeta + parseFloat(element.amount);
                    }else{
                        if(element.method == 'DOLAR'){
                           dolar = dolar + (parseFloat(element.amount)+this.dolaresApertura);
                        }else{
                            suma = suma + parseFloat(element.amount);
                        }
                    }
                });

                suma = suma +  parseFloat(this.sesionActual.cantidadApertura);
               

                this.pagosCorte[1].forEach((element) => {
if(element.tipo == 'INGRESO'){
                    switch(element.metodo){
                        case 'TRANSFERENCIA':
                            transferencias = transferencias + parseFloat(element.cantidad);
                            alert
                            break;
                        case 'TARJETA':
                            Ptarjeta = Ptarjeta + parseFloat(element.cantidad);
                            break;
                        case 'CHEQUE':
                            cheques = cheques + parseFloat(element.cantidad);
                            break;
                        case 'EFECTIVO':
                             suma = suma + parseFloat(element.cantidad);
                            break;
                        case 'DOLAR':
                             dolar = dolar + (parseFloat(element.cantidad));
                            break;  
                    }
}else{
    
                    switch(element.metodo){
                        case 'TRANSFERENCIA':
                            transferencias = transferencias - parseFloat(element.cantidad);
                            suma = suma + parseFloat(element.resto);
                            break;
                        case 'TARJETA':
                            Ptarjeta = Ptarjeta - parseFloat(element.cantidad);
                            suma = suma + parseFloat(element.resto);
                            break;
                        case 'CHEQUE':
                            cheques = cheques - parseFloat(element.cantidad);
                            suma = suma + parseFloat(element.resto);
                            break;
                        case 'EFECTIVO':
                             suma -= parseFloat(element.cantidad);
                             suma = suma + parseFloat(element.resto);
                            break;
                        case 'DOLAR':
                             dolar = dolar - (parseFloat(element.cantidad));
                             dolar = dolar + parseFloat(element.resto);
                            break;  
                    }

}

                });
                
                arrayDeDatos.push(suma, cheques, transferencias, dolar, Ptarjeta);
                return arrayDeDatos;
            }
        },
        updateChequesApertura: function(){
this.sumaPagosPasados[0]=this.chequesApertura;


        },

        updateDolaresApertura: function(){
this.sumaPagosPasados[2]=this.dolaresApertura;


        },

        sumarCantidad: function(){
            let billete = (parseInt(this.cantidad.billete1000) * 1000) + (parseInt(this.cantidad.billete500) * 500) + (parseInt(this.cantidad.billete200) * 200) + (parseInt(this.cantidad.billete100) * 100) + (parseInt(this.cantidad.billete50) * 50) + (parseInt(this.cantidad.billete20) * 20);
            let monedas = (parseInt(this.cantidad.moneda10) * 10) + (parseInt(this.cantidad.moneda5) * 5) + (parseInt(this.cantidad.moneda2) * 2) + (parseInt(this.cantidad.moneda1) * 1) + (parseInt(this.cantidad.centavo50) * 0.50);
            let suma = billete + monedas;
            return suma;
        },

        usuario: function(){
            return JSON.parse(user.content);
        },

        totalAbonado: function(){
            if(this.presupuestoSeleccionado.length != 0){
                let suma = 0;
                this.presupuestoSeleccionado.payments.forEach((element) => {
                    if(element.method != 'DOLAR'){
                        suma += parseFloat(element.amount);
                    }else{
                        suma += (element.amount * element.reference);
                    }
                    
                })

                return suma;
            }
        },
    },
    directives: {
        focus: {
            inserted: function (el) {
                el.focus()
            }
        }
    },
    filters: {
        formatearFecha: function(val){
            moment.locale('es');
            let fecha = moment(val).format('dddd D MMMM YYYY');
            return fecha;
        },

        formatearHora: function(val){
            moment.locale('es');
            let hora = moment(val).format('h:mm a');
            return hora;
        },

        formatearHora2: function(val){
            moment.locale('es');
            //let hora = moment(val).format('h:mm a');
            let hora = moment(val).format('LT');
            return hora;
        },

        truncarDecimales: function (x, posiciones = 2) {
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
    methods: {
        async obtenerProveedores(){
            try {
                let URL = '/obtener-proveedores'

                const response = await axios.get(URL)
                this.proveedores = response.data
            } catch (e) {
                console.log(e.data)
            }
        },

        cancelarContrato: function(){
            let URL = '/cancelar-contrato/' + this.presupuestoSeleccionado.id

            axios.get(URL).then((response) => {
                alert('Contrato cancelado')
                this.obtenerPresupuestos()

            }).catch((error) => {
                console.log(error.data)
            })
        },

        obtenerDetalles: function(){
            this.controlDetalles = true;

            let URL = 'obtener-detalles';
            
            axios.get(URL).then((response) => {
                let pagos = [];
                let otrosPagos = [];
                this.pagosTotalesActuales = response.data;

                this.pagosTotalesActuales[0].forEach((element) => {
                    let pago = {
                        created_at: element.created_at,
                        cantidad: element.amount,
                        metodo: element.method,
                        referencia: element.reference,
                        contrato: element.budget_id,
                        banco: element.bank,
                        cliente: element.cliente,
                        folio: element.folio,

                    }
                    let pago2 = JSON.parse(JSON.stringify(pago));
                    pagos.push(pago2);
                })

                this.pagosTotalesActuales[1].forEach((element) => {
                    if(element.tipo == 'INGRESO'){
                        let pago = {
                            created_at: element.created_at,
                            cantidad: element.cantidad,
                            metodo: element.metodo,
                            referencia: element.referencia,
                            banco: element.banco,
                             contrato: element.contrato,
                            responsable: element.responsable,
                            contrato: element.contrato
                        }

                        let pago2 = JSON.parse(JSON.stringify(pago));
                        pagos.push(pago2);
                    }else{
                        let pago = {
                            created_at: element.created_at,
                            cantidad: element.cantidad -element.resto,
                            metodo: element.metodo,
                            referencia: element.referencia,
                            banco: element.banco,
                            responsable: element.responsable,
                            contrato: element.contrato
                        }

                        let pago2 = JSON.parse(JSON.stringify(pago));
                        otrosPagos.push(pago2);
                    }
                })

                this.pagosTotalesActuales[0] = pagos;
                this.pagosTotalesActuales[1] = otrosPagos;
            })
        },

    liquidarBtn: function(){
           if(this.liquidar==true){
 this.pago.amount = 0;
           }else{
               this.pago.amount = this.totalEtiqueta - this.totalAbonado;
           }
        },
        obtenerCorte: function(){
            let URL = 'caja/corte';

            axios.get(URL).then((response) => {
                this.pagosCorte = response.data;
            })

            this.obtenerDetalles();

            this.controlDetalles = false;
        },

        obtenerOtrosPagos: function(){
            let URL = 'pagos';

            axios.get(URL).then((response) => {
                this.otrosPagos = response.data; 
            })
        },

        obtenerPagosPasados: function(){
            let URL = 'obtener-pagos-pasados';

            axios.get(URL).then((response) => {
                this.pagosPasados = response.data;
                this.filtrarPagosPasados();
            })
        },

        filtrarPagosPasados: function(){
            let cheques = 0;
            let dolares = 0;

            if(this.pagosPasados.length != 0){
                this.pagosPasados[0].forEach((element) => {
                    if(element.method == 'CHEQUE'){
                        cheques = cheques + parseFloat(element.amount);
                    }else if(element.method == 'DOLAR'){
                        dolares = dolares + parseFloat(element.amount);
                    }
                })

                this.pagosPasados[1].forEach((element) => {
                    if(element.metodo == 'CHEQUE'){
                        cheques = cheques + parseFloat(element.cantidad);
                    }else if(element.metodo == 'DOLAR'){
                        dolares = dolares + parseFloat(element.cantidad);
                    }
                })
            }

            this.arrayDatos = [cheques, dolares];
        },

        obtenerCategorias: function(){
            let URL = 'categorias-pagos';

            axios.get(URL).then((response) => {
                this.categorias = response.data;
            })
        },

        guardarCategoria: function(){
            let URL = 'categorias-pagos';

            axios.post(URL, {nombre: this.nuevaCategoria}).then((response) => {
                this.obtenerCategorias();
            })
        },

        eliminarCategoria: function(id){
            let URL = 'categorias-pagos/' + id;

            axios.delete(URL).then((response) => {
                this.obtenerCategorias();
            })
        },

        obtenerResponsable: function(){
            let URL = 'responsable-pagos';

            axios.get(URL).then((response) => {
                this.responsables = response.data;
            })
        },

        guardarResponsable: function(){
            let URL = 'responsable-pagos';

            axios.post(URL, {nombre: this.nuevoResponsable}).then((response) => {
                this.obtenerResponsable();
            })
        },

        eliminarResponsable: function(id){
            let URL = 'responsable-pagos/' + id;

            axios.delete(URL).then((response) => {
                this.obtenerResponsable();
            })
        },

        obtenerSesionActual: function(){
            let URL = 'obtener-sesion-actual';

            axios.get(URL).then((response) => {
                this.sesionActual = response.data[0];
                this.sesion = response.data[1];
            })
        },

        registrarMovimiento: function(){
            let URL = 'pagos';
                
            axios.post(URL, this.movimiento).then((response) => {
                this.movimiento.tipo = '';
                this.movimiento.motivo ='';
                this.movimiento.referencia ='';
                this.movimiento.cantidad ='';
                this.movimiento.metodo ='';
                this.movimiento.descripcion ='';
                this.movimiento.fechaTransferencia ='';
                this.movimiento.contrato ='';
                Swal.fire(
                    'Movimiento registrado!',
                    'El movimiento se registro con exito',
                    'success'
                )
                this.movimiento.responsable='';
                this.obtenerOtrosPagos();
            })
        },

        editarPago: function(){
            let URL = 'pagos/' + this.pagoEditado.id;
            
            Object.defineProperty(this.pagoEditado, 'resto', {
                value: this.editarCambio,
                enumerable: true,
                configurable: true,
                writable: true,
            })
            axios.put(URL, this.pagoEditado).then((response) => {
                Swal.fire(
                    'Cambio registrado!',
                    'Se a registrado una devolución al egreso correctamente',
                    'success'
                )
                this.obtenerOtrosPagos();
            })
        },

        obtenerSesion: function(){
            let URL = 'obtener-sesion-caja';

            axios.get(URL).then((response) => {
                this.sesion = response.data;

                this.cantidad.billete1000 = this.sesion.cierreBillete1000;
                this.cantidad.billete500 = this.sesion.cierreBillete500;
                this.cantidad.billete200 = this.sesion.cierreBillete200;
                this.cantidad.billete100 = this.sesion.cierreBillete100;
                this.cantidad.billete50 = this.sesion.cierreBillete50;
                this.cantidad.billete20 = this.sesion.cierreBillete20;

                this.cantidad.moneda10 = this.sesion.cierreMoneda10;
                this.cantidad.moneda5 = this.sesion.cierreMoneda5;
                this.cantidad.moneda2 = this.sesion.cierreMoneda2;
                this.cantidad.moneda1 = this.sesion.cierreMoneda1;
                this.cantidad.centavo50 = this.sesion.cierreCentavo50;

                this.habilitarCaja();
                
            })
        },

        obtenerClientes: function(){
            let URL = 'obtener-clientes';

            axios.get(URL).then((response) => {
                this.clientes = response .data;
                 
                 //Asignamos una nueva propiedad a los presupuestos con su respectivo cliente
                 this.presupuestos.forEach((element) => {
                     this.clientes.forEach((item) => {
                         if(item.id == element.client_id){
                            if(item.hasOwnProperty('apellidoPaterno')){
                                Object.defineProperty(element, 'cliente', {
                                    value: item.nombre + ' ' + item.apellidoPaterno + ' ' + item.apellidoMaterno,
                                    writable: true,
                                    enumerable: true,
                                    configurable: true
                                });
                            }else{
                                Object.defineProperty(element, 'cliente', {
                                    value: item.nombre,
                                    writable: true,
                                    enumerable: true,
                                    configurable: true
                                });
                            }
                         }
                     })
                 })

                if(this.presupuestoSeleccionado.length != 0){
                    let presupuesto = this.presupuestos.find((element) => {
                        return element.id == this.presupuestoSeleccionado.id
                    })

                    this.presupuestoSeleccionado = presupuesto;
                    if(this.presupuestoSeleccionado.opcionIVA){
                this.totalEtiqueta=0;
                this.totalBuscador=0;
                this.totalEtiqueta = this.presupuestoSeleccionado.total*1.16;
                this.totalBuscador = presupuesto.total*1.16;
                
            }else{
                this.totalEtiqueta = this.presupuestoSeleccionado.total;
                this.totalBuscador = presupuesto.total;
            }
                }
            })
        },

        obtenerPresupuestos: function(){
            let URL = 'caja/obtener-presupuestos';

            axios.get(URL).then((response) => {
                this.presupuestos = response.data;

                if(this.presupuestoSeleccionado.length != 0){
                    let presupuesto = this.presupuestos.find((element) => {
                        return element.id = this.presupuestoSeleccionado
                    })

                    this.presupuestoSeleccionado.cancelado = presupuesto.cancelado
                    this.presupuestoSeleccionado.fechaCancelacion = presupuesto.fechaCancelacion
                }
                this.obtenerClientes();
            }).catch((error) => {
                console.log(error.data);
            })
        },

        obtenerUltimoPago: function(){
            let URL = 'caja/obtener-ultimopago';

            axios.get(URL).then((response) => {
                
                this.ultimoPago = response.data;
                
                //window.open("https://www.mmdec.herokuapp.com/recibo-pago/pdf/"+this.ultimoPago.id, "Recibo de pago", "width=300, height=200");
                var myParameters = window.location.search;// Get the parameters from the current page

                var URL = "https://mmdec.herokuapp.com/recibo-pago/pdf/"+this.ultimoPago.id+myParameters;

                var W = window.open(URL);

                W.window.print(); 

            }).catch((error) => {
                console.log(error.data);
            })
        },

        habilitarCaja: function(){
            if(this.sesion.estatus && (this.sesion.user_id == this.usuario.id)){
                this.obtenerSesionActual()
                this.mostrarAbrirCaja = false;
                this.obtenerOtrosPagos();
            }else{
                if(this.sesion.estatus && (this.sesion.user_id == this.usuario.id)){
                this.mostrarAbrirCaja = true;
                this.cajaAbiertaPorOtroUsuario=true;}else{
                 this.mostrarAbrirCaja = true
                 this.cajaAbiertaPorOtroUsuario=false; 
                }
            }
        },

        obtenerPresupuesto: function(presupuesto){
            this.limpiar = true;
            this.presupuestoSeleccionado = presupuesto;
            this.movimiento.contrato = presupuesto.folio + ' - ' +presupuesto.cliente;
           
            if(this.presupuestoSeleccionado.opcionIVA==1){
                this.totalEtiqueta=0;
                this.totalEtiqueta = this.presupuestoSeleccionado.total*1.16;
                
             
            }else{
                this.totalEtiqueta = this.presupuestoSeleccionado.total;
                
            }

            setTimeout(() => {
                this.limpiar = false;
            }, 1000);
        },

        abrirCaja: function(){
            let URL = 'caja';
            let diferencia = 0;
            if(this.sesion.cantidadCierre != this.sumarCantidad){
                diferencia = this.sumarCantidad - this.sesion.cantidadCierre;
            }

            axios.post(URL, {
                cantidadRealApertura: diferencia,
                cantidadApertura: this.sumarCantidad,
                billetes: this.cantidad,
                arrayDatos: this.arrayDatos,
            }).then((response) => {
                let timerInterval
                Swal.fire({
                title: 'Abriendo caja',
                html: 'Espere un momento porfavor...',
                timer: 2000,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                    Swal.getContent().querySelector('strong')
                        .textContent = Swal.getTimerLeft()
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval);
                    this.obtenerSesionActual();
                    this.mostrarAbrirCaja = false;
                }
                }).then((result) => {
                if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.timer
                ) {
                    console.log('I was closed by the timer')
                }
                })
            })
        },

        confirmarCerrarCaja: function(){
            Swal.fire({
                title: 'Estas a punto de cerrar caja',
                text: "¿Estas seguro de esto?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cerrar caja'
                }).then((result) => {
                    if (result.value) {
                        this.cerrarCaja();
                        //alert('abriendoPDF');
                
                
                    }
            })
        },

        cerrarCaja: function(){
            let URL = 'caja/' + this.sesionActual.id;
            let diferencia = 0;

            if(this.sumarCantidad != this.cantidadPreCorte){
                diferencia = this.sumarCantidad - this.cantidadPreCorte;
            }

            axios.put(URL, {
                cantidadRealCierre: diferencia,
                cantidadCierre: this.sumarCantidad,
                billetes: this.cantidad,
            }).then((response) => {
                Swal.fire(
                    'Cerrada!',
                    'Caja ha sido cerrada',
                    'success'
                )
                this.enviarEmail();
                this.mostrarAbrirCaja = true;
                this.cajaAbiertaPorOtroUsuario= true;
                $('#cerrarCaja').modal('hide');
                
                var URL = "/ultimo-corte/pdf/";
                var W = window.open(URL);
                W.window.print(); 
            })
        },

        registrarPago(){
            let URL = '/registrar-pago';
            let numero = this.totalEtiqueta - this.totalAbonado;
            
            if(this.pago.amount<=0){
                alert('Ingresa un monto mayor a 0');
                return
            }
            if(this.presupuestoSeleccionado==''){
                alert('Selecciona un contrato');
            }else{
            if(this.pago.method==''){
                alert('Selecciona un metodo de pago');
            }else{
            
            this.pago.budget_id = this.presupuestoSeleccionado.id;
            axios.post(URL, this.pago).then((response) => {
                

                if(parseFloat(this.pago.amount).toFixed(2) == (numero.toFixed(2))){
                    let URL = 'pagar-contrato/' + this.presupuestoSeleccionado.id;
                    
                    axios.get(URL).then((response) => {
                        alert('Contrato pagado en su totalidad');
                        location.reload();
                    })
                }
                this.pago.amount='';
                this.pago.reference='';
                this.pago.bank='';
                this.pago.comentarios='';
                
                this.obtenerPagosPasados()
                this.obtenerPresupuestos();
                this.obtenerUltimoPago();
                alert('Pago registrado');
                
            }).catch((error) => {
                console.log(error.data)
            })
                        
                    }
                }
        },

        enviarEmail: function(){
            let URL = 'caja/enviar-email';

            axios.get(URL).then((response) => {
                console.log('email enviado');
            })
        },

        imprimirPDF: function(){
            let URL = 'caja/imprimir-pdf';

            axios.get(URL).then((response) => {
                alert('Corte impreso');
            })
        }
    },
}

</script>