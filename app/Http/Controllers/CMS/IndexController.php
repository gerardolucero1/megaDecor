<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
Use App\Budget;
Use App\User;
Use App\Telephone;
use Illuminate\Support\Facades\DB;
use stdClass;

class IndexController extends Controller
{
    public function clientes(){

        //Obtenemos clientes
        $clientes_morales = DB::table('clients')
        ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
        ->select('clients.id', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.created_at')
        ->get();
        $clientes_fisicos = DB::table('clients')
        ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
        ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.created_at')
        ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        $CompleteClients=[];

        foreach($clientes as $cliente){
            
            $tamanoPresupuestos=0;
            $telefono = Telephone::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();

            //Obtenemos numero de presupuestos del cliente
            $Presupuestos = Budget::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
            $tamanoPresupuestos=count($Presupuestos);
            $createdAt=date('d-m-Y',(strtotime($cliente->created_at)));

                        $CompleteClient = new stdClass();
                        $CompleteClient->id = $cliente->id;
                        $CompleteClient->nombre = $cliente->nombre;
                        $CompleteClient->email = $cliente->email;
                        $CompleteClient->created_at = $createdAt;
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
        $budgets = Budget::orderBy('id', 'ASC')->where('tipo', 'CONTRATO')->get();
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
         //$Presupuesto->vendedor = $budget->vendedor_id;
         $DatosVendedor = User::orderBy('id', 'DESC')->where('id', $budget->vendedor_id)->first();
         $Presupuesto->vendedor = $DatosVendedor->name;
         $Presupuesto->version = $budget->version;
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
        return view('contratos',compact('Presupuestos')); 
    }
    public function pantallaUsuarios(){
        return view('pantallaUsuarios');
    }
    public function comisiones(){
        $fecha_actual= date('Y-m-d',time());
        //Empleado del mes
        $EmpleadoDelMes = DB::table('budgets')
        ->select(DB::raw('count(*) as ventas_count, vendedor_id'))
        ->where('tipo', '=', 'CONTRATO')
        ->groupBy('vendedor_id')
        ->get();
        
        $ventas=0;
        if(count($EmpleadoDelMes) != 0){
            foreach ($EmpleadoDelMes as $EmpleadoMes) {
                if(($EmpleadoMes->ventas_count) > $ventas){
                    $ventas = $EmpleadoMes->ventas_count;
                    $vendedorMes=$EmpleadoMes->vendedor_id;
                   
                }
            }
    
        $ArrayEmpleadoDelMes = User::orderBy('id', 'DESC')->where('id', $vendedorMes)->first();
    
        }else{
            $ArrayEmpleadoDelMes=null;
        }
        $Usuarios = User::orderBy('id', 'DESC')->get();

        //Construir arreglo que se enviara a la lista
        $CompleteUsers=[];

        foreach($Usuarios as $usuario){
            $num_ventas=0;
        foreach($EmpleadoDelMes as $Empleado){
            
            if($Empleado->vendedor_id == $usuario->id){
                $num_ventas = $Empleado->ventas_count;
            } 
        }
            $budgetsDeVendedor = Budget::orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->where('vendedor_id', $usuario->id)->get();
            $totalVentas=0;
            foreach($budgetsDeVendedor as $budgetDeVendedor){
                $totalVentas=$totalVentas+$budgetDeVendedor->total;
            }
            
            $CompleteUser = new stdClass();
            $CompleteUser->totalventas = number_format($totalVentas);
            $CompleteUser->id = $usuario->id;
            $CompleteUser->name = $usuario->name;
            $CompleteUser->ventas = $num_ventas;
            
            array_push($CompleteUsers,$CompleteUser); 
    }

    //Obtenemos totales de venta de los vendedores
    

   
       
        return view('comisiones', compact( 'ArrayEmpleadoDelMes', 'CompleteUsers'));
   
    }
    //Vista dasboard
    public function dashboard(){
        $fecha_actual= date('Y-m-d',time());
        //Presupuestos activos
        $numeroPresupuestos = Budget::orderBy('id', 'DESC')->where('tipo', 'PRESUPUESTO')->get();
        //Presupuestos del dia actual
        $numeroPresupuestosDiaActual = Budget::orderBy('id', 'DESC')->where('fechaEvento', $fecha_actual)->where('tipo', 'CONTRATO')->get();
        //Empleado del mes
        $EmpleadoDelMes = DB::table('budgets')
        ->select(DB::raw('count(*) as ventas_count, vendedor_id'))
        ->where('tipo', '=', 'CONTRATO')
        ->groupBy('vendedor_id')
        ->get();
        
        $ventas=0;
        if(count($EmpleadoDelMes) != 0){
            foreach ($EmpleadoDelMes as $EmpleadoMes) {
                if(($EmpleadoMes->ventas_count) > $ventas){
                    $ventas = $EmpleadoMes->ventas_count;
                    $vendedorMes=$EmpleadoMes->vendedor_id;
                }
            }
    
        $ArrayEmpleadoDelMes = User::orderBy('id', 'DESC')->where('id', $vendedorMes)->first();
    
        }else{
            $ArrayEmpleadoDelMes=null;
        }


        //Comparacion ventas actuales con años pasados
            //Obtenemos contratos del año pasado pero del mes acutal
            $fecha_ano_pasado= date('Y-m',strtotime($fecha_actual."- 365 days"));
            $presupuestosAnoPasado = Budget::orderBy('id', 'DESC')->where('fechaEvento', 'like' , $fecha_ano_pasado.'%')->where('tipo', 'CONTRATO')->get();
            //Obtenemos los contratos de el año y mes actual
            $fecha_mes_actual= date('Y-m',strtotime($fecha_actual."- 0 days"));
            $presupuestosAnoActual = Budget::orderBy('id', 'DESC')->where('fechaEvento', 'like' , $fecha_mes_actual.'%')->where('tipo', 'CONTRATO')->get();

            $porcentajeActual= (100/count($presupuestosAnoPasado)) * count($presupuestosAnoActual);
            
            //calculamos total ventas del año pasado
            $ventasAnoPasado=0;
            $ventasAnoActual=0;
            foreach($presupuestosAnoPasado as $anoPasado){
                $ventasAnoPasado=$ventasAnoPasado+($anoPasado->total);
            }
            foreach($presupuestosAnoActual as $anoActual){
                $ventasAnoActual=$ventasAnoActual+$anoActual->total;
            }
            $porcentajeActualDinero = (100/$ventasAnoPasado) * $ventasAnoActual;
            $ventasAnoPasado=number_format($ventasAnoPasado);
            $ventasAnoActual=number_format($ventasAnoActual);

            //Obtenemos datos para tabla comparativa de comisiones
            $Vendedores = User::orderBy('id', 'DESC')->get();

            $ElementosVendedores=[];
            foreach($Vendedores as $Vendedor){
                $idVendedor=$Vendedor->id;
                $ElementoVendedor = new stdClass();
                $ElementoVendedor->name = $Vendedor->name;

                $PresupuestosVendedor = Budget::orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->where('vendedor_id', $idVendedor)->get();
                $ElementoVendedor->ventas = count($PresupuestosVendedor);
                if($ElementoVendedor->ventas>0){
                array_push($ElementosVendedores,$ElementoVendedor); }
            }
            arsort($ElementosVendedores);


        $tasks = Task::orderBy('id', 'DESC')->get();
        return view('dashboard', compact('tasks', 'numeroPresupuestos', 'numeroPresupuestosDiaActual', 'ArrayEmpleadoDelMes', 'presupuestosAnoPasado', 'presupuestosAnoActual', 'porcentajeActual', 'ventasAnoActual', 'ventasAnoPasado', 'porcentajeActualDinero', 'ElementosVendedores'));
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
         //$Presupuesto->vendedor = $budget->vendedor_id;
         $DatosVendedor = User::orderBy('id', 'DESC')->where('id', $budget->vendedor_id)->first();
         $Presupuesto->vendedor = $DatosVendedor->name;
         $Presupuesto->version = $budget->version;
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
    

    public function presupuestosHoy(){
        $fecha_actual= date('Y-m-d',time());
        $budgets = Budget::orderBy('id', 'DESC')->where('fechaEvento', $fecha_actual)->where('tipo', 'CONTRATO')->get();
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
        return view('presupuestos-hoy',compact('Presupuestos'));   
    }

   

    public function editarPresupuesto($id){
        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();

        return view('presupuesto', compact('presupuesto'));
    }
}
