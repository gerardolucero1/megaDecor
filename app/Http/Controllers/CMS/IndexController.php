<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;

class IndexController extends Controller
{
    public function clientes(){
        return view('clientes');
    }
    public function dashboard(){
        $tasks = Task::orderBy('id', 'DESC')->get();
        return view('dashboard', compact('tasks'));
    }
}
