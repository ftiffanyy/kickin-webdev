<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show()
    {
        //$role = session('user_role', 'Guest');

        if (Auth()->user()->role === 'Admin') {
            return view('admin.dashboard');
        } elseif (Auth()->user()->role === 'Customer') {
            return view('cust.dashboard');
        } 

        //dd(Auth()->user());
    }

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function about()
    {
        return view('cust.about');
    }

    public function terms()
    {
        return view('cust.term');
    }

    public function Privacy()
    {
        return view('cust.Privacy');
    }

    public function faq()
    {
        return view('cust.faq');
    }
}