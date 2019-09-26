<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@if($presupuesto->tipo=='PRESUPUESTO') Presupuesto @else Contrato @endif</title>
</head>
<body style="font-family: Helvetica; ">
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px">
  <tr>
    <td style="padding-right:100px;">
        <img src="http://megamundodecor.com/images/mega-mundo-decor.png" style="width:200px">
    </td>
    <td colspan="2" style="text-align: right">
      <p><span style="font-weight: bolder">Folio:</span>  <span style="font-weight:normal">{{$presupuesto->folio}}</span></p>
      <p><span style="font-weight: bolder">Vendedor:</span> <span style="font-weight:normal">{{$presupuesto->vendedor}}</span></p>
      </td>
  </tr>
  <tr>
      <td style="text-align: left; font-style: italic; font-size:13px">Versión de @if($presupuesto->tipo=='PRESUPUESTO') presupuesto @else contrato @endif {{$presupuesto->version}} de {{$presupuesto->version  }} </td>
  </tr>
  <tr style="text-align: right; font-size:13px">
    <td></td>
    <td colspan="2"><p style="margin-top:-20px">Email: Ventas@megamundo.com.mx<br>Teléfono: (614) 423-41-34<p></td>
  </tr>
</table>
<!--INFORMACION DE CLIENTE-->
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
<tr>
<td colspan="3"><p style="line-height: 14px;"><span style="font-style: italic">Presupuesto generado para:</span> <span style="font-weight: bold">{{$presupuesto->cliente}}</span>
  <br><br><span>{{$presupuesto->emailCliente}}</span>
  
<br><br><span>Teléfonos: @foreach($Telefonos as $telefono)
    @php
      $lada=substr($telefono->numero, 0,3);
      $primerosnumero=substr($telefono->numero, 3,3);
      $segundos=substr($telefono->numero, 6,2);
      $terceros=substr($telefono->numero, 8,2);
    @endphp
  {{'('.$lada.')'.$primerosnumero.'-'.$segundos.'-'.$terceros}}, @endforeach</span></p>
</td>
<td>
<p style="border:solid; border-color:red; border-width: 1px; text-align: center; padding: 10px; font-size: 15px;">{{$presupuesto->creditoCliente}}</p>

</td>
</tr>
<tr>
    <td colspan="4"><p style="line-height: 12px;"><span style="font-style: italic">Fecha de creación:</span> <span style="font-weight:bold">{{$presupuesto->created_at}}</span></p></td>
</tr>
</table>
<!--INFORMACION DEL EVENTO-->
<table style="width: 100%; border-bottom:solid; border-bottom-width: 1px; padding-bottom: 15px" >
<tr>
    <td colspan="4"><H3 style="line-height: 15px; font-size: 18px">INFORMACIÓN DEL EVENTO</H3></td>
  </tr>
<tr style="font-weight: bold; font-size: 14px;">
<td colspan="2"><span>Fecha y Hora: </span></td>
<td><span>Categoria y Tipo de Evento:</span></td>
<td colspan="1">Invitados: <span style="font-weight: normal">{{$presupuesto->numeroInvitados}}</span></td>
</tr>
<tr style=" font-size: 14px;">
    @php                        
    use Carbon\Carbon;    
    $fechaEvento = Carbon::parse($presupuesto->fechaEvento)->locale('es');
@endphp
<td colspan="2">{{$fechaEvento->translatedFormat(' l j F Y')}} <br>@if($presupuesto->pendienteHora==0){{$presupuesto->horaEventoInicio}} - {{$presupuesto->horaEventoFin}}@else Pendiente @endif</td>
  <td><span> {{$presupuesto->categoria}}, {{$presupuesto->tipoEvento}} {{$presupuesto->tipoServicio}}</span></td>
  <td><span style="font-weight: bold">Tono:</span> {{$presupuesto->colorEvento}}</td>
</tr>
<tr style=" font-size: 14px;">
<td colspan="3"></td>
<td><span style="font-weight: bold">Tema:</span> {{$presupuesto->temaEvento}}</td>
</tr>

<tr style=" font-size: 14px;"><td colspan="4"><span style="font-weight: bold">Lugar: </span></td>
</tr>
<tr style=" font-size: 14px;"><td colspan="4">{{$presupuesto->direccionLugar}} {{$presupuesto->numeroLugar}} {{$presupuesto->coloniaLugar}}<br><span style="font-style: italic">Notas: {{$presupuesto->observacionesLugar}}</span></td>
</tr>
</table>
<table style="width: 100%; margin-top: 10px">
  <tr style="padding: 4px; color:white; background:#9E9E9E; text-align: center;">
    <td style="font-size: 13px; padding: 4px;">Servicio</td>
    <td style="font-size: 13px; padding: 4px;">Cantidad</td>
    <td style="font-size: 13px; padding: 4px;">Precio Unitario</td>
    <td style="font-size: 13px; padding: 4px;">Precio Especial</td>
    <td style="font-size: 13px; padding: 4px;">Total</td>
    <td style="font-size: 13px; padding: 4px;">Notas</td>
  </tr>
  @php
      $descuento=0;
  @endphp
  @foreach ($Elementos as $elemento)
  @php
      $descuento=$descuento+($elemento->precioUnitario-$elemento->precioEspecial);
  @endphp
    <tr style="margin-top: 2px; background: #F3F3F3; font-size:13px">
    <td style="padding: 5px;">{{ (strtolower($elemento->servicio)) }}</td>
      <td style="text-align: center">{{ (strtolower($elemento->cantidad)) }}</td>
      <td style="text-align: center">${{ (strtolower($elemento->precioUnitario)) }}</td>
      <td style="text-align: center">@if($elemento->precioUnitario!=$elemento->precioEspecial)${{ (strtolower($elemento->precioEspecial)) }}@else -- @endif</td>
      <td style="text-align: center">${{ (strtolower($elemento->precioFinal)) }}</td>
    <td style="padding: 5px;">{{ (strtolower($elemento->notas)) }}</td>
    </tr>
@endforeach
</table>
@php
  if($presupuesto->opcionIVA==1){
    $iva=(($presupuesto->total/116) * 16);
     $iva=number_format($iva,2);
  }else {$iva=0; $iva=number_format($iva,2);}
  @endphp
<table style="width: 100%; text-align: right">
<tr>
  <td><p>Subtotal: ${{$presupuesto->total}}<br>
  
    IVA: ${{$iva}}<br>
    @if($presupuesto->opcionDescuento==1)
  Ahorro total: ${{$descuento}} @endif<br><br>
     <span style="font-weight: bold">TOTAL:$ {{$presupuesto->total}}<span></p></td>
      </tr>
      <tr style="font-style: italic; text-align: left; font-size: 12px;">
        <td>
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
        </td>
      </tr>
      @if($presupuesto->tipo=='CONTRATO')
     <table style="width: 100%;">
    <tr>
    <td colspan="2">
        <p style="font-size: 16px; font-weight: bold; text-align: left">
            Generales de contrato<br>
            <span style="font-size: 12px; font-weight: normal; text-align: justify">
                FENOMENOS METEOROLOGICOS EN CASO DE LLUVIA, VIENTO, APAGANONES DE LUZ POR CFE, POR NINGUN MOMENTO SE PODRA CANCELAR ESTE CONTRATO YA QUE ES ALGO AJENO A LOS SERVICIOS DE MEGA MUNDO EL CONTRATO TENDRÁ QUE SER LIQUIDADO EN SU TOTALI_ DAD. NO HABRÁ CAMBIO DE FECHA EL MERO DIA DEL EVENTO. MAL FUNCIONAMIENTO DE LA UNIDAD RENTADA: — SI LA UNIDAD RENTADA NO ESTA FUNCIONANDO ADECUADAMENTE, EL CLIENTE TENDÁ QUE REPORTARLO INMEDIATAMENTE A A MEGAMUNDO 614 4 23 41 34 PARA QUE MEGAMUNDO SOLUCIONE EL PROBLEMA LO MAS PRONTO POSIBLE Y ASI RESPONERLE EL TIEMPO PERDIDO. EN CASO DE QUE ESTE PROBLEMA NO SE REPORTE INMEDIATAMENTE, MEGA MUNDO SE DESLINDA DE CUALQUIER RESPONSABILIDAD Y DE REPOSICION DE TIEMPO. CAMBIOS DE FECHA Y CANCELACIONES DEBE SER PAGADO LOS SERVICIOS AL 100% **CAMBIOS DE FECHA SOLO 1 SEMANA ANTES Y CON COSTO ADMINISTRATIVO DE $100 (CIEN PESOS) "NO EXISTEN CANCELACIONES EN ESTE SERVICIO Y NO HAY DEVOLUCION TOTAL NI PARCIAL DEL DINERO "LOS SERVICIOS CONTRATADOS DEBEN SER PAGADOS EN SU TOTALIDAD ANTES DEL EVENTO. ACCIDENTES NO NOS HACEMOS RESPONSABLES POR ACCIDENTES DE LOS INVITADOS DE NINGUNA INDOLE. LA RESPONSABILIDAD CORRE POR QUIEN CONTRATA —PASTILLAS DE LUZ EN CASO DE QUE LAS PASTILLAS DE LUZ SE ESTEN BOTANDO, ES RESPONSABILIDAD DE QUIEN CONTRATA EL ARREGLO DE LUZ Y NO DE MEGA MUNDO. EL TIEMPO NO SE REPONDRA, MEGAMUNDO PUEDE RETIRARSE DE LA 1NSTALACION EN CASO DE QUE POR ESTE U OTRO MOTIVO NO AJENO A MEGAMUNDO , ESTE PUEDA LLEGAR A SUS OTROS EVENTOS (SERVICIOS) TARDE. —PRECIOS MAS IVA —CHEQUES DEVUELTOS TIENE UN CARGO ADICIONAL PARA EL CLIENTE DE EL 20% DEL MONTO TOTAL DEL CHEQUE. 
              </span><br></p>
             
        </td>  
    </tr>
    <tr>
      <td colspan="2">
          <p style="font-size: 16px; font-weight: bold; text-align: left">
              Servicios<br>
              <span style="font-size: 12px; font-weight: normal; text-align: justify">
                  <span style="font-weight: bold">MESERO</span><br> INDICARLE AL MESERO A SU LLEGADA CUALES SON LAS ESPECIFICACIONES DEL EVENTO O LO QUE LE GUSTAR. A USTED OUE SE REALIZA. LOS MESEROS NO SE HACEN RESPOSABLES DE VASOS PLATOS ETC QUEBRADOS DURANTE EL EVENTO LOS MESEROS DEBERÁN REPONER EL TIEMPO PERDIDO EN CASO DE OUE LLEGUEN TARDE LOS MESEROS VAN UNIFORMADOS ES IMPORTANTE ENTREGAR CROOUIS EN HUERTAS O RANCHOS aERRCERIAS, BIEN ESPECIFICADOS P. QUE NO LLEGUEN TARDE Al EVENTO BARMAN TENER Tupo LO NECESARIO PARA EL BUEN DESEMPEÑO DEL BARMAN y POR CONSIGUIENTE EL EXITO DE SU EVENTO HIELO VASOS PINZAS BEBIDAS LICOR ETC 
<br><br><span style="font-weight: bold">PAYASITAS Y PERSONAJES</span><br> —PREMIOS SE SUGIERE AL CLIENTE QUE CONTEMPLE PREMIOS PARA LAS ACTIVIDADES DE LOS SHOWS ME. MUNDO NO LOS LLEVA FAVOR DE ENTREGARSELOS AL LLEGAR LAS PAYASITAS O EL SHOW CORRESPONDIENTE CONTRATADO ...EN CASO DE CONTRATACION DE PAYASITAS HARÁN GLOBOFLEX.. PINTAR GARRAS. AYUDAN ALA PIÑATA Y PONEN JUEGOS ESTAS ACTIVIDADES DEPENDEN DEL DESENVOLVIMIENTO DE LA PIÑATA DEBIDO AL NUMERO DE NIÑOS QUE ASISTIERON O CAMBIO EN EL HORARIO DEL PASTEL Y LA PIÑATA DEBIDO A ESTO ES IMPOSIBLE PODER. DAR UN TIEMPO EXACTO A CADA ACTIVIDAD QUE REALIZARÁN O QUE SE REALIZEN TODAS PERSONAJES O BOTARGAS –NO PINTARAN– SOLO ESTABAN COMO PRESENCIA DURANTE EL EVENTO SI EL PERSONAJE TRAE MASCARA O ES BOTARGA. SE DA. ALGUN TIEMPO DURANTE EL EVENTO PA. PODER TOMAR AIRE O AGUA YA QUE LOS TRAJES SON MUY CALUROSOS Y PODR.N DESHIDRATARSE LOS CHICOS QUE TRAEN EL TRAJE AGRADECEMOS MUCHO SU COMPRENSION POR ESTE MOTIVO —TOMA ELECTRICA PARA SONIDO SE REQUIERE I TOMA CERCA. A LA INSTALACION --SONIDO - NO SE LLEVARA SONIDO AL CONTRATAR SOLO UN PERSONAJE O U. SO, PAYASITA —PAGO DEL SERVICIO ESTE TENDRA QUE SER LIQUIDADO ANTES DE INICIAR CUALQUIER SHOW CONTRATADO PARA PODER INICIAR –.ENCUESTA AL FINAL DE SU EVENTO SE LE ENTREGARA U. ENCUESTA DONDE NOS EVALUARA NUESTRO SERVICIO Y EL PERSONAL OUE ASISTIO A SU EVENTO AGRADECEMOS MUCHO EL LLENARLA Y FIRMAR, PA. SU VALIDACION 
</span><br></p>
      </td>
    </tr>
    <tr>
      <td colspan="2"> <p>
          <span style="font-size: 12px; font-weight: normal; text-align: justify">
             
        <span style="font-weight: bold">MANTELERIA</span> COPIA DE ELECTOR VIGENTE POR LOS 2 LADOS. <BR>
Observaciones <br>
EJEMPLO MANTELERIA, CUBRE SILLAS, CUBRE MANTELES. MOÑOS. ETC "LA RENTA DE MANTELERIA ES POR 1 DIA Y SE ENTREGARA A LAS 12:00 PM DEL SIGUIENTE DIA —MANTELERIA DAÑADA TENDRA UN COSTO DE REPOSICION —MANTELERIA CON MANCHAS QUE NO SE PUEDAN QUITAR CORRERA CON COSTO DE REPOSICION A CARGO DEL CLIENTE MEGA MUNDO NOTIFICARA X TELEFONO EN UN LAPSO DE 48 HORAS mAximo SI EXISTE DESPERFECTO AL LAVARLOS —SE PEDIRA A LA PERSONA DEL LUGAR QUE FIRME LA HOJA CORRESPONDIENTE EN CASO DE ALGUN FALTANTE O DAÑO . EL CUAL EL CLIENTE DE ESTE CONTRATO SERA RESPONSABLE DEL PAGO DE REPOSICION. EL CUAL DEBERA SER PAGADO A NO MAS DE 48 HORAS DESPUES DE LA FIRMA DEL CONTRATO DEL EVENTO. "'LA MANTELERIA SI SE DEJA EN EL DOMICILIO NO INCLUYE INSTALACIÓN. EN CASO DE REQUERIR ESTE SERVICIO TIENE UN COSTO ADICIONAL EL CUAL DEPENDE DE LA CANTIDAD A INSTALAR. ESTE PRECIO CON GUSTO SE LE PUEDE PROPORCIONAR EN LAS OFICINAS DE MEGA MUNDO " NO INCLUYE ENVIO SENCILLO NI DOBLE (LLEVADA Y RECOGIDA) TIENE COSTO ADICIONAL. será responsable de los daÑos y perjuicios ocasionados por cualquier motivo de fenomenos meteorologicos. desastres naturales o perturbación de la paz civil que impidan la ejecución parcial o total del evento. 'El cliente reconoce. acepta y se compromete que a partir de la entrega de los mismos, a cubrir los daÑos que se ocasionen a la mantelena (quemaduras, manchas, descocidas, etc). Al momento de la entrega en nuestras oficinas, el cliente debera revisar que fue entregada en buenas condiciones. de no ser asi ahi mismo pedira la sustitución de los mismos. De no ser ase se da por entendido que la entrega esta correcta en cantidad y no daÑada. Al momento de la entrega en el lugar indicado por el cliente, debera revisar que fue entregada en buenas condiciones y la cantidad correcta. De no ser asi ah' mismo pedira la sustitución de los mismo Si no se notifica en el momento. se da por aceptada la firma de que entrega esta correcta en cantidad y no daNada. —Deposito de 500 pesos por evento es requerido en efectivo 
</span><br><br>
         
        </p></td>
    </tr>
    <tr>
        <td colspan="2">
            <p style="font-size: 16px; font-weight: bold; text-align: left">
                <br>
                <span style="font-size: 12px; font-weight: normal; text-align: justify">
                    <span style="font-weight: bold">BRINCA BRINCA</span><br>  1) NO SE INSTALARAN BRINCA BRINCAS EN TIERRA 0 PISOS FILOSOS.ETC EN CASO E NO AVISAR ANTES DE LA FIRMA DE ESTE CONTRATO MEGA MUNDO CANCELA. EL SERVICIO SIN NINGUNA RESPONSABILIDAD PARA MEGA MUNDO Y NO SE DEVOLVERA EL TOTAL DEL IMPORTE DE IA RENTA DEL BRINCA BRINCA CLIENTS SE OBLIGA A PAGAR EL 100% DE LA RENT, ASI COMO EL IMPORTS TOTAL DEL FLETE <br>2) NO SE PUEDEN PONE R OBJETOS DE NINGU. ESPECIE DEBAJO DE LOS BRINCA BRINCAS <br>3) NO SE INSTALARA LA UNIDAD EN LUGARES DONDE TOPE CON ARBOLES 0 PAREDES YA QUE PUEDEN DANAR LA UNIDAD SE REQUIERE QUE EL CLIENTS DEJE UNA IDENTIFICACION OFICIAL NO VENCIDA EN OFICINAS DE MEGA MUNDO QUE COINCIDA CON LA DIRECCION ACTUAL EN DONDE SE INSTAL. SI NO ASISTE PERNSONAL DE MEGA MUNDO -MEDIDAS MEGA MUNDO NO SE HALE RESPONSABLE EN IR A TOMAR MEDIDAS A LOS LUGARES DE INSTALCION LAS MEDIDAS DE LO CONTRATADO YA FUERON ACEPTADAS POR EL CONTRATANTE Y ACEPTA QUE LAS MEDIDAS SE LE FUERON MOST.DAS Y/0 EXPLICADAS ANTES DE LA FIRMA DE ESTE CONTRATO Y OUEDO TOTALMENTE DE ACUERDO -MARGEN DE MEDIDAS DE ACUERDO A LAS MEDIDAS DEL BRINCA BRINCA CONT.TADO SE DEBE DE DEJAR UN MARGEN A LA REDONDA DE UN METRO MINIMO •• DEJAR ASIGNADO A ALGUNA PERSONA EN SU REPRESENTACION EN CASO DE NO ESTAR EN EL DOMICIL. A INSTALRSE LA UNIDAD YA QUE MEGA MUNDO DA UN LAPSO DE 10 MINUTOS DE ESPEFtA DEBIDO A SU LOGISTICA EN CASO DE NO HABER NADIE. MEGA MUNDO LO INSTALARA EN DONDE CONSIDERS LA MEJOR OPCION. EN CASO DE DUE EL CIIENTE DESPUES OUIERA CAMBIARLO DE LUGAR ESTE TEND. UN COSTO EXTRA Y DEPENDERA DE LA LOGISTICA DE MEGA MUNDO SI PODRIA 0 NO ASISTIR NUEVAMENTE PA. PODER MOVER LA UNIDAD AL LUGAR NUEVO ASIGNADO -- EN CASO DE QUE LA EMPRESA 0 CASA NO CUENMTE CON LA CAPACIDAD NECESARIA PA. LA ELECTRICIDAD Y EL CLIENTS CONT.TE U. PLANTA DE LUZ ESTA DEBE DE ESTAR ANTES DE LA INSTALACION DE LOS BRINCA BRINCAS 0 TOBOGANES PA..CER LAS PRUEBAS NECESARIAS DEL BUEN FUNCIONAMIENTO DE LOS MISMOS MANTAS DE LUZ EXTER.S QUE NO DEN ABASTO PARR EL SERVICIO DE MEGA MUNDO MEGA DECOR NO ES RE SPON.BILIDAD DE MEGA MUNDO EL OTORGAR TIEMPO EXT. 0 EN SU DEFECT° PENALZACION POR MAL SERVICIO DE MAG MUNDO MEGA DECOR </span><br></p>
        </td>
      </tr>
    <tr style="text-align: center">
        <td >____________________________________<br>Firma del cliente<br>{{$presupuesto->cliente}}</td>
        <td >____________________________________<br><br>Mega Mundo Decor</td>
      </tr>
  </table>
          @endif
</table>


      

   
  
   
</body>
</html>