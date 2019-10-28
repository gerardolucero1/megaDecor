    <section class="container">
        <h1>Detalles del Articulo</h1>
        <table  style="font-size: 11px" class="table table-bordered table-striped table-vcenter js-dataTable-full dataTable no-footer" id="TablaPresupuestos" role="grid" >
                <thead>
                    <tr role="row">
                        
                        <!-- (Nombre, Telefono, Correo, Dirección) -->
                        <th>id</th>
                        <th>contrato</th>
                        <th>fecha</th>
                        <th>nombre_de_persona</th>
                        <th>descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    @if($cliente!=null)
                        <tr role="row" class="odd">

                            <td>{{ $faltanteArticulo->id }}</td>
                            <td>{{ $faltanteArticulo->contrato }}</td>
                            <td>{{ $faltanteArticulo->fecha }}</td>
                            <td>{{ $faltanteArticulo->nombre_de_persona }}</td>
                            <td>{{ $faltanteArticulo->descripcion }}</td>
                            
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
          <p class="badge badge-info">{{ $faltanteArticulo->id }}</p>
        </div>

        <div class="form-group">
          <label for="pwd">contrato:</label>
          <p class="badge badge-info">{{ $faltanteArticulo->contrato }}</p>
        </div>
        
        <div class="form-group">
            <label for="email">fecha:</label>
            <p class="badge badge-info">{{ $faltanteArticulo->fecha }}</p>
        </div>
      
        <div class="form-group">
            <label for="pwd">nombre_de_persona:</label>
            <p class="badge badge-info">{{ $faltanteArticulo->nombre_de_persona }}</p>
        </div>
        <div class="form-group">
            <label for="pwd">descripcion:</label>
            <p class="badge badge-info">{{ $faltante->descripcion }}</p>
        </div>
              <hr><br>
      </form>
    </div>
