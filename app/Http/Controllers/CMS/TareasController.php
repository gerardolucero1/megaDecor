<?php

namespace App\Http\Controllers\CMS;
use App\Http\Controllers\Controller;
use App\TaskCategory;
use App\Task;
use App\PhysicalPerson;

use Illuminate\Http\Request;

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
        return Task::orderBy('id', 'DESC')->get();
       
    }
    public function store(Request $request){
        //dd($request);
        // Guardo un nuevo cliente.
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
        $categoria->delete();
    }
    public function editarCategoria(Request $request, $id){
         // edito una nueva categoría
         $categoria = new TaskCategory(); 
         $categoria->nombre = $request->nombre;
         $categoria->save();
    }
   
}
