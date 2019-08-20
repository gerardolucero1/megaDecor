<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function clientes(){
        $clientes_morales = DB::table('clients')
        ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
        ->select('clients.id', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
        ->get();

        $clientes_fisicos = DB::table('clients')
        ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
        ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion')
        ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);
        //dd($clientes);
        return view('clientes',compact('clientes'));    
    }

    public function presupuestos(){
        return view('presupuestos');
    }
    public function contratos(){
        return view('contratos');
    }
    public function comisiones(){
        return view('comisiones');
    }
    public function dashboard(){
        $tasks = Task::orderBy('id', 'DESC')->get();
        return view('dashboard', compact('tasks'));
    }

    public function presupuestos(){
        return view('presupuestos');
    }
}
