<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@php
$fechaEvento = Carbon\Carbon::parse($Budget->fechaEvento)->locale('es');
$cajero = Illuminate\Support\Facades\Auth::user()->name;
@endphp
<body style="font-family: Arial, Helvetica, sans-serif">
    <p style="font-size: 100px; position:absolute; font-weight:bold; color:rgba(238,37,37,.2); text-align:center; transform: rotate(-45deg); margin-left:300px; margin-top:100px;">Reimpresión</p>
        <div style="width: 100%; margin-top;-20px">
                <p style="text-align:center; font-weight:bold"><span style="font-style: italic; font-size:16px">Recibo de dinero</span></p>
                <table style="width: 100%; font-family: Helvetica;" >
                        <tr>
                            <td>
                                <img src="https://adpro3d-os.com/megamundo/mega-mundo-decor.png" alt="" style="width: 150px">
                            </td>
                        <td style="text-align: right">
                                <span style="font-weight: bold; font-size: 14px">Folio de contrato:</span> <span>{{$Budget->folio}} </span><br>
                                <span style="font-weight: bold; font-size: 14px">#Recibo:</span> <span> {{$Pago->id}} </span><br>
                            <span style="font-style: italic; font-size: 14px;  font-weight: bold">Fecha de pago: </span> <span style="font-style: italic; font-size: 14px">{{$Pago->created_at}}  </span><br>
                            <span  style="font-style: italic; font-size: 14px; font-weight: bold">Fecha del evento: </span><span>{{$fechaEvento->translatedFormat(' l j F Y')}}<span>

                            </td>
                        </tr>
                       
                        </table>
                    <p style="text-align: center; margin-top: 0px; font-size:12px"><span style="font-weight: bold;"> Recibimos de: {{$cliente->nombre}} {{$cliente->apellidoPaterno}} {{$cliente->apellidoMaterno}}</span> La cantidad de: 
                        <span style="text-align: center; line-height: 16px; margin: 0; margin-top: -10px; padding: 0; font-style: italic; font-size: 13px;padding-right:20px">( @php
                            $numero=$Pago->amount;
                                function unidad($numuero){
    switch ($numuero)
    {
    case 9:
    {
    $numu = "NUEVE";
    break;
    }
    case 8:
    {
    $numu = "OCHO";
    break;
    }
    case 7:
    {
    $numu = "SIETE";
    break;
    }
    case 6:
    {
    $numu = "SEIS";
    break;
    }
    case 5:
    {
    $numu = "CINCO";
    break;
    }
    case 4:
    {
    $numu = "CUATRO";
    break;
    }
    case 3:
    {
    $numu = "TRES";
    break;
    }
    case 2:
    {
    $numu = "DOS";
    break;
    }
    case 1:
    {
    $numu = "UNO";
    break;
    }
    case 0:
    {
    $numu = "";
    break;
    }
    }
    return $numu;
    }
    
    function decena($numdero){
    
    if ($numdero >= 90 && $numdero <= 99)
    {
    $numd = "NOVENTA ";
    if ($numdero > 90)
    $numd = $numd."Y ".(unidad($numdero - 90));
    }
    else if ($numdero >= 80 && $numdero <= 89)
    {
    $numd = "OCHENTA ";
    if ($numdero > 80)
    $numd = $numd."Y ".(unidad($numdero - 80));
    }
    else if ($numdero >= 70 && $numdero <= 79)
    {
    $numd = "SETENTA ";
    if ($numdero > 70)
    $numd = $numd."Y ".(unidad($numdero - 70));
    }
    else if ($numdero >= 60 && $numdero <= 69)
    {
    $numd = "SESENTA ";
    if ($numdero > 60)
    $numd = $numd."Y ".(unidad($numdero - 60));
    }
    else if ($numdero >= 50 && $numdero <= 59)
    {
    $numd = "CINCUENTA ";
    if ($numdero > 50)
    $numd = $numd."Y ".(unidad($numdero - 50));
    }
    else if ($numdero >= 40 && $numdero <= 49)
    {
    $numd = "CUARENTA ";
    if ($numdero > 40)
    $numd = $numd."Y ".(unidad($numdero - 40));
    }
    else if ($numdero >= 30 && $numdero <= 39)
    {
    $numd = "TREINTA ";
    if ($numdero > 30)
    $numd = $numd."Y ".(unidad($numdero - 30));
    }
    else if ($numdero >= 20 && $numdero <= 29)
    {
    if ($numdero == 20)
    $numd = "VEINTE ";
    else
    $numd = "VEINTI".(unidad($numdero - 20));
    }
    else if ($numdero >= 10 && $numdero <= 19)
    {
    switch ($numdero){
    case 10:
    {
    $numd = "DIEZ ";
    break;
    }
    case 11:
    {
    $numd = "ONCE ";
    break;
    }
    case 12:
    {
    $numd = "DOCE ";
    break;
    }
    case 13:
    {
    $numd = "TRECE ";
    break;
    }
    case 14:
    {
    $numd = "CATORCE ";
    break;
    }
    case 15:
    {
    $numd = "QUINCE ";
    break;
    }
    case 16:
    {
    $numd = "DIECISEIS ";
    break;
    }
    case 17:
    {
    $numd = "DIECISIETE ";
    break;
    }
    case 18:
    {
    $numd = "DIECIOCHO ";
    break;
    }
    case 19:
    {
    $numd = "DIECINUEVE ";
    break;
    }
    }
    }
    else
    $numd = unidad($numdero);
    return $numd;
    }
    
    function centena($numc){
    if ($numc >= 100)
    {
    if ($numc >= 900 && $numc <= 999)
    {
    $numce = "NOVECIENTOS ";
    if ($numc > 900)
    $numce = $numce.(decena($numc - 900));
    }
    else if ($numc >= 800 && $numc <= 899)
    {
    $numce = "OCHOCIENTOS ";
    if ($numc > 800)
    $numce = $numce.(decena($numc - 800));
    }
    else if ($numc >= 700 && $numc <= 799)
    {
    $numce = "SETECIENTOS ";
    if ($numc > 700)
    $numce = $numce.(decena($numc - 700));
    }
    else if ($numc >= 600 && $numc <= 699)
    {
    $numce = "SEISCIENTOS ";
    if ($numc > 600)
    $numce = $numce.(decena($numc - 600));
    }
    else if ($numc >= 500 && $numc <= 599)
    {
    $numce = "QUINIENTOS ";
    if ($numc > 500)
    $numce = $numce.(decena($numc - 500));
    }
    else if ($numc >= 400 && $numc <= 499)
    {
    $numce = "CUATROCIENTOS ";
    if ($numc > 400)
    $numce = $numce.(decena($numc - 400));
    }
    else if ($numc >= 300 && $numc <= 399)
    {
    $numce = "TRESCIENTOS ";
    if ($numc > 300)
    $numce = $numce.(decena($numc - 300));
    }
    else if ($numc >= 200 && $numc <= 299)
    {
    $numce = "DOSCIENTOS ";
    if ($numc > 200)
    $numce = $numce.(decena($numc - 200));
    }
    else if ($numc >= 100 && $numc <= 199)
    {
    if ($numc == 100)
    $numce = "CIEN ";
    else
    $numce = "CIENTO ".(decena($numc - 100));
    }
    }
    else
    $numce = decena($numc);
    
    return $numce;
    }
    
    function miles($nummero){
    if ($nummero >= 1000 && $nummero < 2000){
    $numm = "MIL ".(centena($nummero%1000));
    }
    if ($nummero >= 2000 && $nummero <10000){
    $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
    }
    if ($nummero < 1000)
    $numm = centena($nummero);
    
    return $numm;
    }
    
    function decmiles($numdmero){
    if ($numdmero == 10000)
    $numde = "DIEZ MIL";
    if ($numdmero > 10000 && $numdmero <20000){
    $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
    }
    if ($numdmero >= 20000 && $numdmero <100000){
    $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
    }
    if ($numdmero < 10000)
    $numde = miles($numdmero);
    
    return $numde;
    }
    
    function cienmiles($numcmero){
    if ($numcmero == 100000)
    $num_letracm = "CIEN MIL";
    if ($numcmero >= 100000 && $numcmero <1000000){
    $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
    }
    if ($numcmero < 100000)
    $num_letracm = decmiles($numcmero);
    return $num_letracm;
    }
    
    function millon($nummiero){
    if ($nummiero >= 1000000 && $nummiero <2000000){
    $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
    }
    if ($nummiero >= 2000000 && $nummiero <10000000){
    $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
    }
    if ($nummiero < 1000000)
    $num_letramm = cienmiles($nummiero);
    
    return $num_letramm;
    }
    
    function decmillon($numerodm){
    if ($numerodm == 10000000)
    $num_letradmm = "DIEZ MILLONES";
    if ($numerodm > 10000000 && $numerodm <20000000){
    $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
    }
    if ($numerodm >= 20000000 && $numerodm <100000000){
    $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
    }
    if ($numerodm < 10000000)
    $num_letradmm = millon($numerodm);
    
    return $num_letradmm;
    }
    
    function cienmillon($numcmeros){
    if ($numcmeros == 100000000)
    $num_letracms = "CIEN MILLONES";
    if ($numcmeros >= 100000000 && $numcmeros <1000000000){
    $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
    }
    if ($numcmeros < 100000000)
    $num_letracms = decmillon($numcmeros);
    return $num_letracms;
    }
    
    function milmillon($nummierod){
    if ($nummierod >= 1000000000 && $nummierod <2000000000){
    $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
    }
    if ($nummierod >= 2000000000 && $nummierod <10000000000){
    $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
    }
    if ($nummierod < 1000000000)
    $num_letrammd = cienmillon($nummierod);
    
    return $num_letrammd;
    }
    
    
    function convertir($numero){
    $num = str_replace(",","",$numero);
    $num = number_format($num,2,'.','');
    $cents = substr($num,strlen($num)-2,strlen($num)-1);
    $num = (int)$num;
    
    $numf = milmillon($num);
    
    return $numf." PESOS CON ".$cents."/100";
    }
    
    echo convertir($numero);
    
                            @endphp)</span>
                          </p>
                       
                        <div style="width: 100%; height: 0px"></div>
                        @if(intval(count($Pagos))>0)
                        <label for="" style="font-size: 10px; font-style: italic">Abonos Anteriores</label>
                        <table style="width: 100%; font-size: 11px; margin-bottom: 10px;"> 
                            <tr>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Concepto</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Fecha y hora de pago</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Metodo de pago</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Referencia</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Monto</td>
                            </tr>
                            @foreach ($Pagos as $pago)
                            <tr style="text-align: center">
                                <td>Abono a contrato</td>
                                <td>{{$pago->created_at}}</td>
                                <td>{{$pago->method}}</td>
                                <td>{{$pago->reference}}</td>
                            <td>${{number_format($pago->amount,2)}}</td>
                            </tr>
                            @endforeach
                        </table>
                        @endif

                        <label for="" style="font-size: 10px; font-style: italic">Abono actual</label>
                        <table style="width: 100%; font-size: 13px"> 
                            <tr>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Concepto</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Fecha y hora de pago</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Metodo de pago</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Referencia</td>
                                <td style="padding:4px; background:#E8E8E8; text-align: center">Monto</td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Abono a contrato</td>
                                <td>{{$Pago->created_at}}</td>
                                <td>{{$Pago->method}}</td>
                                <td>{{$Pago->reference}}</td>
                            <td>${{number_format($Pago->amount,2)}}</td>
                            </tr>
                        </table>
                        <div style="width: 100%; height: 0px; border-bottom:solid"></div>
                        @php
                            $totalPagosAnteriores=0;
                            if($Budget->opcionIVA==true){
                            $BudgetTotal=$Budget->total*1.16;}else{
                                $BudgetTotal=$Budget->total;
                            }
                        @endphp
                        @foreach ($Pagos as $pago)
                            @php
                                $totalPagosAnteriores=$totalPagosAnteriores+$pago->amount;
                                
                            @endphp
                        @endforeach
                        @php
                            $saldoPendiente=$BudgetTotal-$totalPagosAnteriores-$Pago->amount;
                        @endphp
                        <p style="text-align: right; font-weight: bold; padding-right:20px">
                        <span>Total del evento: @if($Budget->opcionIVA){{number_format($Budget->total*1.16,2)}}@else {{number_format($Budget->total,2)}}@endif</span>
                            <br><span style="font-weight: normal"> Saldo Anterior: ${{number_format($BudgetTotal-$totalPagosAnteriores,2)}}</span>
                            <br>Pagos anteriores: ${{number_format($totalPagosAnteriores,2)}}
                            <br>Su abono: ${{number_format($Pago->amount,2)}}
                            <br>Saldo Pendiente${{number_format($saldoPendiente,2)}}</p>

                            <p style="text-align: center; width: 50%; margin-top:-100px"><span style="font-size:11px;">El Monto final del evento puede variar por modificaciones en aumento de servicios solicitados por parte del cliente despues de este recibo</span>
                            <br><br>_____________________________________<br>Firma {{$cajero}}</p>
                </div>


<!--Segundo Recibo de pago-->

                <p style="font-size: 100px; position:absolute; font-weight:bold; color:rgba(238,37,37,.2); text-align:center; transform: rotate(-45deg); margin-left:300px; margin-top:100px;">Reimpresión</p>
                <div style="width: 100%; border-top: solid; border-top-style: dotted; border-top-width: 1px;">
                    <p style="text-align:center; font-weight:bold"><span style="font-style: italic; font-size:16px">Recibo de dinero</span></p>
                    <table style="width: 100%; font-family: Helvetica;">
                            <tr>
                                <td>
                                    <img src="http://megamundodecor.com/images/mega-mundo-decor.png" alt="" style="width: 200px">
                                </td>
                            <td style="text-align: right">
                                    <span style="font-weight: bold; font-size: 12px">Folio de contrato:</span> <span>{{$Budget->folio}} </span><br>
                                    <span style="font-weight: bold; font-size: 12px">#Recibo:</span> <span> {{$Pago->id}} </span><br>
                                <span style="font-style: italic; font-size: 12px;  font-weight: bold">Fecha de pago: </span> <span style="font-style: italic; font-size: 14px">{{$Pago->created_at}}  </span><br>
                                <span  style="font-style: italic; font-size: 12px; font-weight: bold">Fecha del evento: </span><span>{{$fechaEvento->translatedFormat(' l j F Y')}}<span>
    
                                </td>
                            </tr>
                           
                            </table>
                        <p style="text-align: center; font-size: 12px;"><span style="font-weight: bold;"> Recibimos de: {{$cliente->nombre}} {{$cliente->apellidoPaterno}} {{$cliente->apellidoMaterno}}</span> La cantidad de: 
                            <span style="text-align: center; line-height: 13px; margin: 0; margin-top: -10px; padding: 0; font-style: italic; font-size: 13px;padding-right:20px">( 
                                @php        
        echo convertir($numero);
        $abonosAnteriores=0;
                                @endphp)</span>
                              </p>
                           
                            <div style="width: 100%; height: 0px"></div>
                            @if(intval(count($Pagos))>0)
                            <label for="" style="font-size: 10px; font-style: italic">Abonos Anteriores</label>
                            <table style="width: 100%; font-size: 11px; margin-bottom: 10px;"> 
                                <tr>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Concepto</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Fecha y hora de pago</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Metodo de pago</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Referencia</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Monto</td>
                                </tr>
                                @foreach ($Pagos as $pago)
                                <tr style="text-align: center">
                                    <td>Abono a contrato</td>
                                    <td>{{$pago->created_at}}</td>
                                    <td>{{$pago->method}}</td>
                                    <td>{{$pago->reference}}</td>
                                <td>${{number_format($pago->amount,2)}}</td>
                                </tr>
                                @php
                                    $abonosAnteriores=$abonosAnteriores+$pago->amount;
                                @endphp
                                @endforeach
                            </table>
                            @endif
    
                            <label for="" style="font-size: 10px; font-style: italic">Abono actual</label>
                            <table style="width: 100%; font-size: 13px"> 
                                <tr>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Concepto</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Fecha y hora de pago</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Metodo de pago</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Referencia</td>
                                    <td style="padding:4px; background:#E8E8E8; text-align: center">Monto</td>
                                </tr>
                                <tr style="text-align: center">
                                    <td>Abono a contrato</td>
                                    <td>{{$Pago->created_at}}</td>
                                    <td>{{$Pago->method}}</td>
                                    <td>{{$Pago->reference}}</td>
                                <td>${{number_format($Pago->amount,2)}}</td>
                                </tr>
                            </table>
                            <div style="width: 100%; height: 0px; border-bottom:solid"></div>
                            @php
                                $totalPagosAnteriores=0;
                                if($Budget->opcionIVA){
                                $BudgetTotal=$Budget->total*1.16;}else{
                                    $BudgetTotal=$Budget->total;
                                }
                            @endphp
                            @foreach ($Pagos as $pago)
                                @php
                                    $totalPagosAnteriores=$totalPagosAnteriores+$pago->amount;
                                    
                                @endphp
                            @endforeach
                            @php
                                $saldoPendiente=$BudgetTotal-$totalPagosAnteriores-$Pago->amount;
                            @endphp
                            <p style="text-align: right; font-weight: bold; padding-right:20px"><span style="font-weight: normal"> Saldo Anterior: ${{number_format($BudgetTotal-$totalPagosAnteriores,2)}}</span>
                                <br>Pagos anteriores: ${{number_format($totalPagosAnteriores,2)}}
                                <br>Su abono: ${{number_format($Pago->amount,2)}}
                                <br>Saldo Pendiente${{number_format($saldoPendiente,2)}}</p>
    
                                <p style="text-align: center; font-size: 11px; font-style: italic">El Monto final del evento puede variar por modificaciones en aumento de servicios solicitados por parte del cliente despues de este recibo</p>
                                <table style="width: 100%; margin-top: -10px">
                                    <tr>
                                    <td><p style="text-align: center">______________________________<br>Firma {{$cajero }}</p></td>
                                        <td><p style="text-align: center">______________________________<br>Firma {{$cliente->nombre}} {{$cliente->apellidoPaterno}} {{$cliente->apellidoMaterno}}</p></td>
                                    </tr>
                                </table>
                                
                    </div>
</body>
</html>