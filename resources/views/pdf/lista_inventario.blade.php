<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Presupuesto</title>
</head>
<body style="font-family: Helvetica; ">
<p style="line-height: 15px; font-size: 16px; font-style: italic; font-weight: bold">Familia: {{$familia}}</p>
<table>


</table>
@php
use Carbon\Carbon;
    $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
@endphp
<p>Inventario Impreso {{$fechaHoy}}</p>
<table style="border-width: 1px; width:100%">
    <tr style="">
      <th style="padding:4px">Imagen</th> 
      <th style="padding: 4px;">Servicio</th>
       <th style="padding: 4px;">Bodega</th>
       <th style="padding: 4px;">Bodega</th>
       <th style="padding: 4px;">Exhibición</th>
       <th style="padding: 4px;">Exhibición</th>
    </tr>
    @foreach($Inventario as $item)
<tr style="font-size:12px;">
<td style="padding: 4px; border-bottom:solid; border-width: 1px; "><img src="{{$item->imagen}}" width="35px"></td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; ">{{$item->servicio}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$item->cantidad}}</td>
<td style="padding: 4px; border-bottom:solid; border-right:solid; border-left:solid; border-width: 1px; "></td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$item->exhibicion}}</td>
<td style="padding: 4px; border-bottom:solid; border-right:solid; border-left:solid; border-width: 1px; "></td>



</tr>
@endforeach
</table>

<table style="width: 100%; margin-top: 20px">
  <tr style="text-align: center">
    <td>_____________________________<br>Firma Aaron Bodega</td>
    <td>_____________________________<br>Ivonne C. Arroyos P.</td>
  </tr>
</table>

      

   
<script type="text/php">
if ( isset($pdf) ) {
    $font = "helvetica";
    $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
}
</script> 
   
</body>
</html>