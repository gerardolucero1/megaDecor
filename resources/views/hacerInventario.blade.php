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
                        <h3 class="block-title" style="color:green">Hacer Inventario</h3>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Foto</th>
                                    <th>Servicio</th>
                                    <th class="d-none d-sm-table-cell">Cantidad anterior</th>
                                    <th class="d-none d-sm-table-cell">Cantidad actual Bodega</th>
                                    <th class="d-none d-sm-table-cell">Cantidad actual Exhibición</th>
                                    <th class="d-none d-sm-table-cell">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Inventario as $producto)
                                    <tr>
                                        <td>
                                            <img src="{{ $producto->imagen }}" alt="" width="100px">
                                        </td>
                                        <td>{{ $producto->servicio }}</td>
                                        <td>{{ $producto->cantidad + $producto->exhibicion }}</td>
                                        <td><input style="width: 100%; background:white; border:solid; border-width: 1px;" value="{{$producto->cantidad}}"></td>
                                        <td><input style="width: 100%; background:white; border:solid; border-width: 1px;" value="{{$producto->exhibicion}}"></td>
                                        @if ($producto->reportado)
                                            <td>
                                                Se ha enviado un reporte para su aprobacion
                                            </td>
                                        @else
                                            <td>
                                                <button style="margin-right:4px;" class="btn btn-sm btn-success" data-toggle="tooltip" title="Guardar" data-original-title="Aprobar dañados">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                
                                            </td>
                                        @endif
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="reporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario" action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-material">
                                        <label for="imagen">Imagen</label>
                                        <input type="file" name="imagen" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-material">
                                        <label for="reporte">Reporte</label>
                                        <textarea name="reporte" id="" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Enviar reporte</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).on("click", ".btn-modal", function () {
            var itemid= $(this).attr('data-item');
            $("#formulario").attr('action', '/registrar-faltante/' + itemid);
        });
    </script>
@endsection


