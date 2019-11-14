<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@php
    $date = Carbon\Carbon::now();
@endphp
<body style="font-family: Arial, Helvetica, sans-serif">
        <div style="width: 100%;">
        <p style="text-align:center; font-weight:bold"><span style="font-style: italic; font-size:17px"> Transferencias bodega-exhibicion</span></p>
                <table style="width: 100%; font-family: Helvetica;" >
                        <tr>
                            <td>
                                <img src="http://megamundodecor.com/images/mega-mundo-decor.png" alt="" style="width: 200px">
                            </td>
                        <td style="text-align: right">
                            <span style="font-style: italic; font-size: 14px;  font-weight: bold">Fecha de impresión: </span> <span style="font-style: italic; font-size: 14px">{{$date->translatedFormat(' l j F Y')}}  </span><br>
                            </td>
                        </tr>
                        </table>
                        <div style="width: 100%; height: 0px; border-bottom:solid"></div>

                        <div>
<table style="width: 100%; margin-top:15px; text-align:center;">
    <tr style=" background:blanchedalmond; padding:6px; font-size:12px">
        <th>Tipo</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th colspan="2">Antes del traspaso</th>
        <th colspan="2">Despues del traspaso</th>
    </tr>
    <tr style=" background:blanchedalmond; padding:6px; font-size:12px">
            <th style="background: white"></th>
            <th style="background: white"></th>
            <th style="background: white"></th>
            <th>Bodega</th>
            <th>Exhibición</th>
            <th>Bodega</th>
            <th>Exhibición</th>
        </tr>
   
    @foreach ($transferencias as $transferencia)
    @php
        $producto = App\Inventory::where('id', $transferencia->producto)->first();
    @endphp

    <tr style="border-bottom:solid; font-size:11px;">
    <td>@if($transferencia->tipo=='salida')  bodega a exhibición
    @else De exhibición a bodega @endif</td>
    <td>{{$producto->servicio}} </td>
    <td>{{$transferencia->cantidad}}</td>
    <td>@if($transferencia->tipo=='salida'){{$producto->cantidad + $transferencia->cantidad}}@else
        {{$producto->cantidad - $transferencia->cantidad}}@endif</td>
    <td>@if($transferencia->tipo=='salida'){{$producto->exhibicion - $transferencia->cantidad}}@else
            {{$producto->exhibicion + $transferencia->cantidad}}@endif</td>
    <td>{{$producto->cantidad}}</td>
    <td>{{$producto->exhibicion}}</td>
    </tr>    
    @endforeach
</table>
                        </div>
    
                </div>
</body>
</html>