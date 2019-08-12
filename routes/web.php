<?php

use App\Telephone;
use App\AboutCategory;
use App\MoralCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Rutas del CMS
    // API Clientes
    Route::get('/telefonos', 'CMS\ClientController@telefonos');
    Route::get('/categorias', 'CMS\ClientController@categorias');
    Route::get('/about-categorias', 'CMS\ClientController@aboutCategorias');
    Route::post('/viejo-telefono', 'CMS\ClientController@viejoTelefono');
    Route::delete('/viejo-telefono/{id}', 'CMS\ClientController@deleteViejoTelefono');

    // API Presupuestos
    Route::get('/usuarios', 'CMS\BudgetController@usuarios');
    Route::get('/obtener-clientes', 'CMS\BudgetController@clientes');
    Route::get('/obtener-inventario', 'CMS\BudgetController@inventario');

// Todo lo referente a presupuestos
Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
Route::post('/presupuestos/create', 'CMS\BudgetController@store')->name('presupuestos.store');

// Todo lo referente a clientes
Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');



