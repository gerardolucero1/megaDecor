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
                        <h3 class="block-title" style="color:green">Presupuestos Activos</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        @php
                            $usuario = Auth::user()->id;    
                        @endphp 
                        
                        @if($usuario != 2)
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                <i class="fa fa-calendar-plus-o"></i> <i>Crear Presupuesto</i> 
                            </button>
                            <button class="btn btn-primary"  onclick="vista_calendario()">
                                <i class="fa fa-calendar"></i> <i>Vista Calendario</i> 
                            </button>
                            <button onclick="presupuestosArchivados()" class="btn btn-secondary">
                                <i class="fa fa-calendar-minus-o"></i> <i>Presupuestos Archivados</i> 
                            </button>
                            <button onclick="PresupuestosHistorial()" class="btn btn-info">
                                <i class="fa fa-calendar-minus-o"></i> <i>Historial</i> 
                            </button>
                        @endif
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Folio</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Version</th>
                                    <th>Etiquetas</th>
                                     <th>Ultima Modificación</th>
                                     <th>Total</th>
                                     <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>           
                            @php
                                use Carbon\Carbon;
                            @endphp         
                            @if (!is_null($Presupuestos))
                            @foreach ($Presupuestos as $budget)                          
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1"><span style="display:none; font-size:2px;">{{$budget->id}}</span><br>{{$budget->folio}}</td>
                                
                                @if (!is_null($budget->fechaEvento))
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
                                
                                <td class="d-none d-sm-table-cell">{{$budget->cliente}}</td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">{{$budget->vendedor}}</td>
                                <td class="d-none d-sm-table-cell text-center">
                                        @if($budget->version>1)<i data-toggle="tooltip" title="Nueva Versión" class="fa fa-star" style="font-size: 8px; color:red"></i>@endif
                                    {{$budget->version}}
                                </td>
                            <td class="d-none d-sm-table-cell text-center d-flex" style="font-size:14px;">
                                @if($usuario != 2)
                                    <a target="_blank" href="{{route('imprimir.budget', $budget->id)}}">
                                        <i class="si si-printer" style="margin-right:8px; @if($budget->impresion==1) color:green; @endif"  data-toggle="tooltip" @if($budget->impresion==1) title="Se Imprimió este presupuesto {{$budget->updated_at}}"  @else title="Aun no se imprime" @endif></i>
                                    </a>
                                    <a href="">
                                        <i class="fa fa-send-o" style="@if($budget->enviado==1) color:green; @endif"  data-toggle="tooltip" @if($budget->enviado==1) title="Presupuesto enviado al cliente"  @else title="Aun no se envia al cliente" @endif></i>
                                    </a>
                                @endif
                                <a target="_blank" href="{{route('imprimir.budgetBodega', $budget->id)}}">
                                    <i class="si si-printer" style="margin-right:8px; @if($budget->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budget->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budget->updated_at}}"  @else title="Aun no se imprime" @endif></i>
                                </a>
                            </td>
                                <td class="d-none d-sm-table-cell">{{$budget->updated_at}}<br>
                                        @if($budget->version>1)por: Ivonne Arroyos @endif
                                </td>
                                @php
                                    $total=number_format($budget->total,2);
                                @endphp
                                <td>
                                    @if($usuario != 2)
                                        ${{$total}}
                                    @endif
                                </td>
                                <td class="d-flex" style="box-sizing: content-box;">
                                    @if($usuario != 2)
                                    <a style="margin-right:4px;" href="{{ route('editar.presupuesto', $budget->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Editar" data-original-title="Editar Presupuesto">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a style="margin-right:4px;" href="{{ route('ver.presupuesto', $budget->id) }}"  class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Ficha Tecnica" data-original-title="View Customer">
                                        <i class="fa fa-eye"></i> 
                                    </a> 
                                    <a href="{{route('presupuesto.archivar', $budget->id)}}" style="margin-right:4px;" onclick="archivarPresupuesto()" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Archivar Presupuesto" data-original-title="View Customer">
                                        <i class="si si-refresh"></i> 
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
                        <h3 class="block-title" style="color:indianred">Presupuestos Archivados</h3>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <button onclick="PresupuestosActivos()" class="btn btn-success">
                                                <i  class="fa fa-calendar-minus-o"></i> <i>Presupuestos Activos</i> 
                                            </button>
                                    <button onclick="PresupuestosHistorial()" class="btn btn-info">
                                                <i  class="fa fa-calendar-minus-o"></i> <i>Historial</i> 
                                            </button>
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosHistorial" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>#Presupuesto</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Lugar</th>
                                    <th>Vendedor</th>
                                    <th>Version</th>
                                     <th>Última Modificación</th>
                                     <th>Opciones</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                        
                                          
                                @if (!is_null($PresupuestosArchivados))
                                @foreach ($PresupuestosArchivados as $budgetArchivados)                          
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">{{$budgetArchivados->folio}}</td>
                                    
                                    @if (!is_null($budgetArchivados->fechaEvento))
                                        @php
                                            $fechaEvento = Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
                                        @endphp
                                        <td class="">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
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
                                    <a href=""><i class="fa fa-send-o" style="@if($budgetArchivados->enviado==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->enviado==1) title="Presupuesto enviado al cliente"  @else title="Aun no se envia al cliente" @endif></i></a>
                                    <a target="_blank" href="{{route('imprimir.budgetBodega', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a></td>
                                    <td class="d-none d-sm-table-cell">{{$budgetArchivados->updated_at}}<br>
                                            @if($budgetArchivados->version>1)por: Ivonne Arroyos @endif
                                    </td>
                                    @php
                                        $total=number_format($budgetArchivados->total,2);
                                    @endphp
                                <td>${{$total}}</td>
                                    <td class="d-flex" style="box-sizing: content-box;">
                                        <button disabled style="margin-right:4px;" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Este presupuesto esta archivado" data-original-title="Editar Presupuesto">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button disabled style="margin-right:4px;"   class="btn btn-sm btn-primary" data-toggle="tooltip" title="Este presupuesto esta archivado" data-original-title="View Customer">
                                            <i class="fa fa-eye"></i> 
                                        </button> 
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
            <div class="block">
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color:indianred">Historial</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        <button onclick="PresupuestosActivos()" class="btn btn-success">
                            <i  class="fa fa-calendar-minus-o"></i> <i>Presupuestos Activos</i> 
                        </button>
                        <button onclick="presupuestosArchivados()" class="btn btn-success">
                            <i  class="fa fa-calendar-minus-o"></i> <i>Presupuestos Archivados</i> 
                        </button>
                    </div>
                </div>
                <div style="padding:15px; padding-top:30px;">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosArchivados" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>#Presupuesto</th>
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
                            @if (!is_null($presupuestosHistorial))
                                @foreach ($presupuestosHistorial as $budgetArchivados)                          
                                    <tr role="row" class="odd">
                                        <td class="text-center sorting_1">{{$budgetArchivados->folio}}</td>
                                        @if (!is_null($budgetArchivados->fechaEvento))
                                            @php
                                                $fechaEvento = Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
                                            @endphp
                                            <td class="">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                        @else
                                            <td class="">{{$budgetArchivados->fechaEvento}}</td>
                                        @endif
                                            @php
                                                $cliente = App\Client::where('id', $budgetArchivados->client_id)->first();

                                                if($cliente->tipo = "FISICO"){
                                                    $clienteCompleto = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                                                    $nombre = $clienteCompleto->nombre;
                                                }else{
                                                    //$clienteCompleto = App\Client::where('id', $cliente->id)->first();
                                                    $nombre = $cliente->id;
                                                }
                                            @endphp
                                            <td class="d-none d-sm-table-cell">{{$nombre}}</td>
                                            <td class="d-none d-sm-table-cell">{{$budgetArchivados->user->name}}</td>
                                            <td class="d-none d-sm-table-cell text-center">
                                                @if($budgetArchivados->version>1)
                                                    <i data-toggle="tooltip" title="Nueva Versión" class="fa fa-star" style="font-size: 8px; color:red"></i>
                                                @endif
                                                {{$budgetArchivados->version}}
                                            </td>
                                            <td class="d-none d-sm-table-cell text-center d-flex" style="font-size:14px;">
                                                <a target="_blank" href="{{route('imprimir.budget', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresion==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresion==1) title="Se Imprimió este presupuesto {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                                <a href=""><i class="fa fa-send-o" style="@if($budgetArchivados->enviado==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->enviado==1) title="Presupuesto enviado al cliente"  @else title="Aun no se envia al cliente" @endif></i></a>
                                                <a target="_blank" href="{{route('imprimir.budgetBodega', $budgetArchivados->id)}}"><i class="si si-printer" style="margin-right:8px; @if($budgetArchivados->impresionBodega==1) color:green; @endif"  data-toggle="tooltip" @if($budgetArchivados->impresionBodega==1) title="Se Imprimió ficha de bodega {{$budgetArchivados->updated_at}}"  @else title="Aun no se imprime" @endif></i></a>
                                            </td>
                                            <td class="d-none d-sm-table-cell">{{$budgetArchivados->updated_at}}<br>
                                                @if($budgetArchivados->version>1)por: Ivonne Arroyos @endif
                                            </td>
                                                @php
                                                    $total=number_format($budgetArchivados->total,2);
                                                @endphp
                                            <td>${{$total}}</td>
                                            <td class="d-flex" style="box-sizing: content-box;">
                                                <button disabled style="margin-right:4px;" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Este presupuesto es pasado" data-original-title="Editar Presupuesto">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button style="margin-right:4px;"   class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver presupuesto" data-original-title="View Customer">
                                                    <i class="fa fa-eye"></i> 
                                                </button> 
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
   
    
    @include('../modals/nuevoPresupuestoModal')
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
            title: '¿Estas seguro de archivar este presupuesto?',
            text: "Al archivar un presupuesto dejara de estar disponible en la tabla de presupuestos",
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
