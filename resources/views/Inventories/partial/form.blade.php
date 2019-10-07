
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
                    <select name="selectmoneda" id="selectmoneda" onchange="seleccionarMoneda()">
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
                                <option value="AIRES - CALENTONES">AIRES - CALENTONES</option>
                                <option value="BEBIDAS">BEBIDAS</option>
                                <option value="BODEGA MATERIAL DE TRABAJO">BODEGA MATERIAL DE TRABAJO</option>
                                <option value="BOLOS">BOLOS</option>
                                <option value="Bolsitas Celofan">Bolsitas Celofan</option>
                                <option value="BOLSITAS PARA DULCES">BOLSITAS PARA DULCES</option>
                                <option value="Botanas">Botanas</option>
                                <option value="BOTARGA">BOTARGA</option>
                                <option value="BRINCA BRINCA">BRINCA BRINCA</option>
                                <option value="CAJAS">CAJAS</option>
                                <option value="CAMINOS">CAMINOS</option>
                                <option value="CARPAS">CARPAS</option>
                                <option value="CASETAS / PEAJE">CASETAS / PEAJE</option>
                                <option value="CATERING">CATERING</option>
                                <option value="Centros de Mesa">Centros de Mesa</option>
                                <option value="COJIN">COJIN</option>
                                <option value="COROPLAS">COROPLAS</option>
                                <option value="CORTINAS">CORTINAS</option>
                                <option value="CUBRE MANTEL">CUBRE MANTEL</option>
                                <option value="CUBRE MANTEL GRANDE PARA MESAS DE DULCES">CUBRE MANTEL GRANDE PARA MESAS DE DULCES</option>
                                <option value="CUBRE SILLA">CUBRE SILLA</option>
                                <option value="DECORACION AMBIENTAL">DECORACION AMBIENTAL</option>
                                <option value="DESECHABLES">DESECHABLES</option>
                                <option value="DETALLES PARA NIÑOS">DETALLES PARA NIÑOS</option>
                                <option value="DISFRACES">DISFRACES</option>
                                <option value="DULCES">DULCES</option>
                                <option value="FALDONES">FALDONES</option>
                                <option value="FERIAS">FERIAS</option>
                                <option value="FLETE DE MOVILIARIO">FLETE DE MOVILIARIO</option>
                                <option value="FLORES">FLORES</option>
                                <option value="Globos">Globos</option>
                                <option value="HALLOWEEN">HALLOWEEN</option>
                                <option value="Helio">Helio</option>
                                <option value="HIELERAS">HIELERAS</option>
                                <option value="INVITACIONES /PAPELERIA/ TARJETERIA /PIN">INVITACIONES /PAPELERIA/ TARJETERIA /PIN</option>
                                <option value="LUZ , ILUMINACION">LUZ , ILUMINACION</option>
                                <option value="MANTELERIA RECTANGULAR ADULTO">MANTELERIA RECTANGULAR ADULTO</option>
                                <option value="MANTELERIA NAVIDEÑA">MANTELERIA NAVIDEÑA</option>
                                <option value="MANTELERIA NIÑO">MANTELERIA NIÑO</option>
                                <option value="MANTELERIA PARA MESAS DE DULCES">MANTELERIA PARA MESAS DE DULCES</option>
                                <option value="MANTELERIA REDONDO ADULTO">MANTELERIA REDONDO ADULTO</option>
                                <option value="MAQUILLAJES">MAQUILLAJES</option>
                                <option value="MAQUINA DE PALOMITAS Y/O MAQUINA DE ALGODONES">MAQUINA DE PALOMITAS Y/O MAQUINA DE ALGODONES</option>
                                <option value="Menu Adultos">Menu Adultos</option>
                                <option value="Menu Niños">Menu Niños</option>
                                <option value="MESAS DE DULCES /FUENTES DE CHOCOLATE/QUESO/CHAMOY">MESAS DE DULCES /FUENTES DE CHOCOLATE/QUESO/CHAMOY</option>
                                <option value="MESERO / ANFITRIONAS	">MESERO / ANFITRIONAS	</option>
                                <option value="MOÑOS">MOÑOS</option>
                                <option value="MOBILIARIO Y EQUIPO">MOBILIARIO Y EQUIPO</option>
                                <option value="MOTORES">MOTORES</option>
                                <option value="NAVIDAD">NAVIDAD</option>
                                <option value="PAGOS">PAGOS</option>
                                <option value="Pastel">Pastel</option>
                                <option value="Piñata">Piñata</option>
                                <option value="POSTRE">POSTRE</option>
                                <option value="REFRACTARIOSE PAR MESAS DE DUCLES">REFRACTARIOSE PAR MESAS DE DUCLES</option>
                                <option value="Renta">Renta</option>
                                <option value="ROCKOLA - KARAOKE">ROCKOLA - KARAOKE</option>
                                <option value="SERVILLETAS">SERVILLETAS</option>
                                <option value="Show">Show</option>
                                <option value="TALLERES">TALLERES</option>
                                <option value="TELAS DECORATIVAS">TELAS DECORATIVAS</option>
                                <option value="TOBOGANES DE AGUA">TOBOGANES DE AGUA</option>
                                <option value="TRAJE PERSONAJES">TRAJE PERSONAJES</option>
                                <option value="VELA">VELA</option>
                                <option value="VIDEO - FOTOGRAFIA">VIDEO - FOTOGRAFIA</option>
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
function seleccionarMoneda(){
           TipoCambio = document.getElementById('selectmoneda').value;
        document.getElementById('tipoCambio').value=TipoCambio;
        }
</script>