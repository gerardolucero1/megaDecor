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
@php
    $deudaTotal=0;
 
@endphp
    <section class="container">
        <div class="content" id="PresupuestosHistorial">
            
            <div class="block" id="divLista">
                <div class="block-header block-header-default" style="background:#FCFFA9; display:none">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color: green; font-weight: bold">Contratos con pago vencido</h3>
                    <h3 class="block-title" style="color:black; font-weight: bold">Adeudo total ${{number_format(($adeudoTotal-1531),2)}}</h3> <a href="{{route('imprimir.creditosAtrasados')}}" class="btn btn-primary">Imprimir</a>
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
                                <th>Teléfono</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contratos as $budgetArchivados) 
                                @php
                                $telefonoCliente = '';
                                $banIva =1;
                                if($budgetArchivados->opcionIVA){
                                    $banIva =1.16;
                                }else{
                                    $banIva =1;
                                }
                                @endphp
                                
                       @if((($budgetArchivados->total*$banIva) - $budgetArchivados->saldoPendiente) > 0 )
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
                                           $telefonoCliente = $clienteFisico->telefono;

                                        }else{
                                            $clienteMoral = App\MoralPerson::where('client_id', $budgetArchivados->client_id)->first();
                                            $clienteNombre = $clienteMoral->nombre;
                                            $telefonoCliente = $clienteMoral->telefono;
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
                                    @php
                                    $deudaTotal=$deudaTotal+(($budgetArchivados->total*1.16)-$budgetArchivados->saldoPendiente);
                                    @endphp
                                    <td class="d-none d-sm-table-cell">${{number_format(($budgetArchivados->total*1.16)-$budgetArchivados->saldoPendiente,2)}}</td>
                                    @else  
                                    @php
                                    $deudaTotal=$deudaTotal+($budgetArchivados->total-$budgetArchivados->saldoPendiente);
                                    @endphp
                                    <td class="d-none d-sm-table-cell">${{number_format($budgetArchivados->total-$budgetArchivados->saldoPendiente,2)}}</td>
                                    @endif



                                    <td>
                                        @php
                                            $telefono = App\Telephone::where('client_id', $budgetArchivados->client_id)->first();
                                            if (isset($telefono->numero)) {
                                            echo $telefono->numero;
                                            }else{
                                                echo $telefonoCliente;
                                            }

                                        @endphp
                                    </td>
                                            <td class="d-flex" style="box-sizing: content-box;">
                                               
                                                <a  target="_blank"  href="{{ route('ver.presupuesto', $budgetArchivados->id) }}" style="margin-right:4px;"   class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver presupuesto" data-original-title="View Customer">
                                                    <i class="fa fa-eye"></i> 
                                                </a>

                                                <a style="margin-right:4px;" onclick="archivarPresupuesto({{$budgetArchivados->id}})" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Restaurar" data-original-title="View Customer">
                                                    <i style="color: white" class="si si-trash"></i> 
                                                </a>
                                                
                                                
                                            </td>
                                        </tr>
                                     @endif
                                    @endforeach
                            </tbody>
                        </table>
                        <div style="position: fixed; z-index: 20; padding: 15px; border:solid; border-width: 1px; background:#fcffa9; top:30px; ">
                            <span style="font-weight: bold">Monto Total: ${{number_format($deudaTotal,2)}} </span>
                            <a href="{{route('imprimir.creditosAtrasados')}}" class="btn btn-primary">Imprimir PDF</a>
                            <span>Saldo Incobrable: $0.00</span>
                            <a href="/creditos-atrasados2" class="btn btn-primary">Creditos Incobrables</a>
                        </div>
                    </div>
                </div>
            </div>
       
        </div>
    </section>
@endsection
@section("scripts")
<script>

function archivarPresupuesto(id){
        //alert(id);
        let motivo = prompt('Teclea "VETAR" para confirmar')
        let URL = '/budget-archivar-vetar/'  + id+'-'+motivo;
        if(motivo == 'VETAR'){
        axios.get(URL).then((response) => {
                    Swal.fire(
                            'Cliente vetado',
                            'Presupuesto archivado y cliente vetado',
                            'success'
                        ); 
                        location.reload();
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                            'Error!',
                            'A ocurrido un error al eliminar',
                            'Danger'
                        ); 
                })
            }else{
                Swal.fire(
                            'Cancelado',
                            'Se cancelo la accion de vetar al cliente o no se ingreso la confirmacion correctamente',
                            'error'
                        ); 
            }

    }
</script>

@endsection


