<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index(){
        //return a view
        return view('ads.index');
    }

    public function create(){
        //return a view
        return view('ads.create');
    }
    
}
