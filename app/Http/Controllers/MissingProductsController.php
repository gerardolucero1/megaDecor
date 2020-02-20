<?php

namespace App\Http\Controllers;

use App\Client;
use App\Inventory;
use App\MissingProducts;

use App\Family;

use Illuminate\Http\Request;

class MissingProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $nombre = Client::Orderby('id','DESC')->first();
        $bool = null;
        $faltantes = MissingProducts::orderBy('id', 'DESC')->get();
        return view('missing.index', compact('faltantes','nombre','bool'));
        
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventarios = Inventory::orderBy('id', 'DESC')->get();
        return view('missing.create', compact('inventarios'));
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

        $faltantes = MissingProducts::create($request->all());

        return redirect()->route('missing.index')
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
        $faltante = MissingProducts::where('id',$id)->first();
        $faltanteArticulo = MissingProducts::where('id', $faltante->id_article)->first();
        $cliente2 = Client::where('id', $faltante->nombre_de_persona)->first();
        $cliente = Client::where('id', $faltante->id)->first();
        //dd($faltante,$cliente);
        if($cliente == null){
        return redirect()->route('missing.index')
            ->with('info', 'El cliente no existe');
        }
        else{
            //si la categoria es cliente ** cliente es en este caso el nulo            
            return view('missing.show', compact('faltante','cliente','cliente2','faltanteArticulo'));           
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
        $faltantes = MissingProducts::findOrFail($id);
        return view('missing.edit', compact('faltantes','inventarios'));
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

        $faltantes = MissingProducts::findOrFail($id);

        $faltantes->fill($request->all())->save();

        return redirect()->route('missing.edit', $faltantes)
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
        $faltantes = MissingProducts::find($id);
        $faltantes->delete();

        return back()
            ->with('info', 'Registro de faltantes eliminada con exito');
    }
}