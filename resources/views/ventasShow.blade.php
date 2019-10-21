@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Mostrando presupuestos y contratos de: {{ $persona->nombre }} {{ $persona->apellidoPaterno }}</h3>
            </div>
            <div class="block col-md-12 p-3">
                <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                    <thead>
                        <tr role="row">
                            <th>Folio</th>
                            <th>Fecha Evento</th>
                            <th>Tipo</th>
                            <th>Vendedor</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>                                   
                        @foreach ($presupuestos as $presupuesto)
                            <tr role="row" class="odd">                                
                                <td class="d-none d-sm-table-cell">
                                    {{ $presupuesto->folio }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $presupuesto->fechaEvento }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $presupuesto->tipo }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $presupuesto->user->name }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $presupuesto->total }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('ver.presupuesto', $presupuesto->id) }}" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach   
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection