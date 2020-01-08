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
<table style="border-width: 1px; width:100%">
    <tr style="">
       <th style="padding: 4px;">Servicio</th>
       <th style="padding: 4px;">Bodega</th>
       <th style="padding: 4px;">Exhibición</th>
       <th style="padding: 4px;">Familia</th>
       <th style="padding: 4px;">Bodega</th>
       <th style="padding: 4px;">Exhibición</th>
    </tr>
    @foreach ($Inventario as $item)
<tr style="font-size:12px;">
<td style="padding: 4px; border-bottom:solid; border-width: 1px; ">{{$item->servicio}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; ">{{$item->cantidad}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; ">{{$item->exhibicion}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; ">{{$item->familia}}</td>
<td style="padding: 4px; border-bottom:solid; border-right:solid; border-left:solid; border-width: 1px; "></td>
<td style="padding: 4px; border-bottom:solid; border-right:solid; border-left:solid; border-width: 1px; "></td>

</tr>
@endforeach
</table>


      

   
  
   
</body>
</html>