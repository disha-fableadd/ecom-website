<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function successPage()
    {
       
        // if (!session('order_success')) {
        //     return redirect()->route('home'); 
        // }
    
      
        session()->forget('order_success');
    
        return view('order.success'); 
    }
    
}
