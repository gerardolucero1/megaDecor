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
                    <h3 class="block-title">Estas editando el producto: {{ $provedores->nombre }}</h3>
                </div>
                <div class="block-content">
                    {!! Form::model($provedores, ['route' => ['provedores.update', $provedores->id], 'method' => 'PUT', 'files' => 'true']) !!}
            
                        @include('provedores.form')
                    {!! Form::close() !!}
                </div>
                <br>
                <a href="/provedores" class="btn btn-sm btn-primary btn-block">Regresar</a>
            </div>
        </div>
    </section>
@endsection 