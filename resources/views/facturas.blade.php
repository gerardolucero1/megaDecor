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
                        <h3 class="block-title" style="color:green">Facturas Solicitadas</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        @php
                            $usuario = Auth::user()->id;    
                        @endphp 
                        
                        @if($usuario != 2 || $usuario != 6)
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
                                    <th class="d-none d-sm-table-cell">Cliente</th>
                                    <th class="d-none d-sm-table-cell">Vendedor</th>
                                    <th class="d-none d-sm-table-cell">Status</th>
                                    <th class="d-none d-sm-table-cell">Fecha de solicitud</th>
                                    <th class="d-none d-sm-table-cell">Total</th>
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
                                <td class="text-center sorting_1"><span style="display:none; font-size:2px;">{{$budget->id}}</span><br>{{$budget->folio}} 
                                    <span>
                                        @if ($budget->pagado)
                                            <i class="fa fa-check" data-toggle="tooltip" title="Contrato pagado"></i> 
                                        @endif
                                    </span>
                                </td>
                                
                                @if (!is_null($budget->fechaEvento))
                                @php
                                    $fechaEvento = Carbon::parse($budget->fechaEvento)->locale('es');
                                    $fechaSolicitud = Carbon::parse($budget->updated_at);
                                @endphp
                                <td class="">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                @else
                                <td class="">Pendiente</td>
                            @endif
                                
                                <td class="d-none d-sm-table-cell">{{$budget->cliente}}</td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">{{$budget->vendedor}}</td>
                                <td class="d-none d-sm-table-cell text-center">
                                    @if($budget->facturaSolicitada==1)
                                    <span style="color:orange"> Factura Solicitada</span>
                                @endif
                                @if($budget->facturaSolicitada==2)
                                <span style="color:green"> Factura Enviada</span><br>
                                <span>{{$budget->fechaEnvioFactura}}</span>
                                @endif
                                </td>
                                <td class="d-none d-sm-table-cell">{{$fechaEvento->translatedFormat(' l j F Y')}}<br>
                                       
                                </td>
                                @php
                                    $total=number_format($budget->total,2);
                                @endphp
                                <td  class="d-none d-sm-table-cell">
                                    @if($usuario != 2)
                                        ${{$total}}
                                    @endif
                                    @if ($budget->IVA)
                                    <br>
                                        <span style="font-size: 10px; color: green;">IVA incluido</span>
                                    @endif
                                   
                                </td>
                                <td class="d-flex" style="box-sizing: content-box;">
                                    <a style="margin-right:4px;" target="_blank"  href="{{ route('ver.presupuesto', $budget->id) }}"  class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Ficha Tecnica" data-original-title="View Customer">
                                        <i class="fa fa-eye"></i> 
                                    </a> 
                                    @if($budget->facturaSolicitada==1)
                                    <a href="{{route('presupuesto.facturaEnviada', $budget->id)}}" style="margin-right:4px;" class="btn btn-sm btn-success" data-toggle="tooltip" title="Marcar como factura enviada" data-original-title="View Customer">
                                        <i class="si si-check"></i> 
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
               
                

        <!--Vista historial -->
        <div class="content" id="PresupuestosHistorial" style="display: none">
                <div class="block" id="divLista">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Facturas Solicitadas</h3>
                    </div>
                    <div class="col-md-9 text-right">
                       
                        
                      
                            <button onclick="PresupuestosHistorial()" class="btn btn-info">
                                <i class="fa fa-calendar-minus-o"></i> <i>Historial</i> 
                            </button>
                      
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Folio</th>
                                    <th>Fecha Evento</th>
                                    <th class="d-none d-sm-table-cell">Cliente</th>
                                    <th class="d-none d-sm-table-cell">Vendedor</th>
                                    <th class="d-none d-sm-table-cell">Status</th>
                                    <th class="d-none d-sm-table-cell">Fecha de solicitud</th>
                                    <th class="d-none d-sm-table-cell">Total</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>           
                                 
                            @if (!is_null($PresupuestosArchivados))
                            @foreach ($PresupuestosArchivados as $budgetArchivado)                          
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1"><span style="display:none; font-size:2px;">{{$budgetArchivado->id}}</span><br>{{$budgetArchivado->folio}} 
                                    <span>
                                        @if ($budgetArchivado->pagado)
                                            <i class="fa fa-check" data-toggle="tooltip" title="Contrato pagado"></i> 
                                        @endif
                                    </span>
                                </td>
                                
                                @if (!is_null($budgetArchivado->fechaEvento))
                                @php
                                    $fechaEvento = Carbon::parse($budgetArchivado->fechaEvento)->locale('es');
                                    $fechaSolicitud = Carbon::parse($budgetArchivado->updated_at);
                                @endphp
                                <td class="">{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
                                @else
                                <td class="">Pendiente</td>
                            @endif
                                
                                <td class="d-none d-sm-table-cell">{{$budgetArchivado->cliente}}</td>
                                <td style="font-size:11px;" class="d-none d-sm-table-cell">{{$budgetArchivado->vendedor}}</td>
                                <td class="d-none d-sm-table-cell text-center">
                                    @if($budgetArchivado->facturaSolicitada==1)
                                    <span style="color:orange"> Factura Solicitada</span>
                                @endif
                                @if($budgetArchivado->facturaSolicitada==2)
                                <span style="color:green"> Factura Enviada</span><br>
                                <span>{{$budgetArchivado->fechaEnvioFactura}}</span>
                                @endif
                                </td>
                                <td class="d-none d-sm-table-cell">{{$budgetArchivado->updated_at}}<br>
                                       
                                </td>
                                @php
                                    $total=number_format($fechaSolicitud->translatedFormat(' l j F Y'));
                                @endphp
                                <td  class="d-none d-sm-table-cell">
                                    @if($usuario != 2)
                                        ${{$total}}
                                    @endif
                                    @if ($budgetArchivado->IVA)
                                    <br>
                                        <span style="font-size: 10px; color: green;">IVA incluido</span>
                                    @endif
                                   
                                </td>
                                <td class="d-flex" style="box-sizing: content-box;">
                                    <a style="margin-right:4px;" target="_blank"  href="{{ route('ver.presupuesto', $budgetArchivado->id) }}"  class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Ficha Tecnica" data-original-title="View Customer">
                                        <i class="fa fa-eye"></i> 
                                    </a> 
                                    @if($budgetArchivado->facturaSolicitada==1)
                                    <a href="{{route('presupuesto.facturaEnviada', $budgetArchivado->id)}}" style="margin-right:4px;" class="btn btn-sm btn-success" data-toggle="tooltip" title="Marcar como factura enviada" data-original-title="View Customer">
                                        <i class="si si-check"></i> 
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
    function enviarCorreoCliente(id){
                let URL = '/enviar-email-cliente/'  + id;

                axios.get(URL).then((response) => {
                    Swal.fire(
                            'Enviado!',
                            'El presupuesto ha sido enviado por correo',
                            'success'
                        ); 
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
        document.getElementById('PresupuestosActivos').style.display="none";
        document.getElementById('PresupuestosHistorial').style.display="none";
    }
    function PresupuestosActivos(){
        document.getElementById('PresupuestosActivos').style.display="block";
        document.getElementById('PresupuestosHistorial').style.display="none";
    }
    function PresupuestosHistorial(){
        document.getElementById('PresupuestosActivos').style.display="none";
        document.getElementById('PresupuestosHistorial').style.display="block";
    }
    </script>

@endsection
