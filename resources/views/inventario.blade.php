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

@php
            $date = Carbon\Carbon::now();
            $usuario = Auth::user()->id; 
            $permisos = App\Permission::where('user_id', $usuario)->first();   
        @endphp
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
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                use App\Family;
                                $familias=Family::orderBy('nombre', 'ASC')->get();
                            @endphp
                            @if($permisos->inventarioImpresionTransferencias==1)
                             <form action="{{route('imprimir.transferencias')}}" method="GET" target="_blank" name="f1" id="f1">
                                
                                    @csrf
                                    <div class="row" style="padding:20px;">
                                <div class="col-12">
                                    <label for="">Movimientos Bodega - Exhibición</label>
                                </div>
                                    <select name="familia" class="form-control col-md-3" required style="margin-right:10px" id="familia" style="width: 100%" onchange="seleccionarFamilia()">
                                                <option value="all">Todas las familias</option>
                                                @foreach($familias as $familia)    
                                                    <option value="{{$familia->nombre}}">{{$familia->nombre}}</option>
                                                @endforeach
                                    </select>
                                    <input class="form-control col-md-3" required style="margin-right:10px" type="date" name="fecha_1" id="f1d1" class="form-control" >
                                    <input class="form-control col-md-3" required style="margin-right:10px" type="date" name="fecha_2" id="fecha2" class="form-control">
                                     <button class="btn btn-info">Obtener Transferencias</button><br>
                                     
                                    </div>
                                 </form>
                                
                                 @endif
                            <form action="{{ route('inventario.filtro') }}" method="POST">
                                @method('POST')
                                @csrf   
                                <div class="row" style="padding: 10px">
                                <div class="col-md-3">
                                        <label for="">Familias:</label>
                                    <select name="familia" class="form-control" id="familia2" style="width: 100%" onchange="seleccionarFamilia()">
                                        <option value="">Todas las familias</option>
                                        @foreach($familias as $familia)    
                                            <option value="{{$familia->nombre}}">{{$familia->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3" style="display: none">
                                    <div class="form-group">
                                        <label for="">Editado Desde:</label>
                                        <input type="date" name="fecha_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3" style="display: none">
                                    <div class="form-group">
                                            <label for="">Editado Hasta:</label>
                                        <input type="date" name="fecha_2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding-top:30px">
                                        <div class="form-group">
                                    <input type="submit" class="btn btn-sm btn-info" value="BUSCAR">
                                        </div>
                                </div>
                            </div>
                            </form>
                           
                        </div>
                    </div>
                    @php
                            $usuario = Auth::user()->id;    
                        @endphp 
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Inventario</h3>
                        <form method="POST" action="{{route('imprimir.familia')}}" >
                                @method('POST')
                                @csrf 
                            <input type="hidden" name="familia" id="inputfamilia" value="">
                        <button class="btn btn-sm btn-info" type="submit">PDF inventario fisico</button>    
                        </form>    
                    </div>
                    <div class="col-md-9 text-right">
                         @if($permisos->inventarioAgregarFamilia==1)
                        <a href="{{ route('familia.index') }}" class="btn btn-primary">
                            Agregar Familia
                        </a>
                        @endif
                        @if($permisos->inventarioAgregarProducto==1)
                        <a class="btn btn-primary" href="{{ route('inventory.create') }}">
                            <i class="fa fa-calendar-plus-o"></i> <i>Crear Elemento</i> 
                        </a>
                        @endif
                        
                       
                    </div>
                </div>
                <div style="padding:15px; padding-top:30px; display:none" class="mb-4">
                    <table style="font-size: 11px;" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestosHistorial" role="grid" >
                        <thead>
                            <tr role="row">
                                <th>Imagen</th>
                                <th>Servicio</th>
                                <th>Total bodega</th>
                                <th>Total exhibición</th>
                                <th>Precio Unitario</th>
                                <th>Proveedor</th>
                                <th>Familia</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                //dd($inventarioAuth);
                            @endphp
                            @if (isset($inventarioAuth))
                                @if (!is_null($inventarioAuth))
                                    @foreach ($inventarioAuth as $inventario)
                                        <tr role="row" class="odd">
                                            <td class="text-center sorting_1"><img style="width: 80px" src="{{ $inventario['imagen']}}"></td>
                                            <td class="">{{ $inventario['servicio'] }}</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>{{ $inventario['precioUnitario'] }}</td>
                                            <td>{{ $inventario['proveedor'] }}</td>
                                            <td>Sin familia</td>
                                            <td class="d-flex" style="box-sizing: content-box;">
                                                @if (array_key_exists('budget_id', $inventario))
                                                    <button onclick="event.preventDefault();
                                                        Swal.fire({
                                                            title: '¿Estas seguro?',
                                                            text: 'Se aprobara este producto',
                                                            type: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Eliminar'
                                                            }).then((result) => {
                                                            if (result.value) {
                                                                document.getElementById('aprobar-producto-{{ $inventario['id'] }}').submit();
                                                                Swal.fire(
                                                                'Aprobado!',
                                                                'El producto ha sido aprobado',
                                                                'success'
                                                                )
                                                            }
                                                        });
                                                    "
                                                    type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" title="Aprobar producto" data-original-title="Delete Client">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @else
                                                    <button onclick="event.preventDefault();
                                                        Swal.fire({
                                                            title: '¿Estas seguro?',
                                                            text: 'Se aprobara este producto',
                                                            type: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Eliminar'
                                                            }).then((result) => {
                                                            if (result.value) {
                                                                document.getElementById('aprobar-paquete-{{ $inventario['id'] }}').submit();
                                                                Swal.fire(
                                                                'Aprobado!',
                                                                'El producto ha sido aprobado',
                                                                'success'
                                                                )
                                                            }
                                                        });
                                                    "
                                                    type="submit" class="btn btn-sm btn-info" data-toggle="tooltip" title="Aprobar producto" data-original-title="Delete Client">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endif
                                                <form id="aprobar-producto-{{ $inventario['id'] }}" action="{{ route('aprobarProducto', $inventario['id']) }}" method="POST">
                                                    @method('POST')
                                                    @csrf
                                                    
                                                </form>  

                                                <form id="aprobar-paquete-{{ $inventario['id'] }}" action="{{ route('aprobarProductoPaquete', $inventario['id']) }}" method="POST">
                                                    @method('POST')
                                                    @csrf

                                                </form>  
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif 
                            @endif    
                        </tbody>
                    </table>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                    
                     <table style="font-size: 11px;" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Imagen</th>
                                    <th>Servicio</th>
                                    <th>Total bodega</th>
                                    <th>Total exhibición</th>
                                    <th>Precio Unitario</th>
                                    <th>Proveedor</th>
                                    <th>Familia</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>                    
                                @if (!is_null($Inventario))
                                    @foreach ($Inventario as $inventario)                      
                            <tr role="row" class="odd">
                            <td class="text-center sorting_1"><img style="width: 80px" src="{{ $inventario->imagen}}"></td>
                                <td class="">{{ $inventario->servicio }}</td>
                                <td class="td-bodega" id="cantidad-{{ $inventario->id }}"  @if($usuario != 2) onclick="editarCantidad({{ $inventario->id }})" @endif>{{ $inventario->cantidad }}</td>
                                <td class="td-ex" id="exhibicion-{{ $inventario->id }}"  @if($usuario != 2)  @endif>{{ $inventario->exhibicion }}</td>
                                @php
                                    $precioUnitario=number_format($inventario->precioUnitario,2);
                                @endphp
                                 @if($usuario != 2)
                                <td style="background:#FFF9D3" class="d-none d-sm-table-cell">${{ $precioUnitario }}</td>
                                <td class="d-none d-sm-table-cell">{{ $inventario->proveedor1 }}</td>
                                @endif
                                <td class="d-none d-sm-table-cell">{{ $inventario->familia }}</td>
                                <td class="d-flex" style="box-sizing: content-box;">
                                    @if (Auth::user()->id == 17 )
                                    <a style="margin-right:4px;" target="_blank" href="{{ route('inventory.edit', $inventario->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Editar" data-original-title="Editar Presupuesto">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('inventory.archivar', $inventario->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" style="margin-right:4px;" onclick="return confirm('¿Deseas archivar este producto?')" class="btn btn-sm btn-danger archivar" data-toggle="tooltip" title="Archivar Presupuesto" data-original-title="View Customer">
                                            <i class="fa fa-remove"></i> 
                                        </button>
                                    </form>
                                    <button data-id="{{ $inventario->id }}" data-tipo="alta" data-cantidad="cantidad-{{ $inventario->id }}" data-toggle="modal" data-target="#asignarAlta" class="altas btn btn-sm btn-success">
                                        <i data-id="{{ $inventario->id }}" data-tipo="alta" data-cantidad="cantidad-{{ $inventario->id }}" class="fa fa-chevron-up"></i>
                                    </button>
                                    <button data-id="{{ $inventario->id }}" data-tipo="baja" data-cantidad="cantidad-{{ $inventario->id }}" data-toggle="modal" data-target="#asignarAlta" class="bajas btn btn-sm btn-success">
                                        <i data-id="{{ $inventario->id }}" data-tipo="baja" data-cantidad="cantidad-{{ $inventario->id }}" class="fa fa-chevron-down"></i>
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
                
        <!-- modal paquete -->
        <div class="modal fade modalAgregarPaquete" id="agregarPaquete" tabindex="-1" role="dialog" aria-labelledby="agregarElemento" aria-hidden="true" style="overflow-y: scroll;">
            <div id="app" class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content" style="border: solid gray">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Crear nuevo paquete</h5>
                    <div  class="close" onClick="$('#agregarPaquete').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div  class="btn btn-secondary" onClick="$('#agregarPaquete').modal('hide')">Close</div>
                    <div  class="btn btn-primary" >Guardar paquete</div>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="asignarAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <altas-component></altas-component>
            </div>
            </div>
        </div>
                
               
    </section>
   
    @include('modals.agregarFamilia')
@endsection

@section("scripts")
    <script>
        $(function(){
            let archivar = document.getElementsByClassName('archivar');

            if(archivar.length != 0){
                for (var i = 0; i < archivar.length; i++) {
                    archivar[i].addEventListener('click', (e) => {
                        let id = e.target.dataset.archivar;
                    });
                }
            }
        })
        function archivarPresupuesto(){
    
            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     type: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, delete it!'
            //     }).then((result) => {
            //     if (result.value) {
            //         let URL = 'inventario/delete/' id;
            //         Swal.fire(
            //         'Deleted!',
            //         'Your file has been deleted.',
            //         'success'
            //         )
            //     }
            // })
        }
        function seleccionarFamilia(){
            
           NombreFamilia = document.getElementById('familia2').value;
           
           //alert(NombreFamilia);
        document.getElementById('inputfamilia').value=NombreFamilia;
        }
        function editarCantidad(id){
            let nuevaCantidad = prompt('Ingresa la cantidad que quedara en bodega, si ingresas una cantidad menor a la actual, el sobrante pasara automaticamente a exhibicion, si ingresas una cantidad mayor, la diferencia se descontara a exhibición: ');
            let URL = 'editar-cantidad-inventario/' + id;

            let data = 'cantidad-' + id;
            let td = document.getElementById(data);

            parseInt(nuevaCantidad);

            if(isNaN(nuevaCantidad)){
                alert('Ingresa un valor valido');
            }else{
                console.log(td);

             axios.put(URL, {
                 'cantidad':  nuevaCantidad,
             }).then((response) => {
                td.innerHTML = nuevaCantidad;
                location.reload();
             }).catch((error) => {
                 console.log(error.data);
             })
            }

            
        }

        function editarExhibicion(id){
            let nuevaCantidad = prompt('Ingresa la cantidad: ');
            let URL = 'editar-exhibicion-inventario/' + id;

            let data = 'exhibicion-' + id;
            let td = document.getElementById(data);

            console.log(td);

             axios.put(URL, {
                 'exhibicion':  nuevaCantidad,
             }).then((response) => {
                console.log('Cantidad actualizada');
                td.innerHTML = nuevaCantidad;
             }).catch((error) => {
                 console.log(error.data);
             })
        }

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
   
   
    </script>

@endsection
