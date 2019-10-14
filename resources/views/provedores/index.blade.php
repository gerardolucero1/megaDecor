@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="block">
            <div class="block-header block-header-default">
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
                            @foreach ($provedores as $provedor)
                                <tr role="row" class="odd">
                                    <td>{{ $provedor->id }}</td>
                                    <td>{{ $provedor->nombre }}</td>
                                    <td>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('provedores.edit', $provedor->id) }}" class="btn btn-sm btn-info">Editar</a>
                                    </td>

                                </tr>
                            @endforeach                                     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection