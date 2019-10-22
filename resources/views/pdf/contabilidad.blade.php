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
        $date = Carbon::now();
        $fechaHoy = Carbon::parse($date->toDateString())->locale('es');  
        $fechaApertura = Carbon::parse($registro->fechaApertura)->locale('es');
        $fechaCierre = Carbon::parse($registro->fechaCierre)->locale('es');
        $horaApertura = date("g:i a", strtotime($registro->horaApertura));
        $horaCierre = date("g:i a", strtotime($registro->horaCierre));
        $cajero = User::orderBy('id', 'DESC')->where('id', $registro->user_id)->first();
    @endphp
    <table style="width: 100%; font-family: Helvetica;" >
    <tr>
        <td colspan="1">
            <img src="http://megamundodecor.com/images/mega-mundo-decor.png" alt="" style="width: 200px">
        </td>
    <td colspan="3"><span style="font-style: italic"> Reporte generado: {{ $fechaHoy->translatedFormat(' l j F Y') }}</span></td>
    </tr>
   
    </table>
    @php

       
    @endphp
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
                <p><span style="font-weight: bold">Monto de apertura: </span> ${{ $registro->cantidadApertura}}<br></p>
            </td>
            <td>
                <p><span style="font-weight: bold">Monto de cierre: </span> ${{ $registro->cantidadCierre}}<br></p>
            </td>
            </tr>
         
    </table>
    <div style="width: 100%; border-bottom:solid; border-width: 1px;"></div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $font = "helvetica";
            $pdf->page_text(72, 18, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
        }
      </script> 
</body>
</html>

{{ $registro->id }}<br>
{{ $registro->fechaApertura }} {{ $registro->horaApertura }} - {{$registro->horaCierre}}<br>
${{ $registro->cantidadApertura }} / ${{ $registro->cantidadRealApertura }}<br>
${{ $registro->cantidadCierre }} / ${{ $registro->cantidadRealCierre }}<br>
