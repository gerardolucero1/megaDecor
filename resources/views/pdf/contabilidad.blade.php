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
        $date = Carbon::now();
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
    <td colspan="3"><span style="font-style: italic"> Reporte generado: {{ $fechaHoy->translatedFormat(' l j F Y') }}</span></td>
    </tr>
   
    </table>
    <table style="width: 100%" style="padding-top: 20px;">
        <tr>
            <td colspan="2">
                    <span style="font-weight: bold">Cajero: </span><span style="font-size:13">{{ $cajero->name }}</span><br>
            </td>
        </tr>
        <tr>
            <td>
            <span style="font-weight: bold">Fecha de corte: </span> {{ $fechaApertura->translatedFormat(' l j F Y ')}} <br>
            </td>
            <td>  <span style="font-weight: bold">Horario de corte: </span> <span> {{ $horaApertura }} a {{ $horaCierre }}</span></td>
        </tr>
        <tr>
            <td>
                <p><span style="font-weight: bold">Efectivo al abrir caja: </span> ${{ $registro->cantidadApertura}}<br></p>
            </td>
            <td>
                <p><span style="font-weight: bold">Efectivo al cerrar caja: </span> ${{ $registro->cantidadCierre}}<br>
                   <span style="font-size:10px; font-style:italic">(Definido por el usuario)</span><br>
                   @if($precorte!=$registro->cantidadCierre)
                <span style="color:red; font-style: italic; font-size: 13px">*Monto final definido por el usuario no concuerda con calculo del sistema de: ${{$precorte}}</span>
                @else  
                <span style="color:green; font-style: italic; font-size: 13px">*Monto final definido por el usuario concuerda con calculo del sistema de: ${{$precorte}}</span>
                @endif</p>
            </td>
            </tr>
         
    </table>
    <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
    <label for="" style="font-weight: bold; margin-bottom: 10px">Pagos a contratos</label>

    <table style="width: 100%; font-size: 13px;">
    <tr style="background: #F9E7A8">
        <td style="text-align: center; padding: 4px;">Folio de contrato</td>
        <td style="text-align: center; padding: 4px;">Metodo de pago</td>
        <td style="text-align: center; padding: 4px;">Referencia</td>
        <td style="text-align: center; padding: 4px;">Fecha Registro</td>
        <td style="text-align: center; padding: 4px;">Monto</td>
    </tr>
    @foreach ($pagos as $pago)
    @php
        $contrato = Budget::orderBy('id', 'DESC')->where('id', $pago->budget_id)->first();
    @endphp
    <tr style="border: solid; border-color:black">
    <td style="text-align: center; padding: 3px;">{{$contrato->folio}}</td>
    <td style="text-align: center; padding: 3px;">{{$pago->method}}</td>
    <td style="text-align: center; padding: 3px;">@if($pago->reference!=''){{$pago->reference}}@else--@endif</td>
    <td style="text-align: center; padding: 3px;">{{$pago->created_at}}</td>
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
    @endforeach
    </table>

<p style="text-align: right; font-weight: bold;">Total pagos en efectivo a contratos: ${{number_format($ingresosContratos,2)}}</p>
<p style="text-align: right; font-weight: normal; font-size:13px">Total pagos contrato en cheques: ${{number_format($ingresosContratosCheque,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px">Total pagos contrato en electronico (Transferencia / tarjeta): ${{number_format($ingresosContratosTarjeta,2)}}</p>
            <p style="text-align: right; font-weight: normal; font-size:13px">Total pagos contrato en Dolares (cantidad en dolares): ${{number_format($ingresosContratosDolar,2)}}</p>
   
<div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
    <label for="" style="font-weight: bold; margin-bottom: 10px">Ingresos Extraordinarios</label>
    <table style="width: 100%; font-size: 13px;">
            <tr style="background: #F9E7A8">
                <td style="text-align: center; padding: 4px;">Tipo</td>
                <td style="text-align: center; padding: 4px;">Motivo</td>
                <td style="text-align: center; padding: 4px;">Descripción</td>
                <td style="text-align: center; padding: 4px;">Metodo</td>
                <td style="text-align: center; padding: 4px;">Entregado a</td>
                <td style="text-align: center; padding: 4px;">Monto</td>
            </tr>
            @foreach ($otrosPagos as $pago)
            @if($pago->tipo=="INGRESO")
            <tr style="border: solid; border-color:black">
            <td style="text-align: center; padding: 3px;">{{$pago->tipo}}</td>
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
            <p style="text-align: right; font-weight: normal; font-size:13px">Total ingresos extraordinarios en Dolares (cantidad en dolares): ${{number_format($ingresosExtraordinarios,2)}}</p>
 
            <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
            <label for="" style="font-weight: bold; margin-bottom: 10px; padding-top:50px">Egresos extraordinarios</label>
            <table style="width: 100%; font-size: 13px;">
                    <tr style="background: #F9E7A8">
                        <td style="text-align: center; padding: 4px;">Tipo</td>
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
                    <td style="text-align: center; padding: 3px;">{{$pago->tipo}}</td>
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
            <p style="text-align: right; font-weight: normal; font-size:13px;">Total engresos extraordinarios en Dolares (cantidad en dolares): ${{number_format($egresosExtraordinarios,2)}}</p>
                    
            <div style="width: 100%; border-top:solid; border-width: 1px; margin-bottom: 10px; height: 10px"></div>
            
            @php
              $totalEfectivoEnCaja =  $registro->cantidadApertura+$ingresosContratos-$ingresosExtraordinarios-$egresosExtraordinarios 
            @endphp
            <p style="font-size: 15px; font-weight: bold">Efectivo en caja (calculado por el sistema): ${{number_format($totalEfectivoEnCaja,2)}}</p>
   
<script type="text/php">
        if ( isset($pdf) ) {
            $font = "helvetica";
            $pdf->page_text(72, 18, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
        }
      </script> 
</body>
</html>

