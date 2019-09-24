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
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('index.ventas') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input class="print" id="fecha" name="fecha" type="month" onchange="obtenerDatos()">
                    <button class="btn btn-primary" type="submit">Enviar</button>
                </form>
                
            </div>
            <div class="col-md-3"><button class="btn btn-primary"><i class="si si-printer"></i>Imprimir</button></div>
        </div>
    </section>
    <section class="container">
        <div class="row">
            <div class="col-md-12 block">
                <div class="block-content block-content-full clearfix">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
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
@endsection

@section('scripts')
    <script>
        function obtenerDatos(){
            let fecha = document.getElementById('fecha').value;

            axios.get()
        }
    </script>
@endsection