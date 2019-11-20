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
                                    <th class="d-none d-sm-table-cell">Precio Unitario</th>
                                    <th class="d-none d-sm-table-cell">Precio Especial</th>
                                    <th class="d-none d-sm-table-cell">Categoria</th>
                                    <th class="d-none d-sm-table-cell">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paquetes as $paquete)
                                    <tr>
                                        <td>
                                            <img src="https://http2.mlstatic.com/caja-carton-corrugado-60x40x20-x-20-unid-embalaje-D_NQ_NP_725349-MLA31085333966_062019-F.jpg" alt="" width="100px">
                                        </td>
                                        <td>{{ $paquete->servicio }}</td>
                                        <td>{{ $paquete->precioUnitario }}</td>
                                        <td>{{ $paquete->precioEspecial }}</td>
                                        <td>{{ $paquete->categoria }}</td>
                                        <td>
                                            <form action="{{ route('aprobarPaquete', $paquete->id) }}" method="POST" style="display: inline-block;">
                                                @method('PUT')
                                                @csrf
                                                <button style="margin-right:4px;" onclick="return alert('¿Quieres aprobar este paquete?')" class="btn btn-sm btn-success" data-toggle="tooltip" title="aprobar dañados" data-original-title="Aprobar dañados">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('cancelarPaquete', $paquete->id) }}" method="POST" style="display: inline-block;">
                                                @method('PUT')
                                                @csrf
                                                <button style="margin-right:4px;" onclick="return alert('¿Quieres cancelar este paquete?')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancelar dañados" data-original-title="Cancelar dañados">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <button style="margin-right:4px;" class="btn-modal btn btn-sm btn-info" data-toggle="modal" data-target="#reporte{{ $paquete->id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="reporte{{ $paquete->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Reporte</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Imagen</th>
                                                                        <th scope="col">Servicio</th>
                                                                        <th scope="col">Cantidad</th>
                                                                        <th scope="col">Proveedor</th>
                                                                        <th scope="col">Precio Final</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($paquete->inventories as $item)
                                                                        <tr>
                                                                            <td>
                                                                                <img src="{{ $item->imagen }}" alt="" width="100px">
                                                                            </td>
                                                                            <td>{{ $item->servicio }}</td>
                                                                            <td>{{ $item->cantidad }}</td>
                                                                            <td>{{ $item->proveedor }}</td>
                                                                            <td>{{ $item->precioFinal }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> 
                                    </tr>
                                @endforeach
                                @foreach ($paquetesAuth as $paquete)
                                <tr>
                                        <td>
                                            <img src="https://http2.mlstatic.com/caja-carton-corrugado-60x40x20-x-20-unid-embalaje-D_NQ_NP_725349-MLA31085333966_062019-F.jpg" alt="" width="100px">
                                        </td>
                                        <td>{{ $paquete->servicio }}</td>
                                        <td>{{ $paquete->precioUnitario }}</td>
                                        <td>{{ $paquete->precioEspecial }}</td>
                                        <td>{{ $paquete->categoria }}</td>
                                        <td>
                                            <a href="{{ route('editar.paquete', $paquete->id) }}" class="btn btn-sm btn-info">Editar</a>
                                            <button style="margin-right:4px;" class="btn-modal btn btn-sm btn-info" data-toggle="modal" data-target="#ver{{ $paquete->id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="ver{{ $paquete->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Reporte</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Imagen</th>
                                                                        <th scope="col">Servicio</th>
                                                                        <th scope="col">Cantidad</th>
                                                                        <th scope="col">Proveedor</th>
                                                                        <th scope="col">Precio Final</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($paquete->inventories as $item)
                                                                        <tr>
                                                                            <td>
                                                                                <img src="{{ $item->imagen }}" alt="" width="100px">
                                                                            </td>
                                                                            <td>{{ $item->servicio }}</td>
                                                                            <td>{{ $item->cantidad }}</td>
                                                                            <td>{{ $item->proveedor }}</td>
                                                                            <td>{{ $item->precioFinal }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

@section('scripts')
    <script>
        $(document).on("click", ".btn-modal", function () {
            var itemid= $(this).attr('data-item');
            $("#formulario").attr('action', '/registrar-faltante/' + itemid);
        });
    </script>
@endsection


