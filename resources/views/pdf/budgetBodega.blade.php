<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Presupuesto</title>
</head>
<body style="font-family: Helvetica; ">
    <p style="line-height: 15px; font-size: 16px; font-style: italic">Ficha tecnica de evento para operadores</p>
    <table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px">
        <tr>
          <td style="padding-right:100px;">
              <img src="http://megamundodecor.com/images/mega-mundo-decor.png" style="width:200px">
          </td>
          <td colspan="2" style="text-align: right">
            <p><span style="font-weight: bolder">Folio:</span>  <span style="font-weight:normal">{{$presupuesto->folio}}</span><br>
              <span style="font-weight: bold; font-size: 13px;">Cliente:</span> <span style="font-style: italic; font-weight: normal;  font-size: 13px;">{{$presupuesto->cliente}}</span>
            </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; font-style: italic; font-size:13px">Versión de @if($presupuesto->tipo=='PRESUPUESTO') presupuesto @else contrato @endif {{$presupuesto->version}} de {{$presupuesto->version  }}<br><span style="font-style: italic">Fecha de creación: </span> {{$presupuesto->created_at}} </td>
        </tr>
        
      </table>
<!--INFORMACION DEL EVENTO-->
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
    <tr>
    <td colspan="4">
            
        <H3 style="line-height: 15px; font-size: 18px">Datos Generales Del Evento</H3></td>
  </tr>
<tr style="font-weight: bold; font-size: 14px;">
<td colspan="2"><span>Fecha y Hora: </span></td>
<td colspan="4"><span style="font-weight: bold">Lugar: </span></td>
</tr>
<tr style=" font-size: 14px;">
    @php                        
    use Carbon\Carbon;    
    $fechaEvento = Carbon::parse($presupuesto->fechaEvento)->locale('es');
@endphp
<td colspan="2">{{$fechaEvento->translatedFormat(' l j F Y')}} <br>@if($presupuesto->pendienteHora==0){{$presupuesto->horaEventoInicio}} - {{$presupuesto->horaEventoFin}}@else Pendiente @endif</td>
<td colspan="2">{{$presupuesto->direccionLugar}} {{$presupuesto->numeroLugar}} {{$presupuesto->coloniaLugar}}<br><span style="font-style: italic">Notas: {{$presupuesto->observacionesLugar}}</span></td>
</tr>
<tr style="font-weight: bold; padding-top: 20px">
<td colspan="2"><span>Entrega de Mobiliario: </span></td>
<td colspan="2"><span>Recolección de Mobiliario: </span></td> 
</tr>
<tr>
<td colspan="2">@if($presupuesto->horaEntrega!=null){{$presupuesto->horaEntrega}}@else Por Definir @endif</td>
<td colspan="2">@if($presupuesto->fechaRecoleccion!=null){{$presupuesto->fechaRecoleccion}}@else Por Definir @endif</td>
</tr>
<tr>
  <td colspan="4">
    <br>Telefonos de contacto:<br>
      @foreach($Telefonos as $telefono)
      @php
        $lada=substr($telefono->numero, 0,3);
        $primerosnumero=substr($telefono->numero, 3,3);
        $segundos=substr($telefono->numero, 6,2);
        $terceros=substr($telefono->numero, 8,2);
      @endphp
    {{'('.$lada.')'.$primerosnumero.'-'.$segundos.'-'.$terceros}}, @endforeach
  </td>
</tr>



</table>
<table style="width: 100%; margin-top: 10px">
  <tr style="padding: 4px; color:white; background:#9E9E9E; text-align: center;">
    <td style="font-size: 13px; padding: 4px;">Servicio</td>
    <td style="font-size: 13px; padding: 4px;">Cantidad</td>
    <td style="font-size: 13px; padding: 4px;">Notas</td>
  </tr>
  @php
      $descuento=0;
  @endphp
  @foreach ($Elementos as $elemento)
  @php
      $descuento=$descuento+($elemento->precioUnitario-$elemento->precioEspecial);
  @endphp
    <tr style="margin-top: 2px; background: #F3F3F3; font-size:13px">
    <td style="padding: 5px;">{{ (strtolower($elemento->servicio)) }}</td>
      <td style="text-align: center">{{ (strtolower($elemento->cantidad)) }}</td>
    <td style="padding: 5px;">{{ (strtolower($elemento->notas)) }}</td>
    </tr>
@endforeach
<tr>
  <td colspan="3"><br>
    <span style="font-weight: bold">Notas de presupuesto:</span><br>
    <span style="font-weight: normal; font-style: italic">{{$presupuesto->notasPresupuesto}}</span>
  </td>
</tr>
</table>
@php
  if($presupuesto->opcionIVA==1){
     $iva=(($presupuesto->total/116) * 16);
  }else {$iva=0;}
  @endphp



      

   
  
   
</body>
</html>