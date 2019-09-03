@extends('layouts.simple')

@section('content')
<div class="bg-gd-dusk">
    <div class="hero-static content content-full bg-white js-appear-enabled animated fadeIn" data-toggle="appear">
        <div class="py-30 px-5 text-center">
            <a class="link-effect font-w700" href="index.php">
                <i class="si si-fire"></i>
                <span class="font-size-xl text-primary-dark">code</span><span class="font-size-xl">base</span>
            </a>
            <h1 class="h2 font-w700 mt-50 mb-10">Welcome to Your Dashboard</h1>
            <h2 class="h4 font-w400 text-muted mb-0">Please sign in</h2>
        </div>
        <div class="row justify-content-center px-5">
            <div class="col-sm-8 col-md-6 col-xl-4">
                <form class="js-validation-signin" action="{{ route('login') }}" action="be_pages_auth_all.php" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material">
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                <label for="email">Email</label>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material">
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" required>
                                <label for="password">Contraseña</label>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row gutters-tiny">
                        <div class="col-12 mb-10">
                            <button type="submit" class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary">
                                <i class="si si-login mr-10"></i> Entrar
                            </button>
                        </div>
                        <div class="col-sm-6 mb-5">
                            <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="{{ route('register') }}">
                                <i class="fa fa-plus text-muted mr-5"></i> Nueva cuenta
                            </a>
                        </div>
                        <div class="col-sm-6 mb-5">
                            <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="{{ route('password.request') }}">
                                <i class="fa fa-warning text-muted mr-5"></i> ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
