@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="block">
            <div class="block-header block-header-default">
                <a href="{{ route('familia.create') }}" class="btn btn-sm btn-primary">Agregar Familia</a>
                <a href="{{ route('grupo.index') }}" class="btn btn-sm btn-info">Ver Requerimentos de Familia</a>
            </div>
            <div class="row">
                <div class="col-md-12 p-4">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Grupo</th>
                                <th>Cantidad</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($familias as $familia)
                                <tr role="row" class="odd">
                                    <td>{{ $familia->id }}</td>
                                    <td>{{ $familia->nombre }}</td>
                                    <td>{{ $familia->grupo }}</td>
                                    <td>
                                        @php
                                            $inventario = App\Inventory::where('familia', $familia->nombre)->get();
                                        @endphp
                                        <span>
                                            <strong>{{ count($inventario) }}</strong>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('familia.destroy', $familia->id) }}" method="POST" style="display: inline-block;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" onclick="return confirm('Seguro quieres eliminar esta familia')" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                        <a href="{{ route('familia.edit', $familia->id) }}" class="btn btn-sm btn-info">Editar</a>
                                        <a target="_blank" href="{{ route('inventario3', $familia->nombre) }}" class="btn btn-sm btn-info">Imprimir Conteo Fisico</a>
                                        <a target="_blank" href="{{ route('inventario4', $familia->nombre) }}" class="btn btn-sm btn-info">Imprimir Bodega</a>
                                        
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