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
    <section class="container-fluid">
            @php
            $usuario = Auth::user()->id; 
            $permisos = App\Permission::where('user_id', $usuario)->first();   
        @endphp
        <div class="row">
            <div id="divCalendario" style="display:none" class="col-md-12">
                <div class="block">
                    <div class="block-content block-content-full text-right">
                            <button style="margin-bottom: 15px;" class="btn btn-primary" onclick="vista_lista()">
                                <i class="fa fa-list"></i> <i>Vista Lista</i> 
                            </button>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content" id="PresupuestosActivos">
                <div class="block" id="divLista">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Contratos Activos</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        @php
                            $usuario = Auth::user()->id;    
                        @endphp 
                        
                        @if($permisos->contratosCrearContrato==1)
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                <i class="fa fa-calendar-plus-o"></i> <i>Crear Contrato</i> 
                            </button>
                        @endif
                        @if($permisos->contratosVistaCalendario==1)
                            <button style="display: none" class="btn btn-primary"  onclick="vista_calendario()">
                                <i class="fa fa-calendar"></i> <i>Vista Calendario</i> 
                            </button>
                        @endif
                        @if($permisos->contratosHistorial==1)
                            <button onclick="PresupuestosHistorial()" class="btn btn-info">
                                <i class="fa fa-calendar-minus-o"></i> <i>Historial</i> 
                            </button>
                        @endif
                        @if($permisos->contratosArchivados==1)
                        <button onclick="presupuestosArchivados()" class="btn btn-secondary">
                            <i class="fa fa-trash"></i> <i>Contratos Eliminados</i> 
                        </button>
                    @endif
                   
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    @if($permisos->contratosFolio==1)
                                    <th>Folio</th>@endif
                                    @if($permisos->contratosFecha==1)
                                    <th>Fecha Evento</th>@endif
                                    @if($permisos->contratosCliente==1)
                                    <th class="d-none d-sm-table-cell">Cliente</th>@endif
                                    @if($permisos->contratosVendedor==1)
                                    <th class="d-none d-sm-table-cell">Vendedor</th>@endif
                                    @if($permisos->contratosVersion==1)
                                    <th class="d-none d-sm-table-cell">Version</th>@endif
                                    <th class="d-none d-sm-table-cell">Etiquetas</th>
                                    @if($permisos->contratosUltimaModificacion==1)
                                     <th class="d-none d-sm-table-cell">Ultima Modificación</th>@endif
                                     @if($permisos->contratosTotal==1)
                                     <th class="d-none d-sm-table-cell">Total</th>@endif
                                     <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>           
                            @php
                                use Carbon\Carbon;
                            @endphp         
                            @if (!is_null($Presupuestos))
                            @foreach ($Presupuestos as $budget)                          
                            <tr role="row" class="odd" style="@if($budget->impresionBodega==2) background:#F9F7BF;@endif">
                                    @if($permisos->contratosFolio==1)
                                <td class="text-center sorting_1"><span style="display:none; font-size:2px;">{{$budget->id}}</span><br>{{$budget->folio}} 
                                    <span>
                                        @if ($budget->pagado)
                                            <i class="fa fa-check" data-toggle="tooltip" title="Contrato pagado"></i> 
                                        @endif
                                    </span>
                                </td>@endif
                                @if($permisos->contratosFecha==1)
                                @if ($budget->pendienteFecha!=1)
                                    @php
                                        $fechaEvento = Carbon::parse($budget->fechaEvento)->locale('es');
                                    @endphp
                                    <td class="">
                                        <span style="display:none; font-size:2px;">{{$fechaEvento}}</span>
                                        <br>
                                        {{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                    @else
                                    <td class="">Pendiente</td>
                                @endif
                                @endif
                                @if($permisos->contratosCliente==1)
                                <td class="d-none d-sm-table-cell">{{$budget->cliente}}</td>@endif
                                @if($permisos->contratosVendedor==1)
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">{{$budget->vendedor}}</td>@endif
                                @if($permisos->contratosVersion==1)
                                <td class="d-none d-sm-table-cell text-center">
                                        @if($budget->version>1)<i data-toggle="tooltip" title="Nueva Versión" class="fa fa-star" style="font-size: 8px; color:red"></i>@endif
                                    {{$budget->version}}
                                </td>
                                @endif
                            <td class="d-none d-sm-table-cell text-center" style="font-size:14px;">
                                    @if($permisos->contratosImpresionCliente==1)
                                    <a target="_blank" href="{{route('imprimir.budget', $budget->id)}}">
                                        <i class="si si-printer" style="margin-right:8px; @if($budget->impresion==1) color:green; @endif"  data-toggle="tooltip" @if($budget->impresion==1) title="Se Imprimió este contrato {{$budget->updated_at}}"  @else title="Aun no se imprime contrato cliente" @endif></i>
                                    </a>@endif
                                    @if($permisos->contratosEnviarCorreo==1)
                                    <i onclick="enviarCorreoCliente({{$budget->id}}, '{{$budget->email}}')" class="fa fa-send-o" style="@if($budget->enviado==1) color:green; @else color:#3f9ce8 @endif"  data-toggle="tooltip" @if($budget->enviado==1) title="Contrato enviado al cliente"  @else title="Aun no se envia al cliente {{$budget->email}}" @endif></i>   
                                 @endif
                                 @if($permisos->contratosImprimirBodega==1)
                                <a style="display:none" target="_blank" href="{{route('imprimir.budgetBodegaCliente', $budget->id)}}">
                                    <i class="si si-printer" style="margin-right:8px; @if($budget->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budget->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budget->updated_at}}"  @else title="Aun no se imprime bodega" @endif></i>
                                </a>
                                <a target="_blank" href="{{route('imprimir.budgetBodegaCliente', $budget->id)}}">
                                        <i class="si si-printer" style="margin-right:8px; @if($budget->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budget->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budget->updated_at}}"  @else title="Aun no se imprime bodega" @endif></i>
                                    </a>
                                    @endif
                            </td>
                            @if($permisos->contratosUltimaModificacion==1)
                                <td class="d-none d-sm-table-cell">{{$budget->updated_at}}<br>
                                @if($budget->version>1)por: Ivonne Arroyos @endif
                                </td>
                                @endif
                                
                                @if($permisos->contratosTotal==1)
                                @php
                                    $total=number_format($budget->total,2);
                                @endphp
                                <td  class="d-none d-sm-table-cell">
                                        ${{$total}}
                                    @if ($budget->IVA)
                                    <br>
                                        <span style="font-size: 10px; color: green;">IVA incluido</span>
                                    @endif<br>
                                    Saldo: 
                                    @php
                                        $abono=0;
                                        $pagos = App\Payment::where('budget_id', $budget->id)->get();
                                        $saldoPendiente = $budget->total;
                                    
                                        if(count($pagos)>0){
                                        foreach ($pagos as $pago) {
                                            if($pago->method=='DOLAR'){
                                                $abono = $abono + ($pago->amount*$pago->reference);
                                            }else{
                                                $abono = $abono + $pago->amount;}
                                        }
                                        $saldoPendiente = $budget->total-$abono;
                                    }
                                    @endphp
                                    ${{number_format($saldoPendiente,2)}}
                                </td>
                              
                            @endif
                                
                                <td class="d-flex" style="box-sizing: content-box;">
                                        @if($permisos->contratosEditar==1)
                                    <a style="margin-right:4px;" target="_blank" href="{{ route('editar.presupuesto', $budget->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Editar" data-original-title="Editar Presupuesto">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
                                    @if($permisos->contratosFichaTecnica==1)
                                    <a style="margin-right:4px;" target="_blank"  href="{{ route('ver.presupuesto', $budget->id) }}"  class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Ficha Tecnica" data-original-title="View Customer">
                                        <i class="fa fa-eye"></i> 
                                    </a> 
                                    @endif
                                    @if($permisos->contratosArchivar==1)
                                    <a style="margin-right:4px;" onclick="archivarPresupuesto({{$budget->id}})" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Archivar Presupuesto" data-original-title="View Customer">
                                        <i style="color: white" class="si si-trash"></i> 
                                    </a>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                            @endif
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
                <!-- Vista presupuestos archivados -->
                <div class="content" id="presupuestosArchivados" style="display: none">
                <div class="block">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:indianred">Contratos Eliminados</h3>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <button onclick="PresupuestosActivos()" class="btn btn-success">
                                                <i  class="fa fa-calendar-minus-o"></i> <i>Contratos Activos</i> 
                                    </button>
                                    <button onclick="PresupuestosHistorial()" class="btn btn-info">
                                                <i  class="fa fa-calendar-minus-o"></i> <i>Historial</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosArchivados" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>#Folio</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Version</th>
                                    <th>Opciones</th>
                                     <th>Última Modificación</th>
                                     <th>Total</th>
                                     <th>Opciones</th>
                                </tr>
                            
                            </thead>
                            <tbody>                    
                                        
                                          
                                @if (!is_null($PresupuestosArchivados))
                                @foreach ($PresupuestosArchivados as $budgetArchivados)                          
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">{{$budgetArchivados->folio}}</td>
                                    
                                    @if ($budgetArchivados->pendienteFecha!=1)
                                    @php
                                        $fechaEvento = Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
                                    @endphp
                                    <td class="">
                                        <span style="display:none; font-size:2px;">{{$fechaEvento}}</span>
                                        <br>
                                        {{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                    @else
                                    <td class="">Pendiente</td>
                                 @endif
                                    
                                    <td class="d-none d-sm-table-cell">{{$budgetArchivados->cliente}}</td>
                                    <td class="d-none d-sm-table-cell">{{$budgetArchivados->vendedor}}</td>
                                    <td class="d-none d-sm-table-cell text-center">
                                            @if($budgetArchivados->version>1)<i data-toggle="tooltip" title="Nueva Versión" class="fa fa-star" style="font-size: 8px; color:red"></i>@endif
                                        {{$budgetArchivados->version}}
                                    </td>
                                 <td class="d-none d-sm-table-cell text-center d-flex" style="font-size:14px;">
                                  <a target="_blank" href="{{route('imprimir.budget', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresion==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresion==1) title="Se Imprimió este presupuesto {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                    <a href=""><i class="fa fa-send-o" style="@if($budgetArchivados->enviado==1) color:green; @else color:#3f9ce8 @endif"  data-toggle="tooltip" @if($budgetArchivados->enviado==1) title="Contrato enviado al cliente"  @else title="Aun no se envia al cliente" @endif></i></a>
                                    <a target="_blank" href="{{route('imprimir.budgetBodegaCliente', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                 </td>
                                    <td class="d-none d-sm-table-cell">{{$budgetArchivados->updated_at}}<br>
                                            @if($budgetArchivados->version>1)por: Ivonne Arroyos @endif
                                    </td>
                                    @php
                                        $total=number_format($budgetArchivados->total,2);
                                    @endphp
                                 <td>${{$total}}<br>
                                    Saldo: 
                                    @php
                                        $abono=0;
                                        $pagos = App\Payment::where('budget_id', $budgetArchivados->id)->get();
                                        $saldoPendiente = $budgetArchivados->total;
                                    
                                        if(count($pagos)>0){
                                        foreach ($pagos as $pago) {
                                            $abono = $abono + $pago->amount;
                                        }
                                        $saldoPendiente = $budgetArchivados->total-$abono;
                                    }
                                    @endphp
                                    ${{number_format($saldoPendiente,2)}}
                                 </td>
                                    <td class="d-flex" style="box-sizing: content-box;">
                                        @if($permisos->contratosEditar==1)
                                        <button disabled style="margin-right:4px;" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Este presupuesto esta archivado" data-original-title="Editar Presupuesto">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        @endif
                                        <a style="margin-right:4px;" target="_blank"  href="{{ route('ver.presupuesto', $budgetArchivados->id) }}"  class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Ficha Tecnica" data-original-title="View Customer">
                                            <i class="fa fa-eye"></i> 
                                        </a> 
                                        <a href="{{route('presupuesto.desarchivar', $budgetArchivados->id)}}" style="margin-right:4px;" onclick="archivarPresupuesto()" class="btn btn-sm btn-success" data-toggle="tooltip" title="Re-activar Presupuesto" data-original-title="View Customer">
                                            <i class="si si-refresh"></i> 
                                        </a>
                                    
                                    </td>
                                </tr>
                            @endforeach
                                @endif
                        
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>

        <!--Vista historial -->
        <div class="content" id="PresupuestosHistorial" style="display: none">

                <form action="{{route('imprimir.recolecciones')}}" method="GET" target="_blank" name="f1" id="f1">
                                
                        @csrf
                        <div class="row" style="padding:20px;">
                    <div class="col-12">
                        <label for="">Recolecciones</label>
                    </div>
                        <input class="form-control col-md-3" required style="margin-right:10px" type="date" name="fecha_1" id="fecha1" class="form-control" >
                        <input class="form-control col-md-3" required style="margin-right:10px" type="date" name="fecha_2" id="fecha2" class="form-control">
                        <select name="tipoImpresion" id="">
                            <option value="TODO">Imprimir todo</option>
                            <option value="RECOLECCION">Imprimir solo recolecciones</option>
                            <option value="BODEGA">Imprimir solo entregas en bodega</option>
                            <option value=""></option>
                        </select>
                         <button class="btn btn-info">Obtener Recolecciones</button><br>
                         
                        </div>
                     </form>

            <div class="block">
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color:indianred">Historial</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        <button onclick="PresupuestosActivos()" class="btn btn-success">
                            <i  class="fa fa-calendar-minus-o"></i> <i>Contratos Activos</i> 
                        </button>
                        <button onclick="presupuestosArchivados()" class="btn btn-success">
                            <i  class="fa fa-calendar-minus-o"></i> <i>Contratos Eliminados</i> 
                        </button>
                    </div>
                </div>
                <div style="padding:15px; padding-top:30px;">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosArchivados2" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>#Folio</th>
                                <th>Fecha Evento</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Et.</th>
                                <th>Recolección</th>
                                <th>Total</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>                               
                            @if (!is_null($presupuestosHistorial))
                                @foreach ($presupuestosHistorial as $budgetArchivados)                          
                                    <tr role="row" class="odd">
                                        <td class="text-center sorting_1">{{$budgetArchivados->folio}}
                                                <span>
                                                        @if ($budgetArchivados->pagado)
                                                            <i class="fa fa-check" data-toggle="tooltip" title="Contrato pagado"></i> 
                                                        @endif
                                                    </span>
                                        </td>
                                        @if ($budgetArchivados->pendienteFecha!=1)
                                            @php
                                                $fechaEvento = Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
                                            @endphp
                                            <td class=""><span style="display:none">{{$fechaEvento}}</span>
                                                <br>
                                                {{$fechaEvento->translatedFormat(' l j F Y')}}</td>
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
                                            <td class="d-none d-sm-table-cell text-center d-flex" style="font-size:14px;">
                                                <a target="_blank" href="{{route('imprimir.budget', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresion==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresion==1) title="Se Imprimió este contrato {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                                <i class="fa fa-send-o" onclick="enviarCorreoCliente({{$budgetArchivados->id}}, '{{$budgetArchivados->email}}')" style="@if($budgetArchivados->enviado==1) color:green; @else color:#3f9ce8 @endif"  data-toggle="tooltip" @if($budgetArchivados->enviado==1) title="Contrato enviado al cliente"  @else title="Aun no se envia al cliente" @endif></i>
                                                <a target="_blank" href="{{route('imprimir.budgetBodegaCliente', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                            </td>
                                            <td class="d-none d-sm-table-cell" style="font-weight:bold">@if($budgetArchivados->entregaEnBodega)Cliente Entrega en bodega @else Recolección @endif<br>
                                               
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
                                                @endif<br>
                                                @php
                                                    $abono=0;
                                                    $pagos = App\Payment::where('budget_id', $budgetArchivados->id)->get();
                                                    $saldoPendiente = $budgetArchivados->total;
                                                
                                                    if(count($pagos)>0){
                                                    foreach ($pagos as $pago) {
                                                       if($pago->method=='DOLAR'){
                                                $abono = $abono + ($pago->amount*$pago->reference);
                                            }else{
                                                $abono = $abono + $pago->amount;}
                                                    }
                                                    if($budgetArchivados->opcionIVA==1){
                                                    $saldoPendiente = ($budgetArchivados->total*1.16)-$abono;
                                                    }else{
                                                    $saldoPendiente = $budgetArchivados->total-$abono;
                                                    }
                                                }
                                                @endphp
                                                <span style="color:red">
                                                Saldo: 
                                                ${{number_format($saldoPendiente,2)}}
                                                </span>
                                            </td>
                                            <td class="d-flex" style="box-sizing: content-box;">
                                                @if($permisos->contratosEditar==1)
                                                <a  target="_blank"  href="{{ route('editar.presupuesto', $budgetArchivados->id) }}" disabled style="margin-right:4px;" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Este Contrato es pasado" data-original-title="Editar Presupuesto">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                @endif
                                                <a  target="_blank"  href="{{ route('ver.presupuesto', $budgetArchivados->id) }}" style="margin-right:4px;"   class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver contrato" data-original-title="View Customer">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                @if($permisos->contratosArchivar==1)
                                                <a style="margin-right:4px;" onclick="archivarPresupuesto({{$budgetArchivados->id}})" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar contrato" data-original-title="View Customer">
                                                    <i style="color: white" class="si si-trash"></i> 
                                                </a>
                                                @endif
                                                @php
                                                    $budgetID = App\Budget::where('id', $budgetArchivados->id)->first();
                                                @endphp
                                                @if($budgetID->recolectado!=1)
                                                <button data-id="{{ $budgetArchivados->id }}" style="margin-right:4px;" class="btn btn-sm btn-primary danados" data-toggle="modal" data-target="#productosDanados">
                                                    <i data-id="{{ $budgetArchivados->id }}" class="fa fa-chain-broken"></i> 
                                                </button>
                                                @else
                                                <i class="fa fa-check" style="color: green" data-toggle="tooltip" title="Recolectado"></i> 
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
    </section>

    <!-- Modal productos dañados-->
    <div class="modal fade" id="productosDanados" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Registro de faltantes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <productos-danados-component></productos-danados-component>
            </div>
        </div>
        </div>
    </div>
   
    
    @include('../modals/nuevoContratoModal')
    @include('../modals/categoriaEventoModal')
    @include('../modals/nuevoProductoModal')
    @include('../modals/nuevoClienteModal')
@endsection

@section("scripts")
    <script>
        function vista_calendario(){
        document.getElementById('divCalendario').style.display="block";
        document.getElementById('divLista').style.display="none";
    }
    function vista_lista(){
        document.getElementById('divCalendario').style.display="none";
        document.getElementById('divLista').style.display="block";
    }
    function archivarCliente(){
        Swal.fire({
            title: '¿Estas seguro de archivar este contrato?',
            text: "Al archivar un contrato dejara de estar disponible en la tabla de contrato",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
            
        }).then((result) => {
        if (result.value) {
            var url= '/presupuestos/eliminar-presupuestos/'+task;
            axios.delete(url).then(response =>{
                this.obtenerTareas();
                }) 
            }
                            
        })
    }

    function archivarPresupuesto(id){
        //alert(id);
        let motivo = prompt('¿Motivo de cancelación?')
        let URL = '/budget-archivar/'  + id+'-'+motivo;
        axios.get(URL).then((response) => {
                    Swal.fire(
                            'Eliminado',
                            'El contrato ha sido eliminado correctamente',
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

    }

    function enviarCorreoCliente(id, email){

                let URL = '/enviar-email-cliente/'  + id+ '&' + email;

                axios.get(URL).then((response) => {
                    Swal.fire(
                            'Enviado!',
                            'El contrato ha sido enviado por correo',
                            'success'
                        ); 
                        location.reload();
                }).catch((error) => {
                    console.log(error.data);
                    Swal.fire(
                            'Error!',
                            'A ocurrido un error al enviar el correo, intentar mas tarde',
                            'Danger'
                        ); 
                })
            }
    function presupuestosArchivados(){
        document.getElementById('presupuestosArchivados').style.display="block";
        document.getElementById('PresupuestosActivos').style.display="none";
        document.getElementById('PresupuestosHistorial').style.display="none";
    }
    function PresupuestosActivos(){
        document.getElementById('presupuestosArchivados').style.display="none";
        document.getElementById('PresupuestosActivos').style.display="block";
        document.getElementById('PresupuestosHistorial').style.display="none";
    }
    function PresupuestosHistorial(){
        document.getElementById('presupuestosArchivados').style.display="none";
        document.getElementById('PresupuestosActivos').style.display="none";
        document.getElementById('PresupuestosHistorial').style.display="block";
    }
    </script>

@endsection
