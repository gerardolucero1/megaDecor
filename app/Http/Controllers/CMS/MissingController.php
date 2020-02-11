<?php

namespace App\Http\Controllers\CMS;

use App\Missing;
use App\Inventory;
use App\BudgetInventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MissingController extends Controller
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

        
        $data = json_decode(file_get_contents('php://input'), true);
   
        foreach($data['inventario'] as $item){
            foreach($item as $itm){
               // dd($itm);
                $retorno = new Missing();
                $retorno->budget_id = $data['recordid'];
                $retorno->inventory_id = $itm['id'];
                $retorno->servicio = $itm['servicio'];
                $retorno->saliente = $itm['cantidad'];
                $retorno->faltante = $itm['faltante'];
                $retorno->danados = $itm['danado'];
                $retorno->imagen = $itm['imagen'];
                $retorno->descripcion = $itm['descripcion'];
                $retorno->aprobado = 0;
                $retorno->save();
            } 
            

        }
        
          
       
       /* foreach($request[0] as $item){
            $producto = Inventory::where('servicio', 'like', $item['servicio'])->first();
            

            $faltante = new Missing();
            if (!is_null($producto)) {
                $faltante->inventory_id = $producto->id; 
            }
            
            $faltante->servicio = $item['servicio'];
            $faltante->saliente = $item['cantidad'];
            $faltante->faltante = $item['faltante'];
            $faltante->danados = $item['danado'];
            $faltante->total = ($item['cantidad'] - $item['faltante']);
            $faltante->descripcion = $item['descripcion'];
            $faltante->aprobado = false;
            $faltante->save();
        }

        foreach($request[1] as $item){
            foreach($item['inventories'] as $element){
                $producto = Inventory::where('servicio', 'like', $element['servicio'])->first();

                $faltante = new Missing();
                if (!is_null($producto)) {
                    $faltante->inventory_id = $producto->id; 
                }

                $faltante->servicio = $element['servicio'];
                $faltante->saliente = $element['cantidad'];
                $faltante->faltante = $element['faltante'];
                $faltante->danados = $element['danado'];
                $faltante->total = ($element['cantidad'] - $element['faltante']);
                $faltante->descripcion = $element['descripcion'];
                $faltante->aprobado = false;
                $faltante->save();
            }
        }*/

        return;
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
        //
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
        $registro = Missing::find($id);
        $registro->informe = $request->reporte;
        $registro->reportado = true;
        $registro->vendedor = Auth::user()->name;
        $registro->save();


        // Store in AWS S3
        if($archivo = $request->file('imagen')){

            $md5Name = md5_file($archivo->getRealPath());
            $guessExtension = $archivo->guessExtension();
            $path = $archivo->storeAs('mmDecor', $md5Name.'.'.$guessExtension  ,'s3');

            $url = 'https://mm-decor.s3.us-east-2.amazonaws.com/';

            $registro->fill(['imagen' => asset($url.$path)])->save();
        }

        return redirect()->route('inventario.danados');
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
}
