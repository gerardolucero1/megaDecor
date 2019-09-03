@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">

        <div class="row" style="padding-left: 25px; padding-right:25px;">
                <div class="col-6 col-lg-4  col-xl-4"><a href="javascript:void(0)" class="block block-link-shadow text-right">
                <div class="block-content block-content-full clearfix"><div class="float-left mt-10 d-none d-sm-block">
                <i class="fa fa-star" style="font-size: 40px;"></i>
                </div> 
                    <div class="font-size-h3 font-w600 js-count-to-enabled">Margarita Robles</div> 
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Ventas: 10</div></div></a></div>

                    <div class="col-6 col-lg-4  col-xl-4"><a href="javascript:void(0)" class="block block-link-shadow text-right">
                        <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                        <i class="fa fa-star" style="font-size: 40px;"></i></div> 
                        <div class="font-size-h3 font-w600 js-count-to-enabled">Margarita Robles</div> 
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Ventas: 10</div></div></a></div>
            
           
        </div>
        <div class="block-content">
                    <form action="be_forms_elements_material.php" method="post" onsubmit="return false;">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-text" name="material-text" placeholder="Meta de ventas a superar">
                                    <label for="material-text">Meta</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="password" class="form-control" id="material-password" name="material-password" placeholder="Bono grupal">
                                    <label for="material-password">Bono grupal si se supera</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material">
                                    <input type="email" class="form-control" id="material-email" name="material-email" placeholder="Bono grupal">
                                    <label for="material-email">Bono grupal si no se supera</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material">
                                    <input type="email" class="form-control" id="material-email" name="material-email" placeholder="Bono empleado del mes">
                                    <label for="material-email">Bono empleado del mes</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material">
                                    <input type="email" class="form-control" id="material-email" name="material-email" placeholder="Establecer minimo de venta para comision">
                                    <label for="material-email">Minimo de venta</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-secondary btn-block min-width-125">Summit</button>
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
                </div>
               
    </section>
   
    @include('../modals/nuevoClienteModal')
    @include('../modals/tiposEmpresaModal')
    @include('../modals/comoSupoModal')
@endsection
@section("scripts")
<script>
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