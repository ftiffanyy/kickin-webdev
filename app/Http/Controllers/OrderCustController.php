<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderCustController extends Controller
{
    public function show()
    {
        return view('cust.orders');

    }

    public function orderdetails($id)
    {
        if ($id == 1) {
            return view('cust.orderdetails1'); 
        } elseif ($id == 2) {
            return view('cust.orderdetails'); 
        }
    }

}
