<?php

use App\Inventory;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('inventariott', function(){
   $inventory = App\Inventory::orderBy('id', 'DESC')->Where('archivar', null)->orWhere('archivar', false)->get();
       // $inventarioBudget = BudgetInventory::where('guardarInventario', true)->get()->toArray();
     //   $inventarioPack = BudgetPackInventory::where('guardarInventario', true)->get()->toArray();
        
       // $inventarioAuth = array_merge($inventarioBudget, $inventarioPack);
        //dd($inventarioAuth);

    return datatables()
    ->of($inventory)
    // ->eloquent(App\Inventory::query())
    ->addColumn('btn', 'actions')
    ->addColumn('img', 'images')
    ->rawColumns(['btn', 'img'])
    ->toJson();
});

Route::get('clientestt', function(){
   $inventory = App\Inventory::orderBy('id', 'DESC')->Where('archivar', null)->orWhere('archivar', false)->get();
       // $inventarioBudget = BudgetInventory::where('guardarInventario', true)->get()->toArray();
     //   $inventarioPack = BudgetPackInventory::where('guardarInventario', true)->get()->toArray();
        
       // $inventarioAuth = array_merge($inventarioBudget, $inventarioPack);
        //dd($inventarioAuth);

    return datatables()
    ->of($inventory)
    // ->eloquent(App\Inventory::query())
    ->addColumn('btn', 'actions')
    ->addColumn('img', 'images')
    ->rawColumns(['btn', 'img'])
    ->toJson();
});