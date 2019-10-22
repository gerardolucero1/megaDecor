@extends('layouts.backend')

@section('content')
    <section class="container">
        <h1>Proveedores</h1>
        <div class="block">
            <div class="block-header block-header-default">
                    <a href="{{ route('providers.create')}}" class="btn btn-sm btn-primary">Agregar provedor</a>
            </div>
            <div class="row">
                <div class="col-md-12 p-4">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                        <thead>
                            <tr role="row">
                                <!-- (Nombre, Telefono, Correo, Dirección) -->
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($provedores as $provedor)
                                <tr role="row" class="odd">
                                    <td>{{ $provedor->id }}</td>
                                    <td>{{ $provedor->nombre }}</td>
                                    <td>{{ $provedor->telefono }}</td>
                                    <td>{{ $provedor->correo }}</td>
                                    <td>{{ $provedor->direccion }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('providers.edit', $provedor->id) }}" class="btn btn-sm btn-info">Editar</a>
                                    </td>
                                    <td class="text-center">
                                            <form action="{{route('providers.destroy', $provedor->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button onclick="return confirm('Esta seguro?')" class="btn btn-danger btn-sm">Borrar</button>
                                            </form>
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