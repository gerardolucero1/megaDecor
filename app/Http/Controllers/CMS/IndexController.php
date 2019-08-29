<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
Use App\Budget;
Use App\Telephone;
use Illuminate\Support\Facades\DB;
use stdClass;

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

        $CompleteClients=[];

        foreach($clientes as $cliente){
            $tamanoPresupuestos=0;
            $telefono = Telephone::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();

            //Obtenemos numero de presupuestos del cliente
            $Presupuestos = Budget::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
            $tamanoPresupuestos=count($Presupuestos);
    

                        $CompleteClient = new stdClass();
                        $CompleteClient->id = $cliente->id;
                        $CompleteClient->nombre = $cliente->nombre;
                        $CompleteClient->email = $cliente->email;
                        $CompleteClient->presupuestos = $tamanoPresupuestos;
                        if(!is_null($telefono)){
                        $CompleteClient->telefono = $telefono->numero;}
                        else{
                            $CompleteClient->telefono = "--";  
                        }
                        array_push($CompleteClients,$CompleteClient);
                        
                        
                        
                   
               
            
        }



        return view('clientes',compact('CompleteClients'));    
    }

   

   
    public function contratos(){
        return view('contratos');
    }
    public function pantallaUsuarios(){
        return view('pantallaUsuarios');
    }
    public function comisiones(){
        return view('comisiones');
    }
    public function dashboard(){
        $tasks = Task::orderBy('id', 'DESC')->get();
        return view('dashboard', compact('tasks'));
    }

    public function presupuestos(){
        $budgets = Budget::orderBy('id', 'ASC')->get();
        $Presupuestos=[];
      
        //Obtenemos clientes morales y fisicos
        $clientes_morales = DB::table('clients')
        ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
        ->select('clients.id', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
        ->get();

        $clientes_fisicos = DB::table('clients')
        ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
        ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion')
        ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        foreach($budgets as $budget){
         $Presupuesto   = new stdClass();
         $Presupuesto->id = $budget->id;
         $Presupuesto->folio = $budget->folio;
         $Presupuesto->fechaEvento = $budget->fechaEvento;
         $Presupuesto->vendedor = $budget->vendedor_id;
         $Presupuesto->updated_at = $budget->updated_at;
         

         foreach($clientes as $cliente){
             if($cliente->id===$budget->client_id){
         $Presupuesto->cliente = $cliente->nombre;
                if($budget->lugarEvento = 'MISMA'){
                    $Presupuesto->lugarEvento = $cliente->direccionFacturacion; 
                    
                }else{
                    $Presupuesto->lugarEvento = $budget->lugarEvento;
                }
                
        }else{$Presupuesto->cliente = "--";}
        }

         array_push($Presupuestos,$Presupuesto);
        }

        //dd($clientes);
        return view('presupuestos',compact('Presupuestos'));   
    }
}
