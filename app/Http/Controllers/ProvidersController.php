<?php

namespace App\Http\Controllers;

use App\Providers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provedores = Providers::orderBy('id', 'DESC')->get();
        return view('providers.index', compact('provedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('providers.create');
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
            'nombre'    => 'required',
            'telefono'  => 'required',
            'correo'    => 'required',
            'direccion' => 'required',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $provedores = Providers::create($request->all());

        return redirect()->route('providers.index')
            ->with('info', 'Provedor creado con exito');
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
        $provedores = Providers::findOrFail($id);
        return view('providers.edit', compact('provedores'));
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
            'nombre'    => 'required',
            'telefono'  => 'required',
            'correo'    => 'required',
            'direccion' => 'required',
            
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $provedores = Providers::findOrFail($id);

        $provedores->fill($request->all())->save();

        return redirect()->route('providers.edit', $provedores)
            ->with('info', 'Provedor editado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provedores = Providers::find($id);
        $provedores->delete();

        return back()
            ->with('info', 'Provedor eliminado con exito');
    }
}