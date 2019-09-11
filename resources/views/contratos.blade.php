@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
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
        <div class="content">
                <div class="block" id="divLista">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title">Contratos</h3>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                            <i class="fa fa-calendar-plus-o"></i> <i>Crear Presupuesto</i> 
                                        </button>
                                        <button class="btn btn-primary" onclick="vista_calendario()">
                                                <i class="fa fa-calendar"></i> <i>Vista Calendario</i> 
                                            </button>
                                    
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>#Contrato</th>
                                    <th>Fecha Evento</th>
                                    <th>Cliente</th>
                                    <th>Lugar</th>
                                    <th>Vendedor</th>
                                    <th>Version</th>
                                     <th>Ultima Modificación</th>
                                     <th>Opciones</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>                    
                                    @foreach($Presupuestos as $Contrato)                 
                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">{{$Contrato->folio}}</td>
                                    <td class="">{{$Contrato->fechaEvento}}</td>
                                    <td class="d-none d-sm-table-cell">{{$Contrato->cliente}}</td>
                                    <td class="d-none d-sm-table-cell">{{$Contrato->lugarEvento}}</td>
                                    <td class="d-none d-sm-table-cell">{{$Contrato->vendedor}}</td>
                                    <td class="d-none d-sm-table-cell">{{$Contrato->version}}</td>
                                    <td class="d-none d-sm-table-cell">{{$Contrato->updated_at}}</td>
                                    
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Ver Perfil" data-original-title="View Customer">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" onclick="archivarCliente()" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="Archivas Contacto" data-original-title="View Customer">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
               
    </section>
   
    @include('../modals/nuevoPresupuestoModal')
    @include('../modals/nuevoClienteModal')
    @include('../modals/tiposEmpresaModal')
    @include('../modals/comoSupoModal')
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
   
</script>

@endsection
