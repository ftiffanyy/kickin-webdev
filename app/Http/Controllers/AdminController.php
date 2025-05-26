<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orderadmin()
    {
        return view('admin.orderpage');
    }

    public function orderdadmin($orderid)
    {
        if ($orderid == 1) {
            return view('admin.detailspage2'); 
        } elseif ($orderid == 2) {
            return view('admin.detailspage'); 
        }
    }
}


// halo ini valen tes ke 2