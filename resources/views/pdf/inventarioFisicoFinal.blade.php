<body style="font-family: Helvetica; ">
<p style="line-height: 15px; font-size: 16px; font-style: italic; font-weight: bold">Familia: {{$familia}}</p>
<table>


</table>
@php
use Carbon\Carbon;
    $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');
@endphp
<p>Inventario Impreso {{$fechaHoy}}</p>
<table style="border-width: 1px; width:100%; text-align:center">
    <tr style=" font-size: 12px">
      <th style="padding:4px">Imagen</th> 
      <th style="padding: 4px;">Servicio</th>
       <th style="padding: 4px;">Antes Bodega</th>
       <th style="padding: 4px;">Fisico Bodega</th>
       <th style="padding: 4px;">Diferencia</th>
       <th style="padding: 4px;">Antes Exhibición</th>
       <th style="padding: 4px;">Fisico Exhibición</th>
       <th style="padding: 4px;">Diferencia</th>
       <th style="padding: 4px;">Total Diferencia</th>
    </tr>
    @foreach ($Inventario as $item)
    @php
        $registro = App\PhysicalInventory::where('idProducto', $item->id)->first();
    @endphp
    @if(!is_null($registro))
<tr style="font-size:11px;">
<td style="padding: 4px; border-bottom:solid; border-width: 1px; "><img src="{{$item->imagen}}" width="35px"></td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; ">{{$item->servicio}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->antesBodega}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->fisicoBodega}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD; @if(($registro->fisicoBodega-$registro->antesBodega)<0) color:red @endif">{{$registro->fisicoBodega-$registro->antesBodega}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center">{{$registro->antesExhibicion}}</td>
<td style="padding: 4px; border-bottom:solid; text-align: center; border-width: 1px; ">{{$registro->fisicoExhibicion}}</td>
<td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD; @if(($registro->fisicoExhibicion-$registro->antesExhibicion)<0) color:red @endif">{{$registro->fisicoExhibicion-$registro->antesExhibicion}}</td>
@if ($registro->diferencia)
  <td style="padding: 4px; border-bottom:solid; border-width: 1px; text-align: center; background:#FFFEDD;">{{($registro->fisicoBodega - $registro->antesBodega) + ($registro->fisicoExhibicion - $registro->antesExhibicion)}}</td>
@endif

  @endif


</tr>
@endforeach
</table>

<table style="width: 100%; margin-top: 20px">
  <tr style="text-align: center">
    <td>_____________________________<br>Firma Aaron Bodega</td>
    <td>_____________________________<br>Ivonne C. Arroyos P.</td>
  </tr>
</table>

      

   
<script type="text/php">
if ( isset($pdf) ) {
    $font = "helvetica";
    $pdf->page_text(520, 817, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font , 6, array(0,0,0));
}
</script> 
   
</body>
