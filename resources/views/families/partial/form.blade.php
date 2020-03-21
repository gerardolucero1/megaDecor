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

            <label for="">Grupo al que pertenece, define el texto que aparecera en el contrato del cliente </label>
                <div class="form-material">
                
                    <select name="grupo" id="" style="width: 100%;">
                        @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->nombre }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select> 
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