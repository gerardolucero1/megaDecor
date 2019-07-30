<?php

namespace App\Http\Controllers\CMS;

use App\PhysicalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhysicalPersonController extends Controller
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
        $cliente = new PhysicalPerson();
        $cliente->nombre = $request->nombreCliente;
        $cliente->apellidoPaterno = $request->apellidoCliente;
        $cliente->apellidoMaterno = $request->apellidoCliente2;
        $cliente->email = $request->emailCliente;
        $cliente->nombreFacturacion = $request->nombreFacturacion;
        $cliente->direccionFacturacion = $request->direccionFacturacion;
        $cliente->coloniaFacturacion = $request->coloniaFacturacion;
        $cliente->numeroFacturacion = $request->numeroFacturacion;
        $cliente->rfcFacturacion = $request->rfcFacturacion;
        $cliente->emailFacturacion = $request->emailFacturacion;

        $cliente->save();
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
        //
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
