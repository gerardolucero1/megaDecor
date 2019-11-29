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
        <p style="text-align:center; font-weight:bold"><span style="font-style: italic; font-size:17px"> Movimientos Bodega - Exhibición</span></p>
                <table style="width: 100%; font-family: Helvetica;" >
                        <tr>
                            <td style="width: 30%">
                                <img src="http://megamundodecor.com/images/mega-mundo-decor.png" alt="" style="width: 200px">
                            </td>
                        <td style="text-align: right; width: 70%">
                            @php
                                $fecha1=$_GET['fecha_1'];
                                $fecha2=$_GET['fecha_2'];

                            @endphp
                                <span style="font-style: italic; font-size: 15px;  font-weight: bold">Fechas de Movimientos: </span> <span style="font-style: italic; font-size: 14px">{{$fecha1}} a {{$fecha2}} </span><br>
                                <span style="font-style: italic; font-size: 15px;  font-weight: bold">Familia: </span> <span style="font-style: italic; font-size: 14px">{{$familia}}  </span><br>
                            <span style="font-style: italic; font-size: 13px;  font-weight: bold">Fecha de impresión: </span> <span style="font-style: italic; font-size: 12px">{{$date->translatedFormat(' l j F Y')}}  </span><br>
                            </td>
                        </tr>
                        </table>
                        <div style="width: 100%; height: 0px; border-bottom:solid"></div>

                        <div>
<table style="width: 100%; margin-top:15px; text-align:center;">
    <tr style=" background:blanchedalmond; padding:6px; font-size:12px">
        <th>Imagen</th>
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
@if($producto->familia==$_GET['familia'])
    <tr style="border-bottom:solid; font-size:11px;">
    <td><img src="{{$producto->imagen}}" alt="" style="width: 40px"></td>
    <td>@if($transferencia->tipo=='salida')  bodega a exhibición
    @else De exhibición a bodega @endif</td>
    <td>{{$producto->servicio}} </td>
    <td>{{$transferencia->cantidad}}</td>
    <td>{{$transferencia->antes}}</td>
    <td>{{$transferencia->antesExhibicion}}</td>
    <td>@if($transferencia->tipo=="salida"){{$transferencia->antes-$transferencia->cantidad}}@else{{$transferencia->antes+$transferencia->cantidad}}@endif</td>
    <td>@if($transferencia->tipo=="salida"){{$transferencia->antesExhibicion+$transferencia->cantidad}}@else{{$transferencia->antesExhibicion-$transferencia->cantidad}}@endif</td>
    </tr>    
    @endif
    @endforeach
    
</table>


<p style="width: 100%; text-align:center; margin-top:30px; font-weight: bold" for="">Altas y bajas de inventario</p>
<div style="width: 100%; height: 0px; border-bottom:solid"></div>
<table style="width: 100%; text-align:center">
    <tr style=" background:blanchedalmond; padding:6px; font-size:12px">
        <th>Imagen</th>
        <th>Tipo</th>
        <th>Producto</th>
        <th>Antes</th>
        <th>Cantidad</th>
        <th>Despues</th>
    </tr>
    @foreach ($altasbajas as $accion)
    @php
        $producto = App\Inventory::where('id', $accion->producto)->first();
    @endphp
    @if($producto->familia==$_GET['familia'] || $_GET['familia']=='all')
    <tr style="font-size:12px">
    <td><img src="{{$producto->imagen}}" alt="" style="width: 40px"></td>
    <td>{{$accion->tipo}}</td>
            <td>{{$producto->servicio}}</td>
            <td>{{$accion->antes}}</td>
            <td>@if($accion->tipo=='alta')<span style="color:green">+ </span>@else <span style="color:red"> - </span>@endif{{$accion->cantidad}}</td>
            <td>@if($accion->tipo=='alta'){{$accion->antes + $accion->cantidad}}@else{{$accion->antes - $accion->cantidad}}@endif</td>
        </tr>
        @endif
    @endforeach
   
</table>

<table style="width: 100%; text-align:center; margin-top:60px">
    <tr>
        <td>__________________________________<br>Firma Responsable de bodega</td>
        <td>__________________________________<br>Firma Administrador</td>
    </tr>
    
</table>
                        </div>
    
                </div>

    <script type="text/php">
    if ( isset($pdf) ) {
        $font = "helvetica";
        $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
    }
    </script> 
</body>
</html>