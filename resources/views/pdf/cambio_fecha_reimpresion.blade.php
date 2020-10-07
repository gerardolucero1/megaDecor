<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@php
    $fechaAntes=Carbon\Carbon::parse($ultimoCambio->fechaAnterior)->locale('es');
    
@endphp
<body style="font-family: Arial, Helvetica, sans-serif">
        <div style="width: 100%; margin-top;-20px">
            <p style="font-size: 100px; position:absolute; font-weight:bold; color:rgba(238,37,37,.2); text-align:center; transform: rotate(-45deg); margin-left:300px; margin-top:100px;">Reimpresión</p>
                <p style="text-align:center; font-weight:bold"><span style="font-style: italic; font-size:16px">Folio de contrato:</span> <span> {{$budget->folio}}</span></p>
               
               
                <table style="width: 100%; font-family: Helvetica;" >
                        <tr>
                            <td>
                                <img src="https://adpro3d-os.com/megamundo/mega-mundo-decor.png" alt="" style="width: 150px">
                            </td>
                        <td style="text-align: right">
                            <span style="font-style: italic; font-size:16px; font-weight:bold">Folio de cambio de fecha:</span> <span> {{$ultimoCambio->id}}</span><br>
                        <span  style="font-style: italic; font-size: 14px; font-weight: bold">Fecha de cambio: </span>{{$fechaAntes->translatedFormat(' l j F Y')}}<span><span>
                                <br>
                                <span  style="font-style: italic; font-size: 14px; font-weight: bold">Fecha nueva solicitada: </span><span>
                                    @if($ultimoCambio->fechaNueva==null)
                                    Pendiente<br>
                                    <span style="font-weight: lighter; font-style: italic; font-size: 12px;">*El saldo abonado a este contrato tiene una vigencia hasta: @php
                                        $vigencia =  Carbon\Carbon::parse($ultimoCambio->vigencia)->locale('es')->translatedFormat(' l j F Y');
                                        echo $vigencia;
                                    @endphp </span>
                                    @else
                                    @php
                                        $fechaNew=Carbon\Carbon::parse($ultimoCambio->fechaNueva)->locale('es')->translatedFormat(' l j F Y');
                                        echo $fechaNew;
                                    @endphp
                                    @endif
                                    <span>

                            </td>
                        </tr>

                        </table>

            

                        <p style="font-weight: bold; padding:0px; margin-top:0px"> <span>Cambios Previos Solicitados: {{count($totalCambios)}}</span><br>Motivo de modificación en fecha: <br><span style="font-style: italic; font-weight:lighter">{{$ultimoCambio->motivo}}</span></p>
                        
                        <table style="width: 100%; text-align:center; margin-top:-10px">
                            <tr>
                            <th>Fecha anterior</th>
                            <th>Fecha despues del cambio</th>
                            <th>Vigencia</th>
                            </tr>
                            @foreach ($totalCambios as $cambios)
                                <tr>
                                <td>{{$cambios->fechaAnterior}}</td>
                                <td>@if($cambios->fechaNueva==null) Pendiente @else{{$cambios->fechaNueva}} @endif</td>
                                <td>{{$cambios->vigencia}}</td>
                                </tr>
                            @endforeach
                        </table>


                                <table style="width: 100%; margin-top: -10px">
                                    <tr>
                                    <td><p style="text-align: center">______________________________<br>Firma Ivonne C. Arroyos Piñon</p></td>
                                        <td><p style="text-align: center">______________________________<br>Firma {{$nombreCliente}}</p></td>
                                    </tr>
                                </table>
                                
                    </div>
                    <div style="width: 100%; margin-top:50px; border-top: solid; border-top-style: dotted;">
                        <p style="text-align:center; font-weight:bold"><span style="font-style: italic; font-size:16px">Cambio de fecha</span></p>
                        <table style="width: 100%; font-family: Helvetica;" >
                                <tr>
                                    <td>
                                        <img src="https://adpro3d-os.com/megamundo/mega-mundo-decor.png" alt="" style="width: 150px">
                                    </td>
                                <td style="text-align: right">
                                <span style="font-weight: bold; font-size: 20px">Folio de contrato:</span> <span> {{$budget->folio}}</span><br>
                                <span  style="font-style: italic; font-size: 14px; font-weight: bold">Fecha del evento antes del cambio: </span>{{$fechaAntes->translatedFormat(' l j F Y')}}<span><span>
                                        <br>
                                        <span  style="font-style: italic; font-size: 14px; font-weight: bold">Fecha del evento actualizada: </span><span>
                                            @if($ultimoCambio->fechaNueva==null)
                                            Pendiente<br>
                                            <span style="font-weight: lighter; font-style: italic; font-size: 12px;">*El saldo abonado a este contrato tiene una vigencia de un año apartir de la fecha de la solicitud de cambio: </span>
                                            @php
                                                $fechainicial =  Carbon\Carbon::parse($ultimoCambio->created_at)->locale('es')->translatedFormat(' l j F Y');
                                                echo $fechainicial;
                                            @endphp
                                            @else
                                            @php
                                                $fechaNew=Carbon\Carbon::parse($ultimoCambio->fechaNueva)->locale('es')->translatedFormat(' l j F Y');
                                                echo $fechaNew;
                                            @endphp
                                            @endif
                                            <span>
        
                                    </td>
                                </tr>
                                </table>
                                <p style="font-weight: bold; padding:20px">Motivo de modificación en fecha: <br><span style="font-style: italic; font-weight:lighter">{{$ultimoCambio->motivo}}</span></p>
                            

                                <table style="width: 100%; text-align:center; margin-top:-10px">
                                    <tr>
                                    <th>Fecha anterior</th>
                                    <th>Fecha despues del cambio</th>
                                    <th>Vigencia</th>
                                    </tr>
                                    @foreach ($totalCambios as $cambios)
                                        <tr>
                                        <td>{{$cambios->fechaAnterior}}</td>
                                        <td>@if($cambios->fechaNueva==null) Pendiente @else{{$cambios->fechaNueva}} @endif</td>
                                        <td>{{$cambios->vigencia}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                           
                                        <table style="width: 100%; margin-top: -10px">
                                            <tr>
                                            <td><p style="text-align: center">______________________________<br>Firma Ivonne C. Arroyos Piñon</p></td>
                                                <td><p style="text-align: center">______________________________<br>Firma {{$nombreCliente}}</p></td>
                                            </tr>
                                        </table>
                                        
                            </div>
</body>
</html>