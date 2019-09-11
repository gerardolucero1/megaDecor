<?php

use App\User;
use App\Budget;
use App\Client;
use App\Telephone;
use App\MoralPerson;
use App\AboutCategory;
use App\MoralCategory;
use App\PhysicalPerson;
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

    Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
    Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
    Route::get('/presupuestos-hoy', 'CMS\IndexController@presupuestosHoy')->name('presupuestos-hoy');
    Route::get('/presupuesto/edit/{id}', 'CMS\IndexController@editarPresupuesto')->name('editar.presupuesto');
    Route::get('/contratos', 'CMS\IndexController@contratos')->name('contratos');
    Route::get('/contratos/obtener-contratos-todos', 'CMS\IndexController@contratosTodos');
    Route::get('/comisiones', 'CMS\IndexController@comisiones')->name('comisiones');

        // API Presupuestos
        Route::get('/usuarios', 'CMS\BudgetController@usuarios');
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

    //Emails
    Route::post('enviar-email', function(Request $request){
        
        $presupuesto    = $request->presupuesto;
        $inventario     = $request->inventario;
        $festejados     = $request->festejados;

        
        $cliente        = Client::orderBy('id', 'DESC')->where('id', $presupuesto['client_id'])->first();        

        if($cliente->tipoPersona == 'FISICA'){
            $persona = PhysicalPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }else{
            $persona = MoralPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }
    
        Mail::to('gera_conecta@hotmail.com', 'Administrador')
            ->cc($persona->email)
            ->send(new NuevoPresupuesto($presupuesto, $inventario, $festejados));
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