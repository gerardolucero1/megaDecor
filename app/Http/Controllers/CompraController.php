<?php

namespace App\Http\Controllers;

use App\Compra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompraController extends Controller
{

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function obtenerCompras()
   {
       $compras = Compra::orderBy('id', 'DESC')->get();
       return $compras;
   }
    //

    public function agregarCompra(Request $request){

        $ultimaCompra = Compra::orderBy('id', 'DESC')->first();

        $compra = new Compra();
        $compra->id =  $ultimaCompra->id+1;
        $compra->fecha =  $request->fecha;
        $compra->moneda =  $request->moneda;
        $compra->tipoCambio =  $request->tipoCambio;
        $compra->montoFactura =  $request->montoFactura;
        $compra->montoEnvio =  $request->montoEnvio;
        $compra->impuestos =  $request->impuestos;
        $compra->folioFactura =  $request->folioFactura;
        $compra->proveedor = $request->proveedor;
        $compra->imgFactura = $request->imgFactura;
        $compra->save();

        $response =Compra::findOrFail($request->id);
        return $response;

    }
}
