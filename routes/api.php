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
    //Obtenemos clientes
    $clientes_morales = DB::table('clients')
    ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
    ->select('clients.id', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.created_at')
    ->get();
    $clientes_fisicos = DB::table('clients')
    ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
    ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.created_at')
    ->get();
    
    $clientes = $clientes_morales->merge($clientes_fisicos);

    $CompleteClients=[];

    foreach($clientes as $cliente){
        
        $tamanoPresupuestos=0;
        $telefono = Telephone::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();

        //Obtenemos numero de presupuestos del cliente
        $Presupuestos = Budget::orderBy('id', 'DESC')->where('client_id', $cliente->id)->get()->toArray();

        $createdAt=date('d-m-Y',(strtotime($cliente->created_at)));
                    $CompleteClient = new stdClass();
                    $CompleteClient->id = $cliente->id;
                    
                    $tipoCliente = Client::where('id', $cliente->id)->first();
                    //dd($tipoCliente->tipoPersona);

                    if($tipoCliente->tipoPersona=='MORAL'){
                    $CompleteClient->nombre = $cliente->nombre;
                    }else{
                    $CompleteClient->nombre = $cliente->nombre.' '.$cliente->apellidoPaterno.' '.$cliente->apellidoMaterno;  
                    }
                

                    $CompleteClient->updated_at = $cliente->updated_at;
                    $CompleteClient->tipo = $cliente->tipoPersona;
                    $CompleteClient->email = $cliente->email;
                    $CompleteClient->created_at = $createdAt;
                    $CompleteClient->presupuestos = $Presupuestos;
                    if(!is_null($telefono)){
                    $CompleteClient->telefono = $telefono->numero;}
                    else{
                        $CompleteClient->telefono = "--";  
                    }
                    array_push($CompleteClients,$CompleteClient);    
    }

    return datatables()
    ->of($CompleteClients)
    // ->eloquent(App\Inventory::query())
    //->addColumn('btn', 'actions')
    //->addColumn('img', 'images')
    //->rawColumns(['btn', 'img'])
    ->toJson();
});