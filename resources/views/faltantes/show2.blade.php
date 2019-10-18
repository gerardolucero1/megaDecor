@extends('layouts.backend')

@section('content')

    <section class="container">
        <h1>Detalles del articulo</h1>
        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                <thead>
                    <tr role="row">
                        
                        <!-- (Nombre, Telefono, Correo, Dirección) -->
                        <th>#</th>
                        <th>clave</th>
                        <th>nombreCliente</th>
                        <th>tipoPersona</th>
                    </tr>
                </thead>
                <tbody>
                    @if($article!=null)
                        <tr role="row" class="odd">

                            <td>{{ $article->id }}</td>
                            <td>{{ $article->clave }}</td>
                            <td>{{ $article->nombreCliente }}</td>
                            <td>{{ $article->tipoPersona }}</td>
                            
                        </tr>   
                           @endif                 
                </tbody>
            </table>
    </section>
    <br>
    <div class="container">
        <form>
            <hr>
        <div class="form-group">
          <label for="email">ID:</label>
          <p class="badge badge-info">{{ $article->id }}</p>
        </div>

        <div class="form-group">
          <label for="pwd">CLAVE:</label>
          <p class="badge badge-info">{{ $article->clave }}</p>
        </div>
        
        <div class="form-group">
            <label for="email">NOMBRE CLIENTE:</label>
            <p class="badge badge-info">{{ $article->nombreCliente }}</p>
        </div>
      
        <div class="form-group">
            <label for="pwd">TIPO DE PERSONA:</label>
            <p class="badge badge-info">{{ $article->tipoPersona }}</p>
        </div>
              
        <a href="/faltantes" class="btn btn-primary btn-block">Volver</a>
      </form>
    </div>
@endsection