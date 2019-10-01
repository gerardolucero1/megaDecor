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

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('disponible', 'Disponibles') }}
                    {{ Form::text('disponible', null, ['class' => 'form-control', 'id' => 'disponible']) }}  
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('precioVenta', 'Precio venta') }}
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

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('proveedor1', 'Proveedor 1') }}
                    {{ Form::text('proveedor1', null, ['class' => 'form-control', 'id' => 'proveedor1']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('proveedor2', 'Proveedor 2') }}
                    {{ Form::text('proveedor2', null, ['class' => 'form-control', 'id' => 'proveedor2']) }}  
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
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
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-sm btn-info">Actualizar producto</button>
        </div>
    </div>
</section>