<?php

namespace App\Http\Controllers\CMS;
use App\Http\Controllers\Controller;
use App\TaskCategory;
use App\Task;
use Carbon\Carbon;
use App\User;
use Auth;
use App\PhysicalPerson;
use stdClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareasController extends Controller
{
   //Obtenemos todas las categorias 
    public function categorias(){
        return TaskCategory::orderBy('id', 'DESC')->get();   
    }
    //Obtenemos los clientes fisicos 
    public function clientesF(){
        return PhysicalPerson::orderBy('id', 'DESC')->get();   
    }
    public function obtenerTareas(){
        $fechaHoy = Carbon::yesterday();
        $idUsuarioLogeado = Auth::user()->id;
        $fecha_actual= date('Y-m-d',time());
        
        if($idUsuarioLogeado==17){
        $tareas = Task::with('comments')->get();
    }else{
        $tareas = Task::with('comments')->where(function($q) {
            $q->where('tasks.vendedor_id', '=', Auth::user()->id)
              ->orWhere('tasks.vendedor_id', '2');
        })-where('tasks.fecha' > $fechaHoy)
        ->get();  
    }

        $Tasks=[];

      

        foreach ($tareas as $tarea) {
            $vendedor = User::orderBy('id', 'DESC')->where('id', $tarea->vendedor_id)->first();
            
             $tarea->id;
                $Task = new stdClass();
                $Task->fecha_actual = $fecha_actual;
                $Task->vendedor = $vendedor->name;
                $Task->id = $tarea->id;
                $Task->comments = $tarea->comments;
                $Task->id_cliente = $tarea->cliente_id;
                $Task->cliente = $tarea->cliente_id;
                $Task->notas = $tarea->notas;
                $Task->categoria = $tarea->categoria;
                $Task->completa = $tarea->completa;
                $Task->fecha = $tarea->fecha;
                $Task->vendedor_id = $tarea->vendedor_id;
                array_push($Tasks,$Task);
               
        }      
       
        return $Tasks; 
    }

    public function obtenerTareasTodas(){
        $idUsuarioLogeado = Auth::user()->id;
        $fecha_actual= date('Y-m-d',time());
        
        if($idUsuarioLogeado==17){
        $tareas = Task::with('comments')->get();
    }else{
        $tareas = Task::with('comments')->where(function($q) {
            $q->where('tasks.vendedor_id', '=', Auth::user()->id)
              ->orWhere('tasks.vendedor_id', '2');
        })
        ->get();  
    }

        $Tasks=[];

      

        foreach ($tareas as $tarea) {
            $vendedor = User::orderBy('id', 'DESC')->where('id', $tarea->vendedor_id)->first();
            
             $tarea->id;
                $Task = new stdClass();
                $Task->fecha_actual = $fecha_actual;
                $Task->vendedor = $vendedor->name;
                $Task->id = $tarea->id;
                $Task->comments = $tarea->comments;
                $Task->id_cliente = $tarea->cliente_id;
                $Task->cliente = $tarea->cliente_id;
                $Task->notas = $tarea->notas;
                $Task->categoria = $tarea->categoria;
                $Task->completa = $tarea->completa;
                $Task->fecha = $tarea->fecha;
                $Task->vendedor_id = $tarea->vendedor_id;
                array_push($Tasks,$Task);
               
        }      
       
        return $Tasks;   

    }



    public function store(Request $request){
        //dd($request);
        // Guardo una nueva tarea
         $tarea = new Task();
         $tarea->vendedor_id = $request->idVendedor;
         $tarea->categoria = $request->nombreCategoria;
         $tarea->cliente_id = $request->idCliente;
         $tarea->fecha = $request->fecha;
         $tarea->notas = $request->textoNotas;
         $tarea->save();

    }
    public function createC(Request $request){
        //dd($request);
        // Guardo un nueva categoría
        $categoria = new TaskCategory(); 
        $categoria->nombre = $request->nombre;
        $categoria->save();
    }
    public function deleteCategoria($id){
        $categoria = TaskCategory::find($id);
        $categoria->delete();
    }
    public function deleteTarea($id){
        $categoria = Task::find($id);
        //$categoria->delete();
        $categoria->completa = '1';
        $categoria->save();

    }
    public function editarCategoria(Request $request, $id){
         // edito una nueva categoría
         $categoria = new TaskCategory(); 
         $categoria->nombre = $request->nombre;
         $categoria->save();
    }
   
}
