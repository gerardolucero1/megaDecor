<?php

namespace App\Http\Controllers\CMS;

use App\User;
use App\Budget;
use App\Client;
use App\Inventory;
use App\Telephone;
use App\BudgetPack;
use App\Celebrated;
use App\BudgetInventory;
use App\ExternalInventory;
use App\BudgetPackInventory;
use Illuminate\Http\Request;
use Intervention\Image\Image;
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

    // Retorna todos los clientes con sus presupeustos a la vista

    public function clientesPresupuestos(){
        return Client::with('budgets')->orderBy('id', 'DESC')->get();
    }

    public function cliente(Request $request){

        if($request->accion == 'telefonos'){
            return Telephone::orderBy('id', 'DESC')->where('client_id', $request->id)->get();
        }

        if($request->accion == 'presupuestos'){
            return Budget::orderBy('id', 'DESC')->where('client_id', $request->id)->get();
        }
        
    }
    // Retorna todos los clientes a la vista
    public function clientes(){

        $clientes_morales = DB::table('clients')
            ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
            ->select('clients.id', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
            ->get();

        $clientes_fisicos = DB::table('clients')
            ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
            ->select( 'clients.id', 'physical_people.nombre', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion')
            ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        return $clientes;
    }

    public function store(Request $request){
    
        if($request->presupuesto['tipoEvento'] == 'INTERNO'){
            $fecha = $request->presupuesto['fechaEvento'];
            $evento = Budget::orderBy('id', 'DESC')->where('fechaEvento', $fecha)->first();
            if(!is_null($evento)){
                return 1;
            }
        }
        

        $ultimoFolio = Budget::orderBy('id', 'DESC')->pluck('folio')->first();
        
        //$ultimoFolio = 'NM10000';
        if(!is_null($ultimoFolio)){
            $numero = explode('M', $ultimoFolio);

            if($request->presupuesto['tipoEvento'] == 'INTERNO'){
                $folio = 'M'.($numero[1] + 1);
            }else{
                $folio = 'NM'.($numero[1] + 1);
            }
        }else{
            $numero = 0;
            if($request->presupuesto['tipoEvento'] == 'INTERNO'){
                $folio = 'M'.($numero + 1);
            }else{
                $folio = 'NM'.($numero + 1);
            }
        }
        
        $presupuesto = new Budget();

        $presupuesto->folio             = $folio;
        $presupuesto->tipo              = $request->presupuesto['tipo'];
        $presupuesto->vendedor_id       = $request->presupuesto['vendedor_id'];
        $presupuesto->client_id         = $request->presupuesto['client_id'];
        $presupuesto->tipoEvento        = $request->presupuesto['tipoEvento'];
        $presupuesto->tipoServicio      = $request->presupuesto['tipoServicio'];
        $presupuesto->categoriaEvento   = $request->presupuesto['categoriaEvento'];
        $presupuesto->fechaEvento       = $request->presupuesto['fechaEvento'];
        $presupuesto->pendienteFecha    = $request->presupuesto['pendienteFecha'];
        $presupuesto->horaEventoInicio  = $request->presupuesto['horaEventoInicio'];
        $presupuesto->horaEventoFin     = $request->presupuesto['horaEventoFin'];
        $presupuesto->pendienteHora     = $request->presupuesto['pendienteHora'];
        $presupuesto->lugarEvento       = $request->presupuesto['lugarEvento'];
        $presupuesto->pendienteLugar    = $request->presupuesto['pendienteLugar'];
        $presupuesto->nombreLugar       = $request->presupuesto['nombreLugar'];
        $presupuesto->direccionLugar    = $request->presupuesto['direccionLugar'];
        $presupuesto->numeroLugar       = $request->presupuesto['numeroLugar'];
        $presupuesto->coloniaLugar      = $request->presupuesto['coloniaLugar'];
        $presupuesto->CPLugar           = $request->presupuesto['CPLugar'];
        $presupuesto->observacionesLugar = $request->presupuesto['observacionesLugar'];
        $presupuesto->numeroInvitados   = $request->presupuesto['numeroInvitados'];
        $presupuesto->colorEvento       = $request->presupuesto['colorEvento'];
        $presupuesto->temaEvento        = $request->presupuesto['temaEvento'];
        $presupuesto->opcionPrecioUnitario        = $request->presupuesto['opcionPrecioUnitario'];
        $presupuesto->opcionDescripcionPaquete        = $request->presupuesto['opcionDescripcionPaquete'];
        $presupuesto->opcionImagen        = $request->presupuesto['opcionImagen'];
        $presupuesto->opcionPrecio        = $request->presupuesto['opcionPrecio'];
        $presupuesto->opcionDescuento        = $request->presupuesto['opcionDescuento'];
        $presupuesto->save();

        $ultimoPresupuesto = Budget::orderBy('id', 'DESC')->pluck('id')->first();

        foreach ($request->festejados as $item) {
           $festejado = new Celebrated();

           $festejado->budget_id    = $ultimoPresupuesto;
           $festejado->nombre       = $item['nombre'];
           $festejado->edad         = $item['edad'];
           $festejado->save();
        }

        foreach($request->inventario as $item){
            if($item['tipo'] == 'PRODUCTO'){
                $producto = new BudgetInventory();

                $producto->budget_id = $ultimoPresupuesto;
                
                //$producto->imagen = $item['imagen'];
                $producto->servicio = $item['servicio'];
                $producto->cantidad = $item['cantidad'];
                $producto->precioUnitario = $item['precioUnitario'];
                $producto->precioFinal = $item['precioFinal'];
                $producto->ahorro = $item['ahorro'];
                $producto->notas = $item['notas'];
                $producto->externo = $item['externo'];
                if($item['externo']){
                    //Otra Imagen
                    if($item['imagen']){

                        $image = $item['imagen'];
                        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                        \Image::make($item['imagen'])->save(public_path('presupuesto/').$name);
                        $producto->fill(['imagen' => asset('presupuesto/'.$name)])->save();
                    }
                }else{
                    $producto->imagen = $item['imagen'];
                    $producto->save();
                }
                
                if(!$item['externo']){
                    $producto = Inventory::find($item['id']);

                    $producto->disponible = ($producto->disponible) - ($item['cantidad']);
                    $producto->save();
                }
            }else{
                $paquete = new BudgetPack();

                $paquete->budget_id = $ultimoPresupuesto;
                $paquete->servicio = $item['servicio'];
                $paquete->precioFinal = $item['precioFinal'];
                $paquete->categoria = $item['paquete']['categoria'];
                $paquete->guardarPaquete = $item['paquete']['guardarPaquete'];
                $paquete->save();

                $ultimoPack = BudgetPack::orderBy('id', 'DESC')->pluck('id')->first();

                    foreach($item['paquete']['inventario'] as $objeto){
                        $producto = new BudgetPackInventory();

                        $producto->budget_pack_id = $ultimoPack;
                        
                        $producto->servicio = $objeto['nombre'];
                        $producto->cantidad = $objeto['cantidad'];
                        $producto->precioUnitario = $objeto['precioUnitario'];
                        $producto->precioFinal = $objeto['precioFinal'];
                        $producto->externo = $objeto['externo'];
                        if($objeto['externo']){
                            //Otra Imagen
                            if($objeto['imagen']){
        
                                $image = $objeto['imagen'];
                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                                \Image::make($objeto['imagen'])->save(public_path('paquete/').$name);
                                $producto->fill(['imagen' => asset('paquete/'.$name)])->save();
                            }
                        }else{
                            $producto->imagen = $objeto['imagen'];
                            $producto->save();
                        }

                        
                        if(!$objeto['externo']){
                            //$paquete->inventories()->attach($objeto['id']);                                                       
                            $producto = Inventory::find($objeto['id']);

                            $producto->disponible = ($producto->disponible) - ($objeto['cantidad']);
                            $producto->save();
                            
                        }
                    }
            }
        }

    }
}
