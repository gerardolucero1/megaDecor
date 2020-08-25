<?php

namespace App\Http\Controllers\CMS;

use App\Budget;
use App\Payment;
use App\Client;
use App\MoralPerson;
use App\PhysicalPerson;
use Carbon\Carbon;
use App\CashRegister;
use App\OtherPayments;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
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
        $registro->cantidadCheques = $request['arrayDatos'][0];
        $registro->cantidadDolares = $request['arrayDatos'][1];
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
        $date = Carbon::now();
        $fechaHoy   = $date->toDateString();
        $horaHoy    = $date->toTimeString();
        
        $registro =  CashRegister::findOrFail($id);
        
        $registro->user_id          = Auth::user()->id;
        $registro->horaCierre       = $horaHoy;
        
            $registro->cierreBillete1000  = $request['billetes']['billete1000'];
            $registro->cierreBillete500   = $request['billetes']['billete500'];
            $registro->cierreBillete200   = $request['billetes']['billete200'];
            $registro->cierreBillete100   = $request['billetes']['billete100'];
            $registro->cierreBillete50    = $request['billetes']['billete50'];
            $registro->cierreBillete20    = $request['billetes']['billete20'];
            $registro->cierreMoneda10     = $request['billetes']['moneda10'];
            $registro->cierreMoneda5      = $request['billetes']['moneda5'];
            $registro->cierreMoneda2      = $request['billetes']['moneda2'];
            $registro->cierreMoneda1      = $request['billetes']['moneda1'];
            $registro->cierreCentavo50    = $request['billetes']['centavo50'];

        $registro->cantidadCierre       = $request['cantidadCierre'];
        $registro->cantidadRealCierre   = $request['cantidadRealCierre'];
        $registro->estatus = false;

        $registro->save();
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

    public function obtenerPresupuestos(){
        $presupuestos = Budget::with('payments')->with('client')->orderBy('id', 'DESC')->where('tipo', 'CONTRATO')->get();
        return $presupuestos;
    }
    public function obtenerUltimoPago(){
        $ultimoPago = Payment::orderBy('id', 'DESC')->first();
        return $ultimoPago;
    }

    public function corte(){
        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
        $horaHoy = $date->toTimeString();


        $registro = CashRegister::orderBy('id', 'DESC')->where('estatus', true)->first();
        $pagos = Payment::whereDate('created_at', $fechaHoy)->whereTime('created_at', '>=', $registro->horaApertura)->whereTime('created_at', '<=', $horaHoy)->get();
        $otrosPagos = OtherPayments::whereDate('created_at', $fechaHoy)->whereTime('created_at', '>=', $registro->horaApertura)->whereTime('created_at', '<=', $horaHoy)->get();

        $registros = [$pagos, $otrosPagos];

        return $registros;
    }

    public function pdf($id){
        $registro = CashRegister::findOrFail($id);

        $date = Carbon::now();
        $fechaCorte = $registro->created_at;
        $fechaCorteCierre = $registro->updated_at;
        $date=$date->format('Y-m-d');
        $fechaCorte = $fechaCorte->format('Y-m-d');
        $fechaCorteCierre = $fechaCorteCierre->format('Y-m-d');


        $fechaApertura = Carbon::parse($registro->created_at);
        $fechaCierre = Carbon::parse($registro->updated_at);
        $pagos = Payment::with('budget')->orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaCorte)->whereDate('created_at', '<=', $fechaCorteCierre)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaCorte)->whereDate('created_at', '<=', $fechaCorteCierre)->get();
        


        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.contabilidad', compact('registro', 'pagos', 'otrosPagos'));

        return $pdf->stream();
    }

    public function precorte($id){
        $registro = CashRegister::findOrFail($id);

        $date = Carbon::now();
        $fechaCorte = $registro->created_at;
        $fechaCorteCierre = $registro->updated_at;
        $date=$date->format('Y-m-d');
        $fechaCorte = $fechaCorte->format('Y-m-d');
        $fechaCorteCierre = $fechaCorteCierre->format('Y-m-d');


        $fechaApertura = Carbon::parse($registro->created_at);
        $fechaCierre = Carbon::parse($registro->updated_at);
        $pagos = Payment::with('budget')->orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaCorte)->whereDate('created_at', '<=', $fechaCorteCierre)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaCorte)->whereDate('created_at', '<=', $fechaCorteCierre)->get();
        


        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.precorte', compact('registro', 'pagos', 'otrosPagos'));

        return $pdf->stream();
    }

    public function pdfReciboDePago($id){
        $date = Carbon::now();
        $Pago = Payment::orderBy('id', 'DESC')->where('id', $id)->first();
        $Pagos = Payment::orderBy('id', 'DESC')->where('budget_id', $Pago->budget_id)->whereTime('created_at', '<', $Pago->created_at)->orWhereDate('created_at', '<', $Pago->created_at)->where('budget_id', $Pago->budget_id)->get();
        $Budget = Budget::orderBy('id', 'DESC')->where('id', $Pago->budget_id)->first();
        $cliente = Client::orderBy('id', 'DESC')->where('id', $Budget->client_id)->first();
        

        if($cliente->tipoPersona=='FISICA'){
            $cliente = PhysicalPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }else{
            $cliente = MoralPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }
        
        

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.recibo_pago', compact('Pago', 'Budget', 'cliente', 'Pagos'));

        return $pdf->stream();
    }

    public function pdfReciboDePagor($id){
        $date = Carbon::now();
        $Pago = Payment::orderBy('id', 'DESC')->where('id', $id)->first();
        $Pagos = Payment::orderBy('id', 'DESC')->where('budget_id', $Pago->budget_id)->whereTime('created_at', '<', $Pago->created_at)->orWhereDate('created_at', '<', $Pago->created_at)->where('budget_id', $Pago->budget_id)->get();
        $Budget = Budget::orderBy('id', 'DESC')->where('id', $Pago->budget_id)->first();
        $cliente = Client::orderBy('id', 'DESC')->where('id', $Budget->client_id)->first();
        

        if($cliente->tipoPersona=='FISICA'){
            $cliente = PhysicalPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }else{
            $cliente = MoralPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }
        
        

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.recibo_pago_reimpresion', compact('Pago', 'Budget', 'cliente', 'Pagos'));

        return $pdf->stream();
    }

    public function ultimoCorte(){

        $registro = CashRegister::orderBy('id', 'DESC')->first();

        $date = Carbon::now();
        $fechaCorte = $registro->created_at;
        $fechaCorteCierre = $registro->updated_at;
        $date=$date->format('Y-m-d');
        $fechaCorte = $fechaCorte->format('Y-m-d');
        $fechaCorteCierre = $fechaCorteCierre->format('Y-m-d');


        $fechaApertura = Carbon::parse($registro->created_at);
        $fechaCierre = Carbon::parse($registro->updated_at);
        $pagos = Payment::with('budget')->orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaCorte)->whereDate('created_at', '<=', $fechaCorteCierre)->get();
        $otrosPagos = OtherPayments::orderBy('id', 'DESC')->whereDate('created_at', '>=', $fechaCorte)->whereDate('created_at', '<=', $fechaCorteCierre)->get();
        

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.ultimoCorte', compact('registro', 'pagos', 'otrosPagos'));

        return $pdf->stream();
    }

    public function cancelarContrato($id){
        $budget = Budget::findOrFail($id);

        $budget->cancelado = true;
        $budget->fechaCancelacion = Carbon::now();

        $budget->save();
        return;
    }

}
