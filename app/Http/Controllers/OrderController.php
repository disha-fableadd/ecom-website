<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function successPage()
    {
       
      
    
      
        session()->forget('order_success');
    
        return view('success'); 
    }
    
}
