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
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" style="color:green">Editando: {{ $proveedor->nombre }}</h3>
                    </div>
                    <div class="block-content">
                        <editar-proveedor-component :proveedor="{{ $proveedor }}"></editar-proveedor-component>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection