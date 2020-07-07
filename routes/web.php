<?php

use App\User;
use App\Budget;
use App\Client;
use App\Missing;
use App\Payment;
use App\Register;
use App\Supplier;
use App\Inventory;
use App\Telephone;
use Carbon\Carbon;
use App\BudgetPack;
use App\MoralPerson;
use App\TaskComment;
use App\CashRegister;
use App\AboutCategory;
use App\MoralCategory;
use App\OtherPayments;
use App\Mail\CorteCaja;
use App\PhysicalPerson;
use App\BudgetInventory;
use App\PhysicalInventory;
use App\BudgetPackInventory;
use Illuminate\Http\Request;
use App\Mail\NuevoPresupuesto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Example Routes
Route::view('/', 'landing');
Auth::routes();

Route::group(['middleware' => ['auth']], function () {

 
    Route::match(['get', 'post'], '/dashboard', function(){
        return view('dashboard');
    });
    Route::get('/dashboard', 'CMS\IndexController@dashboard');

    Route::get('/obtener-usuario', function(){
        return Auth::user();
    });

    Route::get('/obtener-ultimo-presupuesto', function(){
        return Budget::orderBy('id', 'DESC')->first();
    });

    Route::get('/obtener-usuarios', function(){
        return User::orderBy('id', 'DESC')->where('tipo', '!=', 'BODEGA')->where('tipo', '!=', 'CONTABILIDAD')->where('archivado', '!=', '1')->get();
    });
    
    // Rutas del CMS
        // API Clientes
        Route::get('/telefonos', 'CMS\ClientController@telefonos');
        Route::get('/categorias', 'CMS\ClientController@categorias');
        Route::get('/about-categorias', 'CMS\ClientController@aboutCategorias');
        Route::post('/viejo-telefono', 'CMS\ClientController@viejoTelefono');
        Route::post('/clientes/crearTipoEmpresa', 'CMS\ClientController@createC')->name('NuevoTipo.createC');
        Route::get('/clientes/tipo-empresa', 'CMS\ClientController@TipoEmpresa');
        Route::delete('/viejo-telefono/{id}', 'CMS\ClientController@deleteViejoTelefono');
        Route::delete('/clientes/eliminar-tipo-empresa/{id}', 'CMS\ClientController@deleteTipo');
        //Como supo de nosotors
        Route::post('/clientes/crearComoSupo', 'CMS\ClientController@createComoSupo')->name('NuevoComoSupo.createComoSupo');
        Route::get('/clientes/comoSupo', 'CMS\ClientController@ComoSupo');
        Route::delete('/clientes/eliminar-comoSupo/{id}', 'CMS\ClientController@deleteComoSupo');
        //Tareas
        Route::get('/tareas/categorias-tareas', 'CMS\TareasController@Categorias');
        Route::get('/tareas/editar-categorias-tareas', 'CMS\TareasController@editarCategoria');
        Route::delete('/tareas/eliminar-categoria/{id}', 'CMS\TareasController@deleteCategoria');
        Route::delete('/tareas/eliminar-tarea/{id}', 'CMS\TareasController@deleteTarea');
        Route::get('/tareas/obtener-tareas', 'CMS\TareasController@ObtenerTareas');
        Route::get('/tareas/obtener-tareas-todas', 'CMS\TareasController@ObtenerTareasTodas');
        Route::get('/tareas/clientes-fisicos', 'CMS\TareasController@ClientesF');
        Route::post('/tareas/create', 'CMS\TareasController@store')->name('NuevaTarea.store');
        Route::post('/tareas/createcategory', 'CMS\TareasController@createC')->name('NuevaCategory.createC');

            //Comentar tareas
            Route::post('/comentar-tarea/{id}', function(Request $request, $id){
                $taskComment = TaskComment::create($request->all());
                return;
            });

    Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
    Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
    Route::get('/presupuestos-hoy', 'CMS\IndexController@presupuestosHoy')->name('presupuestos-hoy');
    Route::get('/presupuesto/edit/{id}', 'CMS\IndexController@editarPresupuesto')->name('editar.presupuesto');
    Route::get('/contratos', 'CMS\IndexController@contratos')->name('contratos');
    Route::get('/contratos/obtener-contratos-todos', 'CMS\IndexController@contratosTodos');
    Route::get('/contratos/obtener-presupuestos-todos', 'CMS\IndexController@presupuestosTodos');
    Route::get('/comisiones', 'CMS\IndexController@comisiones')->name('comisiones');

    Route::get('/inventario', 'CMS\IndexController@inventario')->name('inventario');
    Route::get('/inventariotest', 'CMS\IndexController@inventariotest')->name('inventariotest');
    Route::get('/inventario2', 'CMS\IndexController@inventario2')->name('inventario2');
    Route::get('/inventario3/{id}', 'CMS\IndexController@inventario3')->name('inventario3');
    Route::get('/inventario4/{id}', 'CMS\IndexController@inventario4')->name('inventario4');
    Route::post('/inventario2', 'CMS\InventoryController@inventarioFiltro2')->name('inventario.filtro2');
    Route::post('/inventario', 'CMS\InventoryController@inventarioFiltro')->name('inventario.filtro');
    Route::post('/inventario/update-product-na/{id}', 'CMS\InventoryController@updateNA')->name('inventario.updateNA');
    Route::post('/inventario/anidados/{id}', 'CMS\InventoryController@anidados')->name('inventario.anidados');
    Route::get('/obtener-nesteds/{id}', 'CMS\InventoryController@obtenerAnidados')->name('inventario.getAnidados');

   

    //Imprimir budget
    Route::get('/imprimir-budget/{id}', 'CMS\BudgetController@pdf')->name('imprimir.budget');
    Route::get('/creditos-atrasadospdf', 'CMS\IndexController@pdfCreditosAtrasados')->name('imprimir.creditosAtrasados');
    Route::get('/imprimir-budgetVentas/{id}', 'CMS\BudgetController@pdfVentas')->name('imprimir.budgetVentas');
    Route::get('/imprimir-budgetBodega/{id}', 'CMS\BudgetController@pdfBodega')->name('imprimir.budgetBodega');
    Route::get('/imprimir-budgetBodegaCliente/{id}', 'CMS\BudgetController@pdfBodegaCliente')->name('imprimir.budgetBodegaCliente');
        
    //Imprimir transferencias de inventario
    Route::get('/imprimir-transferencias', 'CMS\InventoryController@pdfTransferencias')->name('imprimir.transferencias');
    Route::get('/imprimir-recolecciones', 'CMS\BudgetController@pdfRecolecciones')->name('imprimir.recolecciones');
    
    // API Presupuestos
        Route::get('/usuarios', 'CMS\BudgetController@usuarios');
        Route::get('/budget-convertir-contrato/{id}', 'CMS\BudgetController@convertirContrato')->name('convertir.contrato');
        Route::get('/budget-desarchivar/{id}', 'CMS\BudgetController@desarchivar')->name('presupuesto.desarchivar');
        Route::get('/budget-archivar/{id}', 'CMS\BudgetController@archivar')->name('presupuesto.archivar');
        Route::post('/obtener-cliente', 'CMS\BudgetController@cliente');
        Route::get('/obtener-clientes', 'CMS\BudgetController@clientes');
        Route::get('/obtener-inventario', 'CMS\BudgetController@inventario');
        Route::get('/obtener-inventario-postres', 'CMS\BudgetController@inventarioPostres');
        Route::get('/obtener-inventario-botanas', 'CMS\BudgetController@inventarioBotanas');
        Route::get('/obtener-inventarioBocadillos', 'CMS\BudgetController@inventarioBocadillos');
        Route::get('/obtener-ultimo-presupuesto', 'CMS\BudgetController@obtenerUltimoPresupuesto');
        Route::get('/obtener-presupuesto/{id}', 'CMS\BudgetController@obtenerPresupuesto');
        Route::get('/obtener-festejados/{id}', 'CMS\BudgetController@obtenerFestejados');
        Route::get('/obtener-inventario-1/{id}', 'CMS\BudgetController@obtenerInventario1');
        Route::get('/obtener-paquetes/{id}', 'CMS\BudgetController@obtenerPaquetes');
        Route::get('/obtener-elementos-paquetes/{id}', 'CMS\BudgetController@obtenerElementosPaquetes');
        Route::get('/obtener-cliente-presupuesto/{id}', 'CMS\BudgetController@obtenerClientePresupuesto');
        
    //API calculadora Gasolina vehiculos
    Route::get('/obtener-vehiculos', 'CMS\IndexController@obtenerVehiculos');
    Route::post('/vehiculos/agregarVehiculo', 'CMS\IndexController@agregarVehiculo');
    Route::delete('/vehiculos/eliminar-vehiculo/{id}', 'CMS\IndexController@deleteVehiculo');


        //Pantalla Usuarios
        Route::get('/pantallaUsuarios', 'CMS\IndexController@pantallaUsuarios')->name('pantallaUsuarios');
        Route::get('/archivar-usuario/{id}', 'CMS\IndexController@archivarUsuario')->name('usuario.archivar');
        Route::get('/usuariosPermisos/{id}', 'CMS\IndexController@usuariosPermisos')->name('usuario.permisos');
        Route::put('/editarPermisos/{id}', 'CMS\IndexController@editarPermisos')->name('editar.permisos');

    // Todo lo referente a presupuestos
    Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
    Route::get('/presupuestos2', 'CMS\IndexController@presupuestos2')->name('presupuestos2');
    Route::get('/facturas', 'CMS\IndexController@facturas')->name('facturas');
    Route::post('/presupuestos/create', 'CMS\BudgetController@store')->name('presupuestos.store');
    Route::get('/presupuestos/ver/{id}', 'CMS\BudgetController@verPresupuesto')->name('ver.presupuesto');
    Route::get('/obtener-festejados-version/{id}', 'CMS\BudgetController@obtenerFestejadosVersion');
    Route::get('/obtener-inventario-version-1/{id}', 'CMS\BudgetController@obtenerInventarioVersion1');
    Route::get('/obtener-paquetes-version/{id}', 'CMS\BudgetController@obtenerPaquetesVersion');


    //Permisos
    Route::get('/obtener-permisos', 'CMS\IndexController@obtenerPermisos');

    //Route::resource('budget-categorias', 'CMS\BudgetCategoryController');
    Route::get('budget-categorias', 'CMS\BudgetCategoryController@index')->name('budgetCategoria.index');
    Route::post('budget-categorias', 'CMS\BudgetCategoryController@store')->name('budgetCategoria.store');
    Route::delete('budget-categorias/{id}', 'CMS\BudgetCategoryController@destroy')->name('budgetCategoria.delete');

        //Versiones
        Route::post('/presupuestos/create/version', 'CMS\BudgetController@storeVersion')->name('presupuestos.store.version');
        Route::get('/obtener-versiones/{id}', 'CMS\BudgetController@getVersions')->name('presupuestos.index.version');
        Route::get('/obtener-version/{id}', 'CMS\BudgetController@obtenerVersion');
        //Route::get('/obtener-presupuesto/{id}', 'CMS\BudgetController@obtenerPresupuesto');

    //Registrar pago
    Route::get('/obtener-pagos/{id}', 'CMS\PaymentController@index')->name('payment.index');
    Route::post('/registrar-pago', 'CMS\PaymentController@store')->name('payment.store');

    // Todo lo referente a clientes
    Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
    Route::get('/clientes2', 'CMS\IndexController@clientes2')->name('clientes2');
    Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');
    Route::get('/clientes/edit/{id}', 'CMS\ClientController@edit')->name('cliente.edit');
    Route::delete('/clientes/delete/{id}', 'CMS\ClientController@destroy')->name('cliente.delete');

        // API de clientes
        Route::get('/obtener-cliente-editar/{id}', 'CMS\ClientController@obtenerCliente');
        Route::get('/obtener-telefonos-editar/{id}', 'CMS\ClientController@obtenerTelefonos');
        Route::post('/crear-nuevo-telefono', 'CMS\ClientController@crearTelefono');
        Route::put('/clientes/update/{id}', 'CMS\ClientController@update');
        Route::put('/guardar-nuevo-telefono/{id}', 'CMS\ClientController@updateTelefono');
        Route::delete('/eliminar-nuevo-telefono/{id}', 'CMS\ClientController@deleteTelefono');

//Imprimir familia
    Route::post('/imprimir-familia', 'CMS\InventoryController@pdf')->name('imprimir.familia');
    Route::post('/imprimir-familia-inventario-fisico', 'CMS\InventoryController@pdfFamiliaInventarioFisico')->name('imprimir.familiaInventarioFisico');
    Route::post('/imprimir-familia-inventario-fisico2', 'CMS\InventoryController@pdfFamiliaInventarioFisico2')->name('imprimir.familiaInventarioFisico2');
    Route::post('/imprimir-familia-inventario-fisico3', 'CMS\InventoryController@pdfFamiliaInventarioFisico3')->name('imprimir.familiaInventarioFisico3');

    //Configuraciones
    Route::get('/configuraciones', 'CMS\CommissionController@index');
    Route::post('/configuraciones/create', 'CMS\CommissionController@store');
    Route::put('/configuraciones/update', 'CMS\CommissionController@update');

    //Ventas
    Route::get('/ventas', 'CMS\IndexController@ventas')->name('index.ventas');
    Route::post('/ventas', 'CMS\IndexController@ventasFiltro')->name('show.ventas');
    Route::get('/ventas/pdf', 'CMS\IndexController@ventasPDF')->name('pdf.ventas');
    Route::get('/ventas/{id}', 'CMS\IndexController@ventasShow')->name('ventas.show');

    //Factura
    Route::get('/factura-enviada/{id}', 'CMS\BudgetController@facturaEnviada')->name('presupuesto.facturaEnviada');

    //Emails
    Route::post('enviar-email', function(Request $request){
        
        
        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->impresion = 1;
        $presupuesto->save();

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'ASC')->where('budget_id', $presupuesto->id)->get();
        
         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }
    
        Mail::to('asamii149@gmail.com', 'Administrador')
            ->send(new NuevoPresupuesto($presupuesto, $Telefonos, $Elementos));
    });

    Route::get('enviar-email-cliente/{id}', function($id){
        $URL = $_SERVER['REQUEST_URI'];

        $URL = explode('&', $URL);
        $email = $URL[1];
        
        
        $idArray = explode('/', $URL[0]);
        $id = $idArray[2];

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->enviado = 1;
        $presupuesto->save();

        if(empty($email)){
            $email = $presupuesto->emailEnvio;
        }

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        //Obtenemos los paquetes
        $Paquetes= BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        
        $arregloEmentos=[];
        foreach($Paquetes as $paquete){
            $Elementos_paquete= BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $paquete->id)->get();
            foreach($Elementos_paquete as $Elemento_paquete){
                $arregloElemento   = new stdClass();
                $arregloElemento->imagen = $Elemento_paquete->imagen;
                $arregloElemento->servicio = $Elemento_paquete->servicio;
                $arregloElemento->cantidad = $Elemento_paquete->cantidad;
                $arregloElemento->notas = $Elemento_paquete->notas;
                $arregloElemento->budget_pack_id = $Elemento_paquete->budget_pack_id;
                array_push($arregloEmentos,$arregloElemento);
            }
           
        }
       // dd($Elemento_paquete);

         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito', 'moral_people.diasCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito', 'physical_people.diasCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }

        if(is_null($email)){
           $email = $presupuesto->emailCliente;
        }

        //dd($email);
    
        Mail::to($email, 'Presupuesto MegaMundo')
            ->send(new NuevoPresupuesto($presupuesto, $Telefonos, $Elementos, $Paquetes, $arregloEmentos));
        Mail::to('ivonnearroyosg@msn.com', 'Presupuesto MegaMundo')
            ->send(new NuevoPresupuesto($presupuesto, $Telefonos, $Elementos, $Paquetes, $arregloEmentos));
    });

    Route::get('inventario/create', 'CMS\InventoryController@create')->name('inventory.create');
    Route::get('inventario/edit/{id}', 'CMS\InventoryController@edit')->name('inventory.edit');
    Route::post('inventario/store', 'CMS\InventoryController@store')->name('inventory.store');
    Route::put('inventario/edit/{id}', 'CMS\InventoryController@update')->name('inventory.update');
    Route::put('inventario/archivar/{id}', 'CMS\InventoryController@archivar')->name('inventory.archivar');
    Route::put('inventario/no-aplica/{id}', 'CMS\InventoryController@noAplica')->name('inventory.NA');


    Route::put('editar-cantidad-inventario/{id}', function(Request $request, $id){
        $inventario = Inventory::find($id);

        if($inventario->cantidad > $request->cantidad){
            $registro = new Register();
            $registro->tipo = 'salida';
            $registro->antes = $inventario->cantidad;
            $registro->antesExhibicion = $inventario->exhibicion;
            $registro->producto = $inventario->id;
            $registro->cantidad = $inventario->cantidad - $request->cantidad;
            $registro->user_id = Auth::user()->id;
            $registro->save();

            $inventario->exhibicion = $inventario->exhibicion + $registro->cantidad;
            $inventario->save();
        }else{
            $registro = new Register();
            $registro->tipo = 'entrada';
            $registro->antes = $inventario->cantidad;
            $registro->antesExhibicion = $inventario->exhibicion;
            $registro->producto = $inventario->id;
            $registro->cantidad = $request->cantidad - $inventario->cantidad;
            $registro->user_id = Auth::user()->id;
            $registro->save();

            $inventario->exhibicion = $inventario->exhibicion - $registro->cantidad;
            $inventario->save();
        }

        $inventario->cantidad = $request->cantidad;
        $inventario->save();

        return;
    });


    Route::put('registrar-cantidad-actualizada/{id}', function(Request $request, $id){

        $data = json_decode(file_get_contents('php://input'), true);
        $cantidad = $data['cantidad'];


        $servicio = PhysicalInventory::where('idProducto', $id)->get();
        $servicioID = PhysicalInventory::where('idProducto', $id)->first();
        $servicioInventario = Inventory::where('id', $id)->first();
        
        if(count($servicio)==0){
        $registro = new PhysicalInventory();
        $registro->idProducto = $id;
        $registro->antesBodega = $servicioInventario->cantidad;
        $registro->antesExhibicion = $servicioInventario->exhibicion;
        $registro->fisicoBodega = $cantidad;
        $registro->fisicoExhibicion = $servicioInventario->exhibicion;
        $registro->diferencia = true;
        $registro->save();
        }else{
            $inventory = PhysicalInventory::find($servicioID->id);
            $inventory->fisicoBodega = $cantidad;
            $inventory->save();
        }

        return;
    });

    Route::put('registrar-cantidad-actualizada2/{id}', function(Request $request, $id){
        
        $data = json_decode(file_get_contents('php://input'), true);
        $cantidad = $data['cantidad'];


        $servicio = PhysicalInventory::where('idProducto', $id)->get();
        $servicioID = PhysicalInventory::where('idProducto', $id)->first();
        $servicioInventario = Inventory::where('id', $id)->first();
        
        if(count($servicio)==0){
        $registro = new PhysicalInventory();
        $registro->idProducto = $id;
        $registro->antesBodega = $servicioInventario->cantidad;
        $registro->antesExhibicion = $servicioInventario->exhibicion;
        $registro->fisicoBodega = $servicioInventario->cantidad;
        $registro->fisicoExhibicion = $cantidad;
        $registro->diferencia = true;
        $registro->save();
        }else{
            $inventory = PhysicalInventory::find($servicioID->id);
            $inventory->fisicoExhibicion = $cantidad;
            $inventory->save();
        }

        return;
    });

    Route::put('solicitar-factura/{id}', function($id){
        $budget = Budget::find($id);

        $budget->facturaSolicitada = 1;
        $budget->save();
        return;
    });

    Route::put('editar-exhibicion-inventario/{id}', function(Request $request, $id){
        $inventario = Inventory::find($id);

        $inventario->exhibicion = $request->exhibicion;
        $inventario->save();
        return;
    });

    Route::resource('familia', 'CMS\FamilyController');
    Route::resource('grupo', 'CMS\FamilyGroupController');

    //Generar PDF's
    Route::get('/presupuestos/generar-pdf/{id}', 'CMS\BudgetController@pdf')->name('budget.pdf');

    //Route::resource('caja', 'CMS\CashRegisterController');
    Route::get('caja', 'CMS\CashRegisterController@index')->name('caja.index');
    Route::get('caja/obtener-presupuestos', 'CMS\CashRegisterController@obtenerPresupuestos')->name('caja.obtenerPresupuestos');
    Route::get('caja/obtener-ultimopago', 'CMS\CashRegisterController@obtenerUltimoPago')->name('caja.obtenerUltimoPago');
    Route::post('caja', 'CMS\CashRegisterController@store')->name('caja.store');
    Route::put('caja/{id}', 'CMS\CashRegisterController@update')->name('caja.update');
    Route::get('caja/corte', 'CMS\CashRegisterController@corte')->name('pagos.corte');
    Route::get('caja/enviar-email', function(){
        $sesion = CashRegister::orderBy('id', 'DESC')->first();


        $registro = CashRegister::orderBy('id', 'DESC')->first();

        $date = Carbon::now();
        $fechaCorte = $registro->created_at;
        $date=$date->format('Y-m-d');
        $fechaCorte = $fechaCorte->format('Y-m-d');


        $fechaApertura = Carbon::parse($registro->created_at);
        $fechaCierre = Carbon::parse($registro->updated_at);
        $pagos = Payment::with('budget')->orderBy('id', 'DESC')->whereDate('created_at', $fechaCorte)->whereTime('created_at', '>=', $registro->horaApertura)->whereTime('created_at', '<=', $registro->horaCierre)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', $fechaCorte)->whereTime('created_at', '>=', $registro->horaApertura)->whereTime('created_at', '<=', $registro->horaCierre)->get();
        

        Mail::to('ivonnearroyosg@msn.com', 'Corte de caja')
            ->send(new CorteCaja($registro, $pagos, $otrosPagos));
    });

    Route::get('contabilidad/cortes', 'CMS\IndexController@historialCortes')->name('contabilidad.historialCortes');

        //Obtener la sesion de caja anterior
        Route::get('obtener-sesion-caja', function () {
            
            $sesion = CashRegister::with('user')->orderBy('id', 'DESC')->first();

            return $sesion;
            
        });

        //Obtener la sesion de caja actual
        Route::get('obtener-sesion-actual', function () {
            
            $sesion = CashRegister::with('user')->orderBy('id', 'DESC')->where('estatus', true)->first();
            $sesionAnterior = CashRegister::with('user')->orderBy('id', 'DESC')->where('estatus', false)->first();

            $arrayDatos = [$sesion, $sesionAnterior];
            return $arrayDatos;
            
        });
    Route::get('contabilidad/pagos', function(){
        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
        $pagos = Payment::with('budget')->orderBy('id', 'DESC')->whereDate('created_at', $fechaHoy)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', $fechaHoy)->get();
        $sesion = CashRegister::orderBy('id', 'DESC')->first();

        $arrayDatos = [$pagos, $otrosPagos, $sesion];

        return $arrayDatos;
    });

    Route::get('contabilidad/pdf/{id}', 'CMS\CashRegisterController@pdf')->name('contabilidad.pdf');
    Route::get('precorte/pdf/{id}', 'CMS\CashRegisterController@precorte')->name('precorte.pdf');

    Route::get('recibo-pago/pdf/{id}', 'CMS\CashRegisterController@pdfReciboDePago')->name('recibo-pago.pdf');

    Route::get('ultimo-corte/pdf/', 'CMS\CashRegisterController@ultimoCorte')->name('ultimo-corte.pdf');

    Route::get('mesa-bocadillos/pdf/', 'CMS\BudgetController@pdfMesaBocadillos')->name('mesa-bocadillos.pdf');

    Route::resource('pagos', 'CMS\OtherPaymentsController');
    Route::get('obtener-pagos-pasados', function(){
        $date = Carbon::yesterday();
        $fechaAyer = $date->format('Y-m-d');
        $pagos = Payment::orderBy('id', 'DESC')->whereDate('created_at', $fechaAyer)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', $fechaAyer)->get();

        $arrayDatos = [$pagos, $otrosPagos];
        return $arrayDatos;
    });

    Route::get('obtener-detalles', function(){
        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
        $fechaUltimoCorte = CashRegister::orderBy('id', 'DESC')->first();
        $fechaApertura = ($fechaUltimoCorte->created_at)->fotmat('Y-m-d');
        dd($fechaApertura);
        $pagos = Payment::with('budget')->orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaApertura)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaApertura)->get();
        $pagosA=[];
        foreach($pagos as $pago){
            $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
            $cliente = Client::orderBy('id', 'DESC')->where('id', $contrato->client_id)->first();
            
            if($cliente->tipoPersona=='FISICA'){
                $cliente = PhysicalPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
                $nombreCliente = $cliente->nombre.' '.$cliente->apellidoPaterno.' '.$cliente->apellidoMaterno;
            }else{
                $cliente = MoralPerson::where('client_id', $cliente->id)->first();
                $nombreCliente = $cliente->nombre;
            }
            $datosPago = new stdClass();
            $datosPago->cliente = $nombreCliente;
            $datosPago->folio = $contrato->folio;
            $datosPago->amount = $pago->amount;
            $datosPago->method = $pago->method;
            $datosPago->reference = $pago->reference;
            $datosPago->budget_id = $pago->budget_id;
            $datosPago->bank = $pago->bank;
            array_push($pagosA, $datosPago);
        }

        $arrayDatos = [$pagosA, $otrosPagos];

        return $arrayDatos;
    });
    Route::resource('categorias-pagos', 'CMS\CategoryPaymentController');
    Route::resource('responsable-pagos', 'CMS\ResponsablePaymentController');
    Route::get('pagar-contrato/{id}', function($id){
        $contrato = Budget::findOrFail($id);

        $contrato->pagado = true;
        $contrato->save();
    });

    Route::resource('providers', 'ProvidersController');

    Route::resource('missing', 'MissingProductsController');
    
    Route::get('obtener-producto/{id}', function($id){
        $producto = Inventory::findOrFail($id);
        return $producto;
    });

    Route::resource('registrar-alta', 'CMS\RegisterController');

    //Ruta paquetes
    // Route::get('paquetes', 'CMS\PackController@index')->name('pack.index');
    Route::get('editar-paquete/{id}', 'CMS\PackController@edit')->name('editar.paquete');
    // Route::post('aprobar-paquete/{id}', 'CMS\PackController@aprobarPaquete')->name('aprobar.paquete');
    // Route::delete('rechazar-paquete/{id}', 'CMS\PackController@rechazarPaquete')->name('rechazar.paquete');
    Route::put('actualizar-paquete/{id}', 'CMS\PackController@update')->name('update.paquete');

    //Rutas usurios
    Route::get('usuarios/create', 'CMS\UsersController@create')->name('users.create');
    Route::get('usuarios/edit/{id}', 'CMS\UsersController@edit')->name('users.edit');
    Route::put('usuarios/update/{id}', 'CMS\UsersController@update')->name('users.update');

    //Cancelacion de cotratos
    Route::get('cancelar-contrato/{id}', 'CMS\CashRegisterController@cancelarContrato')->name('cancelarContrato');

    //Obtener viejo inventario
    Route::get('obtener-inventario-pasado/{id}', 'CMS\BudgetController@obtenerInventario')->name('obtenerInventario');

    //Obtener comision de contrato
    Route::get('obtener-comision-contrato/{id}', 'CMS\BudgetController@obtenerTotalComision')->name('obtenerComisiones');

    Route::get('obtener-inventario-danados/{id}', function($id){
        $budget = Budget::findOrFail($id);

        $inventario = BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $budget->id)->where('version', $budget->version)->get();
        $paquetes = BudgetPack::with('inventories')->orderBy('id', 'DESC')->where('budget_id', $budget->id)->where('version', $budget->version)->get();
        
        $inventarios = [$inventario, $paquetes];

        return $inventarios;
    });

    Route::post('registrar-faltante', 'CMS\MissingController@store');
    Route::put('registrar-faltante/{id}', 'CMS\MissingController@update')->name('missing.update');

    Route::get('proximos', 'CMS\InventoryController@proximos')->name('proximos');
    Route::post('buscar-proximos', 'CMS\InventoryController@buscarProximos')->name('buscarProximos');


    Route::get('ticket-salida/{id}', 'CMS\IndexController@ticketSalida')->name('ticketSalida');

    Route::post('obtener-disponibles', 'CMS\BudgetController@obtenerDisponibles')->name('obtenerDisponibles');

    Route::get('inventario-danados/', 'CMS\IndexController@danados')->name('inventario.danados');
    Route::get('hacer-inventario/', 'CMS\IndexController@hacerInventario')->name('inventario.hacerinventario');
    Route::get('aprobar-danados', 'CMS\IndexController@aprobarDanados')->name('danados.aprobar');
    Route::put('aprobar-danados/{id}', function($id){
        $producto = Missing::findOrFail($id);
        $producto->aprobado = true;
        $producto->save();

        $productos = Missing::orderBy('id', 'DESC')->where('reportado', true)->where('aprobado', false)->get();
        return view('aprobarDanados', compact('productos'));
    })->name('aprobar');

    Route::post('user/create', 'CMS\UsersController@store')->name('user.store');

    Route::get('paquetes', 'CMS\IndexController@paquetes')->name('paquetes');
    Route::put('cancelar-paquete/{id}', function($id){
        $paquete = BudgetPack::findOrFail($id);
        $paquete->guardarPaquete = false;
        $paquete->save();
        return back();

    })->name('cancelarPaquete');
    Route::put('aprobar-paquete/{id}', 'CMS\PackController@aprobarPaquete')->name('aprobarPaquete');

    Route::get('creditos-atrasados', 'CMS\IndexController@creditosAtrasados')->name('creditosAtrasados');

    //Proveedores
    Route::get('proveedores', 'CMS\IndexController@proveedores')->name('proveedores.index');
    Route::post('proveedores', 'CMS\IndexController@agregarProveedor')->name('proveedores.store');
    Route::get('proveedores/edit/{id}', 'CMS\IndexController@editarProveedor')->name('proveedores.edit');
    Route::put('proveedores/update/{id}', 'CMS\IndexController@actualizarProveedor')->name('proveedores.update');
    Route::delete('proveedores/{id}', 'CMS\IndexController@borrarProveedor')->name('proveedores.delete');

        Route::get('obtener-proveedores', function(){
            $proveedores = Supplier::orderBy('id', 'DESC')->where('tipo', 'NORMAL')->get();
            return $proveedores;
        });
    Route::post('aprobar-producto/{id}', 'CMS\InventoryController@aprobarProducto')->name('aprobarProducto');
    Route::post('aprobar-producto-paquete/{id}', 'CMS\InventoryController@aprobarProductoPaquete')->name('aprobarProductoPaquete');

    Route::get('obtener-otros-provedores', function(){
        $proveedores = Supplier::orderBy('id', 'DESC')->where('tipo', 'PRIVADO')->get();
        return $proveedores;
    });

    Route::post('agregar-otros-provedores', function(Request $request){
        $proveedores = new Supplier();
        $proveedores->nombre = $request->nombre;
        $proveedores->tipo = 'PRIVADO';
        $proveedores->save();

        return;
    });

    Route::delete('eliminar-otros-provedores/{id}', function($id){
        $proveedores = Supplier::findOrFail($id);
        $proveedores->delete();

        return;
    });

    Route::put('registrar-diferencia/{id}', 'CMS\IndexController@registrarDif');
});

