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
        <img src="http://megamundodecor.com/images/mega-mundo-decor.png" style="width:200px">
    </td>
    @else
    <td style="padding-right:100px;">
        <img src="http://megamundodecor.com/images/mega-mundo.png" style="width:180px">
    </td>
    @endif
   
    <td colspan="3" style="text-align: right">
      <p><span style="font-weight: bolder">Folio:</span>  <span style="font-weight:normal">{{$presupuesto->folio}}</span></p>
      <p><span style="font-weight: bolder">Vendedor:</span> <span style="font-weight:normal">{{$presupuesto->vendedor}}</span></p>
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
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
<tr>
<td colspan="3"><p style="line-height: 14px;"><span style="font-style: italic">@if($presupuesto->tipo=='CONTRATO')Contrato @else Presupuesto @endif generado para:</span> <span style="font-weight: bold">{{$presupuesto->cliente}}</span>
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
    $horaI = date("g:i a", $horaI);

    $horaF = strtotime($presupuesto->horaEventoFin);
    $horaF = date("g:i a", $horaF);
    
   
@endphp

<td colspan="2">{{$fechaEvento->translatedFormat(' l j F Y')}} <br>@if($presupuesto->pendienteHora==0){{$horaI}} - {{$horaF}}@else Pendiente @endif</td>
  <td><span> {{$presupuesto->categoria}}, {{$presupuesto->tipoEvento}} {{$presupuesto->tipoServicio}}</span></td>
  <td><span style="font-weight: bold">Tono:</span> {{$presupuesto->colorEvento}}</td>
</tr>
<tr style=" font-size: 14px;">
<td colspan="3"></td>
<td><span style="font-weight: bold">Tema:</span> {{$presupuesto->temaEvento}}</td>
</tr>

<tr style=" font-size: 14px;"><td colspan="4"><span style="font-weight: bold">Lugar: </span></td>
</tr>
<tr style=" font-size: 14px;"><td colspan="4">{{$presupuesto->direccionLugar}} {{$presupuesto->numeroLugar}} {{$presupuesto->coloniaLugar}}<br><span style="font-style: italic">Notas: {{$presupuesto->observacionesLugar}}</span></td>
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
    <td style="font-size: 13px; padding: 4px;">Precio Especial</td>
    @if($presupuesto->opcionPrecio==1) 
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
      <td style="text-align: center">@if($elemento->precioUnitario!=$elemento->precioEspecial)${{ (strtolower($elemento->precioEspecial)) }}@else -- @endif</td>
      @if($presupuesto->opcionPrecioUnitario==1) 
      <td style="text-align: center">${{ (strtolower($elemento->precioFinal)) }}</td>
      @endif
    <td style="padding: 5px;">{{ (strtolower($elemento->notas)) }}</td>
    </tr>
@endforeach

@if(!is_null($Paquetes))
@foreach ($Paquetes as $paquete)
    <tr style="margin-top: 2px; background: #FFF8CD; font-size:13px">
    <td style="padding: 5px; text-align:center; font-weight: bold">Paquete:</td>
    <td style="padding: 5px; text-align:center">{{ (strtolower($paquete->servicio)) }}</td>
      <td style="text-align: center">{{ (strtolower($paquete->cantidad)) }}</td>
      @if($presupuesto->opcionPrecio==1) 
      <td style="text-align: center">${{ (strtolower($paquete->precioUnitario)) }}</td>
      @endif
      <td style="text-align: center">@if($paquete->precioUnitario!=$paquete->precioEspecial)${{ (strtolower($paquete->precioEspecial)) }}@else -- @endif</td>
      @if($presupuesto->opcionPrecio==1) 
      <td style="text-align: center">${{ (strtolower($paquete->precioFinal)) }}</td>
      @endif
    <td style="padding: 5px;">{{ (strtolower($paquete->notas)) }}</td>
    </tr>
    @if($presupuesto->opcionDescripcionPaquete==1)
    <tr style="text-align: center; font-size: 12px;">
        <td style="border-left:solid; border-left-width: 1px;">Imagen</td>
        <td colspan="3" style="border-left:solid; border-left-width: 1px;">Servicio</td>
        <td style="border-left:solid; border-left-width: 1px;">Cantidad</td>
        <td style="border-left:solid; border-left-width: 1px;" colspan="2">Notas</td>
      </tr>
    @foreach ($arregloEmentos as $ElementoPaquete)
    @if($ElementoPaquete->budget_pack_id==$paquete->id)
    <tr style="margin-top: 2px; background: #FFFCE9; font-size:12px; border:solid;">
        <td><img src="{{$ElementoPaquete->imagen}}" width="40px" alt="" style="margin-left: 15px; "></td>
        <td colspan="3" style="padding: 5px;">{{ (strtolower($ElementoPaquete->servicio)) }}<br><span style="font-weight: lighter; font-size: 11px; font-style: italic">Pertenece a: {{ (strtolower($paquete->servicio)) }}</span></td>
          <td colspan="1" style="text-align: center">{{ (strtolower($ElementoPaquete->cantidad)) }}</td>
          
          
        <td colspan="2" style="padding: 5px;">{{ (strtolower($ElementoPaquete->notas)) }}</td>
        </tr> 
        @endif
        
    @endforeach
    @endif
@endforeach

    @endif
</table>
@php
  if($presupuesto->opcionIVA==1){
     $iva=($presupuesto->total*.16);
     $iva=number_format($iva,2);
  }else {$iva=0; $iva=number_format($iva,2);}
  @endphp
<table style="width: 100%; text-align: right">
<tr>
  <td><p>
    @php
        $descuentoGeneral = number_format($descuento,00);
        $subtotal=$presupuesto->total;
        $total=$subtotal + ((int) $iva);
        $total=number_format($total,2);
    @endphp
      @if($presupuesto->opcionDescuento==1)
      Ahorro total: ${{$descuentoGeneral}}.00 @endif<br>
    Subtotal: ${{$subtotal}}.00<br>
  
    IVA: ${{$iva}}<br>
    @php
        
    @endphp
   
     <span style="font-weight: bold">TOTAL:$ {{$total}}<span></p></td>
      </tr>
      <tr style="font-style: italic; text-align: left; font-size: 12px;">
        <td>
            *PRECIOS MAS IVA *Sujetos a disponibilidad hasta el dia de la contratación. ***DESCUENTOS COMPRANDO TODO EL PAQUETE*** EL DESCUENTO FINAL SE VERA REFLEJADO HASTA CONCRETAR LO SOLICITADO POR EL CLIENTE. *** PARA APROBACION SE REQUIERE FIRMA DEL CLIENTE. EN CASO DE EMPRESAS ES REQUISITO FIRMA Y SELLO ; UNA VEZ AUTORIZADA NO HAY CANCELACIONES NI DEVOLUCION DE DINERO ******** ***50% DE ANTICIPO. TODO SERVICIO TIENE QUE SER LIQUIDADO AL 100% 1 DIA HABIL ANTES DEL EVENTO EN CASO DE NO TENER CREDITO*** 2.5 % INTERES MENSUAL X ATRASO DE CREDITO. ***Sillas, mesa, manteleria no incluye instalación,favor de solicitarla. Loza sin lavar tiene costo $.50 c/u extra. **PRESUPUESTO VALIDO 7 DIAS Hábiles A partir de la fecha de envio. Precios cambio sin previo aviso. **APLICAN RESTRICCIONES EVENTO EXTERNOS SE SOLICITA UN DEPOSITO EN GARANTIA DEPENDIENDO DE LOS SERCICIOS SOLICITADOS ***SUBIR O BAJAR ESCALERAS O AREAS LEJANAS, LLEVA COSTO ADICIONAL. LOS SERVICIOS SALIENDO DE BODEGA NO HAY CANCELACIÓN*** LA ENTREGA O RECOLECCIÓN (SERAEN DIAS HABILES) Y DENTRO DEL HORARIO DE 9:00 AM-5PM, FUERA DE ESTOS HORARIOS Y DIAS LLEVARA CARGO EXTRA***EN AL RECIBIR EL EQUIPO SE DA POR ENTENDIDO QUE TODO SE ENCUENTRA BIEN AL MOMENTO DE FIRMAR DE RECIBIDO*** NO INCLUYE INSTALACIÓN SILLAS Y MESAS. *** EL CLIENTE QUE PASE A RECOGER EN BODEGA DEBERA DEJAR UNA IDENTIFICACION OFICIAL VIGENTE Y LA ENTREGA ES AL SIGUIENTE DIA HABIL ANTES DE LAS 12:00 PM PAGOS CON TARJETA O TRASFERENCIA SON MAS IVA.
          </td>
      </tr>
      @if($presupuesto->tipo=='CONTRATO')
     <table style="width: 100%;">
    <tr>
    <td colspan="2">
        <p style="font-size: 16px; font-weight: bold; text-align: left">
            Generales de contrato<br>
            <span style="font-size: 12px; font-weight: normal; text-align: justify">
                FENOMENOS METEOROLOGICOS EN CASO DE LLUVIA, VIENTO, APAGANONES DE LUZ POR CFE, POR NINGUN MOMENTO SE PODRA CANCELAR ESTE CONTRATO YA QUE ES ALGO AJENO A LOS SERVICIOS DE MEGA MUNDO EL CONTRATO TENDRÁ QUE SER LIQUIDADO EN SU TOTALI_ DAD. NO HABRÁ CAMBIO DE FECHA EL MERO DIA DEL EVENTO. MAL FUNCIONAMIENTO DE LA UNIDAD RENTADA: — SI LA UNIDAD RENTADA NO ESTA FUNCIONANDO ADECUADAMENTE, EL CLIENTE TENDÁ QUE REPORTARLO INMEDIATAMENTE A A MEGAMUNDO 614 4 23 41 34 PARA QUE MEGAMUNDO SOLUCIONE EL PROBLEMA LO MAS PRONTO POSIBLE Y ASI RESPONERLE EL TIEMPO PERDIDO. EN CASO DE QUE ESTE PROBLEMA NO SE REPORTE INMEDIATAMENTE, MEGA MUNDO SE DESLINDA DE CUALQUIER RESPONSABILIDAD Y DE REPOSICION DE TIEMPO. CAMBIOS DE FECHA Y CANCELACIONES DEBE SER PAGADO LOS SERVICIOS AL 100% **CAMBIOS DE FECHA SOLO 1 SEMANA ANTES Y CON COSTO ADMINISTRATIVO DE $100 (CIEN PESOS) "NO EXISTEN CANCELACIONES EN ESTE SERVICIO Y NO HAY DEVOLUCION TOTAL NI PARCIAL DEL DINERO "LOS SERVICIOS CONTRATADOS DEBEN SER PAGADOS EN SU TOTALIDAD ANTES DEL EVENTO. ACCIDENTES NO NOS HACEMOS RESPONSABLES POR ACCIDENTES DE LOS INVITADOS DE NINGUNA INDOLE. LA RESPONSABILIDAD CORRE POR QUIEN CONTRATA —PASTILLAS DE LUZ EN CASO DE QUE LAS PASTILLAS DE LUZ SE ESTEN BOTANDO, ES RESPONSABILIDAD DE QUIEN CONTRATA EL ARREGLO DE LUZ Y NO DE MEGA MUNDO. EL TIEMPO NO SE REPONDRA, MEGAMUNDO PUEDE RETIRARSE DE LA 1NSTALACION EN CASO DE QUE POR ESTE U OTRO MOTIVO NO AJENO A MEGAMUNDO , ESTE PUEDA LLEGAR A SUS OTROS EVENTOS (SERVICIOS) TARDE. —PRECIOS MAS IVA —CHEQUES DEVUELTOS TIENE UN CARGO ADICIONAL PARA EL CLIENTE DE EL 20% DEL MONTO TOTAL DEL CHEQUE. 
              </span><br></p>
             
        </td>  
    </tr>
    <tr>
      <td colspan="2">
          <p style="font-size: 16px; font-weight: bold; text-align: left">
              Servicios
          </p>
        @foreach ($demo as $item)
          <p style="font-size: 16px; font-weight: bold; text-align: left">
              {{ $item->nombre }}
          </p>
          @php
              $grupo = App\FamilyGroup::where('nombre', $item->grupo)->first();
          @endphp
          <p style="font-size: 12px; font-weight: normal; text-align: justify">
            {{ $grupo['informacion'] }}
          </p>
        @endforeach
      </td>
    </tr>
    <tr style="text-align: center">
        <td >____________________________________<br>Firma del cliente<br>{{$presupuesto->cliente}}</td>
        <td >____________________________________<br><br>Mega Mundo Decor</td>
      </tr>
  </table>
          @endif
</table>


      

   
<script type="text/php">
  if ( isset($pdf) ) {
      $font = "helvetica";
      $pdf->page_text(72, 18, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
  }
</script> 
   
</body>
</html>