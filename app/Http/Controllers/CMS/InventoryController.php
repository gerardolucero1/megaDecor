<?php

namespace App\Http\Controllers\CMS;

use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Comprobamos que el slug no se repita pero ignoramos el slug propio
         $v = \Validator::make($request->all(), [
            'cantidad' => 'required',
            'servicio' => 'required',
            'precioUnitario' => 'required',
            'precioVenta' => 'required',
            'precioVenta' => 'required',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $inventory = Inventory::create($request->all());

        return redirect()->route('inventory.edit', $inventory->id)
            ->with('info', 'Producto creado con exito');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::find($id);
        return view('Inventories.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Comprobamos que el slug no se repita pero ignoramos el slug propio
        $v = \Validator::make($request->all(), [
            'cantidad' => 'required',
            'servicio' => 'required',
            'precioUnitario' => 'required',
            'precioVenta' => 'required',
            'precioVenta' => 'required',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $inventory = Inventory::find($id);
        $inventory->fill($request->all())->save();

        //Imagen
        if($request->file('imagen')){
            $image = $request->file('imagen');
            $image->move('images', $image->getClientOriginalName());
            $inventory->imagen = time().$image->getClientOriginalName();
            $inventory->save();

        }

        return redirect()->route('inventory.edit', $inventory->id)
            ->with('info', 'Inventario actualizado con exito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pdf($id){        

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->impresion = 1;
        $presupuesto->save();

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        //Obtenemos los paquetes
        $Paquetes= BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        
        $arregloEmentos=[];
        foreach($Paquetes as $paquete){
            $Elementos_paquete= BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $paquete->id)->get();
            foreach($Elementos_paquete as $Elemento_paquete){
                $arregloElemento   = new stdClass();
                $arregloElemento->imagen = $Elemento_paquete->imagen;
                $arregloElemento->servicio = $Elemento_paquete->servicio;
                $arregloElemento->cantidad = $Elemento_paquete->cantidad;
                $arregloElemento->notas = $Elemento_paquete->notas;
                $arregloElemento->budget_pack_id = $Elemento_paquete->budget_pack_id;
                array_push($arregloEmentos,$arregloElemento);
            }
           
        }
       // dd($Elemento_paquete);

         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito', 'moral_people.diasCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito', 'physical_people.diasCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }



        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.budget', compact('presupuesto', 'Telefonos', 'Elementos', 'Paquetes', 'arregloEmentos'));

        return $pdf->stream();

    }
}
