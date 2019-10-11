<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Presupuesto</title>
</head>
<body style="font-family: Helvetica; ">
<p style="line-height: 15px; font-size: 16px; font-style: italic"></p>
<table>


</table>
<table border="1" style="border-width: 1px;">
    <tr style="">
       <th style="padding: 4px;">Servicio</th>
       <th style="padding: 4px;">Bodega</th>
       <th style="padding: 4px;">Exhibición</th>
       <th style="padding: 4px;">Familia</th>
       <th>Check</th>
    </tr>
    @foreach ($Inventario as $item)
<tr style="">
<td style="padding: 4px;">{{$item->servicio}}</td>
<td style="padding: 4px;">{{$item->cantidad}}</td>
<td style="padding: 4px;">{{$item->exhibicion}}</td>
<td style="padding: 4px;">{{$item->familia}}</td>
<td></td>

</tr>
@endforeach
</table>


      

   
  
   
</body>
</html>