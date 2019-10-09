<?php

namespace App\Http\Controllers\CMS;

use App\Task;
use stdClass;
use Carbon\Carbon;
Use App\Budget;
Use App\User;
Use App\Client;
Use App\Inventory;
Use App\Telephone;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

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
            $Presupuestos = Budget::orderBy('id', 'DESC')->where('client_id', $cliente->id)->get();
            if(!is_null($Presupuestos)){
                $tamanoPresupuestos=count($Presupuestos);
            }else{
                $tamanoPresupuestos=0;
            }
            
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

    public function contratosTodos(){
        $budgets = Budget::orderBy('id', 'ASC')->where('tipo', 'CONTRATO')->where('archivado', '0')->get();
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
         $Presupuesto->servicio = $budget->tipoEvento." ".$budget->tipoServicio;
         $Presupuesto->notasPresupuesto = $budget->notasPresupuesto;
         $Presupuesto->horaEventoInicio = $budget->horaEventoInicio;
         $Presupuesto->horaEventoFin = $budget->horaEventoFin;
         
            
            
         foreach($clientes as $cliente){
             if($cliente->id==$budget->client_id){
         $Presupuesto->cliente = $cliente->nombre;
                if($budget->lugarEvento = 'MISMA'){
                    $Presupuesto->lugarEvento = $cliente->direccionFacturacion; 
                    
                }else{
                    $Presupuesto->lugarEvento = $budget->lugarEvento;
                }
                
        }else{$Presupuesto->cliente = "--";}
        }
        $arregloCliente = Client::orderBy('id', 'DESC')->where('id', $budget->client_id)->first();
        $Presupuesto->cliente = $arregloCliente->nombreCliente;

         array_push($Presupuestos,$Presupuesto);
        }

        //dd($clientes);
        return $Presupuestos; 
    }

    public function presupuestosTodos(){
    $budgets = Budget::orderBy('id', 'ASC')->where('tipo', 'PRESUPUESTO')->where('archivado', '0')->get();
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
     $Presupuesto->servicio = $budget->tipoEvento." ".$budget->tipoServicio;
     $Presupuesto->notasPresupuesto = $budget->notasPresupuesto;
     $Presupuesto->horaEventoInicio = $budget->horaEventoInicio;
     $Presupuesto->horaEventoFin = $budget->horaEventoFin;
     
        
        
     foreach($clientes as $cliente){
         if($cliente->id==$budget->client_id){
     $Presupuesto->cliente = $cliente->nombre;
            if($budget->lugarEvento = 'MISMA'){
                $Presupuesto->lugarEvento = $cliente->direccionFacturacion; 
                
            }else{
                $Presupuesto->lugarEvento = $budget->lugarEvento;
            }
            
    }else{$Presupuesto->cliente = "--";}
    }
    $arregloCliente = Client::orderBy('id', 'DESC')->where('id', $budget->client_id)->first();
    $Presupuesto->cliente = $arregloCliente->nombreCliente;

     array_push($Presupuestos,$Presupuesto);
    }

    //dd($clientes);
    return $Presupuestos; 
}

    //Pantalla usuarios
    public function pantallaUsuarios(){
        return view('pantallaUsuarios');
    }
     //Pantalla inventario
     public function inventario(){

        $Inventario = Inventory::orderBy('id', 'DESC')->get();

        return view('inventario', compact('Inventario'));
    }

    public function inventarioFiltro(Request $request){
        $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->get();

        return view('inventario', compact('Inventario'));
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
        $numeroPresupuestos = Budget::orderBy('id', 'DESC')->where('tipo', 'PRESUPUESTO')->where('archivado', '0')->get();
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

            if(count($presupuestosAnoActual) !== 0 && count($presupuestosAnoPasado) !== 0){
                $porcentajeActual= (100/count($presupuestosAnoPasado)) * count($presupuestosAnoActual);
            }else{
                $porcentajeActual = 0;
            }
            
            
            //calculamos total ventas del año pasado
            $ventasAnoPasado=0;
            $ventasAnoActual=0;
            foreach($presupuestosAnoPasado as $anoPasado){
                $ventasAnoPasado=$ventasAnoPasado+($anoPasado->total);
            }
            foreach($presupuestosAnoActual as $anoActual){
                $ventasAnoActual=$ventasAnoActual+$anoActual->total;
            }
               
            if($ventasAnoPasado !== 0){
            
                $porcentajeActualDinero = (100/$ventasAnoPasado) * $ventasAnoActual;
                $diferenciaDinero = $ventasAnoActual-$ventasAnoPasado;
             
            }else{
                $porcentajeActualDinero = 0;
                $diferenciaDinero = 0;
            }
          
            $ventasAnoPasado=number_format($ventasAnoPasado);
            $ventasAnoActual=number_format($ventasAnoActual);

            //Obtenemos datos para tabla comparativa de comisiones
            $Vendedores = User::orderBy('id', 'DESC')->get();

            $ElementosVendedores=[];
            foreach($Vendedores as $Vendedor){
                $idVendedor=$Vendedor->id;
                $ElementoVendedor = new stdClass();
                $ElementoVendedor->name = $Vendedor->name;

                $fecha_mes_actual= date('Y-m',strtotime($fecha_actual."- 0 days"));
                $PresupuestosVendedor = Budget::orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->where('vendedor_id', $idVendedor)->where('fechaEvento', 'like' , $fecha_mes_actual.'%')->get();
                $ElementoVendedor->ventas = count($PresupuestosVendedor);
                $ElementoVendedor->cantidadVenta=0;
                foreach($PresupuestosVendedor as $PresupuestoVendedor){
                        $ElementoVendedor->cantidadVenta = $ElementoVendedor->cantidadVenta+$PresupuestoVendedor->total;
                    }

                if($ElementoVendedor->ventas>0){
                array_push($ElementosVendedores,$ElementoVendedor); }
            }
            arsort($ElementosVendedores);


        $tasks = Task::orderBy('id', 'DESC')->get();
        return view('dashboard', compact('tasks', 'numeroPresupuestos', 'numeroPresupuestosDiaActual', 'ArrayEmpleadoDelMes', 'presupuestosAnoPasado', 'presupuestosAnoActual', 'porcentajeActual', 'ventasAnoActual', 'ventasAnoPasado', 'porcentajeActualDinero', 'ElementosVendedores', 'diferenciaDinero'));
    }

    public function presupuestos(){
        $budgets = Budget::orderBy('id', 'ASC')->where('tipo', 'PRESUPUESTO')->where('archivado', '0')->get();

        $fechaHoy = Carbon::yesterday();
        $presupuestosHistorial = Budget::orderBy('id', 'DESC')->where('tipo', 'PRESUPUESTO')->where('archivado', 0)->whereDate('fechaEvento', '<=', $fechaHoy)->get();
        $Presupuestos=[];
      
        //Obtenemos clientes morales y fisicos
        $clientes_morales = DB::table('clients')
        ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
        ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
        ->get();

        $clientes_fisicos = DB::table('clients')
        ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
        ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion')
        ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        foreach($budgets as $budget){
            if($budget->fechaEvento >= $fechaHoy || $budget->fechaEvento == null){
                $Presupuesto   = new stdClass();
                $Presupuesto->id = $budget->id;
                $Presupuesto->folio = $budget->folio;
                $Presupuesto->fechaEvento = $budget->fechaEvento;
                //$Presupuesto->vendedor = $budget->vendedor_id;
                $DatosVendedor = User::orderBy('id', 'DESC')->where('id', $budget->vendedor_id)->first();
                $Presupuesto->vendedor = $DatosVendedor->name;
                $Presupuesto->version = $budget->version;
                $Presupuesto->impresion = $budget->impresion;
                $Presupuesto->enviado = $budget->enviado;
                if($budget->opcionIVA==1){
                    $Presupuesto->total = ($budget->total)+($budget->total*.16);
                }else{
                    $Presupuesto->total = $budget->total;
                }
                $Presupuesto->impresionBodega = $budget->impresionBodega;
                $Presupuesto->updated_at = $budget->updated_at;
            
         
         

         foreach($clientes as $cliente){
       
             if($cliente->id==$budget->client_id){
                    if($cliente->apellidoPaterno==$cliente->nombre){$Presupuesto->cliente = $cliente->nombre;}else{
                     $Presupuesto->cliente = $cliente->nombre.' '.$cliente->apellidoPaterno;}

                if($budget->lugarEvento = 'MISMA'){
                    $Presupuesto->lugarEvento = $cliente->direccionFacturacion; 
                    
                }else{
                    $Presupuesto->lugarEvento = $budget->lugarEvento;
                }
                
        }
        }

         array_push($Presupuestos,$Presupuesto);
        }
        }


        //Obtenemos los archivados
        $budgetsArchivados = Budget::orderBy('id', 'ASC')->where('tipo', 'PRESUPUESTO')->where('archivado', '1')->get();
        $PresupuestosArchivados=[];
      
        //No obtenemos clientes por que ya los tenemos arriba
        foreach($budgetsArchivados as $budgetArchivados){
         $PresupuestoArchivados   = new stdClass();
         $PresupuestoArchivados->id = $budgetArchivados->id;
         $PresupuestoArchivados->folio = $budgetArchivados->folio;
         $PresupuestoArchivados->fechaEvento = $budgetArchivados->fechaEvento;
         //$Presupuesto->vendedor = $budget->vendedor_id;
         $DatosVendedor = User::orderBy('id', 'DESC')->where('id', $budget->vendedor_id)->first();
         $PresupuestoArchivados->vendedor = $DatosVendedor->name;
         $PresupuestoArchivados->version = $budgetArchivados->version;
         $PresupuestoArchivados->impresion = $budgetArchivados->impresion;
         $PresupuestoArchivados->enviado = $budgetArchivados->enviado;
         $PresupuestoArchivados->total = $budgetArchivados->total;
         $PresupuestoArchivados->impresionBodega = $budgetArchivados->impresionBodega;
         $PresupuestoArchivados->updated_at = $budgetArchivados->updated_at;

         
         

         foreach($clientes as $cliente){
       
             if($cliente->id==$budgetArchivados->client_id){
                    if($cliente->apellidoPaterno==$cliente->nombre){$PresupuestoArchivados->cliente = $cliente->nombre;}else{
                     $PresupuestoArchivados->cliente = $cliente->nombre.' '.$cliente->apellidoPaterno;}

                if($budget->lugarEvento = 'MISMA'){
                    $PresupuestoArchivados->lugarEvento = $cliente->direccionFacturacion; 
                    
                }else{
                    $PresupuestoArchivados->lugarEvento = $budgetArchivados->lugarEvento;
                }
                
        }
        }

         array_push($PresupuestosArchivados,$PresupuestoArchivados);
        }

        //dd($clientes);
        return view('presupuestos',compact('Presupuestos', 'PresupuestosArchivados', 'presupuestosHistorial'));   
    }

    public function presupuestos2(){
        $budgets = Budget::orderBy('id', 'ASC')->where('tipo', 'CONTRATO')->where('archivado', '0')->get();

        $fechaHoy = Carbon::yesterday();
        $presupuestosHistorial = Budget::orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->where('archivado', 0)->whereDate('fechaEvento', '<=', $fechaHoy)->get();
        $Presupuestos=[];
      
        //Obtenemos clientes morales y fisicos
        $clientes_morales = DB::table('clients')
        ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
        ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
        ->get();

        $clientes_fisicos = DB::table('clients')
        ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
        ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion')
        ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        foreach($budgets as $budget){
            if($budget->fechaEvento >= $fechaHoy || $budget->fechaEvento == null){
                $Presupuesto   = new stdClass();
                $Presupuesto->id = $budget->id;
                $Presupuesto->folio = $budget->folio;
                $Presupuesto->fechaEvento = $budget->fechaEvento;
                //$Presupuesto->vendedor = $budget->vendedor_id;
                $DatosVendedor = User::orderBy('id', 'DESC')->where('id', $budget->vendedor_id)->first();
                $Presupuesto->vendedor = $DatosVendedor->name;
                $Presupuesto->version = $budget->version;
                $Presupuesto->impresion = $budget->impresion;
                $Presupuesto->enviado = $budget->enviado;
                if($budget->opcionIVA==1){
                    $Presupuesto->total = ($budget->total)+($budget->total*.16);
                }else{
                    $Presupuesto->total = $budget->total;
                }
                $Presupuesto->impresionBodega = $budget->impresionBodega;
                $Presupuesto->updated_at = $budget->updated_at;
            
         
         

         foreach($clientes as $cliente){
       
             if($cliente->id==$budget->client_id){
                    if($cliente->apellidoPaterno==$cliente->nombre){$Presupuesto->cliente = $cliente->nombre;}else{
                     $Presupuesto->cliente = $cliente->nombre.' '.$cliente->apellidoPaterno;}

                if($budget->lugarEvento = 'MISMA'){
                    $Presupuesto->lugarEvento = $cliente->direccionFacturacion; 
                    
                }else{
                    $Presupuesto->lugarEvento = $budget->lugarEvento;
                }
                
        }
        }

         array_push($Presupuestos,$Presupuesto);
        }
        }


        //Obtenemos los archivados
        $budgetsArchivados = Budget::orderBy('id', 'ASC')->where('tipo', 'PRESUPUESTO')->where('archivado', '1')->get();
        $PresupuestosArchivados=[];
      
        //No obtenemos clientes por que ya los tenemos arriba
        foreach($budgetsArchivados as $budgetArchivados){
         $PresupuestoArchivados   = new stdClass();
         $PresupuestoArchivados->id = $budgetArchivados->id;
         $PresupuestoArchivados->folio = $budgetArchivados->folio;
         $PresupuestoArchivados->fechaEvento = $budgetArchivados->fechaEvento;
         //$Presupuesto->vendedor = $budget->vendedor_id;
         $DatosVendedor = User::orderBy('id', 'DESC')->where('id', $budget->vendedor_id)->first();
         $PresupuestoArchivados->vendedor = $DatosVendedor->name;
         $PresupuestoArchivados->version = $budgetArchivados->version;
         $PresupuestoArchivados->impresion = $budgetArchivados->impresion;
         $PresupuestoArchivados->enviado = $budgetArchivados->enviado;
         $PresupuestoArchivados->total = $budgetArchivados->total;
         $PresupuestoArchivados->impresionBodega = $budgetArchivados->impresionBodega;
         $PresupuestoArchivados->updated_at = $budgetArchivados->updated_at;

         
         

         foreach($clientes as $cliente){
       
             if($cliente->id==$budgetArchivados->client_id){
                    if($cliente->apellidoPaterno==$cliente->nombre){$PresupuestoArchivados->cliente = $cliente->nombre;}else{
                     $PresupuestoArchivados->cliente = $cliente->nombre.' '.$cliente->apellidoPaterno;}

                if($budget->lugarEvento = 'MISMA'){
                    $PresupuestoArchivados->lugarEvento = $cliente->direccionFacturacion; 
                    
                }else{
                    $PresupuestoArchivados->lugarEvento = $budgetArchivados->lugarEvento;
                }
                
        }
        }

         array_push($PresupuestosArchivados,$PresupuestoArchivados);
        }

        //dd($clientes);
        return view('presupuestos2',compact('Presupuestos', 'PresupuestosArchivados', 'presupuestosHistorial'));
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

    //Ventas

    public function ventas(){
        $contratos = Budget::orderBy('id', 'DESC')->get();
        return view('ventas', compact('contratos'));
    }

    public function ventasFiltro(Request $request){
        $fecha = strtotime($request->fecha);
        $mes = date("n", $fecha);
        $ano = date("Y", $fecha);
        $contratos = Budget::orderBy('id', 'DESC')->whereYear('fechaEvento', $ano)->whereMonth('fechaEvento', $mes)->get();
        return view('ventas', compact('contratos'));
    }

    public function ventasPDF(){
        $contratos = Budget::orderBy('id', 'DESC')->get();
        
        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.reporteVentas', compact('contratos'));

        return $pdf->stream();
    }
}
