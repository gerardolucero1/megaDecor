<?php

namespace App\Http\Controllers\CMS;

use App\Client;
use App\Telephone;
use App\ComoLoSupo;
use App\MoralPerson;
use App\tipo_empresa;
use App\AboutCategory;
use App\MoralCategory;
use App\PhysicalPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    // ESta funcion retorna todos los telefonos al formulario del cliente
    public function telefonos(){
        return Telephone::orderBy('id', 'DESC')->get();
    }

    // Esta funcion retorna todas las categorias de las personas morales a la vista clientes
    public function categorias(){
        return MoralCategory::orderBy('id', 'DESC')->get();   
    }
    

    // Esta funcion retorna todas las opciones de ¿Como nos conocio?
    public function aboutCategorias(){
        return AboutCategory::orderBy('id', 'DESC')->get();
    }

    // Esta funcion se encarga de buscar si hay un telefono repetido y retorna el cliente al que le pertenece
    public function viejoTelefono(Request $request){
        $cliente = Client::find($request->id);
        
        if($cliente->tipoPersona == 'FISICA'){
            return PhysicalPerson::where('client_id', $cliente->id)->first();
        }else{
            return MoralPerson::where('client_id', $cliente->id)->first();
        }
    }

    public function deleteViejoTelefono($id){
        
        $telefono = Telephone::find($id);
        $telefono->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function createC(Request $request){
        //dd($request);
        // Guardo un nueva categoría
        $tipo = new tipo_empresa(); 
        $tipo->nombre = $request->nombre;
        $tipo->save();
    }
    public function createComoSupo(Request $request){
        //dd($request);
        // Guardo un nueva categoría
        $tipo = new ComoLoSupo(); 
        $tipo->nombre = $request->nombre;
        $tipo->save();
    }
    public function ComoSupo(){
        return ComoLoSupo::orderBy('id', 'DESC')->get();   
    }
    public function TipoEmpresa(){
        return tipo_empresa::orderBy('id', 'DESC')->get();   
    }
    public function deleteTipo($id){
        $tipo = Tipo_empresa::find($id);
        $tipo->delete();
    }
    public function deleteComoSupo($id){
        $tipo = ComoLoSupo::find($id);
        $tipo->delete();
    }
    public function store(Request $request)
    {
        /*
        Generar cadena aleatoria en PHP con str_shuffle
        */
        $caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.#!';
        for($x = 0; $x < 10; $x++){
            $aleatoria = substr(str_shuffle($caracteres), 0, 10);
        }
         

        // Guardo un nuevo cliente.
        $cliente = new Client();
        $cliente->clave = $aleatoria;
        $cliente->nombreCliente = $request->nombreCliente;
        if($request->tipoPersona == 'fisica'){
            $cliente->tipoPersona = 'FISICA';
        }else{
            $cliente->tipoPersona = 'MORAL';
        }

        $cliente->save();

        // Obtengo el ultimo cliente guardado en la base de datos.
        $ultimoCliente = Client::orderBy('id', 'DESC')->pluck('id')->first();

        

        if($request->tipoPersona == 'fisica'){

            // Guardo una nueva persona fisica.
            $cliente = new PhysicalPerson();
            $cliente->client_id = $ultimoCliente;
            $cliente->about_id = $request->categoriaAbout;
            $cliente->nombre = $request->nombreCliente;
            $cliente->apellidoPaterno = $request->apellidoCliente;
            $cliente->apellidoMaterno = $request->apellidoCliente2;
            $cliente->email = $request->emailCliente;
            $cliente->direccionEmpresa = $request->direccionEmpresa;
            $cliente->coloniaEmpresa = $request->coloniaEmpresa;
            $cliente->numeroEmpresa = $request->numeroEmpresa;
            $cliente->nombreFacturacion = $request->nombreFacturacion;
            $cliente->direccionFacturacion = $request->direccionFacturacion;
            $cliente->coloniaFacturacion = $request->coloniaFacturacion;
            $cliente->numeroFacturacion = $request->numeroFacturacion;
            $cliente->rfcFacturacion = $request->rfcFacturacion;
            $cliente->emailFacturacion = $request->emailFacturacion;
            $cliente->tipoCredito = $request->creditoCliente;
            $cliente->diasCredito = $request->diasCredito;
            $cliente->telefono = $request->telefonos[0]['numero'];
            $cliente->save();

        }else{
            // Guardo una nueva persona moral.
            $cliente = new MoralPerson();

            $cliente->client_id = $ultimoCliente;
            $cliente->categoria_id = $request->categoriaCliente;
            $cliente->about_id = $request->categoriaAbout;
            $cliente->nombre = $request->nombreCliente;
            $cliente->email = $request->emailCliente;
            $cliente->direccionEmpresa = $request->direccionEmpresa;
            $cliente->coloniaEmpresa = $request->coloniaEmpresa;
            $cliente->numeroEmpresa = $request->numeroEmpresa;
            $cliente->nombreFacturacion = $request->nombreFacturacion;
            $cliente->direccionFacturacion = $request->direccionFacturacion;
            $cliente->coloniaFacturacion = $request->coloniaFacturacion;
            $cliente->numeroFacturacion = $request->numeroFacturacion;
            $cliente->rfcFacturacion = $request->rfcFacturacion;
            $cliente->emailFacturacion = $request->emailFacturacion;
            $cliente->tipoCredito = $request->creditoCliente;
            $cliente->diasCredito = $request->diasCredito;
            $cliente->telefono = $request->telefonos[0]['numero'];
            $cliente->save();
        }

        foreach ($request->telefonos as $telephone){
            $telefono = new Telephone();

            $telefono->client_id = $ultimoCliente;
            $telefono->nombre = $telephone['nombre'];
            $telefono->apellidoPaterno = $telephone['apellidoPaterno'];
            $telefono->apellidoMaterno = $telephone['apellidoMaterno'];
            $telefono->email = $telephone['email'];
            $telefono->tipo = $telephone['tipo'];
            $telefono->numero = $telephone['numero'];
            $telefono->ext = $telephone['ext'];
            $telefono->departamento = $telephone['departamento'];
            $telefono->save();

        }
        
    }

    public function edit($id){
        return view('clients.edit');
    }

    public function obtenerCliente($id){
        $data = Client::orderBy('id', 'DESC')->where('id', $id)->first();

        if($data->tipoPersona == 'FISICA'){
             $cliente = PhysicalPerson::where('client_id', $data->id)->with(['client' => function($query){
                $query->with(['budgets']); 
            }])->first();
            $cliente->vetado=$data->vetado;
            $cliente->motivo=$data->motivo;
            return $cliente;
            //return $cliente->client->budgets;
            
        }else{
            $cliente = MoralPerson::where('client_id', $data->id)->with(['client' => function($query){
                $query->with(['budgets']); 
            }])->first();
            $cliente->vetado=$data->vetado;
            $cliente->motivo=$data->motivo;
            return $cliente;
        }
    }
    public function vetar($id){
        $arr = explode("-", $id);
        $data = Client::orderBy('id', 'DESC')->where('id', $arr[0])->first();

        $data->vetado = true;
        $data->motivo = $arr[1];
        $data->save();

    }
    public function desvetar($id){
        $data = Client::orderBy('id', 'DESC')->where('id', $id)->first();

        $data->vetado = false;
        $data->save();

    }

    public function obtenerTelefonos($id){
        $data = Client::orderBy('id', 'DESC')->where('id', $id)->first();

        return $telefonos = Telephone::orderBy('id', 'DESC')->where('client_id', $id)->get();
    }

    public function update(Request $request, $id){
        $cliente = Client::find($id);
        $cliente->vetado = true;
        $cliente->save();


        if($cliente->tipoPersona == 'FISICA'){
            $persona = PhysicalPerson::where('client_id', $cliente->id)->first();

            $persona->fill($request->all())->save();
        }else{
            $persona = MoralPerson::where('client_id', $cliente->id)->first();

            $persona->fill($request->all())->save();
        }

    }

    public function updateTelefono(Request $request, $id){
        $telefono = Telephone::find($id);
        $telefono->fill($request->all())->save();
    }

    public function deleteTelefono($id){
        $telefono = Telephone::find($id);
        $telefono->delete();
    }

    public function crearTelefono(Request $request){
        $telefono = Telephone::create($request->all());
    }

    public function destroy($id){
        $cliente = Client::findOrFail($id);
        if($cliente->tipoPersona == 'FISICA'){
            $persona = PhysicalPerson::where('client_id', $id)->first();
        }else{
            $persona = MoralPerson::where('client_id', $id)->first();
        }

        $persona->delete();
        $cliente->delete();

        return back()->with('info', 'Cliente eliminado con exito');
    }
}
