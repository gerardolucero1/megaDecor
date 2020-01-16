@extends('layouts.backend')

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
        <div class="col-md-12">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Estas editando el producto: {{ $inventory->servicio }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#registros">KARDEX</button>
                    </div>
                </div>
                <div class="block-content">
                    {!! Form::model($inventory, ['route' => ['inventory.update', $inventory->id], 'method' => 'PUT', 'files' => 'true']) !!}
            
                        @include('Inventories.partial.form')
                    {!! Form::close() !!}
                </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="registros" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <P style="position:absolute; right: 100px; font-size:22px; font-weight: bold;">KARDEX</P>
                        <img style="width: 50px; margin-right: 20px" src="{{ $inventory->imagen }}">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ $inventory->servicio }}</h5>
                        
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Motivo</th>
                                            <th scope="col">Antes en bodega</th>
                                            <th scope="col">Despues en bodega</th>
                                            <th scope="col">Antes en exhibicion</th>
                                            <th scope="col">Despues en exhibicion</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Fecha Compra</th>
                                            <th scope="col">Fecha de Captura</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Factura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registros as $registro)
                                            <tr style="font-size: 12px">
                                                <td>@if($registro->tipo=='baja')<i style="color:red" class="fa fa-arrow-down"></i>@else @if($registro->tipo=='alta') <i style="color:green" class="fa fa-arrow-up"></i>@else <i style="color:orange" class="fa fa-arrow-left"></i> @endif @endif @if($registro->tipo=='salida') Bodega-Exhibicion @else @if($registro->tipo=='entrada')Exhibición-Bodega @else {{$registro->tipo}} @endif  @endif</td>
                                                <td>{{ $registro->cantidad }}</td>
                                                <td>{{ $registro->motivo }}</td>
                                                <td>{{ $registro->antes }}</td>
                                                <td>@if($registro->motivo=="baja"){{ $registro->user->antes-$registro->user->cantidad }}@else{{ $registro->user->antes+$registro->user->cantidad }}@endif</td>
                                                <td>{{ $registro->antesExhibicion }}</td>
                                                <td>@if($registro->motivo=="alta"){{ $registro->user->antesExhibicion+$registro->user->cantidad }}@else{{ $registro->user->antesExhibicion-$registro->user->cantidad }}@endif</td>
                                                <td>{{ $registro->user->name }}</td>
                                                <td>{{ $registro->fechaCompra }}</td>
                                                <td>{{ $registro->created_at }}</td>
                                                <td>{{ $registro->proveedor }}</td>
                                                <td>${{ $registro->precio }}</td>
                                                <td>{{ $registro->factura }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
@endsection 