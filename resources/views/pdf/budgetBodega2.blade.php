<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Presupuesto</title>
</head>
@php                        
    use Carbon\Carbon;    
    $fechaEvento = Carbon::parse($presupuesto->fechaEvento)->locale('es');
@endphp
<body style="font-family: Helvetica; ">
    
    <table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px">
        <tr>
          <td style="width: 30%">
              <img src="http://megamundodecor.com/images/mega-mundo-decor.png" style="width:200px">
             <p style="text-align: left; font-style: italic; font-size:13px; width: 300px"> Versión de @if($presupuesto->tipo=='PRESUPUESTO') presupuesto @else contrato @endif {{$presupuesto->version}} de {{$presupuesto->version  }}<br><span style="font-style: italic">Fecha de creación: </span> {{$presupuesto->created_at}}<br>@if($presupuesto->pagado!=1)
              <span style="color:red">*Este contrato aun no esta pagado en su totalidad, por lo que es necesario confirmar con vendedor asignado su liberación </span> </td>
              @else
              <span style="color:green">Contrato pagado en su totalidad</span>
              @endif</p>
          </td>
          <td colspan="3" style="text-align: right; width: 70%">
            <p><span style="font-weight: ;">Numero de contrato:</span>  <span style="font-weight:bold;  font-size:20px">{{$presupuesto->folio}}</span><br>
              <span style="font-weight: normal; font-size: 13px;">Cliente:</span> <span style="font-style: italic; font-weight: bold;  font-size: 20px;">{{$presupuesto->cliente}}</span><br>
              <span style="font-weight: normal; font-size: 13px;">Fecha del evento:</span><br> <span style="font-style: italic; font-weight: normal;  font-size: 20px; font-weight: bolder">{{$fechaEvento->translatedFormat(' l j F Y')}}</span><br>
              <span style="font-weight: normal; font-size: 13px;">Vendedor:</span> <span style="font-style: italic; font-weight: bold;  font-size: 13px;">{{$presupuesto->vendedor}}</span>
            </p>
            </td>
        </tr>
        
      </table>
<!--INFORMACION DEL EVENTO-->
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
    <tr>
    <td colspan="4">
            
        <H3 style="line-height: 15px; font-size: 18px">Datos Generales Del Evento <span style="padding-left: 40px; margin-right:20px; font-size: 14px; font-weight: bold">Requiere Montaje: <span style="font-weight: normal">{{$presupuesto->requiereMontaje}}</span></span>  <span style="padding-left: 20px; font-size: 13px; "> @if($presupuesto->lugarEvento!='BODEGA')<span style="padding-lef:20px">Entrega de Mobiliario:</span><span style="font-weight: normal"> @if($presupuesto->horaEntrega!=null){{$presupuesto->horaEntrega}}@else @if($presupuesto->requiereMontaje!='SI')Por Definir @endif @endif @endif</span></H3></td>
  </tr>
<tr style="font-weight: bold; font-size: 14px;">
<td colspan="2"><span>Fecha y Hora del evento: </span></td>
<td colspan="4"><span style="font-weight: bold">Dirección de entrega: </span></td>
</tr>
<tr style=" font-size: 14px;">
<td colspan="2">{{$fechaEvento->translatedFormat(' l j F Y')}} <br>@if($presupuesto->pendienteHora==0){{$presupuesto->horaEventoInicio}} - {{$presupuesto->horaEventoFin}}@else Horario Pendiente @endif</td>
<td colspan="2">
  @if($presupuesto->lugarEvento!='BODEGA')
    {{$presupuesto->direccionLugar}} {{$presupuesto->numeroLugar}} {{$presupuesto->coloniaLugar}}
  @else
  <span>*RECOLECCIÓN EN BODEGA</span>
  @endif
  <br><span style="font-style: italic; font-weight:bold">Notas lugar de entrega:</span><span> {{$presupuesto->observacionesLugar}}</span></td>
</tr>
<tr>
  <td></td>
  <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
  </tr>
<tr style="font-weight: bold; padding-top: 20px">
<td colspan="2"><span>Recolección de Mobiliario: </span></td> 
</tr>
<tr>
<td colspan="2">@if($presupuesto->recoleccionPreferente!=null){{$presupuesto->recoleccionPreferente}}@else Por Definir @endif</td>
<td colspan="2">
Telefonos de contacto:<br>
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

<table>
    <tr style="background:#F7F7F7; width: 100%">
        <td style="width: 100%">
          <p>
          <span style="font-weight: bold">Notas de presupuesto:</span><br>
          <span style="font-weight: normal; font-style: italic">{{$presupuesto->notasPresupuesto}}</span>
        </p>
        </td>
      </tr>
</table>

<table style="width: 100%; margin-top: 10px">
  <tr style="padding: 4px; color:white; background:#9E9E9E; text-align: center;">
    
      <td style="font-size: 13px; padding: 4px; width: 15px">Cantidad</td>
    <td style="font-size: 13px; padding: 4px;">Servicio</td>
    <td style="font-size: 11px; padding: 4px; width: 60px">Entrega</td>
    <td style="font-size: 11px; padding: 4px; width: 60px">Recolección</td>
    <td style="font-size: 11px; padding: 4px; width: 60px">Faltante</td>
    <td style="font-size: 11px; padding: 4px; width: 200px">Notas</td>
  </tr>
  @php
      $descuento=0;
  @endphp
  @foreach ($Elementos as $elemento)
  @php
      $descuento=$descuento+($elemento->precioUnitario-$elemento->precioEspecial);
  @endphp
  
    <tr style="margin-top: 2px; background: #F3F3F3; font-size:13px">
    <td style="text-align: center;  width: 15px">{{ (strtolower($elemento->cantidad)) }}</td>
    <td style="padding: 5px; font-size:12px">{{ (strtolower($elemento->servicio)) }}</td>
    <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white"></td>
    <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white"></td>
    <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white"></td>
    <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white; width: 150px"></td>
    </tr>
@endforeach
@if(!is_null($Paquetes))
@foreach ($Paquetes as $paquete)
    <tr style="margin-top: 2px; background: #FFF8CD; font-size:13px">
    <td style="padding: 5px; text-align:center">{{ (strtolower($paquete->servicio)) }}</td>
      <td style="text-align: center">{{ (strtolower($paquete->cantidad)) }}</td>
    </tr>
    @if($presupuesto->opcionDescripcionPaquete==1)
    <tr style="text-align: center; font-size: 12px;">
        <td colspan="1" style="border-left:solid; border-left-width: 1px;">Servicio</td>
        <td style="border-left:solid; border-left-width: 1px; width: 100px">Cantidad</td>
        <td style="border-left:solid; border-left-width: 1px; width: 100px">Entrega</td>
        <td style="border-left:solid; border-left-width: 1px; width: 100px">Recolección</td>
        <td style="border-left:solid; border-left-width: 1px; width: 100px">Faltante<td>
            <td style="border-left:solid; border-left-width: 1px; width: 100px">Notas<td>
      </tr>
    @foreach ($arregloEmentos as $ElementoPaquete)
    @if($ElementoPaquete->budget_pack_id==$paquete->id)
    <tr style="margin-top: 2px; background: #FFFCE9; font-size:12px; border:solid;">
        <td colspan="1" style="padding: 5px;">{{ (strtolower($ElementoPaquete->servicio)) }}<br><span style="font-weight: lighter; font-size: 11px; font-style: italic">Pertenece a: {{ (strtolower($paquete->servicio)) }}</span></td>
          <td colspan="1" style="text-align: center">{{ (strtolower($ElementoPaquete->cantidad)) }}</td>
          <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white"></td>
          <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white"></td>
          <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white"></td>
          <td style="border-bottom:solid; border-right:solid; border-right-style: dotted; border-width: 2px; border-right-width: 1px;  background:white; width: 150px"></td>
        </tr> 
        @endif
        
    @endforeach
    @endif
@endforeach

    @endif

</table>

<div style="width: 100%">
    <p style="font-style:italic; text-align: center; font-size:11px">*Indicar con un "S", los articulos entregados correctamente y con una "X" los productos que cuenten con un problema al momento de la entrega o la recolección, firmar unicamente los espacios de entrega al momento de la entrega y firmar y completas los campos faltantes al momento de la recolección</p>
  </div>

<div></div>

<table style="width: 100%; text-align:center; margin-top:50px">
  <tr>
    <td>_________________________________</td>
    <td>_________________________________</td>
  </tr>
  <tr>
      <td>Firma de recepción de mobiliario cliente</td>
      <td>Firma y nombre de entrega de mobiliario Operador</td>
    </tr>
</table>

<table style="width: 100%; text-align:center; margin-top:50px">
    <tr>
      <td>_________________________________</td>
      <td>_________________________________</td>
    </tr>
    <tr>
        <td>Firma de entrega de mobiliario cliente</td>
        <td>Firma y nombre de recolección de mobiliario Operador</td>
      </tr>
  </table>

  <div style="width: 90%">
  <label for="" style="font-weight: bold; padding-left:40px; padding-right:40px; width: 100%"><br>Comentarios de entrega: ___________________________________________________________________________
    ___________________________________________________________________________
    ___________________________________________________________________________
    ___________________________________________________________________________
    ___________________________________________________________________________</label><br>
  <label for="" style="font-weight: bold; padding-left:40px;"><br>Comentarios de recolección: ___________________________________________________________________________<br>
    ___________________________________________________________________________<br>
    ___________________________________________________________________________<br>
    ___________________________________________________________________________<br>
    ___________________________________________________________________________</label>
</div>
  

@php
  if($presupuesto->opcionIVA==1){
     $iva=(($presupuesto->total/116) * 16);
  }else {$iva=0;}
  @endphp

<script type="text/php">
  if ( isset($pdf) ) {
      $font = "helvetica";
      $pdf->page_text(495, 17, "Folio de contrato: {{$presupuesto->folio}}", $font , 6, array(0,0,0));
      $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
  }
</script> 

      

   
  
   
</body>
</html>