@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="row">
            <div class="block col-md-12">
                <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaCortes" role="grid" >
                    <thead>
                        <tr role="row">
                            <th>Fecha apertura</th>
                            <th>Hora apertura</th>
                            <th>Hora cierre</th>
                            <th>Vendedor</th>
                            <th>Cantidad cierre</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>      
                            @php
                            use Carbon\Carbon;
                        @endphp                            
                        @foreach ($cortes as $corte)
                            <tr role="row" class="odd">                                
                                <td class="d-none d-sm-table-cell">
                                        @php
                                        $fechaCorte = Carbon::parse($corte->fechaApertura)->locale('es');
                                    @endphp 
                                    <span style="opacity:0">{{ $corte->fechaApertura}}</span>
                                    {{ $fechaCorte->translatedFormat(' l j F Y') }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $corte->horaApertura }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $corte->horaCierre }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                    {{ $corte->user->name }}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">
                                   $ {{ $corte->cantidadRealCierre}}
                                </td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Show">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <a href="{{ route('contabilidad.pdf', $corte->id) }}" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Print">
                                            <i class="fa fa-print"></i>
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