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
        $fechaHoy = Carbon::parse($date->toDateString())->locale('es');  
        $fechaApertura = Carbon::parse($registro->fechaApertura)->locale('es');
        $fechaCierre = Carbon::parse($registro->updated_at)->locale('es');
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
        $contratosHoy=App\Budget::where('tipo', 'CONTRATO')->where('archivado', false)->whereDate('created_at', '>', $fechaApertura)->whereDate('created_at', '<', $fechaCierre)->get();
        $numContratosHoy=count($contratosHoy);
        $egresosDolaresExtraordinarios=0;
        
        


        $contratosCancelados = Budget::where('tipo', 'CONTRATO')->where('archivado', true)->whereDate('updated_at', $registro->fechaApertura)->get();
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
    @foreach ($otrosPagos as $pago)
    @php
    if($pago->tipo=="INGRESO"){
    if($pago->metodo=="EFECTIVO"){
$ingresosExtraordinarios += $pago->cantidad;}
}else{
    if($pago->metodo=="EFECTIVO"){
            $egresosExtraordinarios += $pago->cantidad - $pago->resto;}
}
@endphp
    @endforeach
    @foreach ($pagos as $pago)
        @php
            if($pago->method=="EFECTIVO"){
        $ingresosContratos += $pago->amount;}
        @endphp
    @endforeach
    @foreach ($pagos as $pago)
        @php
            if($pago->method=="TRANSFERENCIA"){
            $ingresosContratosTransferencia += $pago->amount;}
        @endphp
    @endforeach
    @foreach ($pagos as $pago)
        @php
            if($pago->method=="CHEQUE"){
            $ingresosContratosCheque += $pago->amount;}
        @endphp
    @endforeach
    @foreach ($pagos as $pago)
        @php
            if($pago->method=="TARJETA"){
            $ingresosContratosTarjeta += $pago->amount;}
        @endphp
    @endforeach
    @foreach ($pagos as $pago)
        @php
            if($pago->method=="DOLAR"){
            $ingresosContratosDolar += $pago->amount;}
        @endphp
    @endforeach
    <p style="font-size: 100px; position:absolute; font-weight:bold; color:rgba(238,37,37,.2); text-align:center; transform: rotate(-45deg); margin-left:300px; margin-top:100px;">Reimpresión</p>
    <table style="width: 100%; font-family: Helvetica;" >
    <tr>
        <td colspan="1">
            <img src="https://adpro3d-os.com/megamundo/mega-mundo-decor.png" alt="" style="width: 200px">
        </td>
    <td colspan="3">
        <span style="font-weight: bold; font-size:22px">Fecha y Hora del corte: </span><br> <span> {{ $fechaApertura->translatedFormat(' l j F Y ')}} {{ $horaApertura }} a {{ $fechaCierre->translatedFormat(' l j F Y ')}} {{ $horaCierre }}</span><br>
        <span style="font-weight: bold">Cajero que abre: </span><span style="font-size:13">{{ $cajero->name }}</span><br>
        <span style="font-weight: bold">Cajero que cierra: </span><span style="font-size:13">{{ $cajero->name }}</span><br>
        <span style="font-style: italic"> Cierre de caja Impreso: {{ $fechaHoy->translatedFormat(' l j F Y') }} </span></td>
    </tr>
   
    </table> 
    <table style="width: 100%" style="padding-top: 20px;">
        <tr>
            <td>
            
            <p><span style="font-weight: bold">Efectivo del cierre del corte del dia anterior: </span> ${{ $registro->cantidadApertura}}<br>
                <span>Contratos nuevos: {{$numContratosHoy}}</span><br>
                <span>Total Ingresos hoy: ${{ number_format(($ingresosContratos+$ingresosExtraordinarios),2)}}</span><br></p>
            
            </td>
            <td> <p><span style="font-weight: bold">Efectivo al cerrar caja: </span> ${{ number_format($registro->cantidadCierre,2)}}<br>
                <span style="font-size:10px; font-style:italic">(Definido por el usuario)</span><br>
                @if($precorte > $registro->cantidadCierre)
            <span style="color:red; font-style: italic; font-size: 13px">*Monto final definido por el usuario no concuerda con calculo del sistema de: ${{$precorte}}<br><span style="color:red; font-size: 16px">FALTANTE: ${{number_format($registro->cantidadCierre-$precorte,2)}}</span></span>
            
            @elseif($precorte < $registro->cantidadCierre)
            <span style="color:red; font-style: italic; font-size: 13px">*Monto final definido por el usuario no concuerda con calculo del sistema de: ${{$precorte}}<br><span style="color:red; font-size: 16px">SOBRANTE: ${{number_format($registro->cantidadCierre-$precorte,2)}}</span></span>
            @else
             <span style="color:green; font-style: italic; font-size: 13px">*Monto final definido por el usuario concuerda con calculo del sistema de: ${{$precorte}}</span>
             @endif</p> </td>
        </tr>
    </table>
<!-- nueva tabla resumen corte -->
    <table style="width: 100%; text-align:center">
            <tr>
            <th>Fondo</th>
            <th>Contratos</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th>Saldo Sistema</th>
            <th>Saldo Usuario</th>
            <th>Diferencia</th>
            
        </tr>
        <tr>
            <td>${{ number_format($registro->cantidadApertura,2)}}</td>
            <td>${{ number_format($ingresosContratos,2)}}</td>
            <td>${{ number_format($ingresosExtraordinarios,2)}}</td>
            <td>${{ number_format($egresosExtraordinarios,2)}}</td>
            
            <td>${{number_format($registro->cantidadApertura+$ingresosContratos+$ingresosExtraordinarios-$egresosExtraordinarios,2)}}</td>
            <td>${{ number_format($registro->cantidadCierre,2)}}</td>
            <td>${{number_format($registro->cantidadCierre-$precorte,2)}}</td>
    
        </tr>
        </table>
<!-- nueva tabla resumen corte -->
    <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
    <label for="" style="font-weight: bold; margin-bottom: 10px">Pagos a contratos</label><br>

    <!-- Inicia pagos en efectivo -->
    @if($ingresosContratos>0)
    @php
        $ingresosContratos=0;
    @endphp
    <label for="" style="font-style:italic">Efectivo</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Recibo No. </td>
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
        <td style="text-align: center; padding: 3px;">{{$pago->id}}</td>    
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
    @endif
    <!-- Finaliza tabla pagos en efectivo -->

      <!-- Inicia pagos con tarjeta -->
      @if($ingresosContratosTarjeta>0)
      @php
         $ingresosContratosTarjeta=0; 
      @endphp
    <label for="" style="font-style:italic">Tarjeta</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Recibo No. </td>
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
        <td style="text-align: center; padding: 3px;">{{$pago->id}}</td>    
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
    @endif
    <!-- Termina pagos con tarjeta -->


    <!-- Inicia pagos con transferencia -->
    @if($ingresosContratosTransferencia>0)
    @php
        $ingresosContratosTransferencia=0;
    @endphp
    <label for="" style="font-style:italic">Transferencia</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Recibo No. </td>
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
        <td style="text-align: center; padding: 3px;">{{$pago->id}}</td>
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
    @endif
    <!-- Termina pagos con transferencia -->




<!-- Inicia pagos con cheques -->
@if($ingresosContratosCheque>0)
@php
   $ingresosContratosCheque=0; 
@endphp
    <label for="" style="font-style:italic">Cheques</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Recibo No. </td>
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
        <td style="text-align: center; padding: 3px;">{{$pago->id}}</td>
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
    @endif
    <!-- Termina pagos con cheques -->


    <!-- Inicia pagos con dolares -->
    @if($ingresosContratosDolar>0)
    @php
       $ingresosContratosDolar=0; 
       $ingresosContratosDolarMXN=0;
    @endphp
    <label for="" style="font-style:italic">Dolares</label>
    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Recibo No.</td>
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Cliente</td>
        <td style="text-align: center; padding: 4px;">Hora de transacción</td>
        <td style="text-align: center; padding: 4px;">Monto Dlls</td>
        <td style="text-align: center; padding: 4px;">Tipo de cambio</td>
        <td style="text-align: center; padding: 4px;">Monto MXN</td>
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
    <td style="text-align: center; padding: 3px;">{{$pago->id}}</td>
<td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
<td style="text-align: center; padding: 3px;">{{$nombreCliente}}</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at->translatedFormat(' h:m a')}}</td>
    <td style="text-align: center; padding: 3px;">${{$pago->amount}}Dlls</td>
    <td style="text-align: center; padding: 3px;">$ @if($pago->reference!=''){{$pago->reference}}@else--@endif</td>
    <td style="text-align: center; padding: 3px;">$ {{number_format($pago->amount*$pago->reference, 2)}}</td>
    @php
        if($pago->method=="EFECTIVO"){
        $ingresosContratos += $pago->amount;}
        if($pago->method=="TARJETA" || $pago->metodo=="TRANSFERENCIA"){
        $ingresosContratosTarjeta += $pago->amount;}
        if($pago->method=="CHEQUE"){
        $ingresosContratosCheque += $pago->amount;}
        if($pago->method=="DOLAR"){
        $ingresosContratosDolar += $pago->amount;
        $ingresosContratosDolarMXN += $pago->amount*$pago->reference;}
    @endphp
    </tr>
    @endif
    @endforeach
    </table>
            <p style="text-align: right; font-weight: bold; font-size:13px">Total pagos contrato en Dolares: ${{number_format($ingresosContratosDolar,2)}}Dlls = {{number_format($ingresosContratosDolarMXN,2)}}MXN</p>
            @endif
    <!-- Termina pagos con dolares -->
   

    <!-- Inicia ingresos extraordinarios -->
    @if(($ingresosExtraordinarios+$ingresosExtraordinariosCheque+$ingresosExtraordinariosDolar+$ingresosExtraordinariosTarjeta)>0)
    @php
        $ingresosExtraordinarios=0;
        $ingresosExtraordinariosCheque=0;
        $ingresosExtraordinariosDolar=0;
        $ingresosExtraordinariosTarjeta=0;
    @endphp
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
            @php
            $ingresosExtraordinarios=0;
            @endphp
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
            @endif
            <!--Finaliza tabla ingresos extraordinarios -->

<!-- Inicia egresos extraordinarios -->
@if(($egresosExtraordinarios+$egresosExtraordinariosCheque+$egresosExtraordinariosDolar+$egresosExtraordinariosTarjeta)>0)
@php
    $egresosExtraordinarios=0;
    $egresosExtraordinariosCheque=0;
    $egresosExtraordinariosDolar=0;
    $egresosExtraordinariosTarjeta=0;
@endphp
            <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
            <label for="" style="font-weight: bold; margin-bottom: 10px; padding-top:50px">Egresos extraordinarios</label>
            <table style="width: 100%; font-size: 13px;">
                    <tr style="background: #F9E7A8">
                        <td style="text-align: center; padding: 4px;">Motivo</td>
                        <td style="text-align: center; padding: 4px;">Contrato</td>
                        <td style="text-align: center; padding: 4px;">Fecha</td>
                        <td style="text-align: center; padding: 4px;">Descripción</td>
                        <td style="text-align: center; padding: 4px;">Metodo</td>
                        <td style="text-align: center; padding: 4px;">Entregado a</td>
                        <td style="text-align: center; padding: 4px;">Devolución</td>
                        <td style="text-align: center; padding: 4px;">Monto sin devolición</td>
                    </tr>
                    @php
                        $egresosExtraordinarios =0;
                    @endphp
                    @foreach ($otrosPagos as $pago)
                   @if($pago->tipo=="EGRESO")
                    <tr style="border: solid; border-color:black">
                    <td style="text-align: center; padding: 3px;">{{$pago->motivo}}</td>
                    <td style="text-align: center; padding: 3px;">{{$pago->contrato}}</td>
                    <td style="text-align: center; padding: 3px;">{{$pago->created_at}}</td>
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
            @endif
            <!--Finaliza tabla egresos extraordinarios-->
            
            <div style="width: 100%; background: #FFFACC">
                @if(count($contratosCancelados)>0)
            <p style="font-weight: bold">Contratos Cancelados:</p>
            <table style="width: 100%; font-size:12px">
            <tr>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Quien Cancela</th>
                <th>motivo</th>
            </tr>
            
            @foreach ($contratosCancelados as $item)
                <tr>
                <td>{{$item->folio}}</td>
                <td>
                    @php
                                                $cliente = App\Client::where('id', $item->client_id)->first();

                                                if($cliente->tipoPersona == "FISICA"){
                                                    $clienteFisico = App\PhysicalPerson::where('client_id', $item->client_id)->first();
                                                   echo $clienteNombre = $clienteFisico->nombre.' '.$clienteFisico->apellidoPaterno.' '.$clienteFisico->apellidoMaterno;
                                                   // $clienteCompleto = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                                                   
                                                }else{
                                                    $clienteMoral = App\MoralPerson::where('client_id', $item->client_id)->first();
                                                    echo $clienteNombre = $clienteMoral->nombre;
                                                }
                                            @endphp
                </td>
                <td>
                    @php
                         $vendedor = App\User::where('id', $item->vendedor_id)->first();
                         echo $vendedor->name;
                    @endphp
                </td>
                <td>{{$item->notasPresupuesto}}</td>
                </tr>
            @endforeach
            
            </table>
            @endif
        </div>


        <div style="width: 100%; background: #FFFACC">
            @if(count($contratosHoy)>0)
        <p style="font-weight: bold">Contratos Nuevos:</p>
        <table style="width: 100%; font-size:12px">
        <tr>
            <th>Folio</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Fecha Creación</th>
        </tr>
        
        @foreach ($contratosHoy as $item)
            <tr>
            <td>{{$item->folio}}</td>
            <td>
                @php
                                            $cliente = App\Client::where('id', $item->client_id)->first();

                                            if($cliente->tipoPersona == "FISICA"){
                                                $clienteFisico = App\PhysicalPerson::where('client_id', $item->client_id)->first();
                                               echo $clienteNombre = $clienteFisico->nombre.' '.$clienteFisico->apellidoPaterno.' '.$clienteFisico->apellidoMaterno;
                                               // $clienteCompleto = App\PhysicalPerson::where('client_id', $cliente->id)->first();
                                               
                                            }else{
                                                $clienteMoral = App\MoralPerson::where('client_id', $item->client_id)->first();
                                                echo $clienteNombre = $clienteMoral->nombre;
                                            }
                                        @endphp
            </td>
            <td>
                @php
                     $vendedor = App\User::where('id', $item->vendedor_id)->first();
                     echo $vendedor->name;
                @endphp
            </td>
            <td>{{$item->created_at}}</td>
            </tr>
        @endforeach
        
        </table>
        @endif
    </div>


            @php
              $totalEfectivoEnCaja =  $registro->cantidadApertura+$ingresosContratos-$ingresosExtraordinarios-$egresosExtraordinarios 
            @endphp
            <p style="font-size: 15px; font-weight: bold">Efectivo en caja (calculado por el sistema): ${{number_format($precorte,2)}}</p>
                <p style="font-size: 15px; font-weight: bold; text-align: center; padding-top:30px">___________________________<br>Firma {{$cajero->name}}</p>
   
<script type="text/php">
        if ( isset($pdf) ) {
            $font = "helvetica";
            $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
        }
      </script> 
</body>
</html>

