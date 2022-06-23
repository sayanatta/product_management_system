<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Dashboard
    public function dashboard()
    {
        return view('dashboard.index');
    }
}
