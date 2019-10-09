<section class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('nombre', 'Nombre de la familia') }}
                    {{ Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre']) }}  
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('grupo', 'Grupo al que pertenece') }}
                    {{ Form::text('grupo', null, ['class' => 'form-control', 'id' => 'grupo']) }}  
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