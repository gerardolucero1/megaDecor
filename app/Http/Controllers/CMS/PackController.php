<?php

namespace App\Http\Controllers\CMS;

use App\BudgetPack;
use App\AuthorizedPack;
use App\BudgetPackInventory;
use Illuminate\Http\Request;
use App\AuthorizedPackInventory;
use App\Http\Controllers\Controller;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $normalPacks = BudgetPack::orderBy('id', 'DESC')->where('guardarPaquete', true)->get();
        $authorizedPacks = AuthorizedPack::orderBy('id', 'DESC')->where('guardarPaquete', false)->get();

        $packs = $normalPacks->merge($authorizedPacks);

        return view('inventories.indexPack', compact('packs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $pack = AuthorizedPack::with('inventories')->findOrFail($id);
        return view('inventories.editPack', compact('pack'));
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
        $authorizedPack = AuthorizedPack::findOrFail($id);
        $authorizedPack->fill($request->all())->save();
        
        $itemsPaquete = AuthorizedPackInventory::where('budget_pack_id', $authorizedPack->id)->get();
        foreach($itemsPaquete as $item){
            $item->delete();
        }

        foreach($request->inventories as $item){
            $inventory = new AuthorizedPackInventory();
            $inventory->budget_pack_id = $item['budget_pack_id'];
            $inventory->servicio = $item['servicio'];
            $inventory->imagen = $item['imagen'];
            $inventory->cantidad = $item['cantidad'];
            $inventory->precioUnitario = $item['precioUnitario'];
            $inventory->precioFinal = $item['precioFinal'];
            $inventory->precioVenta = $item['precioVenta'];
            $inventory->precioEspecial = $item['precioEspecial'];
            $inventory->proveedor = $item['proveedor'];
            $inventory->save();
        }

        return;
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

    public function aprobarPaquete($id){
        $pack = BudgetPack::findOrFail($id);
        $pack->guardarPaquete = 0;
        $pack->save();

        $authorizedPack = new AuthorizedPack();
        $authorizedPack->servicio = $pack->servicio;
        $authorizedPack->cantidad = $pack->cantidad;
        $authorizedPack->precioUnitario = $pack->precioUnitario;
        $authorizedPack->precioFinal = $pack->precioFinal;
        $authorizedPack->precioVenta = $pack->precioVenta;
        $authorizedPack->precioEspecial = $pack->precioEspecial;
        $authorizedPack->precioAnterior = $pack->precioAnterior;
        $authorizedPack->guardarPaquete = 0;
        $authorizedPack->ahorro = $pack->ahorro;
        $authorizedPack->categoria = $pack->categoria;
        $authorizedPack->version = $pack->version;
        $authorizedPack->save();

        $newPack = AuthorizedPack::orderBy('id', 'DESC')->first();

        $packInventories = BudgetPackInventory::where('budget_pack_id', $pack->id)->get();
        foreach($packInventories as $inventory){
            $authorizedPackInventory = new AuthorizedPackInventory();
            $authorizedPackInventory->budget_pack_id = $newPack->id;
            $authorizedPackInventory->servicio = $inventory->servicio;
            $authorizedPackInventory->imagen = $inventory->imagen;
            $authorizedPackInventory->cantidad = $inventory->cantidad;
            $authorizedPackInventory->precioUnitario = $inventory->precioUnitario;
            $authorizedPackInventory->precioFinal = $inventory->precioFinal;
            $authorizedPackInventory->precioVenta = $inventory->precioVenta;
            $authorizedPackInventory->precioEspecial = $inventory->precioEspecial;
            $authorizedPackInventory->precioAnterior = $inventory->precioAnterior;
            $authorizedPackInventory->proveedor = $inventory->proveedor;
            $authorizedPackInventory->externo = $inventory->externo;
            $authorizedPackInventory->save();
        }

        return redirect()->route('pack.index');
    }

    public function rechazarPaquete($id){
        $pack = BudgetPack::findOrFail($id);
        $pack->guardarPaquete = 0;
        $pack->save();

        return redirect()->route('pack.index'); 
    }

}
