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
                        <h3 class="block-title" style="color:green">Contratos en Nube <span style="padding-left: 30px; color:red">●</span><span style="font-style: italic; font-size: 12px">Vigencias Vencidas</span></h3>
                    </div>
                    <div class="col-md-9 text-right">
                        @php
                            $usuario = Auth::user()->id;    
                        @endphp 
                   
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    @if($permisos->contratosFolio==1)
                                    <th>Folio</th>@endif
                                    @if($permisos->contratosFecha==1)
                                    <th>Motivo</th>@endif
                                    @if($permisos->contratosCliente==1)
                                    <th class="d-none d-sm-table-cell">Cliente</th>@endif
                                    @if($permisos->contratosVendedor==1)
                                    <th class="d-none d-sm-table-cell">Vendedor</th>@endif
                                    @if($permisos->contratosVersion==1)
                                    <th class="d-none d-sm-table-cell">Version</th>@endif
                                    @if($permisos->contratosUltimaModificacion==1)
                                     <th class="d-none d-sm-table-cell">Vigencia</th>@endif
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
                            @php
                                $ultimoCambio =  App\Cloud::where('budget_id', $budget->id)->first();
                            @endphp                         
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
                                        <span style="display:none; font-size:2px;">{{$ultimoCambio->motivo}}</span>
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
                            
                            @if($permisos->contratosUltimaModificacion==1)
                                <td class="d-none d-sm-table-cell">{{$ultimoCambio->vigencia}}<br>
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
                                            $abono = $abono + $pago->amount;
                                        }
                                        $saldoPendiente = $budget->total-$abono;
                                    }
                                    @endphp
                                    ${{number_format($saldoPendiente,2)}}
                                </td>
                              
                            @endif
                                
                                <td class="d-flex" style="box-sizing: content-box;">
                                        
                                   
                                    <a style="margin-right:4px;" target="_blank" href="{{ route('cambio-fecha-reimpresion.pdf', $budget->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Reimpresion" data-original-title="Reimpresion">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a style="margin-right:4px;" target="_blank" href="{{ route('editar.presupuesto', $budget->id) }}"  class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Ficha Tecnica" data-original-title="View Customer">
                                        <i class="fa fa-eye"></i> Restaurar
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
                <!-- Vista presupuestos archivados -->
                <div class="content" id="presupuestosArchivados" style="display: none">
                
                </div>

        <!--Vista historial -->
        <div class="content" id="PresupuestosHistorial" style="display: none">

               

            
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

    function enviarCorreoCliente(id){
                let URL = '/enviar-email-cliente/'  + id;

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
