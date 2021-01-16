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
    <section class="container-fluid">
    
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


                        <form method="POST" target="_blank" action="{{route('imprimir.familia')}}" >
                                @method('POST')
                                @csrf 
                            <input type="hidden" name="familia" id="inputfamilia" value="">
                        <button class="btn btn-sm btn-info" type="submit">PDF inventario fisico</button>    
                        </form>    

                        <form id="pdfpt2" method="POST" target="_blank" action="{{route('imprimir.familiapt2')}}" >
                            @method('POST')
                            @csrf 
                        <input type="hidden" name="familia" id="inputfamiliapt2" value="">
                    <button class="btn btn-sm btn-info" type="submit">PDF inventario fisico pt2</button>    
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
                
                    <div style="padding:15px; padding-top:30px;">
                    
                     <table style="font-size: 11px;" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaInventario" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Imagen</th>
                                    <th>Servicio</th>
                                    <th>Total bodega</th>
                                    <th>Total exhibición</th>
                                    <th>Precio Unitario</th>
                                    <th>Proveedor</th>
                                    <th>Familia</th>
                                    <th>Ultima Modif. Precio</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            
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
$(document).ready( function () {
    $('#TablaInventario').DataTable({ 
        "serverSide" : true,
        "ajax" : "{{ url('api/inventariott')}}",
        "columns": [
            {data: 'img'},
            {data: 'servicio'},
            {data: 'cantidad'},
            {data: 'exhibicion'},
            {data: 'precioUnitario'},
            {data: 'proveedor1'},
            {data: 'familia'},
            {data: 'updated_at'},
            {data: 'btn'},
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 50,
        
    });
} ); 
</script>
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
        // function archivarPresupuesto(){
    
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //         }).then((result) => {
        //         if (result.value) {
        //             let URL = 'inventario/delete/' id;
        //             Swal.fire(
        //             'Deleted!',
        //             'Your file has been deleted.',
        //             'success'
        //             )
        //         }
        //     })
        // }
        function seleccionarFamilia(){
            
           NombreFamilia = document.getElementById('familia2').value;
           document.getElementById('pdfpt2').style.display='none';
           
           //alert(NombreFamilia);
        document.getElementById('inputfamilia').value=NombreFamilia;
        document.getElementById('inputfamiliapt2').value=NombreFamilia;
        if(NombreFamilia=='Centros de Mesa' || NombreFamilia =='FLORES, FOLLAJES Y TRONCOS' || NombreFamilia = "MOBILIARIO Y EQUIPO"){
        document.getElementById('pdfpt2').style.display='block';
        }
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

