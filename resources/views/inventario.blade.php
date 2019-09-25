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
                        <h3 class="block-title" style="color:green">Inventario</h3>

                        <form action="{{ route('inventario.filtro') }}" method="POST">
                            @method('POST')
                            @csrf
                            <select name="familia" id="">
                                <option value="Manteles">Manteles</option>
                                <option value="Comida">Comida</option>
                                <option value="Musica">Musica</option>
                            </select>

                            <button type="submit" class="btn btn-sm btn-info">Buscar</button>
                        </form>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <button class="btn btn-primary" disabled data-toggle="modal" data-target="#nuevoPresupuestoModal">
                                            <i class="fa fa-calendar-plus-o"></i> <i>Crear Elemento</i> 
                                        </button>
                                        
                                   
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Imagen</th>
                                    <th>Servicio</th>
                                    <th>Existencia en bodega</th>
                                    <th>Existencia en exhibición</th>
                                    <th>Costo</th>
                                    <th>Precio Unitario</th>
                                    <th>Familia</th>
                                    <th>Fecha de creación</th>
                                    <th>Ultima Edición</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>                    
                                @if (!is_null($Inventario))
                                    @foreach ($Inventario as $inventario)                      
                            <tr role="row" class="odd">
                            <td class="text-center sorting_1"><img style="width: 80px" src="{{ $inventario->imagen}}"></td>
                                <td class="">{{ $inventario->servicio }}</td>
                                <td>{{ $inventario->cantidad }}</td>
                                <td>{{ $inventario->disponible }}</td>
                                <td class="d-none d-sm-table-cell">${{ $inventario->precioVenta }}</td>
                                <td class="d-none d-sm-table-cell">${{ $inventario->precioUnitario }}</td>
                                <td class="d-none d-sm-table-cell">{{ $inventario->familia }}</td>
                                <td class="d-none d-sm-table-cell">{{ $inventario->created_at }}</td>
                                <td class="d-none d-sm-table-cell text-center">{{ $inventario->updated_at }}</td>
                                <td class="d-flex" style="box-sizing: content-box;">
                                    <button disabled style="margin-right:4px;" href="" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Editar" data-original-title="Editar Presupuesto">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button disabled style="margin-right:4px;" onclick="archivarPresupuesto()" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Archivar Presupuesto" data-original-title="View Customer">
                                        <i class="fa fa-remove"></i> 
                                    </button>
                                <button disabled class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i>
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
                <!-- Vista presupuestos archivados -->
                

                
               
    </section>
   
    
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
    }
    function PresupuestosActivos(){
        document.getElementById('presupuestosArchivados').style.display="none";
        document.getElementById('PresupuestosActivos').style.display="block";
    }
    </script>

@endsection
