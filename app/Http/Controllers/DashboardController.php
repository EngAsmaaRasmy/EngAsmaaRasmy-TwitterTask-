<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard.index');
    }
}
