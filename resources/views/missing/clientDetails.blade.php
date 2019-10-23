    <section class="container">
        <h1>Detalles del cliente</h1>
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
                    @if($cliente!=null)
                        <tr role="row" class="odd">

                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->clave }}</td>
                            <td>{{ $cliente->nombreCliente }}</td>
                            <td>{{ $cliente->tipoPersona }}</td>
                            
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
          <p class="badge badge-info">{{ $cliente->id }}</p>
        </div>

        <div class="form-group">
          <label for="pwd">CLAVE:</label>
          <p class="badge badge-info">{{ $cliente->clave }}</p>
        </div>
        
        <div class="form-group">
            <label for="email">NOMBRE CLIENTE:</label>
            <p class="badge badge-info">{{ $cliente->nombreCliente }}</p>
        </div>
      
        <div class="form-group">
            <label for="pwd">TIPO DE PERSONA:</label>
            <p class="badge badge-info">{{ $cliente->tipoPersona }}</p>
        </div>
              
        <a href="/missing" class="btn btn-primary btn-block">Volver</a>
      </form>
    </div>
