<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Programación de recolecciones</title>
</head>
@php
    $date = Carbon\Carbon::now();
    $desde = $fechaEvento = Carbon\Carbon::parse($fecha1)->locale('es');
    $hasta = $fechaEvento = Carbon\Carbon::parse($fecha2)->locale('es');
@endphp
<body style="font-family: Arial, Helvetica, sans-serif" style="border:solid;">
        <div style="width: 100%;">
        <p style="font-size:30px; font-weight:bold; text-aling:right; width: 100%;">Fecha de consulta: {{$desde->translatedFormat(' l j F Y')}} - {{$hasta->translatedFormat(' l j F Y')}}</p>
        <table style="width: 100%">
            <tr style="text-align:center">
                <th>Folio</th>
                <th>Fecha Evento</th>
                <th>Hora de inicio</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Versión</th>
                <th>Recolección</th>
                @if($tipoImpresion != 'RECOLECCION')
                <th>Saldo</th>
                @endif
                @if($tipoImpresion == 'RECOLECCION')
                <th>Teléfono</th>
                @endif
            </tr>
            @if($tipoImpresion != 'RECOLECCION')
            @foreach ($presupuestos as $presupuesto)
            
            <tr style="border:solid; text-align: center">
            <td style="padding: 5px;">{{$presupuesto->folio}}</td>
            @php
                 $fechaEvento = Carbon\Carbon::parse($presupuesto->fechaEvento)->locale('es');
            @endphp
            <td style="width: 150px">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
            <td>{{$presupuesto->horaEventoInicio}} {{$presupuesto->inicioAmPm}}</td>
            <td>
@php
    $cliente = App\Client::where('id', $presupuesto->client_id)->first();
    if($cliente->tipoPersona=='FISICA'){
        $datosCliente = App\PhysicalPerson::where('client_id', $cliente->id)->first();
        $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
    }else{
        $nombreCliente =  $cliente->nombreCliente;
    }
@endphp
<p style="font-size: 10px">
{{$nombreCliente}}</p>

            </td>
            <td>
            @php
                $vendedor = App\User::where('id', $presupuesto->vendedor_id)->first();
            @endphp
           <p style="font-size: 10px"> {{$vendedor->name}}</p>
            </td>
            <td>{{$presupuesto->version}}</td>
            <td>
                @if($presupuesto->entregaEnBodega)
                Entrega en bodega
                @else
                Recolección
                @endif
                </td>
                @php
                    $totalPagos=0;
                        $pagos = App\Payment::where('budget_id', $presupuesto->id)->get();
                    @endphp
                    @foreach ($pagos as $pago)
                        @php
                            $totalPagos = $totalPagos+$pago->amount;
                        @endphp
                    @endforeach
                    @if($tipoImpresion != 'RECOLECCION')
                <td >
                    @if ($presupuesto->opcionIVA)
                    ${{number_format(($presupuesto->total*1.16)-$totalPagos,2)}}
                    @else
                    ${{number_format(($presupuesto->total)-$totalPagos,2)}}
                    @endif
                    
                </td>
                @endif
                @if($tipoImpresion == 'RECOLECCION')
                <td >
                   telefono
                    
                </td>
                @endif
            </tr>
            @endforeach
            @else
            @foreach ($presupuestos as $presupuesto)
            @if($presupuesto->entregaEnBodega)
            @else
            <tr style="border:solid; text-align: center">
                <td style="padding: 5px;">{{$presupuesto->folio}}</td>
                @php
                     $fechaEvento = Carbon\Carbon::parse($presupuesto->fechaEvento)->locale('es');
                @endphp
                <td style="width: 150px">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                <td>{{$presupuesto->horaEventoInicio}} {{$presupuesto->inicioAmPm}}</td>
                <td>
    @php
        $cliente = App\Client::where('id', $presupuesto->client_id)->first();
        if($cliente->tipoPersona=='FISICA'){
            $datosCliente = App\PhysicalPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
        }else{
            $nombreCliente =  $cliente->nombreCliente;
        }
    @endphp
    <p style="font-size: 10px">
    {{$nombreCliente}}</p>
    
                </td>
                <td>
                @php
                    $vendedor = App\User::where('id', $presupuesto->vendedor_id)->first();
                @endphp
               <p style="font-size: 10px"> {{$vendedor->name}}</p>
                </td>
                <td>{{$presupuesto->version}}</td>
                <td>
                    @if($presupuesto->entregaEnBodega)
                    Entrega en bodega
                    @else
                    Recolección
                    @endif
                    </td>
                    @php
                        $totalPagos=0;
                            $pagos = App\Payment::where('budget_id', $presupuesto->id)->get();
                        @endphp
                        @foreach ($pagos as $pago)
                            @php
                                $totalPagos = $totalPagos+$pago->amount;
                            @endphp
                        @endforeach
                        @if($tipoImpresion != 'RECOLECCION')
                    <td >
                        @if ($presupuesto->opcionIVA)
                        ${{number_format(($presupuesto->total*1.16)-$totalPagos,2)}}
                        @else
                        ${{number_format(($presupuesto->total)-$totalPagos,2)}}
                        @endif
                        
                    </td>
                    @endif
                    @if($tipoImpresion == 'RECOLECCION')
                    <td >
                       telefono
                        
                    </td>
                    @endif

                </tr>
                @endif
            @endforeach
            @endif
            
            
        </table>
       <div>

        <script type="text/php">
            if ( isset($pdf) ) {
                $font = "helvetica";
                $pdf->page_text(770, 567, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font , 5, array(0,0,0));
            }
            </script> 
</body>
</html>