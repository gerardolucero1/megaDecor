<?php

namespace App\Http\Controllers\CMS;

use App\Budget;
use App\Family;
use App\Register;
use stdClass;
use App\Supplier;
use App\Inventory;
use Carbon\Carbon;
use App\BudgetInventory;
use App\BudgetPackInventory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        $familias=Family::orderBy('nombre', 'ASC')->get();
        $proveedores = Supplier::orderBy('id', 'DESC')->where('tipo', 'NORMAL')->get();
        
        return view('Inventories.create', compact('familias', 'proveedores'));
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
            'familia' => 'required',
        ]);
            
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $inventory = Inventory::create($request->all());

        // Store in AWS S3
        if($archivo = $request->file('imagen')){

            $md5Name = md5_file($archivo->getRealPath());
            $guessExtension = $archivo->guessExtension();
            $path = $archivo->storeAs('mmDecor', $md5Name.'.'.$guessExtension  ,'s3');

            $url = 'https://mm-decor.s3.us-east-2.amazonaws.com/';

            $inventory->fill(['imagen' => asset($url.$path)])->save();
        }

        $producto = Inventory::orderBy('id', 'DESC')->first();
        
        $registro = new Register();
        $registro->tipo = 'alta';
        $registro->antes = 0;
        $registro->proveedor = $producto->proveedor1;
        $registro->precio = $producto->precioVenta;
        $registro->fechaCompra = $request->fechaCompra;
        $registro->factura = $request->factura;
        $registro->antesExhibicion = 0;
        $registro->cantidad = $producto->cantidad;
        $registro->producto = $producto->id;
        $registro->user_id = Auth::user()->id;
        $registro->save();

        return redirect()->route('inventory.create')
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
        $familias=Family::orderBy('nombre', 'ASC')->get();
        $registros = Register::orderBy('id', 'DESC')->where('producto', $id)->get();
        $proveedores = Supplier::orderBy('id', 'DESC')->where('tipo', 'NORMAL')->get();
        
        return view('Inventories.edit', compact('inventory', 'familias', 'registros', 'proveedores'));
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
            'familia' => 'required',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $inventory = Inventory::find($id);
        $inventory->fill($request->all())->save();

        //Imagen
        /*
        if($request->file('imagen')){
            $image = $request->file('imagen');
            $image->move('images', $image->getClientOriginalName());
            $inventory->imagen = time().$image->getClientOriginalName();
            $inventory->save();

        }*/

        // Store in AWS S3
        if($archivo = $request->file('imagen')){

            $md5Name = md5_file($archivo->getRealPath());
            $guessExtension = $archivo->guessExtension();
            $path = $archivo->storeAs('mmDecor', $md5Name.'.'.$guessExtension  ,'s3');

            $url = 'https://mm-decor.s3.us-east-2.amazonaws.com/';

            $inventory->fill(['imagen' => asset($url.$path)])->save();
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
        
    }

    public function archivar($id){
        $inventory = Inventory::find($id);
        $inventory->archivar = true;
        $inventory->save();

        $Inventario = Inventory::orderBy('id', 'DESC')->where('archivar', false)->orWhere('archivar', null)->get();

        return view('inventario', compact('Inventario'));

    }

    public function pdf(Request $request){        
        
        if(!is_null($request->familia)){
        $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->get();
        }else{
        $Inventario = Inventory::orderBy('familia', 'DESC')->get();
        }
        
        $familia = $request->familia;


        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.lista_inventario', compact('Inventario', 'familia'));

        return $pdf->stream();

    }

    public function inventarioFiltro(Request $request){
        if($request->familia && ($request->fecha_1 == null && $request->fecha_2 == null)){
            $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->get();

            return view('inventario', compact('Inventario'));
        }else if($request->familia == null && ($request->fecha_1 && $request->fecha_2)){
            $Inventario = Inventory::orderBy('id', 'DESC')->whereDate('updated_at', '>=', $request->fecha_1)->whereDate('updated_at', '<=', $request->fecha_2)->get();

            return view('inventario', compact('Inventario'));
        }else if($request->familia == null && ($request->fecha_1 && $request->fecha_2 == null)){
            $Inventario = Inventory::orderBy('id', 'DESC')->whereDate('updated_at', '>=', $request->fecha_1)->get();

            return view('inventario', compact('Inventario'));
        }else if($request->familia && ($request->fecha_1 && $request->fecha_2 == null)){
            $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->whereDate('updated_at', '>=', $request->fecha_1)->get();

            return view('inventario', compact('Inventario'));
        }else{
            $Inventario = Inventory::orderBy('id', 'DESC')->get();

            return view('inventario', compact('Inventario'));
        }
    }


    public function inventarioFiltro2(Request $request){
        if($request->familia && ($request->fecha_1 == null && $request->fecha_2 == null)){
            $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->get();

            return view('inventario2', compact('Inventario'));
        }else if($request->familia == null && ($request->fecha_1 && $request->fecha_2)){
            $Inventario = Inventory::orderBy('id', 'DESC')->whereDate('updated_at', '>=', $request->fecha_1)->whereDate('updated_at', '<=', $request->fecha_2)->get();

            return view('inventario2', compact('Inventario'));
        }else if($request->familia == null && ($request->fecha_1 && $request->fecha_2 == null)){
            $Inventario = Inventory::orderBy('id', 'DESC')->whereDate('updated_at', '>=', $request->fecha_1)->get();

            return view('inventario2', compact('Inventario'));
        }else if($request->familia && ($request->fecha_1 && $request->fecha_2 == null)){
            $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->whereDate('updated_at', '>=', $request->fecha_1)->get();

            return view('inventario2', compact('Inventario'));
        }else{
            $Inventario = Inventory::orderBy('id', 'DESC')->get();

            return view('inventario2', compact('Inventario'));
        }
    }

    public function proximos(){
        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');

        $contratos = Budget::orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->whereDate('fechaEvento', '=', $date)->get();
        $elementos=[];
        
        foreach($contratos as $contrato){
            $elementosContrato = BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $contrato->id)->where('version', $contrato->version)->get();
            foreach($elementosContrato as $elementoContrato){
            $elemento = new stdClass();
            $elemento->servicio = $elementoContrato->servicio;
            $elemento->cantidad = $elementoContrato->cantidad;
            $elemento->contrato = $contrato->folio;
            array_push($elementos,$elemento);
            }
            
        }
        $totales=[];
        $cantidadesTotales=[];
        //dd($elementos);
        foreach($elementos as $elemento){
            if(in_array($elemento->servicio, $totales)){
                
            }else{
               array_push($totales,$elemento->servicio);
            }
        }

        foreach($totales as $total){
            $producto = new stdClass();
            $producto->total=0;
            foreach($elementos as $elemento){
                if($total==$elemento->servicio){
               $producto->servicio = $elemento->servicio;
               $producto->total = $producto->total + $elemento->cantidad;
                }
                
            }
            array_push($cantidadesTotales,$producto);
        }
        //dd($cantidadesTotales);

        

        return view('eventosProximos', compact('contratos', 'cantidadesTotales'));
    }

    public function pdfTransferencias(){        
        $fecha1 = $_GET['fecha_1'];
        $fecha2 = $_GET['fecha_2'];
        $familia = $_GET['familia'];
        
        $transferencias = Register::orderBy('id', 'ASC')->where('tipo', 'salida')->whereDate('created_at','>=', $fecha1)->whereDate('created_at','<=', $fecha2)->orWhere('tipo', 'entrada')->whereDate('updated_at','>=', $fecha1)->whereDate('updated_at','<=', $fecha2)->get();
        $altasbajas = Register::orderBy('id', 'ASC')->where('tipo', 'alta')->whereDate('updated_at','>=', $fecha1)->whereDate('updated_at','<=', $fecha2)->orWhere('tipo', 'baja')->whereDate('updated_at','>=', $fecha1)->whereDate('updated_at','<=', $fecha2)->get();
        //$demo = collect($otroArray);
        $pdf = App::make('dompdf');
        $pdf = PDF::loadView('pdf.transferencias', compact('transferencias' , 'altasbajas', 'familia'));
        return $pdf->stream();
    }
    public function buscarProximos(Request $request){
        $contratos = Budget::orderBy('id', 'ASC')->where('tipo', 'CONTRATO')->whereDate('fechaEvento', '=', $request->fecha)->get();
        $elementos=[];
        
        foreach($contratos as $contrato){
            $elementosContrato = BudgetInventory::orderBy('id', 'ASC')->where('budget_id', $contrato->id)->where('version', $contrato->version)->get();
            foreach($elementosContrato as $elementoContrato){
            $elemento = new stdClass();
            $elemento->servicio = $elementoContrato->servicio;
            $elemento->cantidad = $elementoContrato->cantidad;
            $elemento->contrato = $contrato->folio;
            array_push($elementos,$elemento);
            }
            
        }
        $totales=[];
        $cantidadesTotales=[];
        //dd($elementos);
        foreach($elementos as $elemento){
            if(in_array($elemento->servicio, $totales)){
                
            }else{
               array_push($totales,$elemento->servicio);
            }
        }

        foreach($totales as $total){
            $producto = new stdClass();
            $producto->total=0;
            foreach($elementos as $elemento){
                if($total==$elemento->servicio){
               $producto->servicio = $elemento->servicio;
               $producto->total = $producto->total + $elemento->cantidad;
                }
                
            }
            array_push($cantidadesTotales,$producto);
        }
        //dd($cantidadesTotales);

        

        return view('eventosProximos', compact('contratos', 'cantidadesTotales'));
    }

    public function aprobarProducto($id){
        $producto = BudgetInventory::findOrFail($id);
        $producto->guardarInventario = false;
        $producto->save();

        $inventario = new Inventory();
        $inventario->servicio = $producto->servicio;
        $inventario->imagen = $producto->imagen;
        $inventario->precioUnitario = $producto->precioUnitario;
        $inventario->precioVenta = $producto->precioVenta;
        $inventario->tipoCambio = 'MXN';
        $inventario->proveedor1 = 'MegaMundo';
        $inventario->proveedor2 = 'MegaMundo';
        $inventario->exhibicion = 0;
        $inventario->cantidad = 0;
        $inventario->disponible = 0;
        $inventario->save();

        return redirect()->route('inventario');
    }

    public function aprobarProductoPaquete($id){
        $producto = BudgetPackInventory::findOrFail($id);
        $producto->guardarInventario = false;
        $producto->save();

        $inventario = new Inventory();
        $inventario->servicio = $producto->servicio;
        $inventario->imagen = $producto->imagen;
        $inventario->precioUnitario = $producto->precioUnitario;
        $inventario->precioVenta = $producto->precioVenta;
        $inventario->tipoCambio = 'MXN';
        $inventario->proveedor1 = 'MegaMundo';
        $inventario->proveedor2 = 'MegaMundo';
        $inventario->exhibicion = 0;
        $inventario->cantidad = 0;
        $inventario->disponible = 0;
        $inventario->save();

        return redirect()->route('inventario');
    }
}
