@extends('layouts.backend')

@section('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <style>
        table.dataTable td{
        box-sizing: inherit;
        }
        * {
    font-size: 12px;
    font-family: 'Times New Roman';
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.producto,
th.producto {
    width: 75px;
    max-width: 75px;
}

td.cantidad,
th.cantidad {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.precio,
th.precio {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centrado {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}
    </style>


@endsection

@section('content')
    <section class="container">
            <div class="ticket">
                    <img
                        src="http://megamundodecor.com/images/mega-mundo-decor.png"
                        alt="Logotipo" style="padding-bottom: 15px; margin-top: 20px;">
                    <p class="centrado" style="margin: 0; padding: 0"><span style="font-weight: bold">Salida de Dinero</span>
                        <br>{{$salida->created_at}}
                        <br><span style="font-weight: bold">Responsable:</span> {{$salida->responsable}}</p>
                    <div>
                    <p style="margin: 0; padding: 0"><span style="font-weight: bold;">Motivo: </span>{{$salida->motivo}}</p>
                    <p style="margin: 0; padding: 0"><span style="font-weight: bold; text-align: center">Descripción: </span>{{$salida->descripcion}}</p>
                    @if(!is_null($salida->contrato))
                    <p style="margin: 0; padding: 0"><span style="font-weight: bold; text-align: center">Contrato: </span>{{$salida->contrato}}</p>
                    @endif
                    </div>
                    </table>
                    <p class="centrado" style="margin-top: 15px;">Firma de recibido
                        <br>_____________________</p>
                </div>
    </section>
@endsection
@section('scripts')
<script>
  window.print();
</script>
    
@endsection

