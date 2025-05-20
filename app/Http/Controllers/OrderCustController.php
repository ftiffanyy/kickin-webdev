<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderCustController extends Controller
{
    public function show()
    {
       $role = session('user_role', 'Guest');

        if ($role === 'Admin') {
            return view('admin.orderpage');
        } elseif ($role === 'User') {
            return view('cust.orders');
        } 
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
