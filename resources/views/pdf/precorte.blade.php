<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-family: Helvetica;">
    @php
        use Carbon\Carbon;
        use App\User;
        use App\Budget;
        use App\Client;
        use App\MoralPerson;
        use App\PhysicalPerson;
        $date = Carbon::now();
        $contratosHoy = Budget::where('tipo', 'CONTRATO')->where('created_at', 'like', $registro->fechaApertura)->get();
        $fechaHoy = Carbon::parse($date->toDateString())->locale('es');  
        $fechaApertura = Carbon::parse($registro->fechaApertura)->locale('es');
        $fechaCierre = Carbon::parse($registro->fechaCierre)->locale('es');
        $horaApertura = date("g:i a", strtotime($registro->horaApertura));
        $horaCierre = date("g:i a", strtotime($registro->horaCierre));
        $cajero = User::orderBy('id', 'DESC')->where('id', $registro->user_id)->first();        
        $precorte=$registro->cantidadApertura;
        $ingresosExtraordinarios=0;
        $egresosExtraordinarios=0;
        $ingresosExtraordinariosTarjeta=0;
        $ingresosExtraordinariosCheque=0;
        $ingresosExtraordinariosDolar=0;
        $egresosExtraordinariosTarjeta=0;
        $egresosExtraordinariosCheque=0;
        $egresosExtraordinariosDolar=0;
        $ingresosContratos=0;
        $ingresosContratosTarjeta=0;
        $ingresosContratosCheque=0;
        $ingresosContratosDolar=0;
        $ingresosContratosTransferencia=0;
        $numContratosHoy=0;
        $egresosDolaresExtraordinarios=0;
        
        $numContratosHoy=count($contratosHoy);
    @endphp
    <!--Calculo de total -->
    @foreach ($pagos as $pago)
    @php
    if($pago->method=='EFECTIVO'){
       $precorte = $precorte + $pago->amount;
    }
    $ingresosContratos=0;
    $ingresosExtraordinarios=0;
    $egresosExtraordinarios=0;
    @endphp
    @endforeach
    @foreach ($otrosPagos as $pago)
    @php
    if($pago->metodo=='EFECTIVO' && $pago->tipo=='INGRESO'){
       $precorte = $precorte + $pago->cantidad;
    }
    if($pago->metodo=='EFECTIVO' && $pago->tipo=='EGRESO'){
        $precorte = $precorte - $pago->cantidad + $pago->resto;
    }
   
    @endphp
    @endforeach
    <table style="width: 100%; font-family: Helvetica;" >
    <tr>
        <td colspan="1">
            <img src="http://megamundodecor.com/images/mega-mundo-decor.png" alt="" style="width: 200px">
        </td>
    <td colspan="3"><span style="font-style: italic"> Precorte de caja generado: {{ $fechaHoy->translatedFormat(' l j F Y') }} </span><br>
        
        <span style="font-weight: bold">Cajero que abre: </span><span style="font-size:13">{{ $cajero->name }}</span><br>
       
    </tr>
   
    </table>
    <table style="width: 100%" style="padding-top: 20px;">
       
        <tr>
            <td>
            <span style="font-weight: bold">Fecha de apertura: </span> {{ $fechaApertura->translatedFormat(' l j F Y ')}} <br>
            <span>Contratos hoy: {{$numContratosHoy}}</span><br>
            <p><span style="font-weight: bold">Efectivo al abrir caja (cierre dia anterior): </span> ${{ $registro->cantidadApertura}}<br><br><br></p>
            
            </td>
            <td> <p style="border:solid; border-color:red; padding: 8px;"><span style="font-weight: bold">Precorte calculado por el sistema: </span> ${{number_format($precorte,2)}}<br><br>
               </p> </td>
        </tr>
        
         
    </table>
    <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
    <label for="" style="font-weight: bold; margin-bottom: 10px">Pagos a contratos</label><br>
    <label for="" style="font-style:italic">Efectivo</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Cliente</td>
        <td style="text-align: center; padding: 4px;">Hora de transacción</td>
        <td style="text-align: center; padding: 4px;">Monto</td>
    </tr>
    @foreach ($pagos as $pago)
    @if($pago->method=="EFECTIVO")
    @php
        $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
        $cliente = Client::where('id', $contrato->client_id)->first();
        if($cliente->tipoPersona == 'MORAL'){
            $datosCliente = MoralPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre;
        }else{
            $datosCliente = PhysicalPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
        }
    @endphp
    <tr style="border: solid; border-color:black">
    <td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
    <td style="text-align: center; padding: 3px;">{{$nombreCliente}}</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at->translatedFormat(' h:m a')}}</td>
    <td style="text-align: center; padding: 3px;">${{$pago->amount}}</td>
    @php
        if($pago->method=="EFECTIVO"){
        $ingresosContratos += $pago->amount;}
        if($pago->method=="TARJETA" || $pago->metodo=="TRANSFERENCIA"){
        $ingresosContratosTarjeta += $pago->amount;}
        if($pago->method=="CHEQUE"){
        $ingresosContratosCheque += $pago->amount;}
        if($pago->method=="DOLAR"){
        $ingresosContratosDolar += $pago->amount;}
    @endphp
    </tr>
    @endif
    @endforeach
    </table>
    <p style="text-align: right; font-weight: bold;">Total pagos en efectivo a contratos: ${{number_format($ingresosContratos,2)}}</p>

    <label for="" style="font-style:italic">Tarjeta</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Cliente</td>
        <td style="text-align: center; padding: 4px;">Ultimos 4 numeros de tarjeta</td>
        <td style="text-align: center; padding: 4px;">Banco</td>
        <td style="text-align: center; padding: 4px;">Hora de transacción</td>
        <td style="text-align: center; padding: 4px;">Monto</td>
    </tr>
    @foreach ($pagos as $pago)
    @if($pago->method=="TARJETA")
    @php
        $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
        $cliente = Client::where('id', $contrato->client_id)->first();
        if($cliente->tipoPersona == 'MORAL'){
            $datosCliente = MoralPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre;
        }else{
            $datosCliente = PhysicalPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
        }
    @endphp
    <tr style="border: solid; border-color:black">
    <td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
    <td style="text-align: center; padding: 3px;">{{$nombreCliente}}</td>
    <td style="text-align: center; padding: 3px;">@if($pago->reference!=''){{$pago->reference}}@else--@endif</td>
    <td style="text-align: center; padding: 3px;">{{$pago->bank}}</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at->translatedFormat(' h:m a')}}</td>
    <td style="text-align: center; padding: 3px;">${{$pago->amount}}</td>
    @php
        if($pago->method=="EFECTIVO"){
        $ingresosContratos += $pago->amount;}
        if($pago->method=="TARJETA"){
        $ingresosContratosTarjeta += $pago->amount;}
        if($pago->method=="CHEQUE"){
        $ingresosContratosCheque += $pago->amount;}
        if($pago->method=="DOLAR"){
        $ingresosContratosDolar += $pago->amount;}
    @endphp
    </tr>
    @endif
    @endforeach
    </table>
    <p style="text-align: right; font-weight: bold; font-size:13px">Total pagos contrato con tarjeta: ${{number_format($ingresosContratosTarjeta,2)}}</p>

    <label for="" style="font-style:italic">Transferencia</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Cliente</td>
        <td style="text-align: center; padding: 4px;">Referencia</td>
        <td style="text-align: center; padding: 4px;">Banco</td>
        <td style="text-align: center; padding: 4px;">Hora de transacción</td>
        <td style="text-align: center; padding: 4px;">Monto</td>
    </tr>
    @foreach ($pagos as $pago)
    @if($pago->method=="TRANSFERENCIA")
    @php
        $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
        $cliente = Client::where('id', $contrato->client_id)->first();
        if($cliente->tipoPersona == 'MORAL'){
            $datosCliente = MoralPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre;
        }else{
            $datosCliente = PhysicalPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
        }
    @endphp
    <tr style="border: solid; border-color:black">
    <td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
    <td style="text-align: center; padding: 3px;">{{$nombreCliente}}</td>
    <td style="text-align: center; padding: 3px;">@if($pago->reference!=''){{$pago->reference}}@else--@endif</td>
    <td style="text-align: center; padding: 3px;">{{$pago->bank}}</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at->translatedFormat(' h:m a')}}</td>
    <td style="text-align: center; padding: 3px;">${{$pago->amount}}</td>
    @php
        
        
        $ingresosContratosTransferencia += $pago->amount;
    @endphp
    </tr>
    @endif
    @endforeach
    </table>
    <p style="text-align: right; font-weight: bold; font-size:13px">Total pagos contrato con transferencia: ${{number_format($ingresosContratosTransferencia,2)}}</p>

    <label for="" style="font-style:italic">Cheques</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Cliente</td>
        <td style="text-align: center; padding: 4px;">Numero de cheque</td>
        <td style="text-align: center; padding: 4px;">Banco</td>
        <td style="text-align: center; padding: 4px;">Hora de transacción</td>
        <td style="text-align: center; padding: 4px;">Monto</td>
    </tr>
    @foreach ($pagos as $pago)
    @if($pago->method=="CHEQUE")
    @php
        $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
        $cliente = Client::where('id', $contrato->client_id)->first();
        if($cliente->tipoPersona == 'MORAL'){
            $datosCliente = MoralPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre;
        }else{
            $datosCliente = PhysicalPerson::where('client_id', $cliente->id)->first();
            $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
        }
    @endphp
    <tr style="border: solid; border-color:black">
    <td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
    <td style="text-align: center; padding: 3px;">{{$nombreCliente}}</td>
    <td style="text-align: center; padding: 3px;">@if($pago->reference!=''){{$pago->reference}}@else--@endif</td>
    <td style="text-align: center; padding: 3px;">{{$contrato->bank}}</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at->translatedFormat(' h:m a')}}</td>
    <td style="text-align: center; padding: 3px;">${{$pago->amount}}</td>
    @php
        if($pago->method=="EFECTIVO"){
        $ingresosContratos += $pago->amount;}
        if($pago->method=="TARJETA" || $pago->metodo=="TRANSFERENCIA"){
        $ingresosContratosTarjeta += $pago->amount;}
        if($pago->method=="CHEQUE"){
        $ingresosContratosCheque += $pago->amount;}
        if($pago->method=="DOLAR"){
        $ingresosContratosDolar += $pago->amount;}
    @endphp
    </tr>
    @endif
    @endforeach
    </table>
    <p style="text-align: right; font-weight: bold; font-size:13px">Total pagos contrato en cheques: ${{number_format($ingresosContratosCheque,2)}}</p>

    <label for="" style="font-style:italic">Dolares</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Cliente</td>
        <td style="text-align: center; padding: 4px;">Tipo de cambio</td>
        <td style="text-align: center; padding: 4px;">Hora de transacción</td>
        <td style="text-align: center; padding: 4px;">Monto</td>
    </tr>
    @foreach ($pagos as $pago)
    @if($pago->method=="DOLAR")
    @php
    $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
    $cliente = Client::where('id', $contrato->client_id)->first();
    if($cliente->tipoPersona == 'MORAL'){
        $datosCliente = MoralPerson::where('client_id', $cliente->id)->first();
        $nombreCliente = $datosCliente->nombre;
    }else{
        $datosCliente = PhysicalPerson::where('client_id', $cliente->id)->first();
        $nombreCliente = $datosCliente->nombre.' '.$datosCliente->apellidoPaterno.' '.$datosCliente->apellidoMaterno;
    }
@endphp
<tr style="border: solid; border-color:black">
<td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
<td style="text-align: center; padding: 3px;">{{$nombreCliente}}</td>
    <td style="text-align: center; padding: 3px;">$ @if($pago->reference!=''){{$pago->reference}}@else--@endif</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at->translatedFormat(' h:m a')}}</td>
    <td style="text-align: center; padding: 3px;">${{$pago->amount}}Dlls</td>
    @php
        if($pago->method=="EFECTIVO"){
        $ingresosContratos += $pago->amount;}
        if($pago->method=="TARJETA" || $pago->metodo=="TRANSFERENCIA"){
        $ingresosContratosTarjeta += $pago->amount;}
        if($pago->method=="CHEQUE"){
        $ingresosContratosCheque += $pago->amount;}
        if($pago->method=="DOLAR"){
        $ingresosContratosDolar += $pago->amount;}
    @endphp
    </tr>
    @endif
    @endforeach
    </table>
            <p style="text-align: right; font-weight: bold; font-size:13px">Total pagos contrato en Dolares (cantidad en dolares): ${{number_format($ingresosContratosDolar,2)}}Dlls</p>
   
<div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
    <label for="" style="font-weight: bold; margin-bottom: 10px">Ingresos Extraordinarios</label>
    <table style="width: 100%; font-size: 13px;">
            <tr style="background: #F9E7A8">
                <td style="text-align: center; padding: 4px;">Motivo</td>
                <td style="text-align: center; padding: 4px;">Descripción</td>
                <td style="text-align: center; padding: 4px;">Metodo</td>
                <td style="text-align: center; padding: 4px;">Entregado a</td>
                <td style="text-align: center; padding: 4px;">Monto</td>
            </tr>
            @foreach ($otrosPagos as $pago)
            @if($pago->tipo=="INGRESO")
            <tr style="border: solid; border-color:black">
            <td style="text-align: center; padding: 3px;">{{$pago->motivo}}</td>
            <td style="text-align: center; padding: 3px;">{{$pago->descripcion}}</td>
            <td style="text-align: center; padding: 3px;">{{$pago->metodo}}</td>
            <td style="text-align: center; padding: 3px;">{{$pago->responsable}}</td>
            <td style="text-align: center; padding: 3px; @if($pago->tipo=='EGRESO') background:#F7C2C2; @else background:#D0F7C2; @endif">${{$pago->cantidad}}</td>
            @php
            if($pago->metodo=="EFECTIVO"){
        $ingresosExtraordinarios += $pago->cantidad;}
        if($pago->metodo=="TARJETA" || $pago->metodo=="TRANSFERENCIA"){
        $ingresosExtraordinariosTarjeta += $pago->cantidad;}
        if($pago->metodo=="CHEQUE"){
        $ingresosExtraordinariosCheque += $pago->cantidad;}
        if($pago->metodo=="DOLAR"){
        $ingresosExtraordinariosDolar += $pago->cantidad;}
    @endphp
            </tr>
            @endif
            @endforeach
            </table>
            <p style="text-align: right; font-weight: bold;">Total ingresos extraordinarios en efectivo: ${{number_format($ingresosExtraordinarios,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px">Total ingresos extraordinarios en cheques: ${{number_format($ingresosExtraordinariosCheque,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px">Total ingresos extraordinarios en electronico (Transferencia / tarjeta): ${{number_format($ingresosExtraordinariosTarjeta,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px">Total ingresos extraordinarios en Dolares (cantidad en dolares): ${{number_format($ingresosExtraordinariosDolar,2)}}</p>
 
            <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
            <label for="" style="font-weight: bold; margin-bottom: 10px; padding-top:50px">Egresos extraordinarios</label>
            <table style="width: 100%; font-size: 13px;">
                    <tr style="background: #F9E7A8">
                        <td style="text-align: center; padding: 4px;">Motivo</td>
                        <td style="text-align: center; padding: 4px;">Descripción</td>
                        <td style="text-align: center; padding: 4px;">Metodo</td>
                        <td style="text-align: center; padding: 4px;">Entregado a</td>
                        <td style="text-align: center; padding: 4px;">Devolución</td>
                        <td style="text-align: center; padding: 4px;">Monto sin devolición</td>
                    </tr>
                    @foreach ($otrosPagos as $pago)
                   @if($pago->tipo=="EGRESO")
                    <tr style="border: solid; border-color:black">
                    <td style="text-align: center; padding: 3px;">{{$pago->motivo}}</td>
                    <td style="text-align: center; padding: 3px;">{{$pago->descripcion}}</td>
                    <td style="text-align: center; padding: 3px;">{{$pago->metodo}}</td>
                    <td style="text-align: center; padding: 3px;">{{$pago->responsable}}</td>
                    <td style="text-align: center; padding: 3px;">@if($pago->resto!='')${{$pago->resto}}@else--@endif</td>
                    <td style="text-align: center; padding: 3px; @if($pago->tipo=='EGRESO') background:#F7C2C2; @else background:#D0F7C2; @endif">${{$pago->cantidad}}</td>
                    
                    @php
        
        if($pago->metodo=="EFECTIVO"){
            $egresosExtraordinarios += $pago->cantidad - $pago->resto;}
        if($pago->metodo=="TARJETA" || $pago->metodo=="TRANSFERENCIA"){
        $egresosExtraordinariosTarjeta += $pago->cantidad;}
        if($pago->metodo=="CHEQUE"){
        $egresosExtraordinariosCheque += $pago->cantidad;}
        if($pago->metodo=="DOLAR"){
        $egresosExtraordinariosDolar += $pago->cantidad;}
    @endphp
                    </tr>
                    @endif
                    @endforeach
                    </table>
                    <p style="text-align: right; font-weight: bold;">Total egresos en efectivo: ${{number_format($egresosExtraordinarios,2)}}</p>
                    <p style="text-align: right; font-weight: normal; font-size:13px;">Total engresos extraordinarios en cheques: ${{number_format($egresosExtraordinariosCheque,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px;">Total engresos extraordinarios en electronico (Transferencia / tarjeta): ${{number_format($egresosExtraordinariosTarjeta,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px;">Total engresos extraordinarios en Dolares (cantidad en dolares): ${{number_format($egresosDolaresExtraordinarios,2)}}</p>
                    
            <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
            
            @php
              $totalEfectivoEnCaja =  $registro->cantidadApertura+$ingresosContratos-$ingresosExtraordinarios-$egresosExtraordinarios 
            @endphp
            <p style="font-size: 15px; font-weight: bold">Efectivo en caja (calculado por el sistema): ${{$precorte}}</p>
            <p style="font-size: 15px; font-weight: bold; text-align: center; padding-top:30px">___________________________<br>Firma de responsable</p>
   
<script type="text/php">
        if ( isset($pdf) ) {
            $font = "helvetica";
            $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
        }
      </script> 
</body>
</html>

