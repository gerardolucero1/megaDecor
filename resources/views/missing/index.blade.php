@extends('layouts.backend')

@section('content')
@if (session('info'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('info') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
        <h1>Faltantes</h1>
        <div class="block">
            <div class="block-header block-header-default">
                    <a href="{{ route('missing.create')}}" class="btn btn-sm btn-primary">Agregar faltantes</a>
            </div>
            <div class="row">
                <div class="col-md-12 p-4">
                    <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                        <thead>
                            <tr role="row">
                                <!-- (Nombre, Telefono, Correo, Dirección) -->
                                <th>#</th>
                                <th>id_article</th>
                                <th>contrato</th>
                                <th>fecha</th>
                                <th>nombre_de_persona</th>
                                <th>descripcion</th>
                                <th>cantidad_que_falta</th>
                                <th>dias_desde_no_regreso</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                                <th>Detalles</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faltantes as $faltante)
                                <tr role="row" class="odd">
                                    <td>{{ $faltante->id }}</td>
                                    <td>{{ $faltante->id_article }}</td>
                                    <td>{{ $faltante->contrato }}</td>
                                    <td>{{ $faltante->fecha }}</td>
                                    <td>{{ $faltante->nombre_de_persona }}</td>
                                    <td>{{ $faltante->descripcion }}</td>                                    
                                    <td>{{ $faltante->cantidad_que_falta }}</td>
                                    <td>{{ $faltante->dias_desde_no_regreso }}</td>                                    


                                    <td class="text-center">
                                        <a href="{{ route('missing.edit', $faltante->id) }}" class="btn btn-sm btn-info">Editar</a>
                                    </td>
                                    <td class="text-center">
                                            <form action="{{route('missing.destroy', $faltante->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button onclick="return confirm('Esta seguro?')" class="btn btn-danger btn-sm">Borrar</button>
                                            </form>
                                    </td>
                                    <td class="text-center">                                                                               
                                        <a href="{{ route('missing.show', $faltante->id,$bool=false) }}" class="btn btn-sm btn-info">Cliente</a>
                                    </td>
                                    <td class="text-center">  
                                                                                                                     
                                        <a href="{{ route('missing.show', $faltante->id_article,$bool=true) }}" class="btn btn-sm btn-info">Articulo</a>
                                    </td>
                                </tr>
                            @endforeach                                     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- <section class="container"></section>-->
    
@endsection