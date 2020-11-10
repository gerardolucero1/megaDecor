@extends('layouts.simple')

@section('content')
<div class="bg-gd-dusk" >
    <div class="hero-static content content-full js-appear-enabled animated fadeIn" data-toggle="appear" style="background: url('https://wallpapercave.com/wp/z1e1yxC.jpg'); background-siz:200% 100%; width: 100vw; max-width: 100vw" >
        <div class="py-30 px-5 text-center" >
            <a class="font-w700" href="">
                <img src="https://adpro3d-os.com/megamundo/mega-mundo-decor.png" width="30%" style="background:rgba(255,255,255,1); padding:20px; border-radius:40px">
            </a>
            <h2 class="h4 font-w400 text-muted mb-0" style="color:white; font-style:italic; padding-top: 20px">Ingresa tus datos para acceder al sistema</h2>
        </div>
        <div class="row justify-content-center px-5">
            <div class="col-sm-8 col-md-6 col-xl-4">
                <form class="js-validation-signin" action="{{ route('login') }}" action="be_pages_auth_all.php" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material">
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required autofocus style="border-radius:15px; border:none; padding:10px; background:white">
                                <label for="email" style="color:#BCB216; padding-left:10px">Introduce Tu Email</label>
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
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" required style="border-radius:15px; border:none; padding:10px; background:white">
                                <label for="password" style="color:#BCB216; padding-left:10px">Introduce Tu Contraseña</label>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row gutters-tiny">
                        <div class="col-6 mb-10">
                            <button type="submit" class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-primary" style="background:url('https://png.pngtree.com/thumb_back/fw800/background/20190221/ourmid/pngtree-creative-gold-flash-sheet-metal-background-gold-image_15891.jpg'); background-size:100% 100%; border:none; color:black;">
                                <i class="si si-login mr-10"></i> Entrar
                            </button>
                        </div>
                        <div class="col-sm-6 mb-5">
                                <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="{{ route('password.request') }}" style="background:url('https://img.freepik.com/vector-gratis/fondo-textura-metal_46250-1743.jpg?size=626&ext=jpg'); background-size:100% 100%; border:none; padding:6px">
                                    <i class="fa fa-warning text-muted mr-5"></i> ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        <div style="display:none" class="col-sm-6 mb-5">
                            <a style="display:none" class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="{{ route('register') }}">
                                <i class="fa fa-plus text-muted mr-5"></i> Nueva cuenta
                            </a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
