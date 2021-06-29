<?php

namespace App\Http\Controllers;

use App\Compra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompraController extends Controller
{

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
       $compras = Compra::orderBy('id', 'DESC')->get();
       return $compras;
   }
    //
}
