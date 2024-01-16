<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class LayoutController extends Controller
{
    
    public function index()
    {
        return view('layout.home')->with([
            'users' => Auth::user(),
        ]);
    }
}
