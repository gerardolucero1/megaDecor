<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@php
    $date = Carbon\Carbon::now();
@endphp
<body style="font-family: Arial, Helvetica, sans-serif" style="border:solid;">
        <div style="width: 100%;">
        <table style="width: 100%">
            <tr style="text-align:center">
                <th>Folio</th>
                <th>Fecha Evento</th>
                <th>Vendedor</th>
                <th>Versión</th>
                <th>Recolección</th>
            </tr>
            @foreach ($presupuestos as $presupuesto)
            <tr style="border:solid; text-align: center">
            <td style="padding: 5px;">{{$presupuesto->folio}}</td>
            <td>{{$presupuesto->fechaEvento}}</td>
            <td>
            @php
                $vendedor = App\User::where('id', $presupuesto->vendedor_id)->first();
            @endphp
            {{$vendedor->name}}
            </td>
            <td>{{$presupuesto->version}}</td>
            <td>
                @if($presupuesto->entregaEnBodega)
                Entrega en bodega
                @else
                Recolección
                @endif
                </td>
            </tr>
            @endforeach
            
        </table>
       <div>

    <script type="text/php">
    if ( isset($pdf) ) {
        $font = "helvetica";
        $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
    }
    </script> 
</body>
</html>