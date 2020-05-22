<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> Creditos Vencidos</title>
</head>
<body style="font-family: Helvetica; ">

      <table style="width: 100%; font-size:12px; text-align:center;">
        <tr style="background: cornsilk; padding:5px">
    <th style="width: 5%">#Folio</th>    
    <th style="width: 15%">Fecha Evento</th>
    <th style="width: 15%">Fecha Limite de pago</th>
    <th style="width: 10%">Días de credito</th>
    <th style="width: 10%">Días de atraso</th>
    <th style="width: 15%">Cliente</th>
    <th style="width: 6%">Total</th>
    <th style="width: 6%">Saldo Pendiente</th>
    <th style="width: 13%">Tel�fono</th>
        </tr>
    </table>

    @foreach ($contratos as $budgetArchivados)
    <table style="border-bottom: solid; font-size: 12px; width: 100%; border-width: 1px; text-align: center">
        @php
            $fechaEvento = Carbon\Carbon::parse($budgetArchivados->fechaEvento)->locale('es');
            $fechaLimite = Carbon\Carbon::parse($budgetArchivados->fechaLimite)->locale('es');
            $date = $budgetArchivados->fechaEvento." 11:00:00";
            $datework = Carbon\Carbon::createFromDate($date);
            $now = Carbon\Carbon::now();
            $testdate = $datework->diffInDays($now);
                                             
                                            @endphp


<tr >
    <td style=" font-weight: bold; padding-top:5px; width: 5%">{{$budgetArchivados->folio}}</td>
    <td style="width: 15%"><span style="display: none">{{$budgetArchivados->fechaEvento}}</span><br>{{$fechaEvento->translatedFormat(' l j F Y')}}</td>
    <td style="width: 15%"> @if($budgetArchivados->diasCredito>0){{$fechaLimite->translatedFormat(' l j F Y')}}@else {{$fechaEvento->translatedFormat(' l j F Y')}}@endif</td>
    <td style="width: 10%">{{$budgetArchivados->diasCredito}}</td>
    <td style="width: 10%">{{$testdate}} Días</td>
    <td style="width: 15%">@php
        $cliente = App\Client::where('id', $budgetArchivados->client_id)->first();

        if($cliente->tipoPersona == "FISICA"){
            $clienteFisico = App\PhysicalPerson::where('client_id', $budgetArchivados->client_id)->first();
            $clienteNombre = $clienteFisico->nombre.' '.$clienteFisico->apellidoPaterno.' '.$clienteFisico->apellidoMaterno;
           // $clienteCompleto = App\PhysicalPerson::where('client_id', $cliente->id)->first();
           
        }else{
            $clienteMoral = App\MoralPerson::where('client_id', $budgetArchivados->client_id)->first();
            $clienteNombre = $clienteMoral->nombre;
        }
    @endphp {{$clienteNombre}}</td>
   @php
   if($budgetArchivados->opcionIVA == 1){
       $total = $budgetArchivados->total + ($budgetArchivados->total * 0.16);
   }else{
       $total = $budgetArchivados->total;
       
   }
   $total=number_format($total,2);
   //saldo pendiente
   
@endphp
<td style="width: 10%">
${{$total}}
@if ($budgetArchivados->opcionIVA == 1)
   <br>
   <span style="font-size: 10px; color: green;">IVA</span>
@endif</td>
@if($budgetArchivados->opcionIVA == 1)
<td style="width: 6%" class="d-none d-sm-table-cell">${{number_format(($budgetArchivados->total*1.16)-$budgetArchivados->saldoPendiente,2)}}</td>
@else  
<td style="width: 6%;" class="d-none d-sm-table-cell">${{number_format($budgetArchivados->total-$budgetArchivados->saldoPendiente,2)}}</td>
@endif
<td style="width: 13%">
    @php
    $telefono = App\Telephone::where('client_id', $budgetArchivados->client_id)->first();
    echo $telefono->numero;
@endphp
</td>
</tr>
</table>
@endforeach

    </table>
    <div style="background: cornsilk; color:red">
    <p style="font-size: 20px">Adeudo Total ${{number_format($adeudoTotal,2)}}</p>
    </div>

   
<script type="text/php">
  if ( isset($pdf) ) {
      $font = "helvetica";
      $pdf->page_text(520, 787, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
  }
</script> 
   
</body>
</html>