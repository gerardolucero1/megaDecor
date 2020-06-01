@extends('layouts.backendSimple')
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
                            
                           
                        </div>
                    </div>
                    @php
                            $usuario = Auth::user()->id; 
                            if(isset($familiaSeleccionada)){ 
                            $ultimoInventario =  App\Register::orderBy('id', 'ASC')->where('motivo', $familiaSeleccionada)->first();
                            }
                    @endphp
                    <div class="block-header block-header-default">
                        <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Inventario</h3>
                        <form target="_blank" method="POST" action="{{route('imprimir.familia')}}" >
                                @if(isset($familiaSeleccionada))
                                <input type="hidden" name="familia" value="{{ $familiaSeleccionada }}">
                                @endif
                                @method('POST')
                                @csrf 
                        @if(isset($familiaSeleccionada))
                            <button class="btn btn-sm btn-info" type="submit">PDF inventario fisico</button>   
                        @endif 
                        </form>    
                    </div>
                    <div class="col-md-9 text-right">
                      
                        @if(isset($ultimoInventario))
                        <p>Inventario Finalizado Miercoles 2 de abril 2020</p>
                        <button class="btn btn-primary">Hacer Inventario Nuevamente</button>
                        <form target="_blank" method="POST" action="{{route('imprimir.familiaInventarioFisico2')}}" style="display: inline-block;">
                            @if(isset($familiaSeleccionada))
                                <input type="hidden" name="familia" value="{{ $familiaSeleccionada }}">
                                <input type="hidden" name="faltante" value="no">
                            @endif

                            @method('POST')
                            @csrf 
                    @if(isset($familiaSeleccionada))
                        <button class="btn btn-sm btn-info" type="submit">
                            Impresion (Todos) <li class="fa fa-print"></li>
                        </button>
                    @endif  
                    </form>
                    <form target="_blank" method="POST" action="{{route('imprimir.familiaInventarioFisico3')}}" style="display: inline-block;">
                        @if(isset($familiaSeleccionada))
                            <input type="hidden" name="familia" value="{{ $familiaSeleccionada }}">
                            <input type="hidden" name="faltante" value="no">
                        @endif

                        @method('POST')
                        @csrf 
                @if(isset($familiaSeleccionada))
                    <button class="btn btn-sm btn-info" type="submit">
                        Impresion Entrega <li class="fa fa-print"></li>
                    </button>
                @endif  
                </form>
                        @else
                        
                        
                    
                @endif
                       
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px; width:100vh">
                        
                    <h1>Familia: {{$familiaSelect}}</h1>
                    
                     <table class="table" role="grid" style="font-size: 11px; width: 80vh" >
                            <thead>
                                <tr role="row">
                                    <th>Imagen</th>
                                    <th>Servicio</th>
                                    <th>Familia</th>
                                    <th>Actual en bodega</th>
                                    <th>Actual exhibición</th>
                                    <th>Total ambas</th>

                                </tr>
                            </thead>
                            <tbody>                    
                                @if (!is_null($Inventario))
                                    @foreach ($Inventario as $inventario)
                                    @if(!$inventario->noAplica) 
                                    @php
                                    $servicio = App\PhysicalInventory::where('idProducto', $inventario->id)->get();
                                @endphp
                                @if(count($servicio)==0)
                        <tr role="row" class="odd">
                        <td class="text-center sorting_1"><img style="width: 80px" src="{{ $inventario->imagen}}"></td>
                            <td style="width: 20%"><p style="width: 100px">{{ $inventario->servicio }}</p></td>
                            <td class="d-none d-sm-table-cell" style="width: 20%"><p style="width: 100px">{{ $inventario->familia }}</p></td>
                            <td style="width: 20%"><p style="width: 100px">{{$inventario->cantidad}}
                                <span id="aumentoBodega-{{ $inventario->id }}" style="color:green; display:none" class="fa fa-arrow-up"></span>
                                <span id="disminucionBodega-{{ $inventario->id }}" style="color:red; display:none" class="fa fa-arrow-down"></span>
                            </p>
                        </td>
                            <td style="width: 20%"><p style="width: 100px">{{$inventario->exhibicion}}
                                <span id="aumentoExhibicion-{{ $inventario->id }}" style="color:green; display:none" class="fa fa-arrow-up"></span>
                                <span id="disminucionExhibicion-{{ $inventario->id }}" style="color:red; display:none" class="fa fa-arrow-down"></span></p>
                            </td>
                           
                            @php
                                $precioUnitario=number_format($inventario->precioUnitario,2);
                            @endphp
                             @if($usuario != 2)
                            @endif
                            <td id="totalDif-{{ $inventario->id }}" style="text-align:center; font-weight: bold">
                                    {{ ($inventario->cantidad + $inventario->exhibicion) }}
                                </td>
                            <td class="d-flex" style="box-sizing: content-box;">
                                   

                                    <i class="fa fa-check" style="color:green; display:none; font-size:25px" id="label-check-{{ $inventario->id }}"></i>
                                
                            </td>
                        </tr>
                        @else
                        @php
                            $servicioDatos = App\PhysicalInventory::where('idProducto', $inventario->id)->first();
                        @endphp
                        <tr role="row" class="odd">
                                <td class="text-center sorting_1"><img style="width: 80px" src="{{ $inventario->imagen}}"></td>
                                <td class="" style="width: 20%"><p style="width: 150px">{{ $inventario->servicio }}</p></td>
                                <td  class="d-none d-sm-table-cell" style="width: 20%"><p style="width: 150px">{{ $inventario->familia }}</p></td>
                                <td style="text-align: center" style="width: 20%"><p style="width: 100px">{{$servicioDatos->antesBodega}}</p></td>
                               
                                <td style="text-align: center" style="width: 20%"><p style="width: 100px">{{$servicioDatos->antesExhibicion}}</p></td>
                               
                                
                                
                            </tr>
                        @endif
                                    @endif
                                    
                            @endforeach
                            @endif
                       
                            
                            </tbody>
                     </table>
                            </div>
                        </div>
                </div>
                <!-- Vista presupuestos archivados -->
                
       

                
               
    </section>
   
    @include('modals.agregarFamilia')
@endsection

@section("scripts")
    <script>
        window.print();
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
        document.getElementById('inputfamilia2').value=NombreFamilia;
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


        function RegistrarActualizado(id, cantidad){
            //alert(cantidad);
            let nuevaCantidad = prompt('Ingresa la cantidad obtenida en el inventario fisico');
            let URL = 'registrar-cantidad-actualizada/' + id;

            dataTotalDif = 'totalDif-' + id

            let data = 'cantidad-' + id;
            let aumento = 'aumentoBodega-' + id;
            let disminucion = 'disminucionBodega-' + id;
            let td = document.getElementById(data);
            let up = document.getElementById(aumento);
            let down = document.getElementById(disminucion);
            let btncheck = 'btn-check-'+id;
            let labelcheck = 'label-check-'+id;
            

            let dif1 = 'dif1-' + id
            let tdDif1 = document.getElementById(dif1);

            let dif2 = 'dif2-' + id
            let tdDif2 = document.getElementById(dif2);

            let valorDif2 = parseInt(tdDif2.innerHTML)

            let totalDif = document.getElementById(dataTotalDif);
            
    
            parseInt(nuevaCantidad);

            td.innerHTML = nuevaCantidad;

            if(isNaN(nuevaCantidad)){
                alert('Ingresa un valor valido');
            }else{
             axios.put(URL, {
                 'cantidad':  nuevaCantidad,
             }).then((response) => {
                console.log(nuevaCantidad)
                tdDif1.innerHTML = (nuevaCantidad - cantidad);
                td.innerHTML = nuevaCantidad;

                totalDif.innerHTML = ((nuevaCantidad - cantidad)) + (valorDif2)
                
                if(nuevaCantidad>=cantidad){
                up.style.display="inline";
                down.style.display="none";
                }else{
                up.style.display="none";
                down.style.display="inline";  
                } 
               
                //location.reload();
             }).catch((error) => {
                 console.log(error.data);
             })
            }

            
        }
        
        function RegistrarActualizado2(id, cantidad){
            //alert(cantidad);
            let nuevaCantidad = cantidad;
            let URL = 'registrar-cantidad-actualizada/' + id;
            let btncheck = 'btn-check-'+id;
            let labelcheck = 'label-check-'+id;
            document.getElementById(btncheck).style.display="none";
            document.getElementById(labelcheck).style.display="inline";

            let data = 'cantidad-' + id;
            let aumento = 'aumentoBodega-' + id;
            let disminucion = 'disminucionBodega-' + id;
            let td = document.getElementById(data);
            let up = document.getElementById(aumento);
            let down = document.getElementById(disminucion);

           
            
            

            parseInt(nuevaCantidad);

            if(isNaN(nuevaCantidad)){
                alert('Ingresa un valor valido');
            }else{
             axios.put(URL, {
                 'cantidad':  nuevaCantidad,
             }).then((response) => {

                Swal.fire({
            title: 'Registro Exitoso',
            text: "El elemento se actualizo correctamente",
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            
            
        })

                td.innerHTML = nuevaCantidad;
                
                if(nuevaCantidad>=cantidad){
                up.style.display="inline";
                down.style.display="none";
                }else{
                up.style.display="none";
                down.style.display="inline";  
                } 
               
                //location.reload();
             }).catch((error) => {
                 console.log(error.data);
             })
            }

            
        }


        function RegistrarExhibicionActualizado(id, cantidad){

            let nuevaCantidad = prompt('Ingresa la cantidad obtenida en el inventario fisico');

            let dataTotalDif = 'totalDif-' + id

            let URL = 'registrar-cantidad-actualizada2/' + id;

            let data = 'exhibicion-' + id;
            let aumento = 'aumentoExhibicion-' + id;
            let disminucion = 'disminucionExhibicion-' + id;
            let td = document.getElementById(data);
            let up = document.getElementById(aumento);
            let down = document.getElementById(disminucion);
            let btncheck = 'btn-check-'+id;
            let labelcheck = 'label-check-'+id;
            console.log(td)

            let totalDif = document.getElementById(dataTotalDif);

            let dif1 = 'dif1-' + id
            let tdDif1 = document.getElementById(dif1);
            
            let valorDif1 = parseInt(tdDif1.innerHTML)

            let dif2 = 'dif2-' + id
            let tdDif2 = document.getElementById(dif2);

            parseInt(nuevaCantidad);

td.innerHTML = nuevaCantidad;


            if(isNaN(nuevaCantidad)){
                alert('Ingresa un valor valido');
            }else{
             axios.put(URL, {
                 'cantidad':  nuevaCantidad,
             }).then((response) => {
                tdDif2.innerHTML = (nuevaCantidad - cantidad);

                totalDif.innerHTML = ((nuevaCantidad - cantidad)) + (valorDif1)

                td.innerHTML = nuevaCantidad;
                if(nuevaCantidad>=cantidad){
                up.style.display="inline";
                down.style.display="none";
                }else{
                up.style.display="none";
                down.style.display="inline";  
                } 
               
                //location.reload();
             }).catch((error) => {
                 console.log(error.data);
             })
            }   
        }

        function cambiarDiferencia(id){
           let color = document.getElementById('btnDiferencia'+id).style.background;
            if(color=='red'){
                document.getElementById('btnDiferencia'+id).style.background="#3f9ce8";
            }else{
                document.getElementById('btnDiferencia'+id).style.background="red";
            }
           
            console.log(id)
            let URL = 'registrar-diferencia/' + id

            axios.put(URL, {
                data: '',
            }).then((response) => {
                console.log('actualizado')
            })

            
        }

        function marcar(){
            for (var i = 0; i < 12500; i++) {
                try {
                cambiarDiferencia(i);
                }catch{

                }
            }
        }

        function finalizarInventarioFisico(){
            var opcion = confirm("Al aceptar finalizar el inventario fisico se remplazaran las cantidades actuales en el inventario con las nuevas especificadas");
    if (opcion == true) {
        mensaje = "Inventario Fisico Actualizado";
	} else {
	    mensaje = "Inventario Fisico Cancelado";
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
