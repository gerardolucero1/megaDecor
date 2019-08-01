<?php

use App\Telephone;
use App\AboutCategory;
use App\MoralCategory;

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
Route::view('/examples/plugin-helper', 'examples.plugin_helper');
Route::view('/examples/plugin-init', 'examples.plugin_init');
Route::view('/examples/blank', 'examples.blank');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Rutas del CMS
    // API Formularios
    Route::get('/telefonos', function(){
        return App\Telephone::orderBy('id', 'DESC')->get();
    });

    Route::get('/categorias', function(){
        return App\MoralCategory::orderBy('id', 'DESC')->get();
    });

    Route::get('/about-categorias', function(){
        return App\AboutCategory::orderBy('id', 'DESC')->get();
    });

Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');

