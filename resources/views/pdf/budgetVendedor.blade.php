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
<tr style=" font-size: 12px;">
<td colspan="3"></td>
<td><span style="font-weight: bold">Tema:</span> {{$presupuesto->temaEvento}}</td>
</tr>

<tr style=" font-size: 12px;"><td colspan="4"><span style="font-weight: bold">Lugar: </span></td>
</tr>
<tr style=" font-size: 12px;"><td colspan="4">{{$presupuesto->direccionLugar}} {{$presupuesto->numeroLugar}} {{$presupuesto->coloniaLugar}}<br><span style="font-style: italic">Notas (visibles para cliente): {{$presupuesto->observacionesLugar}}</span></td>
</tr>
<tr>
    <td>Notas (solo visibles para vendedores):</td>
  <td>{{$presupuesto->notasPresupuesto}}</td>
    <td></td></tr>
</table>
<table style="width: 100%; margin-top: 10px">
  <tr style="padding: 4px; color:white; background:#9E9E9E; text-align: center;">
    @if($presupuesto->opcionImagen==1)  
    <td style="font-size: 11px; padding: 4px;">Imagen</td>
    @endif
    <td style="font-size: 11px; padding: 4px;">Servicio</td>
    <td style="font-size: 11px; padding: 4px;">Cantidad</td>
    @if($presupuesto->opcionPrecioUnitario==1) 
    <td style="font-size: 11px; padding: 4px;">Precio Unitario</td>
    @endif
    @if($presupuesto->opcionPrecio==1)
    <td style="font-size: 11px; padding: 4px;">Precio Especial</td>
    <td style="font-size: 11px; padding: 4px;">Total Con Descuento</td>
    @endif
    <td style="font-size: 11px; padding: 4px;">Notas</td>
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
    <tr style="margin-top: 2px; background: #F3F3F3; font-size:11px">
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

@if(!is_null($Paquetes))
@foreach ($Paquetes as $paquete)
    <tr style="margin-top: 2px; background: #FFF8CD; font-size:11px">
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
    <tr style="text-align: center; font-size: 11px;">
        <td style="border-left:solid; border-left-width: 1px;">Imagen</td>
        <td colspan="3" style="border-left:solid; border-left-width: 1px;">Servicio</td>
        <td style="border-left:solid; border-left-width: 1px;">Cantidad</td>
        <td style="border-left:solid; border-left-width: 1px;" colspan="2">Notas</td>
      </tr>
    @foreach ($arregloEmentos as $ElementoPaquete)
    @if($ElementoPaquete->budget_pack_id==$paquete->id)
    <tr style="margin-top: 2px; background: #FFFCE9; font-size:11px; border:solid;">
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
     
  }else {$iva=0;}
  @endphp
<table style="width: 100%; text-align: right">
<tr>
  <td><p>
    @php
        $descuentoGeneral = number_format($descuento,00);
        $subtotal=$presupuesto->total;
        $total=intval($subtotal) + intval($iva);
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
     
      @if($presupuesto->tipo=='CONTRATO')
     <table style="width: 100%;">
    <tr>
   
    </tr>
   
  </table>
          @endif
</table>


      

   
<script type="text/php">
  if ( isset($pdf) ) {
      $font = "helvetica";
      $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
  }
</script> 
   
</body>
</html>