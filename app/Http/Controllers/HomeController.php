<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        $role = session('user_role', 'Guest');

        if ($role === 'Admin') {
            return view('admin.dashboard');
        } elseif ($role === 'User') {
            return view('cust.dashboard');
        } 
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