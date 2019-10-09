<?php

use App\User;
use App\Budget;
use App\Client;
use App\Inventory;
use App\Telephone;
use App\BudgetPack;
use App\MoralPerson;
use App\TaskComment;
use App\AboutCategory;
use App\MoralCategory;
use App\PhysicalPerson;
use App\BudgetInventory;
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
        return User::orderBy('id', 'DESC')->get();
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
    Route::post('/inventario', 'CMS\IndexController@inventarioFiltro')->name('inventario.filtro');

    //Imprimir budget
    Route::get('/imprimir-budget/{id}', 'CMS\BudgetController@pdf')->name('imprimir.budget');
    Route::get('/imprimir-budgetBodega/{id}', 'CMS\BudgetController@pdfBodega')->name('imprimir.budgetBodega');
        // API Presupuestos
        Route::get('/usuarios', 'CMS\BudgetController@usuarios');
        Route::get('/budget-convertir-contrato/{id}', 'CMS\BudgetController@convertirContrato')->name('convertir.contrato');
        Route::get('/budget-desarchivar/{id}', 'CMS\BudgetController@desarchivar')->name('presupuesto.desarchivar');
        Route::get('/budget-archivar/{id}', 'CMS\BudgetController@archivar')->name('presupuesto.archivar');
        Route::post('/obtener-cliente', 'CMS\BudgetController@cliente');
        Route::get('/obtener-clientes', 'CMS\BudgetController@clientes');
        Route::get('/obtener-inventario', 'CMS\BudgetController@inventario');
        Route::get('/obtener-ultimo-presupuesto', 'CMS\BudgetController@obtenerUltimoPresupuesto');
        Route::get('/obtener-presupuesto/{id}', 'CMS\BudgetController@obtenerPresupuesto');
        Route::get('/obtener-festejados/{id}', 'CMS\BudgetController@obtenerFestejados');
        Route::get('/obtener-inventario-1/{id}', 'CMS\BudgetController@obtenerInventario1');
        Route::get('/obtener-paquetes/{id}', 'CMS\BudgetController@obtenerPaquetes');
        Route::get('/obtener-elementos-paquetes/{id}', 'CMS\BudgetController@obtenerElementosPaquetes');
        Route::get('/obtener-cliente-presupuesto/{id}', 'CMS\BudgetController@obtenerClientePresupuesto');
        

        //Pantalla Usuarios
        Route::get('/pantallaUsuarios', 'CMS\IndexController@pantallaUsuarios')->name('pantallaUsuarios');

    // Todo lo referente a presupuestos
    Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
    Route::get('/presupuestos2', 'CMS\IndexController@presupuestos2')->name('presupuestos2');
    Route::post('/presupuestos/create', 'CMS\BudgetController@store')->name('presupuestos.store');
    Route::get('/presupuestos/ver/{id}', 'CMS\BudgetController@verPresupuesto')->name('ver.presupuesto');
    Route::get('/obtener-festejados-version/{id}', 'CMS\BudgetController@obtenerFestejadosVersion');
    Route::get('/obtener-inventario-version-1/{id}', 'CMS\BudgetController@obtenerInventarioVersion1');
    Route::get('/obtener-paquetes-version/{id}', 'CMS\BudgetController@obtenerPaquetesVersion');

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
    Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');
    Route::get('/clientes/edit/{id}', 'CMS\ClientController@edit')->name('cliente.edit');

        // API de clientes
        Route::get('/obtener-cliente-editar/{id}', 'CMS\ClientController@obtenerCliente');
        Route::get('/obtener-telefonos-editar/{id}', 'CMS\ClientController@obtenerTelefonos');
        Route::post('/crear-nuevo-telefono', 'CMS\ClientController@crearTelefono');
        Route::put('/clientes/update/{id}', 'CMS\ClientController@update');
        Route::put('/guardar-nuevo-telefono/{id}', 'CMS\ClientController@updateTelefono');
        Route::delete('/eliminar-nuevo-telefono/{id}', 'CMS\ClientController@deleteTelefono');

//Imprimir familia
    Route::post('/imprimir-familia', 'CMS\InventoryController@pdf')->name('imprimir.familia');

    //Configuraciones
    Route::get('/configuraciones', 'CMS\CommissionController@index');
    Route::post('/configuraciones/create', 'CMS\CommissionController@store');
    Route::put('/configuraciones/update', 'CMS\CommissionController@update');

    //Ventas
    Route::get('/ventas', 'CMS\IndexController@ventas')->name('index.ventas');
    Route::post('/ventas', 'CMS\IndexController@ventasFiltro')->name('show.ventas');
    Route::get('/ventas/pdf', 'CMS\IndexController@ventasPDF')->name('pdf.ventas');

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
    
        Mail::to('gera_conecta@hotmail.com', 'Administrador')
            ->send(new NuevoPresupuesto($presupuesto, $Telefonos, $Elementos));
    });

    Route::get('enviar-email-cliente/{id}', function($id){

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->impresion = 1;
        $presupuesto->save();

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
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito', 'moral_people.diasCredito')
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
    
        Mail::to($presupuesto->emailCliente, 'Presupuesto MegaMundo')
            ->send(new NuevoPresupuesto($presupuesto, $Telefonos, $Elementos, $Paquetes, $arregloEmentos));
    });

    Route::get('inventario/create', 'CMS\InventoryController@create')->name('inventory.create');
    Route::get('inventario/edit/{id}', 'CMS\InventoryController@edit')->name('inventory.edit');
    Route::post('inventario/store', 'CMS\InventoryController@store')->name('inventory.store');
    Route::put('inventario/edit/{id}', 'CMS\InventoryController@update')->name('inventory.update');

    Route::put('editar-cantidad-inventario/{id}', function(Request $request, $id){
        $inventario = Inventory::find($id);

        $inventario->cantidad = $request->cantidad;
        $inventario->save();
        return;
    });

    Route::put('editar-exhibicion-inventario/{id}', function(Request $request, $id){
        $inventario = Inventory::find($id);

        $inventario->exhibicion = $request->exhibicion;
        $inventario->save();
        return;
    });

    //Generar PDF's
    Route::get('/presupuestos/generar-pdf/{id}', 'CMS\BudgetController@pdf')->name('budget.pdf');

});

/*
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});



Auth::routes();

Route::group(['middleware' => ['auth'] 
], function(){

//ruta dashboard
Route::get('/dashboard', 'CMS\IndexController@dashboard');

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
    Route::get('/tareas/clientes-fisicos', 'CMS\TareasController@ClientesF');
    Route::post('/tareas/create', 'CMS\TareasController@store')->name('NuevaTarea.store');
    Route::post('/tareas/createcategory', 'CMS\TareasController@createC')->name('NuevaCategory.createC');

Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
Route::get('/contratos', 'CMS\IndexController@contratos')->name('contratos');
Route::get('/comisiones', 'CMS\IndexController@comisiones')->name('comisiones');

    // API Presupuestos
    Route::get('/usuarios', 'CMS\BudgetController@usuarios');
    Route::post('/obtener-cliente', 'CMS\BudgetController@cliente');
    Route::get('/obtener-clientes', 'CMS\BudgetController@clientes');
    Route::get('/obtener-inventario', 'CMS\BudgetController@inventario');


    //Pantalla Usuarios
    Route::get('/pantallaUsuarios', 'CMS\IndexController@pantallaUsuarios')->name('pantallaUsuarios');


// Todo lo referente a presupuestos
Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
Route::post('/presupuestos/create', 'CMS\BudgetController@store')->name('presupuestos.store');

// Todo lo referente a clientes
Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');

});
  
    //clientes






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){
    Route::post('roles/store')->name('roles.store')
    ->middleware('permission:roles.create');
});





//Rutas para permisos

*/