<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@if($presupuesto->tipo=='PRESUPUESTO') Presupuesto @else Contrato @endif</title>
</head>
<body style="font-family: Helvetica; ">
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px">
  <tr>
    @if($presupuesto->tipoEvento == 'Externo' && $presupuesto->tipoServicio == 'Formal')
    <td style="padding-right:100px;">
        <img src="http://adpro3d-os.com/megamundo/mega-mundo-decor.png" style="width:200px">
    </td>
    @else
    <td style="padding-right:100px;">
        <img src="http://megamundodecor.com/images/mega-mundo.png" style="width:180px">
    </td>
    @endif
   
    <td colspan="3" style="text-align: right">
      <p><span style="font-weight: bolder; font-size:24px">@if($presupuesto->tipo=='PRESUPUESTO') Presupuesto @else Contrato @endif</span></p>
      <p><span style="font-weight: bolder">Folio:</span>  <span style="font-weight:normal">{{$presupuesto->folio}}</span></p>
      <p><span style="font-weight: bolder">Vendedor:</span> <span style="font-weight:normal">{{$presupuesto->vendedor}}</span></p>
      <p><span style="font-weight: bolder">Categoria:</span> <span style="font-weight:normal">{{$presupuesto->categoriaEvento}}</span></p>
      </td>
  </tr>
  <tr>
      <td style="text-align: left; font-style: italic; font-size:13px">Versión de @if($presupuesto->tipo=='PRESUPUESTO') presupuesto @else contrato @endif {{$presupuesto->version}} de {{$presupuesto->version  }}<br><span style="font-style: italic">Fecha de creación: </span> {{$presupuesto->created_at}} </td>
  </tr>
  <tr style="text-align: right; font-size:13px">
    <td colspan="2" style="text-align: right">
      
    </td>
    <td colspan="2"><p style="margin-top:-20px">Email: Ventas@megamundo.com.mx<br>Teléfono: (614) 423-41-34<p></td>
  </tr>
</table>
<!--INFORMACION DE CLIENTE-->
@if($presupuesto->archivado==true)
<div style="width: 100%; background:#FCD4D4; padding:10px; border-radius:10px">
<p style="font-weight:bold">Contrato Cancelado por: IVONNE ARROYOS</p>
<p>{{$presupuesto->notasPresupuesto}}<p>
</div>
@endif
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
<tr>
<td colspan="3"><p style="line-height: 14px;"> <span style="font-weight: bold">{{$presupuesto->cliente}}</span>
  <br><br><span>{{$presupuesto->emailCliente}}</span>
  
<br><br><span>Teléfonos: 
  @foreach($Telefonos as $telefono)
    @php
      $lada=substr($telefono->numero, 0,3);
      $primerosnumero=substr($telefono->numero, 3,3);
      $segundos=substr($telefono->numero, 6,2);
      $terceros=substr($telefono->numero, 8,2);
    @endphp
  {{'('.$lada.')'.$primerosnumero.'-'.$segundos.'-'.$terceros}}, @endforeach</span></p>
  <span style="font-style:normal">Cuente bancaria para FACTURACIÓN:<BR>
    AFIRME: 176109351<BR>
  TRANSFERENCIA: 062150001761093515</span>
</td>
<td>
  @php
  
      $fechadepago = date('Y-m-d',strtotime($presupuesto->fechaEvento."+ ".$presupuesto->diasCredito." days"));
  @endphp
<p style="border:solid; border-color:red; border-width: 1px; text-align: center; padding: 10px; font-size: 13px;">@if($presupuesto->creditoCliente!='SIN CREDITO')CREDITO @endif{{$presupuesto->creditoCliente}}<br>
@if($presupuesto->creditoCliente!='SIN CREDITO')
Dias de credito: {{$presupuesto->diasCredito}}  <br>
  Fecha limite de pago:<br>
{{$fechadepago }}
@endif
</p>

</td>
</tr>
</table>
<!--INFORMACION DEL EVENTO-->
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
<tr>
    <td colspan="4"><H3 style="line-height: 15px; font-size: 18px">INFORMACIÓN DEL EVENTO</H3></td>
  </tr>
<tr style="font-weight: bold; font-size: 14px;">
<td colspan="2"><span>Fecha y Hora: </span></td>
<td><span>Categoria y Tipo de Evento:</span></td>
<td colspan="1">Invitados: <span style="font-weight: normal">{{$presupuesto->numeroInvitados}}</span></td>
</tr>
<tr style=" font-size: 14px;">
    @php                        
    use Carbon\Carbon;    
    $fechaEvento = Carbon::parse($presupuesto->fechaEvento)->locale('es');
    $horaI = strtotime($presupuesto->horaEventoInicio);
    $horaI = date("g:i", $horaI);

    $horaF = strtotime($presupuesto->horaEventoFin);
    $horaF = date("g:i", $horaF);
    
   
@endphp

<td colspan="2">{{$fechaEvento->translatedFormat(' l j F Y')}} <br>@if($presupuesto->pendienteHora==0){{$horaI}}{{$presupuesto->inicioAmPm}} - {{$horaF}}{{$presupuesto->finAmPm}}@else Pendiente @endif<br><span style="font-weight: bold">Requiere Montaje:</span> <span>{{$presupuesto->requiereMontaje}}</span></td>
  <td><span> {{$presupuesto->categoria}}, {{$presupuesto->tipoEvento}} {{$presupuesto->tipoServicio}}</span></td>
  <td><span style="font-weight: bold">Tono:</span> {{$presupuesto->colorEvento}}</td>
</tr>
<tr style=" font-size: 14px;">
<td colspan="3"></td>
<td><span style="font-weight: bold">Tema:</span> {{$presupuesto->temaEvento}}<br></td>
</tr>

<tr style=" font-size: 14px;">
  <td colspan="4"><span style="font-weight: bold">Lugar: </span>
  @if($presupuesto->lugarEvento=='BODEGA')
  Recolección en Bodega, Periferico de la Juventud #7501 Segundo Piso <span style="font-style:italic">Subiendo al hotel sheraton</span>
  En un horario de 9:30 Am a 5:30 Pm. La devolución de la mercancia, es al siguiente dia habil, antes de las 12:00 Pm en la misma dirección, en caso omiso se cobrara un día mas de renta.
  @endif
</td>
</tr>
<tr style=" font-size: 14px;"><td colspan="4">{{$presupuesto->direccionLugar}} {{$presupuesto->numeroLugar}} {{$presupuesto->coloniaLugar}}<br><span style="font-style: italic">Notas: {{$presupuesto->observacionesLugar}}</span>
</td>
</tr>
</table>
<table style="width: 100%; margin-top: 10px">
  <tr style="padding: 4px; color:white; background:#9E9E9E; text-align: center;">
    @if($presupuesto->opcionImagen==1)  
    <td style="font-size: 13px; padding: 4px;">Imagen</td>
    @endif
    <td style="font-size: 13px; padding: 4px;">Servicio</td>
    <td style="font-size: 13px; padding: 4px;">Cantidad</td>
    @if($presupuesto->opcionPrecioUnitario==1) 
    <td style="font-size: 13px; padding: 4px;">Precio Unitario</td>
    @endif
    @if($presupuesto->opcionPrecio==1)
    <td style="font-size: 13px; padding: 4px;">Precio Especial</td>
    <td style="font-size: 13px; padding: 4px;">Total Con Descuento</td>
    @endif
    <td style="font-size: 13px; padding: 4px;">Notas</td>
  </tr>
  @php
      $descuento=0;
      $familias=[];
      $c=0;
  @endphp
  @foreach ($Elementos as $elemento)
  @php
      $descuento=$descuento+($elemento->precioUnitario-$elemento->precioEspecial);
      $c++;
      $familias[$c]=$elemento->familia;
  @endphp
    <tr style="margin-top: 2px; background: #F3F3F3; font-size:13px">
        @if($presupuesto->opcionImagen==1)  
    <td><img src="{{$elemento->imagen}}" width="60px" alt=""></td>
        @endif
    <td style="padding: 5px;">{{ (strtolower($elemento->servicio)) }}<br>{{$elemento->familia}}</td>
      <td style="text-align: center">{{ (strtolower($elemento->cantidad)) }}</td>
      @if($presupuesto->opcionPrecioUnitario==1)  
      <td style="text-align: center">${{ (strtolower($elemento->precioUnitario)) }}</td>
      @endif
      @if($presupuesto->opcionPrecioUnitario==1)
      <td style="text-align: center">@if($elemento->precioUnitario!=$elemento->precioEspecial)${{ (strtolower($elemento->precioEspecial)) }}@else -- @endif</td>
      <td style="text-align: center">${{ (strtolower($elemento->precioFinal)) }}</td>
      @endif
    <td style="padding: 5px;">{{ (strtolower($elemento->notas)) }}</td>
    </tr>
@endforeach
 


</table>


<!--///////////////////////////////////////////prueba paquetes -->
@if(!is_null($Paquetes))
<h2>Paquetes: </h2>
@foreach ($Paquetes as $paquete)
<table style="width: 100%;">
  <tr>
<th>Servicio</th>
<th>Cantidad</th>

</tr>
<tr style="background:#FFF9C8 ">
  <td style="font-weight: bold">{{ (strtolower($paquete->servicio)) }}</td>
  <td style="font-style: italic">{{ (strtolower($paquete->notas)) }}</td>
</tr>
@foreach ($arregloEmentos as $ElementoPaquete)
@if($ElementoPaquete->budget_pack_id==$paquete->id)
<tr>
  <td>{{ (strtolower($ElementoPaquete->servicio)) }}</td>
  <td>{{ (strtolower($ElementoPaquete->cantidad)) }}</td>
  
</tr>
@endif 
    @endforeach
     
@endforeach
@endif
</table>
  <!--///////////////////////////////////////////prueba paquetes -->  




@php
  if($presupuesto->opcionIVA==1){
     $iva=($presupuesto->total*.16);
     
  }else {$iva=0;}


  //Obtenemos los pagos realizados al contrato
  $Pagos = App\Payment::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->get();
  $saldoPagado=0;
  @endphp

<table style="width: 80%; text-align:center; margin-top:30px">
  <tr style="background: #cecece">
    <th colspan="4">Pagos Realizados</th>
  </tr>
  <tr>
    <th>Fecha Pago</th>
    <th>Monto</th>
    <th>Metodo Pago</th>
    <th>Referencia</th>
  </tr>
  @foreach ($Pagos as $pago)
  <tr>
  <td>{{$pago->created_at}}</td>
  @if($pago->method=='DOLAR')
    <td>${{number_format($pago->amount,2)}}Dlls=${{number_format($pago->amount*$pago->reference,2)}}MXN</td>
    @else
    <td>${{number_format($pago->amount,2)}}</td>
    @endif
    <td>{{$pago->method}}</td>
    @if($pago->method=='DOLAR')
    <td><span style="font-size:10px; font-style: italic">Tipo de cambio:</span><br>${{$pago->reference}}</td>
    @else
    <td>{{$pago->reference}}</td>
    @endif
  </tr>
  @php
       if($pago->method=='DOLAR'){
        $saldoPagado += ($pago->amount*$pago->reference);
        }else{
          $saldoPagado +=$pago->amount;}
      
  @endphp
  @endforeach
  
</table>

<table style="width: 100%; text-align: right">
<tr>
  <td><p>
    @php
        $descuentoGeneral = number_format($descuento,2);
        $subtotal=$presupuesto->total;
        $total=$subtotal + $iva;
        $total=number_format($total,2);
    @endphp
      @if($presupuesto->opcionDescuento==1)
      Ahorro total: ${{number_format($descuentoGeneral,2)}} @endif<br>
    Subtotal: ${{number_format($subtotal,2)}}<br>
    
  
    IVA: ${{number_format($iva,2)}}<br>
    @php
        
    @endphp
   
     <span style="font-weight: bold">TOTAL:$ {{$total}}<span><br>
      Saldo Pendiente: ${{number_format($subtotal + $iva-$saldoPagado,2)}}</p></td>
      </tr>
      <tr style="font-style: italic; text-align: left; font-size: 12px;">
          @if($presupuesto->tipo=='PRESUPUESTO')
        <td>
            *PRECIOS MAS IVA *Sujetos a disponibilidad hasta el dia de la contratación. ***DESCUENTOS COMPRANDO TODO EL PAQUETE*** EL DESCUENTO FINAL SE VERA REFLEJADO HASTA CONCRETAR LO SOLICITADO POR EL CLIENTE. *** PARA APROBACION SE REQUIERE FIRMA DEL CLIENTE. EN CASO DE EMPRESAS ES REQUISITO FIRMA Y SELLO ; UNA VEZ AUTORIZADA NO HAY CANCELACIONES NI DEVOLUCION DE DINERO ******** ***50% DE ANTICIPO. TODO SERVICIO TIENE QUE SER LIQUIDADO AL 100% 1 DIA HABIL ANTES DEL EVENTO EN CASO DE NO TENER CREDITO*** 2.5 % INTERES MENSUAL X ATRASO DE CREDITO. ***Sillas, mesa, manteleria no incluye instalación,favor de solicitarla. Loza sin lavar tiene costo $.50 c/u extra. **PRESUPUESTO VALIDO 7 DIAS Hábiles A partir de la fecha de envio. Precios cambio sin previo aviso. **APLICAN RESTRICCIONES EVENTO EXTERNOS SE SOLICITA UN DEPOSITO EN GARANTIA DEPENDIENDO DE LOS SERCICIOS SOLICITADOS ***SUBIR O BAJAR ESCALERAS O AREAS LEJANAS, LLEVA COSTO ADICIONAL. LOS SERVICIOS SALIENDO DE BODEGA NO HAY CANCELACIÓN*** LA ENTREGA O RECOLECCIÓN (SERAEN DIAS HABILES) Y DENTRO DEL HORARIO DE 9:00 AM-5PM, FUERA DE ESTOS HORARIOS Y DIAS LLEVARA CARGO EXTRA***EN AL RECIBIR EL EQUIPO SE DA POR ENTENDIDO QUE TODO SE ENCUENTRA BIEN AL MOMENTO DE FIRMAR DE RECIBIDO*** NO INCLUYE INSTALACIÓN SILLAS Y MESAS. *** EL CLIENTE QUE PASE A RECOGER EN BODEGA DEBERA DEJAR UNA IDENTIFICACION OFICIAL VIGENTE Y LA ENTREGA ES AL SIGUIENTE DIA HABIL ANTES DE LAS 12:00 PM PAGOS CON TARJETA O TRASFERENCIA SON MAS IVA.
          </td>
          @endif
      </tr>
      @if($presupuesto->tipo=='CONTRATO')
     <table style="width: 100%;">
    <tr>
    <td colspan="2">
        </td>  
    </tr>
    <tr>
      <td colspan="2">
          <p style="font-size: 16px; font-weight: bold; text-align: left">
              Servicios
          </p>
          @php
              $testigo=0;
          @endphp
        @foreach ($demo as $item)
      
        @php
        if($item->grupo=='Manteleria'){
            $testigo=1;
        }
        @endphp
    

    
        @endforeach
      </td>
    </tr>

  </table>
          @endif
</table>

<p style="font-style:italic; text-align: center; font-weight: lighter"> *La empresa no garantiza un horario exacto de entrega</p>
       
@if($presupuesto->tipo=='PRESUPUESTO')  @else 
<p style="font-size: 16px; font-weight: bold; text-align: left"><br>
            GENERALES DE CONTRATO<br>
            <span style="font-size: 12px; font-weight: normal; text-align: justify">
                **PAGOS EN EFECTIVO. EN CASO DE REALIZAR TRASFERENCIA O PAGOS CON TARJETA, SERIA MAS IVA.
**LOS EVENTOS TIENEN QUE SER PAGADOS EN SU TOTALIDAD MINIMO 3 DIAS DEL EVENTO Y EN EL CASO DE BODAS / EVENTOS GRANDES/ XV AÑOS CON UN MINIMO DE UNA SEMANA.
** NO HAY CANCELACION TOTAL NI PARCIAL DE CONTRATO UNA VEZ AUTORIZADO EL PRESUPUESTO Y EL CLIENTE SE COMPROMETE A LIQUIDAR EL VENTO.
**LLEVADA Y RECOGIDA DE LOS SERVICIOS SERAN EN UN HORARIO LABORAL DE 9:00 AM A 5:00 PM. EN CASO DE SER EN UN HORARIO FUERA DEL ANTERIOR EL CLIENTE DEBERA SOLICITARLO Y CON UN COSTO ADICIONAL
**CHEQUES DEVUELTOS, COSTO ADICIONAL DE $500 MAS EL SALDO PENDIENTE DE PAGO DEL SERVICIO
**LOS SERVICIOS SOLICITADOS SE ENTREGAN EN LUGARES CERCANOS DENTRO DE LA DIRECCION DE ENVIO. EN CASO DE ESCALERAS, LUGARES LEJANOS O PISOS SUBSECUENTES A PLATA BAJA, TIENEN UN COSTO ADICIONAL QUE DEBERA SER PAGADO ANTES DE SU INSTALACION EN NUESTRAS OFICINAS.
**MEGA DECOR NO SE HACE RESPONSABLE DE ACCIDENTES ANTES, DURANTES Y DESPUES DEL EVENTO.
**EN CASO DE FENOMENOS METEOROLOGICOS, NO HAY CANCELACIONES Y EL CLIENTE SE RESPONSABILIZA POR DAÑOS AL MOBILIARIO YA QUE LOS SERVICIOS SOLICITADOS SE  ENCUENTRAN EN SU POSESIÓN.
**SERVICIOS QUE SE RECOGEN EN BODEGA SERAN DEVUELTOS AL SIGUIENTE DIA HABIL ANTES DE LAS 2:00 PM, EN CASO CONTRARIO, CORRE OTRO DIA DE RENTA DE LOS SERVICIOS.
**SERVICIOS RECOGIDOS EN BODEGA ES INDISPENSABLE DEJAR CREDENCIAL OFICIAL VIGENTE  Y SE ENTREGA AL MOMENTO DE HACER LA DEVOLUACIÓN EN BODEGA.
              </span><br></p>
<br>

            <!--  <p style="font-size: 16px; font-weight: bold; text-align: left"><br>
                Mantelería<br>
                <span style="font-weight: bold">Requerimentos: </span><br>
                <span style="font-size: 12px; font-weight: normal; text-align: justify">
                    -Deposito de 500 pesos por evento es requerido en efectivo.</span><br>
                <span style="font-weight: bold">Observaciones: </span><br>
                <span style="font-size: 12px; font-weight: normal; text-align: justify">
                    MANTELERIA, CUBRE SILLAS, CUBRE MANTELES. MOÑOS. ETC "LA RENTA DE MANTELERIA ES POR 1 DIA 
** SE ENTREGARA A LAS 12:00 PM DEL SIGUIENTE DIA EN CASO DE QUE EL CLIENTE HAYA RECOGIDO EN BODEGA. <br>
**MANTELERIA DAÑADA TENDRA UN COSTO DE REPOSICION Y MEGA DECOR ENTREGA  EL DAÑADO AL CLIENTE<br>
**MANTELERIA CON MANCHAS QUE NO SE PUEDAN QUITAR <br>
 SE NOTIFICA AL CLIENTE Y CORRERA CON COSTO DE REPOSICION EN CASO DE QUE NO SE PUEDA QUITAR.<br>  MEGA MUNDO NOTIFICARA X TELEFONO EN UN LAPSO DE 48 HORAS mAximo. 
**SE PEDIRA A LA PERSONA DEL LUGAR QUE FIRME LA HOJA CORRESPONDIENTE EN CASO DE ALGUN FALTANTE O DAÑO .<br> EL CUAL EL CLIENTE DE ESTE CONTRATO SERA RESPONSABLE DEL PAGO DE REPOSICION. EL CUAL DEBERA SER PAGADO A NO MAS DE 48 HORAS DESPUES DE LA FIRMA DEL CONTRATO DEL EVENTO. 
** Al momento de la entrega en nuestras oficinas, eS RESPONSABILIDAD DEL cliente  revisar que fue entregada en buenas condiciones. de no ser asi ahi mismo pedira la sustitución de los mismos. De no ser asI se da por entendido que la entrega esta correcta en cantidad y no dañada.
                  </span><br></p> -->

                  <br>
             <!--     <p style="font-size: 16px; font-weight: bold; text-align: left"><br>
                    CARPAS<br>
                    <span style="font-weight: bold">Requerimentos: </span><br>
                    <span style="font-size: 12px; font-weight: normal; text-align: justify">
                        AL MOMENTO DE LA ENTREGA FAVOR DE CHECAR SI LE LLEGO BIEN EL PRODUCTO (BUENA PRESENTACIÓN,TAMAÑO,CALIDAD Y TEMPERATURA) SI NO LE LLEGO ADECUADAMENTE FAVOR DE REPORTARLO A MEGA MUNDO 4.23.41.34 ANTES DE QUE SE VALLA EL REPARTIDOR. NUNCA AL FINAL DEL EVENTO.<br>
                        TEMPERATURA DE LA COMIDA. EN CASO DE HABER PEDIDO COMIDA CALIENTE. ESTA SE ENTREGARA ASÍ: SIN EMBARGO MEGA MUNDO NO SE HACE RESPONSABLE SI LA COMIDA NO SIRVE A LOS INVITADOS INMEDIATAMENTE Y ESTA SE ENFRÍA.<br>
                         ADICIONAL EN CASO DE CONTRATACIÓN DE FUENTES. ESTE SERVICIO VA INCLUIDA UN ANFITRIONA QUE ESTARÁ AL PENDIENTE QUE SIEMPRE ESTE LIMPIO EL ÁREA DE LAS FUENTES.</span><br>
                    <span style="font-weight: bold">Observaciones: </span><br>
                    <span style="font-size: 12px; font-weight: normal; text-align: justify">
                        ME MUNDO NO SE HACE RESPONSABLE POR DAÑOS AL DOMICILIO O A INVITADOS. <br>
EN CASO DE AIRES FUERTES O EVENTOS METEREOLÓGICOS QUE SUCEDAN DURANTE EL EVENTO EL CLIENTE ES RESPONSABLE DE LA REPARACIÓN O REPOSICIÓN DE LOS MISMOS A MEGA MUNDO.<br>
LAS CARPAS SE ENTREGAN EN PERFECTAS CONDICIONES. INSTALADOS CON ESTACAS O CON BOLSAS DE ARENA. EL CLIENTE CHECA Y ACEPTA AL MOMENTO DE SER INSTALADAS LAS CARPAS. EN CASO DE QUE EL CLIENTE O EL RESPONSABLE NO SE ENCUENTRE EN EL DOMICILIO DEBERÁ DEJAR A UN ENCARGADO PARA LA ACEPTACIÓN DE LA BUENA INSTALACIÓN. UNA VEZ RETIRADO DE LAS INSTALACIONES DEL CLIENTE YA ES RESPONSABILIDAD DEL CLIENTE.<br>
DURANTE EL EVENTO Y HAGA QUE SE DERRAME EL CHAMOY. LA MAQUINA SE APAGARA PARA QUE EL PRODUCTO DEL CHAMOY NO SE DERRAME.
NO HAY DEVOLUCIÓN NI DESCUENTO POR ESTE SUCESO O ALGÚN OTRO ACONTECIMIENTO METEOROLÓGICO. </span><br></p> -->

<br>
             <!--     <p style="font-size: 16px; font-weight: bold; text-align: left"><br>
                    PLAQUE<br>
                    
                    <span style="font-weight: bold">Observaciones: </span><br>
                    <span style="font-size: 12px; font-weight: normal; text-align: justify">
                        **EL CLIENTE CONTABILIZA JUNTO AL PROVEEDOR DE SERVICIOS LA CANTIDAD RECIBIDA. EN CASO DE SOLO RECIBIRLA EL CLIENTE SE RESPONSABILIZA DE LA CANTIDAD RECIBIDA.<br>
                        ** LOZA ENTREGADA SUCIA TIENE UN COSTO DE .50 POR PIEZA .<br>
                        ** LOZA QUEBRADA, ASTILLADA O EN CASO DE FALTANTE, TIENE COSTO DE REPOSICIÓN Y SE AVISA AL RECOGER O SI EL CLIENTE LO LLEVA A BODEGA . </span><br></p>
                    -->
                        <br>
                  @foreach ($grupos as $grupo)
                  <p style="font-size: 16px; font-weight: bold; text-align: left"><br>
                  {{ $grupo->nombre }}<br>
                    <span style="font-weight: bold">Requisitos: </span><br>
                    <span style="font-size: 12px; font-weight: normal; text-align: justify">
                      {{ $grupo->informacion }}
                    </span><br>
                    <span style="font-weight: bold">Observaciones: </span><br>
                    <span style="font-size: 12px; font-weight: normal; text-align: justify">
                      {{ $grupo->observaciones }}
                    </span><br></p>
                  @endforeach
                  <div>
                    
                  </div>

<table>
    <tr style="text-align: center">
        <td >____________________________________<br>Firma del cliente<br>{{$presupuesto->cliente}}</td>
        <td >____________________________________<br>Mega Mundo Decor<br>{{$presupuesto->vendedor}}</td>
      </tr>
</table>

@endif

   
<script type="text/php">
  if ( isset($pdf) ) {
      $font = "helvetica";
      $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
  }
</script> 
   
</body>
</html>