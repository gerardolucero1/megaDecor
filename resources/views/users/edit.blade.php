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
            <div class="col-md-12">
                <div class="block">
                    <div class="col-md-12">
                        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'files' => 'true']) !!}
    
                            @include('users.partial.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection