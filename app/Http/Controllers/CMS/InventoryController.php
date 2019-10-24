<?php

namespace App\Http\Controllers\CMS;

use App\Inventory;
use App\Family;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;

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
        
        return view('Inventories.create', compact('familias'));
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
        
        return view('Inventories.edit', compact('inventory', 'familias'));
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
        //
    }

    public function pdf(Request $request){        

        $Inventario = Inventory::orderBy('id', 'DESC')->where('familia', $request->familia)->get();
        


        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.lista_inventario', compact('Inventario'));

        return $pdf->stream();

    }
}
