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
        <a class="btn btn-info" href="/paginaweb">Volver</a>
        <div class="col-md-12">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Estas editando el la galeria: {{ $galeria->servicio }}</h3>
                    <div class="block-options">
                        
                    </div>
                </div>
                <div class="block-content">
                    {!! Form::model($galeria, ['route' => ['gallery.update', $galeria->id], 'method' => 'PUT', 'files' => 'true']) !!}
            
                        @include('paginaweb.partial.form')
                    {!! Form::close() !!}
                </div>
            </div>

            
         

        
        </div>
    </section>
@endsection 