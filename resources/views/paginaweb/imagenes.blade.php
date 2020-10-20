@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

    <section class="container">
        <a class="btn btn-info" href="/paginaweb">Volver</a>
            <div class="content" id="PresupuestosActivos">
            <div class="block" id="divLista">
                <div class="block-header block-header-default">
                    <div class="col-md-3">
                    <h3 class="block-title" style="color:green">Galería {{$galeria->name}}</h3>
                    </div>
                    <div class="col-md-9 text-right">
                        
                    </div>
                </div>

                <div class="">
                    <form action="{{ asset('/proyecto/'.$galeria->id.'/imagenes') }}"
                    class="dropzone"
                    id="my-awesome-dropzone">
                    {{ csrf_field() }}
              </form>
                </div>
                    <div style="padding:15px; padding-top:30px;">
                        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Foto Principal</th>
                                    <th class="d-none d-sm-table-cell">Categoría</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($imagenes as $imagen)
                                <tr>
                                <td><img style="width: 80px" src="{{ $imagen->imagen}}"></td>
                                <td>{{$imagen->created_at}}</td>
                                <td>
                                    <button style="display:none" onclick="event.preventDefault();
                                                        Swal.fire({
                                                            title: '¿Estas seguro?',
                                                            text: '¡No podras revertir esto!',
                                                            type: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Eliminar'
                                                            }).then((result) => {
                                                            if (result.value) {
                                                                document.getElementById('delete-photo-{{ $imagen->id }}').submit();
                                                                Swal.fire(
                                                                '¡Eliminada!',
                                                                'Elemento Eliminado',
                                                                'success'
                                                                )
                                                            }
                                                        });
                                                    "
                                                    type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar foto" data-original-title="Eliminar foto">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                    <form id="delete-photo-{{ $imagen->id }}" action="{{ route('photo.delete', $imagen->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button class="btn btn-info" id="btn-delete-{{$imagen->id}}" onclick="eliminar({{$imagen->id}})">Eliminar</button>
                            <p id="txt-delete-{{$imagen->id}}" style="display:none; color:red">Eliminado!</p>
                            </td>
                                </tr>
                                @endforeach
                            
                               
                            </tbody>
                        </table>
                    </div>
                </div>
         
               
    </section>
   
    
@endsection
@section("scripts")
<script>

function eliminar(id){
   

    document.getElementById('btn-delete-'+id).style.display="none";
    document.getElementById('txt-delete-'+id).style.display="block";
                   
    let URL = '/photo/'+id;

            axios.delete(URL).then((response) => {
                response.data.forEach((doc) => {
                   
                })
            }).catch((error) => {
                console.log(error.data);
            });

}

Dropzone.options.myAwesomeDropzone = {
    paramName: "file", // Las imágenes se van a usar bajo este nombre de parámetro
    maxFilesize: 50 // Tamaño máximo en MB
};
</script>

@endsection