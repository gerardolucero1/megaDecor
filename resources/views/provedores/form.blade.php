<section class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('nombre', 'Nombre del provedor') }}
                    {{ Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre']) }}  
                </div>
                <div class="form-material">
                    {{ Form::label('telefono', 'telefono del provedor') }}
                    {{ Form::text('telefono', null, ['class' => 'form-control', 'id' => 'telefono']) }}  
                </div>
                <div class="form-material">
                    {{ Form::label('correo', 'correo del provedor') }}
                    {{ Form::text('correo', null, ['class' => 'form-control', 'id' => 'correo']) }}  
                </div>
                <div class="form-material">
                    {{ Form::label('direccion', 'direccion del provedor') }}
                    {{ Form::text('direccion', null, ['class' => 'form-control', 'id' => 'direccion']) }}  
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="row">
    <div class="col-md-4 offset-md-4">
        <button type="submit" class="btn btn-sm btn-primary btn-block">Enviar</button>
    </div>
</section>
<!--
            $table->increments('id');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('correo');
            $table->string('direccion');
            $table->timestamps();

-->