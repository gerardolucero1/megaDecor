@extends('layouts.backend')

@section('content')
    <section class="container">
        <div class="block p-4">
            <div class="block-header block-header-default">
                <a href="{{ route('grupo.create') }}" class="btn btn-sm btn-primary">Agregar nuevo grupo</a>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="accordion" id="accordionExample">
                        @foreach ($grupos as $grupo)
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#grupo{{ $grupo->id }}" aria-expanded="true" aria-controls="collapse{{ $grupo->id }}">
                                            {{ $grupo->nombre }}
                                        </button>
                                        <a href="{{ route('grupo.edit', $grupo->id) }}" class="btn btn-sm btn-info">Editar</a>
                                    </h2>
                                </div>
                            
                                <div id="grupo{{ $grupo->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body text-justify">
                                        {{ $grupo->informacion }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection