
<section class="row">
    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('servicio', 'Servicio') }}
                    {{ Form::text('servicio', null, ['class' => 'form-control', 'id' => 'servicio']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('cantidad', 'Cantidad en bodega') }}
                    {{ Form::text('cantidad', null, ['class' => 'form-control', 'id' => 'cantidad']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('exhibicion', 'En exhibicion') }}
                    {{ Form::text('exhibicion', null, ['class' => 'form-control', 'id' => 'exhibicion']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row" style="display:none">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('disponible', 'Disponibles') }}
                    {{ Form::hidden('disponible', null, ['class' => 'form-control', 'id' => 'disponible']) }}  
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('precioVenta', 'Costo Proveedor') }}
                    {{ Form::text('precioVenta', null, ['class' => 'form-control', 'id' => 'precioVenta']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('precioUnitario', 'Precio unitario') }}
                    {{ Form::text('precioUnitario', null, ['class' => 'form-control', 'id' => 'precioUnitario']) }}  
                </div>
            </div>
        </div>
<!-- -->
<div class="form-group row">
        <div class="col-md-12">
            <br>
            <label for="">Selecciona un provedor</label>
                <select name="provedor" id="selectprovedor" style="width: 100%" onchange="seleccionarProvedor()">
                        <option value="">Selecciona un provedor</option>
                    @foreach($provedores as $provedor)    
                    <option value="{{$provedor->nombre}}">{{$provedor->nombre}}</option>
                    @endforeach
                    </select>
            <div class="form-material">
                {{ Form::label('provedor', 'provedor') }}
                <label for=""> Provedor seleccionado:</label>
                {{ Form::text('provedor', null, ['class' => 'form-control', 'id' => 'provedor', 'disabled' => 'true']) }}  
            </div>
        </div>
    </div>

    </div>
    <div class="col-md-4">

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    <select name="selectmoneda" id="selectmoneda" onchange="seleccionarMoneda()">
                        <option value="">Selecciona tipo de cambio</option>
                        <option value="MXN">MXN</option>
                        <option value="DLLS">DLLS</option>
                    </select>
                    {{ Form::label('tipoCambio', 'Tipo de cambio') }}
                    {{ Form::text('tipoCambio', null, ['class' => 'form-control', 'id' => 'tipoCambio']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('imagen', 'Imagen') }}
                    {{ Form::file('imagen', ['class' => 'form-control']) }} 
                </div>
            </div>
        </div>
        <div class="form-group row">
                <div class="col-md-12">
                    <label for="">Selecciona una familia</label>
                        <select name="familia" id="selectfamilia" style="width: 100%" onchange="seleccionarFamilia()">
                                <option value="">Selecciona una familia</option>
                            @foreach($familias as $familia)    
                            <option value="{{$familia->nombre}}">{{$familia->nombre}}</option>
                            @endforeach
                            </select>
                    <div class="form-material">
                        {{ Form::label('familia', 'Familia') }}
                        <label for="">Familia seleccionada:</label>
                        {{ Form::text('familia', null, ['class' => 'form-control', 'id' => 'familia', 'disabled' => 'true']) }}  
                    </div>
                </div>
            </div>
            
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-info">Guardar</button>
        </div>
    </div>
</section>
<script>
function seleccionarFamilia(){
           NombreFamilia = document.getElementById('selectfamilia').value;
        document.getElementById('familia').value=NombreFamilia;
        }
function seleccionarProvedor(){
        NombreProvedor = document.getElementById('selectprovedor').value;
        document.getElementById('provedor').value=NombreProvedor;
        }
function seleccionarMoneda(){
           TipoCambio = document.getElementById('selectmoneda').value;
        document.getElementById('tipoCambio').value=TipoCambio;
        }
</script>