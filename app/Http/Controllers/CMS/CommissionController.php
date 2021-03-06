<?php

namespace App\Http\Controllers\CMS;

use App\Commission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Commission::orderBy('id', 'DESC')->first();
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

        //Comprobamos que ningun campo este vacio
        $request->validate([
            'porcentajeCrecimientoVentas' => 'required|integer',
            'porcentajeCrecimientoUtilidad' => 'required|integer',
            'bonoObjetivoVentas' => 'required|integer',
            'bonoObjetivoNoVentas' => 'required|integer',
            'comisionContrato' => 'required|integer',
            'bonoVendedorMes' => 'required|integer',
            'minimoVentaComision' => 'required|integer',
        ]);

        $data = Commission::first();
        $data->delete();
        $commission = Commission::create($request->all());
        
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
