<body style="font-family: Helvetica;">
<p style="line-height: 15px; font-size: 16px; font-style: italic; font-weight: bold">Familia: {{$familia}}</p>
<table>


</table>
@php
use Carbon\Carbon;
    $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
@endphp
<p>Inventario Impreso {{$fechaHoy}} Entrega</p>
<table style="border-width: 1px; width:100%; text-align:center">
    <tr style=" font-size: 12px">
      <th style="padding:4px">Imagen</th> 
      <th style="padding: 4px;">Servicio</th>
    
       <th style="padding: 4px;">Fisico Bodega</th>
       
       
       <th style="padding: 4px;">Fisico Exhibición</th>
      
      
    </tr>
    @foreach ($Inventario as $item)
    @if(!$item->noAplica) 
    @php
        $registro = App\PhysicalInventory::where('idProducto', $item->id)->first();
    @endphp

    
    @if(!is_null($registro))
    @if($faltantes=='si')
    @php
        $faltante=($registro->fisicoBodega - $registro->antesBodega) + ($registro->fisicoExhibicion - $registro->antesExhibicion);

    @endphp
    @if($faltante<0)
<tr style="font-size:11px;">
<td style="padding: 4px; border-bottom:solid; border-width: 1px; max-width: 35px"><img src="{{$item->imagen}}" width="35px"></td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; max-width: 100px">{{$item->servicio}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->antesBodega}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->fisicoBodega}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD; @if(($registro->fisicoBodega-$registro->antesBodega)<0) color:red @endif">{{$registro->fisicoBodega-$registro->antesBodega}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->antesExhibicion}}</td>
<td style="padding: 4px; border-bottom:solid; text-align: center; border-width: 1px; ">{{$registro->fisicoExhibicion}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD; @if(($registro->fisicoExhibicion-$registro->antesExhibicion)<0) color:red @endif">{{$registro->fisicoExhibicion-$registro->antesExhibicion}}</td>

  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD;">{{($registro->fisicoBodega - $registro->antesBodega) + ($registro->fisicoExhibicion - $registro->antesExhibicion)}}</td>

</tr>
@endif
@else

@if($item->diferencia=='TRUE')
<tr style="font-size:11px;">
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; max-width: 35px "><img src="{{$item->imagen}}" width="35px"></td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; max-width: 100px">{{$item->servicio}}</td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->antesBodega}}</td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->fisicoBodega}}</td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD; @if(($registro->fisicoBodega-$registro->antesBodega)<0) color:red @endif">{{$registro->fisicoBodega-$registro->antesBodega}}</td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->antesExhibicion}}</td>
  <td style="padding: 4px; border-bottom:solid; text-align: center; border-width: 1px; ">{{$registro->fisicoExhibicion}}</td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD; @if(($registro->fisicoExhibicion-$registro->antesExhibicion)<0) color:red @endif">{{$registro->fisicoExhibicion-$registro->antesExhibicion}}</td>
 
    <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD;">{{($registro->fisicoBodega - $registro->antesBodega) + ($registro->fisicoExhibicion - $registro->antesExhibicion)}}</td>
  
  </tr>
@else
<tr style="font-size:11px;">
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; max-width: 35px "><img src="{{$item->imagen}}" width="35px"></td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; max-width: 100px">{{$item->servicio}}</td>
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->fisicoBodega}}</td>
 
  <td style="padding: 4px; border-bottom:solid; text-align: center; border-width: 1px; ">{{$registro->fisicoExhibicion}}</td>
  
  
  </tr>
@endif


@endif
@endif
@endif


@endforeach
</table>

<table style="width: 100%; margin-top: 20px">
  <tr style="text-align: center">
    <td>_______________________<br>Firma de inventario entregado por:<br>_______________________</td>
    <td>_______________________<br>Ivonne C. Arroyos P.</td>
  </tr>
  <tr>
    <td colspan="2"><br><span style="font-style: italic">Acepto que esta es la cantidad entregada al: ______________________</span></td>
  </tr>
  <tr>
    <td colspan="2" style="font-style: italic">Acepto que estas son las cantidades que e contado fisicamente en persona y acepto mis faltantes</td>
  </tr>
 
  
  <tr style="text-align: center;">
    <td><br><br>_____________________________<br>Firma de inventario recibido por:<br>_______________________</td>
  </tr>
  <tr>
    <td colspan="2"><br><span style="font-style: italic">Acepto que esta es la cantidad recibida al: ______________________</span></td>
  </tr>
</table>

      

   
<script type="text/php">
if ( isset($pdf) ) {
    $font = "helvetica";
    $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
}
</script> 
   
</body>
