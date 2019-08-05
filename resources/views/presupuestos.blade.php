@extends('layouts.backend')

@section('content')
<section class="container">
    <div class="row">
        <div class="col-md-4 text-center">
            <input type="text" width="100%">
        </div>
        <div class="col-md-4 text-center">
            <button class="btn btn-primary">
                Busqueda Avanzada
            </button>
        </div>
        <div class="col-md-4 text-center">
            <button class="btn btn-success" data-toggle="modal" data-target="#nuevoPresupuestoModal">
                Nuevo Presupuesto
            </button>
        </div>
    </div>
</section>


    @include('../modals/nuevoPresupuestoModal')
@endsection