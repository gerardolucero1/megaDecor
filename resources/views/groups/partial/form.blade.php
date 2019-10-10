<section class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material">
                        {{ Form::label('nombre', 'Nombre del grupo') }}
                        {{ Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre']) }}  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material">
                        {{ Form::label('informacion', 'Requisitos') }}
                        {{ Form::textarea('informacion', null, ['class' => 'form-control', 'id' => 'informacion']) }}  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material">
                        {{ Form::label('observaciones', 'Observaciones') }}
                        {{ Form::textarea('observaciones', null, ['class' => 'form-control', 'id' => 'observaciones']) }}  
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