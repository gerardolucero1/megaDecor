<?php

namespace App\Http\Controllers\CMS;

use App\User;
use App\Budget;
use App\Inventory;
use App\Celebrated;
use App\BudgetInventory;
use App\ExternalInventory;
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

    // Retorna todos los clientes a la vista
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

    public function store(Request $request){
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
        $presupuesto->vendedor_id       = $request->presupuesto['vendedor_id'];
        $presupuesto->cliente_id        = $request->presupuesto['cliente_id'];
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
            $producto = new BudgetInventory();

            $producto->budget_id = $ultimoPresupuesto;
            //$producto->imagen = $item['imagen'];
            $producto->imagen = 'Imagen de prueba';
            $producto->servicio = $item['servicio'];
            $producto->cantidad = $item['cantidad'];
            $producto->precioUnitario = $item['precioUnitario'];
            $producto->precioFinal = $item['precioFinal'];
            $producto->ahorro = $item['ahorro'];
            $producto->notas = $item['notas'];
            $producto->save();
            if(!$item['externo']){
                $producto = Inventory::find($item['id']);

                $producto->cantidad = ($producto->cantidad) - ($item['cantidad']);
                $producto->save();
            }
        }

    }
}
