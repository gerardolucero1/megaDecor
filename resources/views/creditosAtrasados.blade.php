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
        <div class="content" id="PresupuestosHistorial">
            
            <div class="block" id="divLista">
                <div class="block-header block-header-default" style="background:#FCFFA9">
                    <div class="col-md-3">
                    <h3 class="block-title" style="color:black; font-weight: bold">Adeudo total ${{number_format($adeudoTotal,2)}}</h3>
                    </div>
                </div>
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Eventos con pago vencido</h3>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosHistorial" role="grid" >
                            <thead>
                                <tr role="row">
                                <th>#Folio</th>
                                <th>Fecha Evento</th>
                                <th>Fecha Limite de pago</th>
                                <th>Dias de credito</th>
                                <th>Dias de atraso</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Saldo Pendiente</th>
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
                                        
                                            @php
                                                 

                                                $fechaEvento = Carbon\Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
                                                $fechaLimite = Carbon\Carbon::parse($budgetArchivados->fechaLimite)->locale('es');

                                                $date = $budgetArchivados->fechaEvento." 11:00:00";
                                                $datework = Carbon\Carbon::createFromDate($date);
                                                $now = Carbon\Carbon::now();
                                                $testdate = $datework->diffInDays($now);
                                             
                                            @endphp
                                            <td class=""><span style="display: none">{{$budgetArchivados->fechaEvento}}</span><br>{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                    <td class="d-none d-sm-table-cell"> @if($budgetArchivados->diasCredito>0){{$fechaLimite->translatedFormat(' l j F Y')}}@else {{$fechaEvento->translatedFormat(' l j F Y')}}@endif<br>
                                       
                                            <td>{{$budgetArchivados->diasCredito}}</td>
                                            <td>{{$testdate}}</td>
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
                                            @php
                                            if($budgetArchivados->opcionIVA == 1){
                                                $total = $budgetArchivados->total + ($budgetArchivados->total * 0.16);
                                            }else{
                                                $total = $budgetArchivados->total;
                                                
                                            }
                                            $total=number_format($total,2);
                                            //saldo pendiente
                                            
                                        @endphp
                                    <td>
                                        ${{$total}}
                                        @if ($budgetArchivados->opcionIVA == 1)
                                            <br>
                                            <span style="font-size: 10px; color: green;">IVA</span>
                                        @endif
                                    </td>
                                    @if($budgetArchivados->opcionIVA == 1)
                                    <td class="d-none d-sm-table-cell">${{number_format(($budgetArchivados->total*1.16)-$budgetArchivados->saldoPendiente,2)}}</td>
                                    @else  
                                    <td class="d-none d-sm-table-cell">${{number_format($budgetArchivados->total-$budgetArchivados->saldoPendiente,2)}}</td>
                                    @endif
                                            <td class="d-flex" style="box-sizing: content-box;">
                                               
                                                <a  target="_blank"  href="{{ route('ver.presupuesto', $budgetArchivados->id) }}" style="margin-right:4px;"   class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver presupuesto" data-original-title="View Customer">
                                                    <i class="fa fa-eye"></i> 
                                                </a>

                                                <a href="{{route('presupuesto.archivar', $budgetArchivados->id)}}" style="margin-right:4px;" onclick="archivarPresupuesto()" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Presupuesto" data-original-title="View Customer">
                                                    <i class="si si-trash"></i> 
                                                </a>
                                                
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


