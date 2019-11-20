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
                        <h3 class="block-title" style="color:green">Eventos atrasados</h3>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>#Folio</th>
                                <th>Fecha Evento</th>
                                <th>Cliente</th>
                                <th>Lugar</th>
                                <th>Vendedor</th>
                                <th>Version</th>
                                <th>Última Modificación</th>
                                <th>Total</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contratos as $budgetArchivados)                          
                                    <tr role="row" class="odd">
                                        <td class="text-center sorting_1">{{$budgetArchivados->folio}}
                                                <span>
                                                        @if ($budgetArchivados->pagado)
                                                            <i class="fa fa-check" data-toggle="tooltip" title="Contrato pagado"></i> 
                                                        @endif
                                                    </span>
                                        </td>
                                        @if (is_null($budgetArchivados->pendienteFecha))
                                            @php
                                                $fechaEvento = Carbon\Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
                                            @endphp
                                            <td class="">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                        @else
                                            <td class="">{{$budgetArchivados->fechaEvento}}</td>
                                        @endif
                                        @php
                                        $cliente = App\Client::where('id', $budgetArchivados->client_id)->first();

                                        if($cliente->tipoPersona == "FISICA"){
                                            $clienteFisico = App\PhysicalPerson::where('client_id', $budgetArchivados->client_id)->first();
                                            $clienteNombre = $clienteFisico->nombre.' '.$clienteFisico->apellidoPaterno.' '.$clienteFisico->apellidoMaterno;
                                           // $clienteCompleto = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                                           
                                        }else{
                                            $clienteMoral = App\MoralPerson::where('client_id', $budgetArchivados->client_id)->first();
                                            $clienteNombre = $clienteMoral->nombre;
                                        }
                                    @endphp
                                            <td class="d-none d-sm-table-cell">{{$clienteNombre}}</td>
                                            <td class="d-none d-sm-table-cell">{{$budgetArchivados->user->name}}</td>
                                            <td class="d-none d-sm-table-cell text-center">
                                                @if($budgetArchivados->version>1)
                                                    <i data-toggle="tooltip" title="Nueva Versión" class="fa fa-star" style="font-size: 8px; color:red"></i>
                                                @endif
                                                {{$budgetArchivados->version}}
                                            </td>
                                            <td class="d-none d-sm-table-cell text-center d-flex" style="font-size:14px;">
                                                <a target="_blank" href="{{route('imprimir.budget', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresion==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresion==1) title="Se Imprimió este presupuesto {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                                <a href=""><i class="fa fa-send-o" style="@if($budgetArchivados->enviado==1) color:green; @else color:#3f9ce8 @endif"  data-toggle="tooltip" @if($budgetArchivados->enviado==1) title="Presupuesto enviado al cliente"  @else title="Aun no se envia al cliente" @endif></i></a>
                                                <a target="_blank" href="{{route('imprimir.budgetBodega', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                            </td>
                                            <td class="d-none d-sm-table-cell">{{$budgetArchivados->updated_at}}<br>
                                                @if($budgetArchivados->version>1)por: Ivonne Arroyos @endif
                                            </td>
                                                @php
                                                    if($budgetArchivados->opcionIVA == 1){
                                                        $total = $budgetArchivados->total + ($budgetArchivados->total * 0.16);
                                                    }else{
                                                        $total = $budgetArchivados->total;
                                                    }
                                                    $total=number_format($total,2);
                                                @endphp
                                            <td>
                                                ${{$total}}
                                                @if ($budgetArchivados->opcionIVA == 1)
                                                    <br>
                                                    <span style="font-size: 10px; color: green;">IVA</span>
                                                @endif
                                            </td>
                                            <td class="d-flex" style="box-sizing: content-box;">
                                                <a  target="_blank"  href="{{ route('editar.presupuesto', $budgetArchivados->id) }}" disabled style="margin-right:4px;" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Este presupuesto es pasado" data-original-title="Editar Presupuesto">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a  target="_blank"  href="{{ route('ver.presupuesto', $budgetArchivados->id) }}" style="margin-right:4px;"   class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver presupuesto" data-original-title="View Customer">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                <button data-id="{{ $budgetArchivados->id }}" style="margin-right:4px;" class="btn btn-sm btn-primary danados" data-toggle="modal" data-target="#productosDanados">
                                                    <i data-id="{{ $budgetArchivados->id }}" class="fa fa-chain-broken"></i> 
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


