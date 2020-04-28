<?php

namespace App\Http\Controllers\CMS;

use App\User;
use stdClass;
use App\Budget;
use App\Client;
use App\Family;
use App\Inventory;
use App\Telephone;
use Carbon\Carbon;
use App\BudgetPack;
use App\Celebrated;
use App\Commission;
use App\FamilyGroup;
use App\MoralPerson;
use App\BudgetVersion;
use App\PhysicalPerson;
use App\BudgetInventory;
use App\ExternalInventory;
use App\BudgetPackInventory;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function usuarios(){
        return User::orderBy('id', 'DESC')->get();
    }

    public function inventario(){
        return Inventory::orderBy('id', 'DESC')->get();
    }

    public function inventarioPostres(){
        return Inventory::orderBy('id', 'DESC')->where('familia', 'POSTRE')->get();
    }
    public function inventarioBotanas(){
        return Inventory::orderBy('id', 'DESC')->where('familia', 'Botanas')->get();
    }

    // Retorna todos los clientes con sus presupeustos a la vista

    public function clientesPresupuestos(){
        return Client::with('budgets')->orderBy('id', 'DESC')->get();
    }

    public function cliente(Request $request){

        if($request->accion == 'telefonos'){
            return Telephone::orderBy('id', 'DESC')->where('client_id', $request->id)->get();
        }

        if($request->accion == 'presupuestos'){
            return Budget::orderBy('id', 'DESC')->where('client_id', $request->id)->get();
        }
        
    }
    // Retorna todos los clientes a la vista
    public function clientes(){

        $clientes_morales = DB::table('clients')
            ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
            ->select('clients.id', 'clients.tipoPersona', 'moral_people.diasCredito', 'moral_people.telefono', 'moral_people.nombre', 'moral_people.email as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.rfcFacturacion')
            ->get();

        $clientes_fisicos = DB::table('clients')
            ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
            ->select( 'clients.id', 'clients.tipoPersona', 'physical_people.diasCredito', 'physical_people.telefono', 'physical_people.nombre', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.rfcFacturacion')
            ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        return json_encode($clientes);
    }

    public function pdfMesaBocadillos($id){
        $date = Carbon::now();
        $Pago = Payment::orderBy('id', 'DESC')->where('id', $id)->first();
        $Pagos = Payment::orderBy('id', 'DESC')->where('budget_id', $Pago->budget_id)->whereTime('created_at', '<', $Pago->created_at)->orWhereDate('created_at', '<', $Pago->created_at)->where('budget_id', $Pago->budget_id)->get();
        $Budget = Budget::orderBy('id', 'DESC')->where('id', $Pago->budget_id)->first();
        $cliente = Client::orderBy('id', 'DESC')->where('id', $Budget->client_id)->first();
        

        if($cliente->tipoPersona=='FISICA'){
            $cliente = PhysicalPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }else{
            $cliente = MoralPerson::orderBy('id', 'DESC')->where('client_id', $cliente->id)->first();
        }
        
        

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.recibo_pago', compact('Pago', 'Budget', 'cliente', 'Pagos'));

        return $pdf->stream();
    }

    public function store(Request $request){
    
        if($request->presupuesto['tipoEvento'] == 'INTERNO'){
            $fecha = $request->presupuesto['fechaEvento'];
            $evento = Budget::orderBy('id', 'DESC')->where('tipoEvento', 'INTERNO')->where('fechaEvento', $fecha)->first();

            if(!is_null($evento)){
                return 1;
            }
        }
        

        $ultimoFolio = Budget::orderBy('id', 'DESC')->first();
        
        //$ultimoFolio = 'NM10000';
        if(!is_null($ultimoFolio)){
            $numero = explode('M', $ultimoFolio->folio);
            if($request->presupuesto['tipoEvento'] == 'INTERNO'){
                $folio = 'SM'.($numero[1] + 1);
            }else{
                $folio = 'NM'.($numero[1] + 1);
            }
        }else{
            $numero = 0;
            if($request->presupuesto['tipoEvento'] == 'INTERNO'){
                $folio = 'SM'.($numero + 1);
            }else{
                $folio = 'NM'.($numero + 1);
            }
        }
        
        $presupuesto = new Budget();

        $presupuesto->folio             = $folio;
        $presupuesto->tipo              = $request->presupuesto['tipo'];
        $presupuesto->vendedor_id       = $request->presupuesto['vendedor_id'];
        $presupuesto->client_id         = $request->presupuesto['client_id'];
        $presupuesto->tipoEvento        = $request->presupuesto['tipoEvento'];
        $presupuesto->tipoServicio      = $request->presupuesto['tipoServicio'];
        $presupuesto->categoriaEvento   = $request->presupuesto['categoriaEvento'];
        $presupuesto->requiereFactura   = $request->presupuesto['requiereFactura'];
        $presupuesto->requiereMontaje   = $request->presupuesto['requiereMontaje'];
        $presupuesto->fechaEvento       = $request->presupuesto['fechaEvento'];
        $presupuesto->pendienteFecha    = $request->presupuesto['pendienteFecha'];
        $presupuesto->horaEventoInicio  = $request->presupuesto['horaEventoInicio'];
        $presupuesto->horaEventoFin     = $request->presupuesto['horaEventoFin'];
        $presupuesto->pendienteHora     = $request->presupuesto['pendienteHora'];
        $presupuesto->lugarEvento       = $request->presupuesto['lugarEvento'];
        $presupuesto->pendienteLugar    = $request->presupuesto['pendienteLugar'];
        $presupuesto->nombreLugar       = $request->presupuesto['nombreLugar'];
        $presupuesto->direccionLugar    = $request->presupuesto['direccionLugar'];
        $presupuesto->numeroLugar       = $request->presupuesto['numeroLugar'];
        $presupuesto->coloniaLugar      = $request->presupuesto['coloniaLugar'];
        $presupuesto->CPLugar           = $request->presupuesto['CPLugar'];
        $presupuesto->observacionesLugar = $request->presupuesto['observacionesLugar'];
        $presupuesto->numeroInvitados   = $request->presupuesto['numeroInvitados'];
        $presupuesto->colorEvento       = $request->presupuesto['colorEvento'];
        $presupuesto->temaEvento        = $request->presupuesto['temaEvento'];
        $presupuesto->opcionPrecioUnitario        = $request->presupuesto['opcionPrecioUnitario'];
        $presupuesto->opcionDescripcionPaquete        = $request->presupuesto['opcionDescripcionPaquete'];
        $presupuesto->opcionImagen        = $request->presupuesto['opcionImagen'];
        $presupuesto->opcionPrecio        = $request->presupuesto['opcionPrecio'];
        $presupuesto->opcionDescuento        = $request->presupuesto['opcionDescuento'];
        $presupuesto->opcionIVA         = $request->presupuesto['opcionIVA'];
        $presupuesto->impresion         = $request->presupuesto['impresion'];
        $presupuesto->emailEnvio         = $request->presupuesto['emailEnvio'];
        $presupuesto->inicioAmPm         = $request->presupuesto['inicioAmPm'];
        $presupuesto->finAmPm         = $request->presupuesto['finAmPm'];

        if($request->presupuesto['tipo'] == 'CONTRATO'){
            $presupuesto->horaInicio                = $request->facturacion['horaInicio'];
            $presupuesto->horaFin                   = $request->facturacion['horaFin'];
            $presupuesto->horaEntrega               = $request->facturacion['horaEntrega'];
            $presupuesto->fechaRecoleccion          = $request->facturacion['fechaRecoleccion'];
            $presupuesto->horaRecoleccion           = $request->facturacion['horaRecoleccion'];
            $presupuesto->recoleccionPreferente     = $request->facturacion['recoleccionPreferente'];
            $presupuesto->notasFacturacion          = $request->facturacion['notasFacturacion'];
            $presupuesto->nombreFacturacion         = $request->facturacion['nombreFacturacion'];
            $presupuesto->direccionFacturacion      = $request->facturacion['direccionFacturacion'];
            $presupuesto->numeroFacturacion         = $request->facturacion['numeroFacturacion'];
            $presupuesto->coloniaFacturacion        = $request->facturacion['coloniaFacturacion'];
            $presupuesto->emailFacturacion          = $request->facturacion['emailFacturacion'];
            $presupuesto->rfcFacturacion            = $request->facturacion['rfcFacturacion'];
            $presupuesto->entregaEnBodega           = $request->facturacion['entregaEnBodega'];
        }
        $presupuesto->version = $request->presupuesto['version'];
        $presupuesto->comision = $request->presupuesto['comision'];
        $presupuesto->total = $request->presupuesto['total'];
        $presupuesto->notasPresupuesto = $request->presupuesto['notasPresupuesto'];
        $presupuesto->quienEdito = Auth::user()->name;
        $presupuesto->save();

        $ultimoPresupuesto = Budget::orderBy('id', 'DESC')->first();

        foreach ($request->festejados as $item) {
           $festejado = new Celebrated();

           $festejado->budget_id    = $ultimoPresupuesto->id;
           $festejado->client_id    = $ultimoPresupuesto->client_id;
           $festejado->nombre       = $item['nombre'];
           $festejado->edad         = $item['edad'];
           $festejado->version      = $ultimoPresupuesto->version;
           $festejado->save();
        }

        foreach($request->inventario as $item){
            if($item['tipo'] == 'PRODUCTO'){
                $producto = new BudgetInventory();

                $producto->budget_id = $ultimoPresupuesto->id;
                
                //$producto->imagen = $item['imagen'];
                $producto->servicio = $item['servicio'];
                $producto->cantidad = $item['cantidad'];
                $producto->precioUnitario = $item['precioUnitario'];
                $producto->precioFinal = $item['precioFinal'];
                $producto->precioVenta = $item['precioVenta'];
                $producto->precioEspecial = $item['precioEspecial'];
                $producto->precioAnterior = $item['precioAnterior'];
                $producto->ahorro = $item['ahorro'];
                $producto->notas = $item['notas'];
                $producto->externo = $item['externo'];
                $producto->proveedor = $item['proveedor'];
                if($item['externo']){
                    $producto->guardarInventario = $item['autorizado'];

                    //Otra Imagen
                    if($item['imagen']){

                        $image = $item['imagen'];
                        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                        \Image::make($item['imagen'])->save(public_path('presupuesto/').$name);
                        $producto->fill(['imagen' => asset('presupuesto/'.$name)]);
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }else{
                        $producto->imagen = 'http://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }
                }else{
                    if($item['imagen']){
                        $producto->imagen = $item['imagen'];
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }else{
                        $producto->imagen = 'http://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }
                    
                }
                
                //Este metodo es para reducir de nuestra tabla inventarios la cantidad disponible del producto
                if(!$item['externo']){
                    $producto = Inventory::find($item['id']);
                    $producto->disponible = ($producto->disponible) - ($item['cantidad']);
                    $producto->save();
                }

            }else{
                $paquete = new BudgetPack();

                $paquete->budget_id = $ultimoPresupuesto->id;
                $paquete->servicio = $item['servicio'];
                $paquete->cantidad = $item['cantidad'];
                $paquete->precioUnitario = $item['precioUnitario'];
                $paquete->precioFinal = $item['precioFinal'];
                $paquete->precioVenta = $item['precioVenta'];
                $paquete->precioEspecial = $item['precioEspecial'];
                $paquete->precioAnterior = $item['precioAnterior'];
                $paquete->ahorro = $item['ahorro'];
                $paquete->notas = $item['notas'];
                $paquete->categoria = $item['paquete']['categoria'];
                $paquete->guardarPaquete = $item['paquete']['guardarPaquete'];
                $paquete->version = $ultimoPresupuesto->version;
                $paquete->save();

                $ultimoPack = BudgetPack::orderBy('id', 'DESC')->pluck('id')->first();

                    foreach($item['paquete']['inventario'] as $objeto){
                        $producto = new BudgetPackInventory();

                        $producto->budget_pack_id = $ultimoPack;
                        
                        $producto->servicio = $objeto['nombre'];
                        $producto->cantidad = $objeto['cantidad'];
                        $producto->precioUnitario = $objeto['precioUnitario'];
                        $producto->precioFinal = $objeto['precioFinal'];
                        $producto->precioVenta = $objeto['precioVenta'];
                        $producto->precioEspecial = $objeto['precioEspecial'];
                        $producto->precioAnterior = $objeto['precioAnterior'];
                        $producto->externo = $objeto['externo'];
                        $producto->proveedor = $objeto['proveedor'];
                        if($objeto['externo']){
                            $producto->guardarInventario = $objeto['autorizado'];
                            //Otra Imagen
                            if($objeto['imagen']){
        
                                $image = $objeto['imagen'];
                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                                \Image::make($objeto['imagen'])->save(public_path('paquete/').$name);
                                $producto->fill(['imagen' => asset('paquete/'.$name)])->save();
                            }else{
                                $producto->imagen = 'http://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                                $producto->save();
                            }
                        }else{
                            if($objeto['imagen']){
                                $producto->imagen = $objeto['imagen'];
                                $producto->save();
                            }else{
                                $producto->imagen = 'http://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                                $producto->save();
                            }
                            
                        }
                    }
            }
        }

    }

    public function obtenerUltimoPresupuesto(){
        return Budget::orderBy('id', 'DESC')->first();
    }

    public function pdf($id){        

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->impresion = 1;
        $presupuesto->save();

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        //Obtenemos los paquetes
        $Paquetes= BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        $arregloFamilias = [];

        foreach($Elementos as $item){
            
            $element = Inventory::where('servicio', $item->servicio)->first();
            if(is_null($element)){
                array_push($arregloFamilias, 'General');
            }else{
            array_push($arregloFamilias, $element->familia);}
        }

        foreach($Paquetes as $paquete){
            $elements = BudgetPackInventory::where('budget_pack_id', $paquete->id)->get();
            foreach($elements as $element){
                $producto = Inventory::where('servicio', $element->servicio)->first();
                if(is_null($producto)){
                    array_push($arregloFamilias, 'General');
                }else{
                array_push($arregloFamilias, $producto->familia);}
           
            }
        }

        $arregloGrupos = [];

        $familias = array_unique($arregloFamilias);
        foreach ($familias as $familia) {
            $family = Family::where('nombre', $familia)->first();
            if(!is_null($family)){
                $group = FamilyGroup::where('nombre', $family->grupo)->first();
                if(!is_null($group)){
                    array_push($arregloGrupos, $group);
                }
            }  
        }  
        
        $grupos = array_unique($arregloGrupos);

        $arregloEmentos=[];
        foreach($Paquetes as $paquete){
            $Elementos_paquete= BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $paquete->id)->get();
            foreach($Elementos_paquete as $Elemento_paquete){
                $arregloElemento   = new stdClass();
                $arregloElemento->imagen = $Elemento_paquete->imagen;
                $arregloElemento->servicio = $Elemento_paquete->servicio;
                $arregloElemento->cantidad = $Elemento_paquete->cantidad;
                $arregloElemento->notas = $Elemento_paquete->notas;
                $arregloElemento->budget_pack_id = $Elemento_paquete->budget_pack_id;
                array_push($arregloEmentos,$arregloElemento);
            }
           
        }
       // dd($Elemento_paquete);

         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito', 'moral_people.diasCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito', 'physical_people.diasCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }

        $otroArray = [];
        foreach($familias as $familia){
            $item = Family::where('nombre', $familia)->first();
            if(is_null($item)){}else{
            array_push($otroArray, $item);}
        }

        $demo = collect($otroArray);

        //dd($demo);

        



        //dd($demo);

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.budget', compact('presupuesto', 'Telefonos', 'Elementos', 'Paquetes', 'arregloEmentos', 'demo', 'grupos'));

        return $pdf->stream();

    }

    public function pdfVentas($id){        

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        //Obtenemos los paquetes
        $Paquetes= BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        $arregloFamilias = [];

        foreach($Elementos as $item){
            
            $element = Inventory::where('servicio', $item->servicio)->first();
            if(is_null($element)){
                array_push($arregloFamilias, 'General');
            }else{
            array_push($arregloFamilias, $element->familia);}
        }

        foreach($Paquetes as $paquete){
            $elements = BudgetPackInventory::where('budget_pack_id', $paquete->id)->get();
            foreach($elements as $element){
                $producto = Inventory::where('servicio', $element->servicio)->first();
                if(is_null($producto)){
                    array_push($arregloFamilias, 'General');
                }else{
                array_push($arregloFamilias, $producto->familia);}
           
            }
        }

        $familias = array_unique($arregloFamilias);

        $arregloEmentos=[];
        foreach($Paquetes as $paquete){
            $Elementos_paquete= BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $paquete->id)->get();
            foreach($Elementos_paquete as $Elemento_paquete){
                $arregloElemento   = new stdClass();
                $arregloElemento->imagen = $Elemento_paquete->imagen;
                $arregloElemento->servicio = $Elemento_paquete->servicio;
                $arregloElemento->cantidad = $Elemento_paquete->cantidad;
                $arregloElemento->notas = $Elemento_paquete->notas;
                $arregloElemento->budget_pack_id = $Elemento_paquete->budget_pack_id;
                array_push($arregloEmentos,$arregloElemento);
            }
           
        }
       // dd($Elemento_paquete);

         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito', 'moral_people.diasCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito', 'physical_people.diasCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->diasCredito=$cliente->diasCredito;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }

        $otroArray = [];
        foreach($familias as $familia){
            $item = Family::where('nombre', $familia)->first();
            if(is_null($item)){}else{
            array_push($otroArray, $item);}
        }

        $demo = collect($otroArray);

        //dd($demo);

        



        //dd($demo);

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.budgetVendedor', compact('presupuesto', 'Telefonos', 'Elementos', 'Paquetes', 'arregloEmentos', 'demo'));

        return $pdf->stream();

    }

    public function pdfBodega($id){        

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->impresionBodega = 1;
        $presupuesto->save();

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'ASC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();
        
        //Obtenemos los paquetes
        $Paquetes= BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        
        $arregloEmentos=[];
        foreach($Paquetes as $paquete){
            $Elementos_paquete= BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $paquete->id)->get();
            foreach($Elementos_paquete as $Elemento_paquete){
                $arregloElemento   = new stdClass();
                $arregloElemento->imagen = $Elemento_paquete->imagen;
                $arregloElemento->servicio = $Elemento_paquete->servicio;
                $arregloElemento->cantidad = $Elemento_paquete->cantidad;
                $arregloElemento->notas = $Elemento_paquete->notas;
                $arregloElemento->budget_pack_id = $Elemento_paquete->budget_pack_id;
                array_push($arregloEmentos,$arregloElemento);
            }
           
        }
       // dd($Elemento_paquete);

         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }

        $DatosPresupuesto = 0;



        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.budgetBodega', compact('presupuesto', 'DatosPresupuesto', 'Telefonos', 'Elementos', 'Paquetes', 'arregloEmentos'));

        return $pdf->stream();

    }


    public function obtenerDisponibles(Request $request){
        $data = json_decode(file_get_contents('php://input'), true);
        if($data['fecha']!=''){
        $budgets = Budget::whereDate('fechaEvento', $data['fecha'])->get();

        $producto = Inventory::orderBy('id', 'ASC')->where('servicio', $data['id'])->first();
        $disponible=$producto->cantidad+$producto->exhibicion;

    //segunda opcion
    foreach($budgets as $budget){
        $elementos = BudgetInventory::orderBy('id', 'ASC')->where('budget_id', $budget->id)->where('version', $budget->version)->get();
        foreach($elementos as $elemento){
            if($elemento->servicio==$data['id']){
                $disponible=$disponible-$elemento->cantidad;
            }
        }
    }

        
        }else{
            $disponible='Sin información de fecha';
        }
        return $disponible;
    }

    public function pdfRecolecciones(){        
        $fecha1 = $_GET['fecha_1'];
        $fecha2 = $_GET['fecha_2'];
        
        $presupuestos = Budget::orderBy('id', 'ASC')->where('tipo', 'CONTRATO')->whereDate('fechaEvento','>=', $fecha1)->WhereDate('fechaEvento','<=', $fecha2)->get();
        //dd($presupuestos);
        $pdf = App::make('dompdf');
        $pdf = PDF::loadView('pdf.recolecciones', compact('presupuestos'));
        return $pdf->stream();
    }

    public function pdfBodegaCliente($id){        

        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $presupuesto->impresionBodega = 1;
        $presupuesto->save();

        $Vendedor = User::orderBy('id', 'DESC')->where('id', $presupuesto->vendedor_id)->first();
        $presupuesto->vendedor = $Vendedor->name;
        $Telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $presupuesto->client_id)->get();
       
        //Obtenemos los elementos que pertenecen al inventario
        $Elementos= BudgetInventory::orderBy('id', 'ASC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();
        
        //Obtenemos los paquetes
        $Paquetes= BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->id)->where('version', $presupuesto->version)->get();

        
        $arregloEmentos=[];
        foreach($Paquetes as $paquete){
            $Elementos_paquete= BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $paquete->id)->get();
            foreach($Elementos_paquete as $Elemento_paquete){
                $arregloElemento   = new stdClass();
                $arregloElemento->imagen = $Elemento_paquete->imagen;
                $arregloElemento->servicio = $Elemento_paquete->servicio;
                $arregloElemento->cantidad = $Elemento_paquete->cantidad;
                $arregloElemento->notas = $Elemento_paquete->notas;
                $arregloElemento->budget_pack_id = $Elemento_paquete->budget_pack_id;
                array_push($arregloEmentos,$arregloElemento);
            }
           
        }
       // dd($Elemento_paquete);

         //Obtenemos clientes morales y fisicos
         $clientes_morales = DB::table('clients')
         ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
         ->select('clients.id', 'moral_people.nombre', 'moral_people.nombre as apellidoPaterno','moral_people.nombre as apellidoMaterno', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion', 'moral_people.tipoCredito')
         ->get();
 
         $clientes_fisicos = DB::table('clients')
         ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
         ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.tipoCredito')
         ->get();
         
         $clientes = $clientes_morales->merge($clientes_fisicos);

         //formato de minusculas
         $presupuesto->tipoEvento=ucfirst(strtolower($presupuesto->tipoEvento));
         $presupuesto->tipoServicio=ucfirst(strtolower($presupuesto->tipoServicio));

         //Definimos la categoria del evento
         switch($presupuesto->categoriaEvento){
            case 1:
            $presupuesto->categoria="XV años";
            break;
            case 2:
            $presupuesto->categoria="Aniversario";
            break;
            case 3:
            $presupuesto->categoria="Cumpleaños";
            break;
            case 4:
            $presupuesto->categoria="Graduación";
            break;
            case 5:
            $presupuesto->categoria="Cena de Gala";
            break;
            case 6:
            $presupuesto->categoria="Otro";
            break;

        }
        
        //Obtener datos generales del cliente
         foreach($clientes as $cliente){
             if($presupuesto->client_id == $cliente->id){
                 if($cliente->apellidoPaterno==$cliente->nombre){
                $presupuesto->cliente=$cliente->nombre;
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
                 }else{
                $presupuesto->cliente=$cliente->nombre." ".$cliente->apellidoPaterno." ".$cliente->apellidoMaterno;}
                $presupuesto->emailCliente=$cliente->email;
                $presupuesto->creditoCliente=$cliente->tipoCredito;
            }
         }

        $DatosPresupuesto = 0;



        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.budgetBodega2', compact('presupuesto', 'DatosPresupuesto', 'Telefonos', 'Elementos', 'Paquetes', 'arregloEmentos'));

        return $pdf->stream();

    }

    public function obtenerPresupuesto($id){
        return Budget::with('client')->orderBy('id', 'DESC')->where('id', $id)->first();
    }

    public function obtenerFestejados($id){
        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        return Celebrated::orderBy('id', 'DESC')->where('budget_id', $id)->where('version', $presupuesto->version)->get();
    }

    public function obtenerInventario1($id){
        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        return BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $id)->where('version', $presupuesto->version)->get();
    }

    public function obtenerPaquetes($id){
        $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        return BudgetPack::orderBy('id', 'DESC')->where('budget_id', $id)->where('version', $presupuesto->version)->get();
    }

    public function obtenerTotalComision($id){
        $Budget = Budget::orderBy('id', 'DESC')->where('id', $id)->first();
        $BudgetInventory = BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $id)->where('version', $Budget->version)->get();
        $budgetPack = BudgetPack::orderBy('id', 'DESC')->where('budget_id', $id)->get();
        $comision = Commission::orderBy('id', 'DESC')->first();
        $totalComisionable = 0;
        $arregloComisiones=[];
        $totalComision=0;
        if($Budget->total > $comision->minimoVentaComision){
        foreach($BudgetInventory as $element){
            $totalComisionable = $totalComisionable + ($element->cantidad*$element->precioEspecial) - ($element->cantidad*$element->precioVenta);
        }
        $totalComision=$comision->comisionContrato;
    }
        $arregloComisiones=[$totalComisionable, $totalComision, $comision->minimoVentaComision];
  
        return $arregloComisiones;
    }

    public function obtenerElementosPaquetes($id){
        return BudgetPackInventory::orderBy('id', 'DESC')->where('budget_pack_id', $id)->get();
    }


    //Versiones
    public function storeVersion(Request $request){

        if($request->guardarVersion){
            $version = Budget::orderBy('id', 'DESC')->where('id', $request->presupuesto['budget_id'])->first();
        }else{
            $version = Budget::orderBy('id', 'DESC')->where('id', $request->presupuesto['id'])->first(); 
        }
        //$version = Budget::orderBy('id', 'DESC')->where('id', $request->presupuesto['id'])->first();
        //dd($version);

        //Generamos una copia del budget original y la guardamos en versiones
        $oldVersion = new BudgetVersion();
        $oldVersion->budget_id = $version->id;
        $oldVersion->folio = $version->folio;
        $oldVersion->tipo = $version->tipo;
        $oldVersion->vendedor_id = $version->vendedor_id;
        $oldVersion->client_id = $version->client_id;
        $oldVersion->tipoEvento = $version->tipoEvento;
        $oldVersion->tipoServicio = $version->tipoServicio;
        $oldVersion->categoriaEvento = $version->categoriaEvento;
        $oldVersion->requiereFactura = $version->requiereFactura;
        $oldVersion->requiereMontaje = $version->requiereMontaje;
        $oldVersion->fechaEvento = $version->fechaEvento;
        $oldVersion->pendienteFecha = $version->pendienteFecha;
        $oldVersion->horaEventoInicio = $version->horaEventoInicio;
        $oldVersion->horaEventoFin = $version->horaEventoFin;
        $oldVersion->pendienteHora = $version->pendienteHora;
        $oldVersion->lugarEvento = $version->lugarEvento;
        $oldVersion->pendienteLugar = $version->pendienteLugar;
        $oldVersion->nombreLugar = $version->nombreLugar;
        $oldVersion->direccionLugar = $version->direccionLugar;
        $oldVersion->numeroLugar = $version->numeroLugar;
        $oldVersion->coloniaLugar = $version->coloniaLugar;
        $oldVersion->CPLugar = $version->CPLugar;
        $oldVersion->observacionesLugar = $version->observacionesLugar;
        $oldVersion->numeroInvitados = $version->numeroInvitados;
        $oldVersion->colorEvento = $version->colorEvento;
        $oldVersion->temaEvento = $version->temaEvento;
        $oldVersion->opcionPrecio = $version->opcionPrecio;
        $oldVersion->opcionPrecioUnitario = $version->opcionPrecioUnitario;
        $oldVersion->opcionDescripcionPaquete = $version->opcionDescripcionPaquete;
        $oldVersion->opcionImagen = $version->opcionImagen;
        $oldVersion->opcionDescuento = $version->opcionDescuento;
        $oldVersion->opcionIVA = $version->opcionIVA;
        $oldVersion->emailEnvio = $version->emailEnvio;
        $oldVersion->inicioAmPm = $version->inicioAmPm;
        $oldVersion->finAmPm = $version->finAmPm;
        
        $oldVersion->horaInicio = $version->horaInicio;
        $oldVersion->horaFin = $version->horaFin;
        $oldVersion->horaEntrega = $version->horaEntrega;
        $oldVersion->fechaRecoleccion = $version->fechaRecoleccion;
        $oldVersion->notasFacturacion = $version->notasFacturacion;
        $oldVersion->nombreFacturacion = $version->nombreFacturacion;
        $oldVersion->direccionFacturacion = $version->direccionFacturacion;
        $oldVersion->numeroFacturacion = $version->numeroFacturacion;
        $oldVersion->coloniaFacturacion = $version->coloniaFacturacion;
        $oldVersion->emailFacturacion = $version->emailFacturacion;
        $oldVersion->entregaEnBodega = $version->entregaEnBodega;
        
        $oldVersion->impresion = $version->impresion;
        $oldVersion->budget_id = $version->id;
        $oldVersion->version = $version->version;
        $oldVersion->comision = $version->comision;
        $oldVersion->total = $version->total;
        $oldVersion->notasPresupuesto = $version->notasPresupuesto;
        $oldVersion->quienEdito = $version->quienEdito;
        $oldVersion->save();

        //Obtenemos el budget original
        if($request->guardarVersion){
            $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $request->presupuesto['budget_id'])->first();
        }else{
            $presupuesto = Budget::orderBy('id', 'DESC')->where('id', $request->presupuesto['id'])->first();  
        }

        //Editamos el budget original y lo actualizamos con los nuevos datos
        $presupuesto->folio             = $request->presupuesto['folio'];
        $presupuesto->tipo              = $request->presupuesto['tipo'];
        $presupuesto->vendedor_id       = $request->presupuesto['vendedor_id'];
        $presupuesto->client_id         = $request->presupuesto['client_id'];
        $presupuesto->tipoEvento        = $request->presupuesto['tipoEvento'];
        $presupuesto->tipoServicio      = $request->presupuesto['tipoServicio'];
        $presupuesto->categoriaEvento   = $request->presupuesto['categoriaEvento'];
        $presupuesto->requiereFactura   = $request->presupuesto['requiereFactura'];
        $presupuesto->requiereMontaje   = $request->presupuesto['requiereMontaje'];
        $presupuesto->fechaEvento       = $request->presupuesto['fechaEvento'];
        $presupuesto->pendienteFecha    = $request->presupuesto['pendienteFecha'];
        $presupuesto->horaEventoInicio  = $request->presupuesto['horaEventoInicio'];
        $presupuesto->horaEventoFin     = $request->presupuesto['horaEventoFin'];
        $presupuesto->pendienteHora     = $request->presupuesto['pendienteHora'];
        $presupuesto->lugarEvento       = $request->presupuesto['lugarEvento'];
        $presupuesto->pendienteLugar    = $request->presupuesto['pendienteLugar'];
        $presupuesto->nombreLugar       = $request->presupuesto['nombreLugar'];
        $presupuesto->direccionLugar    = $request->presupuesto['direccionLugar'];
        $presupuesto->numeroLugar       = $request->presupuesto['numeroLugar'];
        $presupuesto->coloniaLugar      = $request->presupuesto['coloniaLugar'];
        $presupuesto->CPLugar           = $request->presupuesto['CPLugar'];
        $presupuesto->observacionesLugar = $request->presupuesto['observacionesLugar'];
        $presupuesto->numeroInvitados   = $request->presupuesto['numeroInvitados'];
        $presupuesto->colorEvento       = $request->presupuesto['colorEvento'];
        $presupuesto->temaEvento        = $request->presupuesto['temaEvento'];
        $presupuesto->opcionPrecioUnitario        = $request->presupuesto['opcionPrecioUnitario'];
        $presupuesto->opcionDescripcionPaquete        = $request->presupuesto['opcionDescripcionPaquete'];
        $presupuesto->opcionImagen        = $request->presupuesto['opcionImagen'];
        $presupuesto->opcionPrecio        = $request->presupuesto['opcionPrecio'];
        $presupuesto->opcionDescuento        = $request->presupuesto['opcionDescuento'];
        $presupuesto->opcionIVA         = $request->presupuesto['opcionIVA'];
        $presupuesto->impresion         = $request->presupuesto['impresion'];
        $presupuesto->notasPresupuesto         = $request->presupuesto['notasPresupuesto'];
        $presupuesto->emailEnvio         = $request->presupuesto['emailEnvio'];
        $presupuesto->inicioAmPm         = $request->presupuesto['inicioAmPm'];
        $presupuesto->finAmPm         = $request->presupuesto['finAmPm'];
        
        
        
        
       
        if($request->presupuesto['tipo'] == 'CONTRATO'){
            
            $presupuesto->horaInicio                = $request->presupuesto['horaInicio'];
            $presupuesto->horaFin                   = $request->presupuesto['horaFin'];
            $presupuesto->horaEntrega               = $request->presupuesto['horaEntrega'];
            $presupuesto->fechaRecoleccion          = $request->presupuesto['fechaRecoleccion'];
            $presupuesto->horaRecoleccion           = $request->presupuesto['horaRecoleccion'];
            $presupuesto->recoleccionPreferente     = $request->presupuesto['recoleccionPreferente'];
            $presupuesto->notasFacturacion          = $request->presupuesto['notasFacturacion'];
            $presupuesto->nombreFacturacion         = $request->presupuesto['nombreFacturacion'];
            $presupuesto->direccionFacturacion      = $request->presupuesto['direccionFacturacion'];
            $presupuesto->numeroFacturacion         = $request->presupuesto['numeroFacturacion'];
            $presupuesto->coloniaFacturacion        = $request->presupuesto['coloniaFacturacion'];
            $presupuesto->emailFacturacion          = $request->presupuesto['emailFacturacion'];
            $presupuesto->rfcFacturacion            = $request->presupuesto['rfcFacturacion'];
            $presupuesto->entregaEnBodega           = $request->presupuesto['entregaEnBodega'];

            if($version->total!=$presupuesto->total){
            $presupuesto->pagado                    = false;}


            if($request->presupuesto['impresionBodega'] == 1){
                $presupuesto->impresionBodega = 2;
                $presupuesto->fechaEdicion = Carbon::now();
            }
        }
        $presupuesto->comision = $request->presupuesto['comision'];
        $presupuesto->total = $request->presupuesto['total'];
        $presupuesto->version = ($presupuesto->version) + 1;
        $presupuesto->quienEdito = Auth::user()->name;
        $presupuesto->save();

        //Buscamos el ultimo presupuesto actualizado guardado


        $ultimoPresupuesto = $presupuesto;

        //Por cada festejado en el arreglo que mandamos le agregamos el id del budget y lo guardamos.
        foreach ($request->festejados as $item) {
           $festejado = new Celebrated();

           $festejado->budget_id    = $ultimoPresupuesto->id;
           $festejado->client_id    = $ultimoPresupuesto->client_id;
           $festejado->nombre       = $item['nombre'];
           $festejado->edad         = $item['edad'];
           $festejado->version      = $ultimoPresupuesto->version;
           $festejado->save();
        }

        //Por cada inventario en el arreglo que mandamos le agregamos el id del budget y lo guardamos
        foreach($request->inventario as $item){
            if($item['tipo'] == 'PRODUCTO'){
                $producto = new BudgetInventory();
                $producto->budget_id = $ultimoPresupuesto->id;
                $producto->servicio = $item['servicio'];
                $producto->cantidad = $item['cantidad'];
                $producto->precioUnitario = $item['precioUnitario'];
                $producto->precioEspecial = $item['precioEspecial'];
                $producto->precioAnterior = $item['precioAnterior'];
                $producto->precioFinal = $item['precioFinal'];
                $producto->precioVenta = $item['precioVenta'];
                $producto->precioEspecial = $item['precioEspecial'];
                $producto->ahorro = $item['ahorro'];
                $producto->notas = $item['notas'];
                $producto->externo = $item['externo'];
                $producto->proveedor = $item['proveedor'];

                //Si el producto es externo
                if($item['externo']){
                    //Guardamos la imagen si lleva una
                    if($item['imagen']){
                        //Hacemos un explode de imagen para saber si es base64 o no
                        $miArray = explode('/', $item['imagen']);
                        if($miArray[0] == 'data:image'){
                            $image = $item['imagen'];
                            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                            \Image::make($item['imagen'])->save(public_path('presupuesto/').$name);
                            $producto->fill(['imagen' => asset('presupuesto/'.$name)]);
                            $producto->version = $ultimoPresupuesto->version;
                            $producto->save();
                        }else{
                            $producto->imagen = $item['imagen'];
                            $producto->version = $ultimoPresupuesto->version;
                            $producto->save();
                        }
                        
                    }else{
                        $producto->imagen = 'https://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save(); 
                    }
                }else{
                    if($item['imagen']){
                        $producto->imagen = $item['imagen'];
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }else{
                        $producto->imagen = 'https://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }
                    
                }

            }else{

                //Si el inventario es paquete hacemos el mismo recorrido
                $paquete = new BudgetPack();
                $paquete->budget_id = $ultimoPresupuesto->id;
                $paquete->servicio = $item['servicio'];
                $paquete->cantidad = $item['cantidad'];
                $paquete->precioUnitario = $item['precioUnitario'];
                $paquete->precioEspecial = $item['precioEspecial'];
                $paquete->precioAnterior = $item['precioAnterior'];
                $paquete->precioFinal = $item['precioFinal'];
                $paquete->precioVenta = $item['precioVenta'];
                $paquete->precioEspecial = $item['precioEspecial'];
                $paquete->ahorro = $item['ahorro'];
                $paquete->notas = $item['notas'];
                $paquete->categoria = $item['paquete']['categoria'];
                $paquete->guardarPaquete = $item['paquete']['guardarPaquete'];
                $paquete->version = $ultimoPresupuesto->version;
                $paquete->save();

                //Obtenemos el ultimo paquete guardado
                $ultimoPack = BudgetPack::orderBy('id', 'DESC')->pluck('id')->first();

                    //Recorremos el arreglo de productos que pertenecen al paquete enviado y lo guardamos
                    foreach($item['paquete']['inventario'] as $objeto){
                        $producto = new BudgetPackInventory();
                        $producto->budget_pack_id = $ultimoPack;
                        $producto->servicio = $objeto['nombre'];
                        $producto->cantidad = $objeto['cantidad'];
                        $producto->precioUnitario = $objeto['precioUnitario'];
                        $producto->precioEspecial = $objeto['precioEspecial'];
                        $producto->precioAnterior = $objeto['precioAnterior'];
                        $producto->precioFinal = $objeto['precioFinal'];
                        $producto->precioVenta = $objeto['precioVenta'];
                        $producto->precioEspecial = $objeto['precioEspecial'];
                        $producto->externo = $objeto['externo'];
                        $producto->proveedor = $objeto['proveedor'];
                        if($objeto['externo']){
                            //Guardamos la imagen si contiene una
                            if($objeto['imagen']){
                                //Verificamos si la imagen es base64
                                $miArray = explode('/', $objeto['imagen']);
                                if($miArray[0] == 'data:image'){
                                    $image = $objeto['imagen'];
                                    $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                                    \Image::make($objeto['imagen'])->save(public_path('paquete/').$name);
                                    $producto->fill(['imagen' => asset('paquete/'.$name)])->save();
                                }else{
                                    $producto->imagen = $objeto['imagen'];
                                    $producto->save(); 
                                }
                                
                            }else{
                                $producto->imagen = 'https://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                                $producto->save();
                            }
                        }else{
                            if($objeto['imagen']){
                                $producto->imagen = $objeto['imagen'];
                                $producto->save();
                            }else{
                                $producto->imagen = 'https://dubsism.files.wordpress.com/2017/12/image-not-found.png';
                                $producto->save();
                            }
                            
                        }

                        //Al momento de recuperar los productos de los paquetes y almacenarlos en el array de productos
                        //en el componente no estamos recuperando el id del producto de la tabla inventarios, requerimos
                        //recueperar ese id para poder hacer la resta en inventarios.
                        /*
                        if(!$objeto['externo']){
                            //$paquete->inventories()->attach($objeto['id']);                                                       
                            $producto = Inventory::find($objeto['id']);

                            $producto->disponible = ($producto->disponible) - ($objeto['cantidad']);
                            $producto->save();
                            
                        }
                        */
                    }
            }
        }

    }

    public function obtenerClientePresupuesto($id){
        $data = Client::orderBy('id', 'DESC')->where('id', $id)->first();

        if($data->tipoPersona == 'FISICA'){
            return $cliente = PhysicalPerson::where('client_id', $data->id)->first();
        }else{
            return $cliente = MoralPerson::where('client_id', $data->id)->first();
        }
        
    }

    public function verPresupuesto($id){
        return view('verPresupuesto');
    }

    public function getVersions($id){
        return BudgetVersion::orderBy('id', 'DESC')->where('budget_id', $id)->get();
    }

    public function obtenerVersion($id){
        return BudgetVersion::with('client')->where('id', $id)->first();
    }

    public function obtenerFestejadosVersion($id){
        $presupuesto = BudgetVersion::orderBy('id', 'DESC')->where('id', $id)->first();
        return Celebrated::orderBy('id', 'DESC')->where('budget_id', $presupuesto->budget_id)->where('version', $presupuesto->version)->get();
    }

    public function obtenerInventarioVersion1($id){
        $presupuesto = BudgetVersion::orderBy('id', 'DESC')->where('id', $id)->first();
        return BudgetInventory::orderBy('id', 'DESC')->where('budget_id', $presupuesto->budget_id)->where('version', $presupuesto->version)->get();
    }

    public function obtenerPaquetesVersion($id){
        $presupuesto = BudgetVersion::orderBy('id', 'DESC')->where('id', $id)->first();
        return BudgetPack::orderBy('id', 'DESC')->where('budget_id', $presupuesto->budget_id)->where('version', $presupuesto->version)->get();
    }
    public function convertirContrato($id){
        $budget=Budget::find($id);
        $budget->tipo='CONTRATO';
        $budget->save();
        return back();
    }

    public function desarchivar($id){
        $budget=Budget::find($id);
        $budget->archivado='0';
        $budget->save();
        return back();
    }
    public function archivar($id){
        $budget=Budget::find($id);
        $budget->archivado='1';
        $budget->save();
        return back();
    }
    public function facturaEnviada($id){
        $budget=Budget::find($id);
        $budget->fechaEnvioFactura= $date = Carbon::now();
        $budget->facturaSolicitada= 2;
        $budget->save();
        return back();
    }

    public function obtenerInventario($id){
        $presupuesto = Budget::where('id', $id)->first();

        $version = $presupuesto->version - 1;

        if($version <= 0){
            $version = 1;
        }

        $inventarios = BudgetInventory::where('budget_id', $presupuesto->id)->where('version', $version)->get();
        $paquetes = BudgetPack::with('inventories')->where('budget_id', $presupuesto->id)->where('version', $version)->get();
        $inventario = [$inventarios, $paquetes];
        return $inventario;
    }
}
