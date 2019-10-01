@extends('layouts.backend')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<style>
        table.dataTable td{
        box-sizing: inherit;
        }
        </style>
@endsection
@section('content')


    <section class="container">
        <div class="row">
            <div id="divCalendario" style="display:none" class="col-md-12">
                
                    <div class="block">

                        <div class="block-content block-content-full text-right">
                                <button style="margin-bottom: 15px;" class="btn btn-primary" onclick="vista_lista()">
                                        <i class="fa fa-list"></i> <i>Vista Lista</i> 
                                    </button>
                    <div id='calendar'></div>
                        </div>
                    </div>
                </div>
        
       
    </div>
        <div class="content" id="PresupuestosActivos">
                <div class="block" id="divLista">
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Inventario</h3>

                        <form action="{{ route('inventario.filtro') }}" method="POST">
                            @method('POST')
                            @csrf
                            <select name="familia" id="">
                                <option value="">Todos los elementos</option>
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

                            <button type="submit" class="btn btn-sm btn-info">Buscar</button>
                        </form>
                    </div>
                    <div class="col-md-9 text-right">
                           
                                    <a class="btn btn-primary" href="{{ route('inventory.create') }}">
                                            <i class="fa fa-calendar-plus-o"></i> <i>Crear Elemento</i> 
                                    </a>
                                        
                                   
                    </div>
                    </div>
                    <div style="padding:15px; padding-top:30px;">
                     <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Imagen</th>
                                    <th>Servicio</th>
                                    <th>Total bodega</th>
                                    <th>Total exhibición</th>
                                    <th>Precio Unitario</th>
                                    <th>Costo</th>
                                    <th>Proveedor</th>
                                    <th>Familia</th>
                                    <th>Ultima Edición</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>                    
                                @if (!is_null($Inventario))
                                    @foreach ($Inventario as $inventario)                      
                            <tr role="row" class="odd">
                            <td class="text-center sorting_1"><img style="width: 80px" src="{{ $inventario->imagen}}"></td>
                                <td class="">{{ $inventario->servicio }}</td>
                                <td>{{ $inventario->cantidad }}</td>
                                <td>{{ $inventario->exhibicion }}</td>
                                @php
                                    $precioUnitario=number_format($inventario->precioUnitario,2);
                                @endphp
                                <td style="background:#FFF9D3" class="d-none d-sm-table-cell">${{ $precioUnitario }}</td>
                                <td class="d-none d-sm-table-cell">{{ $inventario->precioVenta }}</td>
                                <td class="d-none d-sm-table-cell">{{ $inventario->proveedor1 }}</td>
                                <td class="d-none d-sm-table-cell">{{ $inventario->familia }}</td>
                                <td class="d-none d-sm-table-cell text-center">{{ $inventario->updated_at }}</td>
                                <td class="d-flex" style="box-sizing: content-box;">
                                    @if (Auth::user()->id == 17 )
                                    <a style="margin-right:4px;" href="{{ route('inventory.edit', $inventario->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Editar" data-original-title="Editar Presupuesto">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button disabled style="margin-right:4px;" onclick="archivarPresupuesto()" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Archivar Presupuesto" data-original-title="View Customer">
                                        <i class="fa fa-remove"></i> 
                                    </button>
                                <button disabled class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    @else
                                        SIN PERMISOS
                                    @endif
                                    
                                </td>
                            </tr>
                            @endforeach
                            @endif
                       
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
                <!-- Vista presupuestos archivados -->
                

                
               
    </section>
   
    
@endsection

@section("scripts")
    <script>
        function vista_calendario(){
        document.getElementById('divCalendario').style.display="block";
        document.getElementById('divLista').style.display="none";
    }
    function vista_lista(){
        document.getElementById('divCalendario').style.display="none";
        document.getElementById('divLista').style.display="block";
    }
    function archivarCliente(){
        Swal.fire({
            title: '¿Estas seguro de archivar este presupuesto?',
            text: "Al archivar un presupuesto dejara de estar disponible en la tabla de presupuestos",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
            
        }).then((result) => {
        if (result.value) {
            var url= '/presupuestos/eliminar-presupuestos/'+task;
            axios.delete(url).then(response =>{
                this.obtenerTareas();
                }) 
            }
                            
        })
    }
    function presupuestosArchivados(){
        document.getElementById('presupuestosArchivados').style.display="block";
        document.getElementById('PresupuestosActivos').style.display="none";
    }
    function PresupuestosActivos(){
        document.getElementById('presupuestosArchivados').style.display="none";
        document.getElementById('PresupuestosActivos').style.display="block";
    }
    </script>

@endsection
