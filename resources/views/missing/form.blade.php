<section class="row">
    <div class="col-md-12">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('contrato', 'Contrato') }}
                    {{ Form::text('contrato', null, ['class' => 'form-control', 'id' => 'contrato']) }}  
                </div>
                <!-- Seccion de select con datos de inventario -->
                <br>
                <div class="form-material">
                        {{ Form::label('inventarios', 'Lista de articulos disponibles') }}
                    <select name="inventarios" id="seclectArticulo" style="width: 100%;" onchange="seleccionarArticulo()">
                        @foreach ($inventarios as $inventario)
                            <option value="{{ $inventario->id }}">Servicio: {{ $inventario->servicio }}  - ID:{{ $inventario->id }}</option>
                        @endforeach
                    </select> 
                </div>

                <div class="form-material">
                    {{ Form::label('id_article', 'Articulo') }}
                    <label for="">Articulo actual:</label>
                    {{ Form::text('id_article', null, ['class' => 'form-control', 'id' => 'id_article']) }}  
                </div>              
                <br>
                <!-- Fin de Seccion de select con datos de inventario -->
                <div class="form-material">
                    {{ Form::label('fecha', 'Fecha') }}
                    {{ Form::text('fecha', null, ['class' => 'form-control', 'id' => 'fecha']) }}  
                </div>
                <div class="form-material">
                    {{ Form::label('nombre_de_persona', 'Nombre del encargado') }}
                    {{ Form::text('nombre_de_persona', null, ['class' => 'form-control', 'id' => 'nombre_de_persona']) }}  
                </div>
                <div class="form-material">
                    {{ Form::label('descripcion', 'Descripcion') }}
                    {{ Form::text('descripcion', null, ['class' => 'form-control', 'id' => 'descripcion']) }}  
                </div>                
                <div class="form-material">
                    {{ Form::label('cantidad_que_falta', 'Cantidad faltante') }}
                    {{ Form::text('cantidad_que_falta', null, ['class' => 'form-control', 'id' => 'cantidad_que_falta']) }}  
                </div>
                <div class="form-material">
                    {{ Form::label('dias_desde_no_regreso', 'Retraso en dias') }}
                    {{ Form::text('dias_desde_no_regreso', null, ['class' => 'form-control', 'id' => 'dias_desde_no_regreso']) }}  
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
<script>
    function seleccionarArticulo(){
               NombreArticulo = document.getElementById('seclectArticulo').value;
            document.getElementById('id_article').value=NombreArticulo;
            }
</script>