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
    @if (session('info'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (count($errors))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <section class="container">
        <div class="content" id="PresupuestosActivos">
            <div class="block" id="divLista">
                <div class="block-header block-header-default">
                    <h3 class="block-title" style="color:green">Proveedores</h3>
                    <div class="block-options">
                        <proveedores-component></proveedores-component>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Nombre</th>
                                    <th>Direccion</th>
                                    <th>Descripcion</th>
                                    <th class="d-none d-sm-table-cell">Telefono General</th>
                                    <th class="d-none d-sm-table-cell">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proveedores as $proveedor)
                                    <tr>
                                        <td>
                                            {{ $proveedor->nombre }}
                                        </td>
                                        <td>{{ $proveedor->direccion }}</td>
                                        <td>{{ $proveedor->descripcion }}</td>
                                        <td>{{ $proveedor->telefonoGeneral }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                            <button onclick="event.preventDefault();
                                                        Swal.fire({
                                                            title: '¿Estas seguro?',
                                                            text: '¡No podras revertir esto!',
                                                            type: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Eliminar'
                                                            }).then((result) => {
                                                            if (result.value) {
                                                                document.getElementById('delete-supplier-{{ $proveedor->id }}').submit();
                                                                Swal.fire(
                                                                '¡Eliminado!',
                                                                'El proveedor ha sido eliminado',
                                                                'success'
                                                                )
                                                            }
                                                        });
                                                    "
                                                    type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar proveedor" data-original-title="Delete supplier">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                            <form id="delete-supplier-{{ $proveedor->id }}" action="{{ route('proveedores.delete', $proveedor->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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


