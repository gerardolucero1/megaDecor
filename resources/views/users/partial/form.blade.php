<div class="container">
    <div class="row">
        <div class="col-md-12 p-4">
            <div class="form-group">
                {{ Form::label('nameUser', 'Nombre de usuario') }}
                {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'nameUser']) }}  
            </div>
            <div class="form-group">
                {{ Form::label('emailUser', 'Email de usuario') }}
                {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'emailUser']) }}
            </div>
            <div class="form-group">
                {{ Form::label('passwordUser', 'Nueva contraseña') }}
                {{ Form::password('password', ['class' => 'form-control', 'id' => 'passwordUser']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4 p-4">
            <button type="submit" class="btn btn-sm btn-block btn-info">Guardar</button>
        </div>
    </div>
</div>