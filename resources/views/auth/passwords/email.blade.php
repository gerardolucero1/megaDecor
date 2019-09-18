@extends('layouts.simple')

@section('content')
<section id="main-container" style="min-height: 414px;">
    <div class="bg-gd-lake">
        <div class="hero-static content content-full bg-white js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="py-30 px-5 text-center">
                <a class="link-effect font-w700" href="index.php">
                    <i class="si si-fire"></i>
                    <span class="font-size-xl text-primary-dark">Mega</span><span class="font-size-xl">Decor</span>
                </a>
                <h1 class="h2 font-w700 mt-50 mb-10">No te preocupes, estaras de vuelta</h1>
                <h2 class="h4 font-w400 text-muted mb-0">Porfavor ingresa tu correo electronico</h2>
            </div>
            <div class="row justify-content-center px-5">
                <div class="col-sm-8 col-md-6 col-xl-4">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    <form class="js-validation-reminder" method="POST" action="{{ route('password.email') }}" novalidate="novalidate">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="reminder-credential" name="email" value="{{ old('email') }}" required>
                                    <label for="email">Email</label>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary">
                                <i class="fa fa-asterisk mr-10"></i> Recuperar contraseña
                            </button>
                            <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="{{ route('login') }}">
                                <i class="si si-login text-muted mr-10"></i> Entrar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
