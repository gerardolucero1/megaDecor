<?php

namespace App\Http\Controllers\CMS;

use App\Budget;
use Carbon\Carbon;
use App\CashRegister;
use App\OtherPayments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('caja.index');
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
        $date = Carbon::now();
        $fechaHoy = $date->toDateString();
        $horaHoy = $date->toTimeString();
        
        $registro = new CashRegister();
        
        $registro->user_id          = Auth::user()->id;
        $registro->fechaApertura    = $fechaHoy;
        $registro->horaApertura     = $horaHoy;
        
       
            $registro->aperturaBillete1000 = $request['billetes']['billete1000'];
            $registro->aperturaBillete500 = $request['billetes']['billete500'];
            $registro->aperturaBillete200 = $request['billetes']['billete200'];
            $registro->aperturaBillete100 = $request['billetes']['billete100'];
            $registro->aperturaBillete50 = $request['billetes']['billete50'];
            $registro->aperturaBillete20 = $request['billetes']['billete20'];
            $registro->aperturaMoneda10 = $request['billetes']['moneda10'];
            $registro->aperturaMoneda5 = $request['billetes']['moneda5'];
            $registro->aperturaMoneda2 = $request['billetes']['moneda2'];
            $registro->aperturaMoneda1 = $request['billetes']['moneda1'];
            $registro->aperturaCentavo50 = $request['billetes']['centavo50'];
        

        $registro->cantidadApertura = $request['cantidadApertura'];
        $registro->cantidadRealApertura = $request['cantidadRealApertura'];
        $registro->estatus = true;

        $registro->save();
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

    public function obtenerPresupuestos(){
        $presupuestos = Budget::with('payments')->with('client')->orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->get();
        return $presupuestos;
    }

}
