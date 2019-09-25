<?php

namespace App\Http\Controllers\CMS;

use App\User;
use stdClass;
use App\Budget;
use App\Client;
use App\Inventory;
use App\Telephone;
use App\BudgetPack;
use App\Celebrated;
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
            ->select('clients.id', 'moral_people.telefono', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
            ->get();

        $clientes_fisicos = DB::table('clients')
            ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
            ->select( 'clients.id', 'physical_people.telefono', 'physical_people.nombre', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion', 'physical_people.apellidoPaterno', 'physical_people.apellidoMaterno' )
            ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);

        return json_encode($clientes);
    }

    public function store(Request $request){
    
        if($request->presupuesto['tipoEvento'] == 'INTERNO'){
            $fecha = $request->presupuesto['fechaEvento'];
            $evento = Budget::orderBy('id', 'DESC')->where('fechaEvento', $fecha)->first();
            if(!is_null($evento)){
                return 1;
            }
        }
        

        $ultimoFolio = Budget::orderBy('id', 'DESC')->pluck('folio')->first();
        
        //$ultimoFolio = 'NM10000';
        if(!is_null($ultimoFolio)){
            $numero = explode('M', $ultimoFolio);

            if($request->presupuesto['tipoEvento'] == 'INTERNO'){
                $folio = 'M'.($numero[1] + 1);
            }else{
                $folio = 'NM'.($numero[1] + 1);
            }
        }else{
            $numero = 0;
            if($request->presupuesto['tipoEvento'] == 'INTERNO'){
                $folio = 'M'.($numero + 1);
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

        if($request->presupuesto['tipo'] == 'CONTRATO'){
            $presupuesto->horaInicio                = $request->facturacion['horaInicio'];
            $presupuesto->horaFin                   = $request->facturacion['horaFin'];
            $presupuesto->horaEntrega               = $request->facturacion['horaEntrega'];
            $presupuesto->fechaRecoleccion          = $request->facturacion['fechaRecoleccion'];
            $presupuesto->notasFacturacion          = $request->facturacion['notasFacturacion'];
            $presupuesto->nombreFacturacion         = $request->facturacion['nombreFacturacion'];
            $presupuesto->direccionFacturacion      = $request->facturacion['direccionFacturacion'];
            $presupuesto->numeroFacturacion         = $request->facturacion['numeroFacturacion'];
            $presupuesto->coloniaFacturacion        = $request->facturacion['coloniaFacturacion'];
            $presupuesto->emailFacturacion          = $request->facturacion['emailFacturacion'];
        }
        $presupuesto->version = $request->presupuesto['version'];
        $presupuesto->comision = $request->presupuesto['comision'];
        $presupuesto->total = $request->presupuesto['total'];
        $presupuesto->notasPresupuesto = $request->presupuesto['notasPresupuesto'];
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
                $producto->ahorro = $item['ahorro'];
                $producto->notas = $item['notas'];
                $producto->externo = $item['externo'];
                $producto->proveedor = $item['proveedor'];
                if($item['externo']){
                    //Otra Imagen
                    if($item['imagen']){

                        $image = $item['imagen'];
                        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                        \Image::make($item['imagen'])->save(public_path('presupuesto/').$name);
                        $producto->fill(['imagen' => asset('presupuesto/'.$name)]);
                        $producto->version = $ultimoPresupuesto->version;
                        $producto->save();
                    }
                }else{
                    $producto->imagen = $item['imagen'];
                    $producto->version = $ultimoPresupuesto->version;
                    $producto->save();
                }
                
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
                        $producto->externo = $objeto['externo'];
                        $producto->proveedor = $objeto['proveedor'];
                        if($objeto['externo']){
                            //Otra Imagen
                            if($objeto['imagen']){
        
                                $image = $objeto['imagen'];
                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                                \Image::make($objeto['imagen'])->save(public_path('paquete/').$name);
                                $producto->fill(['imagen' => asset('paquete/'.$name)])->save();
                            }
                        }else{
                            $producto->imagen = $objeto['imagen'];
                            $producto->save();
                        }

                        
                        if(!$objeto['externo']){
                            //$paquete->inventories()->attach($objeto['id']);                                                       
                            $producto = Inventory::find($objeto['id']);

                            $producto->disponible = ($producto->disponible) - ($objeto['cantidad']);
                            $producto->save();
                            
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

        $pdf = App::make('dompdf');

        $pdf = PDF::loadView('pdf.budget', compact('presupuesto'));

        return $pdf->stream();

    }

    public function obtenerPresupuesto($id){
        return Budget::orderBy('id', 'DESC')->where('id', $id)->first();
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
        $oldVersion->opcionIva = $version->opcionIva;
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
        $oldVersion->impresion = $version->impresion;
        $oldVersion->budget_id = $version->id;
        $oldVersion->version = $version->version;
        $oldVersion->comision = $version->comision;
        $oldVersion->total = $version->total;
        $oldVersion->quienEdito = Auth::user()->name;
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

        if($request->presupuesto['tipo'] == 'CONTRATO'){
            $presupuesto->horaInicio                = $request->facturacion['horaInicio'];
            $presupuesto->horaFin                   = $request->facturacion['horaFin'];
            $presupuesto->horaEntrega               = $request->facturacion['horaEntrega'];
            $presupuesto->fechaRecoleccion          = $request->facturacion['fechaRecoleccion'];
            $presupuesto->notasFacturacion          = $request->facturacion['notasFacturacion'];
            $presupuesto->nombreFacturacion         = $request->facturacion['nombreFacturacion'];
            $presupuesto->direccionFacturacion      = $request->facturacion['direccionFacturacion'];
            $presupuesto->numeroFacturacion         = $request->facturacion['numeroFacturacion'];
            $presupuesto->coloniaFacturacion        = $request->facturacion['coloniaFacturacion'];
            $presupuesto->emailFacturacion          = $request->facturacion['emailFacturacion'];
        }
        $presupuesto->comision = $request->presupuesto['comision'];
        $presupuesto->total = $request->presupuesto['total'];
        $presupuesto->version = ($presupuesto->version) + 1;
        $presupuesto->save();

        //Buscamos el ultimo presupuesto actualizado guardado
        $ultimoPresupuesto = Budget::orderBy('id', 'DESC')->first();

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
                $producto->precioFinal = $item['precioFinal'];
                $producto->precioVenta = $item['precioVenta'];
                $producto->ahorro = $item['ahorro'];
                $producto->notas = $item['notas'];
                $producto->externo = $item['externo'];
                $producto->proveedor = $item['proveedor'];

                //Si el producto es externo
                if($item['externo']){
                    //Guardamos la imagen si lleva una
                    if($item['imagen'] && (base64_encode(base64_decode($item['imagen'], true)) === $item['imagen'])){

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
                    $producto->imagen = $item['imagen'];
                    $producto->version = $ultimoPresupuesto->version;
                    $producto->save();
                }
                
                if(!$item['externo']){
                    $producto = Inventory::find($item['id']);
                    $producto->disponible = ($producto->disponible) - ($item['cantidad']);
                    $producto->save();
                }
            }else{

                //Si el inventario es paquete hacemos el mismo recorrido
                $paquete = new BudgetPack();
                $paquete->budget_id = $ultimoPresupuesto->id;
                $paquete->servicio = $item['servicio'];
                $paquete->cantidad = $item['cantidad'];
                $paquete->precioUnitario = $item['precioUnitario'];
                $paquete->precioFinal = $item['precioFinal'];
                $paquete->precioVenta = $item['precioVenta'];
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
                        $producto->precioFinal = $objeto['precioFinal'];
                        $producto->precioVenta = $objeto['precioVenta'];
                        $producto->externo = $objeto['externo'];
                        $producto->proveedor = $objeto['proveedor'];
                        if($objeto['externo']){
                            //Guardamos la imagen si contiene una
                            if($objeto['imagen'] && (base64_encode(base64_decode($objeto['imagen'], true)) === $objeto['imagen'])){
                                $image = $objeto['imagen'];
                                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                                \Image::make($objeto['imagen'])->save(public_path('paquete/').$name);
                                $producto->fill(['imagen' => asset('paquete/'.$name)])->save();
                            }else{
                                $producto->imagen = $objeto['imagen'];
                                $producto->save();
                            }
                        }else{
                            $producto->imagen = $objeto['imagen'];
                            $producto->save();
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
        return BudgetVersion::where('id', $id)->first();
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
}
