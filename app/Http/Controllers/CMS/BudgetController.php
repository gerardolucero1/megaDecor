<?php

namespace App\Http\Controllers\CMS;

use App\User;
use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    public function usuarios(){
        return User::orderBy('id', 'DESC')->get();
    }

    public function inventario(){
        return Inventory::orderBy('id', 'DESC')->get();
    }

    public function clientes(){
        $clientes_morales = DB::table('clients')
            ->join('moral_people', 'moral_people.cliente_id', '=', 'clients.id')
            ->select('clients.id',  'moral_people.nombre')
            ->get();

        $clientes_fisicos = DB::table('clients')
            ->join('physical_people', 'physical_people.cliente_id', '=', 'clients.id')
            ->select('clients.id',  'physical_people.nombre')
            ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        return $clientes;
    }
}
