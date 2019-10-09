@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="block">
            <div class="block-header block-header-default">
                <a href="{{ route('familia.create') }}" class="btn btn-sm btn-primary">Agregar Familia</a>
                <a href="{{ route('grupo.index') }}" class="btn btn-sm btn-info">Ver Grupos</a>
            </div>
            <div class="row">
                <div class="col-md-12 p-4">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>                                        
                            <tr role="row" class="odd">
                                <td>1</td>
                                <td>Cojines</td>
                                <td>50</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                    <button class="btn btn-sm btn-info">Editar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection