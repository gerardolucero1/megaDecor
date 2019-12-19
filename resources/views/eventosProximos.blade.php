@extends('layouts.backend')

@section('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <style>
        table.dataTable td{
        box-sizing: inherit;
        }
    </style>

@endsection

@section('content')
    <section class="container">
        <div class="content" id="PresupuestosActivos">
            <div class="row">
                <div class="col-md-3">
                    <form action="{{ route('buscarProximos') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input name="fecha" class="form-control" type="date">
                        <button type="submit" class="btn btn-block btn-info mt-2">Buscar</button>
                    </form>
                    <button class="btn btn-block btn-info mt-2" onclick="window.print()">Imprimir</button>
                </div>
            </div>
            <div class="block" id="divLista">
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Eventos proximos</h3>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Foto</th>
                                    <th>Servicio</th>
                                    <th class="d-none d-sm-table-cell">Cantidad</th>
                                    <th class="d-none d-sm-table-cell">Notas</th>
                                    <th class="d-none d-sm-table-cell">Contrato</th>
                                    <th class="d-none d-sm-table-cell">Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $servicioAnt='';
                                    $banderas=[];
                                @endphp
                                @foreach($contratos as $contrato)
                                    @foreach($contrato->inventories as $inventario)
                                    @if($inventario->servicio!='FLETE DIVERSO')
                                    @if($inventario->version == $contrato->version)
                                        <tr>
                                            <td>
                                                <img src="{{ $inventario->imagen }}" width="80px">
                                            </td>
                                            <td>{{ $inventario->servicio }}</td>
                                            <td>{{ $inventario->cantidad }}</td>
                                            <td>{{ $inventario->notas }}</td>
                                            <td>{{ $inventario->budget->folio }}</td>
                                            <td>{{ $inventario->budget->client->nombreCliente }}</td>
                                        </tr>
                                        @foreach ($cantidadesTotales as $totales)
                                    @if($totales->servicio==$inventario->servicio)
                                    @if(in_array($totales->servicio, $banderas))@else
                                    <tr style="background: #FFD5C8">
                                        <td>TOTAL:</td>
                                        <td>{{$totales->servicio}}<span style="opacity: 0">z</span></td>
                                        <td>{{$totales->total}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @php
                                        array_push($banderas,$totales->servicio);
                                    @endphp
                                    @endif
                                    @endif
                                    @endforeach
                                        @php
                                        $servicioAnt=$inventario->servicio;
                                    @endphp
                                        @endif
                                        @endif
                                    @endforeach
                                   
                                    @foreach($contrato->budgetPacks as $pack)
                                        @foreach($pack->inventories as $inventario)
                                        @if($inventario->servicio!='FLETE DIVERSO')
                                        @if($inventario->version == $contrato->version)
                                            <tr>
                                                <td>
                                                    <img src="{{ $inventario->imagen }}" width="80px">
                                                </td>
                                                <td>{{ $inventario->servicio }}</td>
                                                <td>{{ $inventario->cantidad }}</td>
                                                <td>{{ $inventario->notas }}</td>
                                                <td>{{ $contrato->folio }}</td>
                                                <td>{{ $contrato->client->nombreCliente }}</td>
                                            </tr>
                                            @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


