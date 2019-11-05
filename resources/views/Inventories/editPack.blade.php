@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="block">
            <editar-paquete-component :paquete2="{{ $pack }}"></editar-paquete-component>
        </div>
    </section>
@endsection