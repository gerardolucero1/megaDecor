<?php

namespace App\Http\Controllers\CMS;

use App\Payment;
use Carbon\Carbon;
use App\OtherPayments;
use App\CashRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtherPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
        $horaHoy = $date->toTimeString();

        $registro = CashRegister::where('estatus', true)->first();
        $pagos = OtherPayments::whereDate('created_at', $fechaHoy)->whereTime('created_at', '>=', $registro->horaApertura)->whereTime('created_at', '<=', $horaHoy)->get();

        return $pagos;
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
        $pago = OtherPayments::create($request->all());
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        $pago = OtherPayments::findOrFail($id);
        $pago->resto=$request->resto;
        $pago->created_at=$pago->updated_at;
        $pago->save();

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

}
