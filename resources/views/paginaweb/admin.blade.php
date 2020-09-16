@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">
                
            <div class="content" id="PresupuestosActivos">
            <div class="block" id="divLista">
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                        <h3 class="block-title" style="color:green">Galería Categorías</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        <a href="{{ route('gallery.create') }}" class="btn btn-primary">
                            <i class="fa fa-calendar-plus-o"></i> <i>Crear Categoria</i> 
                        </a>
                    </div>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Foto Principal</th>
                                    <th class="d-none d-sm-table-cell">Categoría</th>
                                    <th class="d-none d-sm-table-cell">Fotos</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>  
                                        <td><button class="btn btn-info">Ver</button></td>  
                                    </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
         
               
    </section>
   
    
@endsection
@section("scripts")
<script>
</script>

@endsection