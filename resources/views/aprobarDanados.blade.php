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
                        <h3 class="block-title" style="color:green">Productos dañados</h3>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Foto</th>
                                    <th>Servicio</th>
                                    <th class="d-none d-sm-table-cell">Cantidad</th>
                                    <th class="d-none d-sm-table-cell">Reporte</th>
                                    <th class="d-none d-sm-table-cell">Vendedor</th>
                                    <th class="d-none d-sm-table-cell">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>
                                            <img src="{{ $producto->inventory->imagen }}" alt="" width="100px">
                                        </td>
                                        <td>{{ $producto->servicio }}</td>
                                        <td>{{ $producto->danados }}</td>
                                        <td>{{ $producto->informe }}</td>
                                        <td>{{ $producto->vendedor }}</td>
                                        <td>
                                            <form action="{{ route('aprobar', $producto->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button data-item="{{ $producto->id }}" onclick="return confirm('¿Quieres aprobar este producto dañado?')" style="margin-right:4px;" class="btm btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                            <button data-item="{{ $producto->imagen }}" style="margin-right:4px; margin-top: -5px;" class="btn-modal btn btn-sm btn-success" data-toggle="modal" data-target="#imagen">
                                                <i class="fa fa-eye"></i>
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
        <!-- Modal -->
        <div class="modal fade" id="imagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="" alt="" id="foto" width="100%">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar reporte</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).on("click", ".btn-modal", function () {
            var img= $(this).attr('data-item');
            $("#foto").attr('src', img);
        });
    </script>
@endsection


