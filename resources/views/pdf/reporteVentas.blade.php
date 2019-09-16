<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
        <thead>
            <tr role="row">
                <th>MES</th>
                <th>#VENTAS</th>
                <th>#VENTAS AÑO PASADO</th>
                <th>DIFERENCIA</th>
                <th>% DE VENTAS</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;

                $meses = array('enero','febrero','marzo','abril','mayo','junio','julio',
'agosto','septiembre','octubre','noviembre','diciembre');
                $contador = 1;

                
                
            @endphp                    
            @foreach ($meses as $mes)
                <tr>
                    <th>{{ $mes }}</th>
                    @php
                        $fechaHoy = Carbon::now();
                        $fechaHoyEntera = strtotime($fechaHoy);
                        $anoHoy = date("Y", $fechaHoyEntera);

                        $contratosDelMes = App\Budget::orderBy('id', 'DESC')
                            ->whereYear('fechaEvento', $anoHoy)
                            ->whereMonth('fechaEvento', $contador)
                            ->get();
                    @endphp
                    <th>{{ count($contratosDelMes) }}</th>
                    @php

                        $fechaPasada = $fechaHoy->subYears(1);
                        $fechaPasadaEntera = strtotime($fechaPasada);
                        $anoPasado = date("Y", $fechaPasadaEntera);

                        $contratosDelMesPasados = App\Budget::orderBy('id', 'DESC')
                            ->whereYear('fechaEvento', $anoPasado)
                            ->whereMonth('fechaEvento', $contador)
                            ->get();
                    @endphp
                    <th>{{ count($contratosDelMesPasados) }}</th>
                    <th>{{ count($contratosDelMes) - count($contratosDelMesPasados) }}</th>
                    @php
                        if(count($contratosDelMesPasados) != 0){
                            $numero = count($contratosDelMes)/count($contratosDelMesPasados);
                            $porcentaje = round($numero*100);
                        }else if(count($contratosDelMesPasados) == 0 && count($contratosDelMes) == 0){
                            $porcentaje = 0;
                        }else if(count($contratosDelMesPasados) == 0 && count($contratosDelMes) != 0){
                            $porcentaje = 100;
                        }
                        
                    @endphp
                    <th>{{ $porcentaje }}%</th>
                </tr>
                @php
                    $contador++;
                @endphp
            @endforeach
        </tbody>
    </table>

    <!-- VENTAS MES -->
    <table  style="font-size: 11px; margin-top: 50px;">
        <thead>
            <tr role="row">
                <th>FOLIO</th>
                <th>NOMBRE DEL CLIENTE</th>
                <th>FECHA DEL EVENTO</th>
                <th>IMPORTE</th>
                <th>VENDEDOR</th>
                <th>COMISION POR VENTA</th>
                <th>OPCIONES</th>
            </tr>
        </thead>
        <tbody>                    
            @foreach($contratos as $contrato)
                <tr role="row" class="odd">
                    <td class="text-center sorting_1">{{ $contrato->folio}}</td>
                    @php
                        $cliente = App\Client::where('id', $contrato->client_id)->first();
                        if($cliente->tipoPersona == 'FISICA'){
                            $persona = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                        }else{
                            $persona = App\MoralPerson::where('client_id', $cliente->id)->first();
                        }
                    @endphp
                    <td class="">{{ $persona->nombre}}</td>
                    <td class="d-none d-sm-table-cell">{{ $contrato->fechaEvento }}</td>
                    <td class="d-none d-sm-table-cell">${{ $contrato->total}}</td>
                    <td class="d-none d-sm-table-cell">{{ $contrato->user->name }}</td>
                    <td class="d-none d-sm-table-cell">{{ $contrato->comision }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Lista de eventos" data-original-title="View Customer">
                            <i class="fa fa-list-ul"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>