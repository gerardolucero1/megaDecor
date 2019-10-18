<?php

namespace App\Http\Controllers\CMS;

use App\Faltantes;
use App\Client;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaltantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $nombre = Client::Orderby('id','DESC')->first();
        $faltantes = Faltantes::orderBy('id', 'DESC')->get();
        return view('faltantes.index', compact('faltantes','nombre'));
        
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventarios = Inventory::orderBy('id', 'DESC')->get();
        return view('faltantes.create', compact('inventarios'));
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
            'contrato'              => 'required',
            'fecha'                 => 'required',
            'nombre_de_persona'     => 'required',
            'descripcion'           => 'required',
            'cantidad_que_falta'    => 'required',
            'dias_desde_no_regreso' => 'required',
            'id_article'            => 'required',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $faltantes = Faltantes::create($request->all());

        return redirect()->route('faltantes.index')
            ->with('info', 'Registro de faltantes creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faltante = Faltantes::where('id',$id)->first();

        $cliente2 = Client::where('id', $faltante->nombre_de_persona)->first();
        $cliente = Client::where('id', $faltante->id)->first();
        //dd($faltante,$cliente);
        if($cliente == null){
        return redirect()->route('faltantes.index')
            ->with('info', 'El cliente no existe');
        }
        else{
            return view('faltantes.show', compact('faltante','cliente','cliente2'));
        }
       
    }

    public function show2($id)
    {
        $faltante = Faltantes::where('id',$id)->first();

        $inventario = Inventory::where('id', $faltante->id)->first();
        dd($faltante,$inventario);
        if($inventario == null){
        return redirect()->route('faltantes.index')
            ->with('info', 'El articulo no existe');
        }
        else{
            return view('faltantes.show2', compact('faltante','inventario'));
        }
       
    }
   
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $inventarios = Inventory::orderBy('id', 'DESC')->get();
        $faltantes = Faltantes::findOrFail($id);
        return view('faltantes.edit', compact('faltantes','inventarios'));
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
            'contrato'              => 'required',
            'fecha'                 => 'required',
            'nombre_de_persona'     => 'required',
            'descripcion'           => 'required',
            'cantidad_que_falta'    => 'required',
            'dias_desde_no_regreso' => 'required',
            'id_article'            => 'required',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $faltantes = Faltantes::findOrFail($id);

        $faltantes->fill($request->all())->save();

        return redirect()->route('faltantes.edit', $faltantes)
            ->with('info', 'Registro de faltantes editado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faltantes = Faltantes::find($id);
        $faltantes->delete();

        return back()
            ->with('info', 'Registro de faltantes eliminada con exito');
    }
}
