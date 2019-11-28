
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
        <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material">
                        {{ Form::label('precioVenta', 'Costo Proveedor') }}
                        {{ Form::text('precioVenta', null, ['class' => 'form-control', 'id' => 'precioVenta']) }}  
                    </div>
                </div>
            </div>

    </div>
    <div class="col-md-4">

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('precioUnitario', 'Precio unitario') }}
                    {{ Form::text('precioUnitario', null, ['class' => 'form-control', 'id' => 'precioUnitario']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('proveedor1', 'Proveedor 1') }}
                    <select name="proveedor1" id="" class="form-control">
                        @if (isset($inventory))
                            <option value="{{ $inventory->proveedor1 }}">{{ $inventory->proveedor1 }}</option>
                        @endif
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->nombre }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        
                    </select>
                    {{-- {{ Form::text('proveedor1', null, ['class' => 'form-control', 'id' => 'proveedor1']) }}   --}}
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('proveedor2', 'Proveedor 2') }}
                    <select name="proveedor2" id="" class="form-control">
                        @if (isset($inventory))
                            <option value="{{ $inventory->proveedor2 }}">{{ $inventory->proveedor2 }}</option>
                        @endif
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->nombre }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        
                    </select>
                    {{-- {{ Form::text('proveedor2', null, ['class' => 'form-control', 'id' => 'proveedor2']) }}   --}}
                </div>
            </div>
        </div>
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
    </div>
    <div class="col-md-4">
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
                            @if (isset($inventory))
                                <option value="{{ $inventory->familia }}">{{ $inventory->familia }}</option>
                            @else
                                <option value="null">Selecciona familia</option>
                            @endif
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
        <div class="col-md-12" style="padding: 10px">
            <button type="submit" class="btn btn-sm btn-info" style="margin-left: 10px">Guardar</button>
        </div>
        
    </div>
   
</section>
<script>
function seleccionarFamilia(){
           NombreFamilia = document.getElementById('selectfamilia').value;
        document.getElementById('familia').value=NombreFamilia;
        }
function seleccionarMoneda(){
           TipoCambio = document.getElementById('selectmoneda').value;
        document.getElementById('tipoCambio').value=TipoCambio;
        }
</script>