<?php

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
   // $Inventario = Inventory::orderBy('id', 'DESC')->get();
       // $inventarioBudget = BudgetInventory::where('guardarInventario', true)->get()->toArray();
     //   $inventarioPack = BudgetPackInventory::where('guardarInventario', true)->get()->toArray();
        
       // $inventarioAuth = array_merge($inventarioBudget, $inventarioPack);
        //dd($inventarioAuth);
    return datatables()
    ->eloquent(App\Inventory::query())
    ->addColumn('btn', 'actions')
    ->addColumn('img', 'images')
    ->rawColumns(['btn', 'img'])
    ->toJson();
});