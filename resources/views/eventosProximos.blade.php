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
            <div class="block" id="divLista">
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Presupuestos Activos</h3>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Foto</th>
                                    <th>Servicio</th>
                                    <th class="d-none d-sm-table-cell">Cantidad</th>
                                    <th class="d-none d-sm-table-cell">Contrato</th>
                                    <th class="d-none d-sm-table-cell">Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contratos as $contrato)
                                    @foreach($contrato->inventories as $inventario)
                                        <tr>
                                            <td>
                                                <img src="{{ $inventario->imagen }}" width="100px">
                                            </td>
                                            <td>{{ $inventario->servicio }}</td>
                                            <td>{{ $inventario->cantidad }}</td>
                                            <td>{{ $inventario->budget->folio }}</td>
                                            <td>{{ $inventario->budget->client->nombreCliente }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($contrato->budgetPacks as $pack)
                                        @foreach($pack->inventories as $inventario)
                                            <tr>
                                                <td>
                                                    <img src="{{ $inventario->imagen }}" width="100px">
                                                </td>
                                                <td>{{ $inventario->servicio }}</td>
                                                <td>{{ $inventario->cantidad }}</td>
                                                <td>{{ $contrato->folio }}</td>
                                                <td>{{ $contrato->client->nombreCliente }}</td>
                                            </tr>
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


