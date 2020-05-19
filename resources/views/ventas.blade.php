@extends('layouts.backend')
@section('styles')
<style>
@media print {
.impre {display:none}
}
</style>
@endsection

@section('content')
    <section class="container">
            @php
            $comision = App\Commission::orderBy('id', 'DESC')->first();
            $totalventasMes = 0;
            $totalComisionesMes = 0;
        @endphp  
        <div class="row">
            <div class="col-md-7">
                <form action="{{ route('index.ventas') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input class="print" id="fecha" name="fecha" type="month" onchange="obtenerDatos()">
                    <button class="btn btn-primary" type="submit">Consultar</button>
                </form>
                <button class="btn btn-secondary" data-toggle="modal" data-target="#settingsMaster">Configurar Comisiones</button>
            </div>
        </div>
    </section>
    <section id="ventas" class="container">
        <div class="row">
            <div class="col-md-12 block">
                <div class="block-content block-content-full clearfix">
                        <p style="margin: 0; padding: 10px; background:lemonchiffon"><span style="font-weight: bold">Comision General por contrato:</span> <span style="font-style: italic">{{$comision->comisionContrato}}%</span>
                            <span style="font-weight: bold; padding-left: 20px">Minimo de venta:</span> <span style="font-style: italic">${{$comision->minimoVentaComision}}</span>
                        </p>
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>FOLIO</th>
                                <th>NOMBRE DEL CLIENTE</th>
                                <th>FECHA DEL EVENTO</th>
                                <th>IMPORTE</th>
                                <th>IMPORTE COMISIONABLE</th>
                                <th>VENDEDOR</th>
                                <th>COMISION TOTAL</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>                  
                            @foreach($contratos as $contrato)

                            @php
                            $totalComisionable = 0;
                            $arregloComisiones=[];
                            $totalComision=0;
                            $Budget = App\Budget::orderBy('id', 'DESC')->where('id', $contrato->id)->first();
                            $BudgetInventory = App\BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $contrato->id)->where('version', $contrato->version)->get();
                            $budgetPack = App\BudgetPack::orderBy('id', 'DESC')->where('budget_id', $contrato->id)->get();
                                if($contrato->total > $comision->minimoVentaComision){
                                    
                                    foreach($BudgetInventory as $element){
                                        
                                     $totalComisionable = $totalComisionable + (floatval($element->cantidad)*floatval($element->precioEspecial)) - (floatval($element->cantidad)*floatval($element->precioVenta));
                                }
                                    $totalComision= ($totalComisionable)*($comision->comisionContrato/100);
                            }
                               
                            @endphp

                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1"><span style="opacity: 0">{{$contrato->id}}<br></span>{{$contrato->folio}}</td>
                                    @php
                                        $cliente = App\Client::where('id', $contrato->client_id)->first();
                                        if($cliente->tipoPersona == 'FISICA'){
                                            $persona = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                                            $nombre= $persona->nombre.' '.$persona->apellidoPaterno.' '.$persona->apellidoMaterno;
                                        }else{
                                            $persona = App\MoralPerson::where('client_id', $cliente->id)->first();
                                            $nombre =  $persona->nombre;
                                        }
                                    @endphp
                                    <td class="">{{ $nombre}}</td>
                                    @php
                                        $fechaEvento = Carbon\Carbon::parse($contrato->fechaEvento)->locale('es');
                                    @endphp
                                    <td class="d-none d-sm-table-cell">{{ $fechaEvento->translatedFormat(' l j F Y') }}</td>
                                    @php
                                        if($contrato->opcionIVA==1){
                                            $total = $contrato->total*1.16;
                                        }else{
                                            $total = $contrato->total;
                                        }
                                        $totalventasMes = $totalventasMes+$contrato->total;
                                    @endphp     

                                    <td class="d-none d-sm-table-cell">${{$total}}<br>@if($contrato->opcionIVA==1)<span style="color:green; font-size: 10px">IVA Incluido</span>@endif</td>
                                    <td class="d-none d-sm-table-cell">$@if($totalComisionable>=$comision->minimoVentaComision){{ $totalComisionable-$comision->minimoVentaComision }}@else 0 @endif</td>
                                    <td class="d-none d-sm-table-cell">
                                        @php
                                            $vendedor = App\User::where('id', $contrato->vendedor_id)->first();
                                        @endphp
                                        {{$vendedor->name}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">$@if($totalComisionable>=$comision->minimoVentaComision){{ ($totalComisionable-$comision->minimoVentaComision)*($comision->comisionContrato/100) }}<br>
                                        <span style="font-style: italic; font-size: 10px;">Comisión: {{$comision->comisionContrato}}%</span>@else 0 @endif
                                    
                                    </td>
                                    @php
                                    if($totalComisionable>=$comision->minimoVentaComision){
                                        $totalComisionesMes = $totalComisionesMes+(($totalComisionable-$comision->minimoVentaComision)*($comision->comisionContrato/100));
                                    }
                                    @endphp
                                    <td class="text-center">
                                        <a href="{{ route('ver.presupuesto', $contrato->id) }}" 
                                            target="_blank"
                                            type="button" 
                                            class="btn btn-sm btn-secondary js-tooltip-enabled" 
                                            data-toggle="tooltip" title="Ver Lista de eventos" 
                                            data-original-title="View Customer"
                                            >
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="background: ghostwhite"><span>Total ventas del mes</span><br>
                                <span style="font-size: 9px; font-style: italic;">Sin IVA</span></td>
                            <td style="font-weight: bold">${{number_format($totalventasMes,2)}}</td>
                            <td></td>
                            <td style="background: ghostwhite"><span>Total comisiones del mes</span><br></td>
                            <td style="font-weight: bold">${{number_format($totalComisionesMes,2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section class="container mt-4">
        <div class="row">
            <div class="col-md-12 block">
                <div class="block-content block-content-full clearfix">
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

                                        $contratosDelMes = App\Budget::orderBy('id', 'DESC')->where('tipo', 'CONTRATO')
                                            ->whereYear('fechaEvento', $anoHoy)
                                            ->whereMonth('fechaEvento', $contador)
                                            ->get();
                                    @endphp
                                    <th>
                                        @php
                                        $totaldelmes=0;
                                            foreach($contratosDelMes as $contratoDelMes){
                                                if($contratoDelMes->opcionIVA==1){
                                                $totaldelmes=$totaldelmes+($contratoDelMes->total);}
                                                else{
                                                    $totaldelmes=$totaldelmes+($contratoDelMes->total);
                                                }
                                            }
                                        @endphp
                                        ${{ number_format($totaldelmes,2) }}</th>
                                    @php

                                        $fechaPasada = $fechaHoy->subYears(1);
                                        $fechaPasadaEntera = strtotime($fechaPasada);
                                        $anoPasado = date("Y", $fechaPasadaEntera);

                                        $contratosDelMesPasados = App\Budget::orderBy('id', 'DESC')
                                            ->whereYear('fechaEvento', $anoPasado)
                                            ->whereMonth('fechaEvento', $contador)
                                            ->get();
                                    @endphp
                                     @php
                                     $totaldelmesPasado=0;
                                         foreach($contratosDelMesPasados as $contratoDelMesPasado){
                                             if($contratoDelMesPasado->opcionIVA==1){
                                             $totaldelmesPasado=$totaldelmesPasado+($contratoDelMesPasado->total);}
                                             else{
                                                 $totaldelmesPasado=$totaldelmesPasado+($contratoDelMesPasado->total);
                                             }
                                         }
                                     @endphp
                                    <th>${{ number_format($totaldelmesPasado,2) }}</th>
                                    <th>${{ number_format($totaldelmes - $totaldelmesPasado,2) }}</th>
                                    @php
                                        if(count($contratosDelMesPasados) != 0){
                                            $numero = $totaldelmes / $totaldelmesPasado;
                                            $porcentaje = round($numero*100);
                                        }else if(count($contratosDelMesPasados) == 0 && count($contratosDelMes) == 0){
                                            $porcentaje = 0;
                                        }else if(count($contratosDelMesPasados) == 0 && count($contratosDelMes) != 0){
                                            $porcentaje = 100;
                                        }
                                        
                                    @endphp
                                    <th style="
                                        @if($porcentaje >= 100)
                                            color: green;
                                        @else
                                            color: red;
                                        @endif
                                        
                                    ">{{ $porcentaje }}%</th>
                                </tr>
                                @php
                                    $contador++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('pdf.ventas') }}" target="_blank" class="btn btn-sm btn-success">Imprimir detalles de facturacion</a>
    </section>
    @include('../modals/settingsMaster')
@endsection

@section('scripts')
    <script>
        
    </script>
@endsection