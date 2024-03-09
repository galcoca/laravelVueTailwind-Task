<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if($user->phone_verified_at != null) 
            return view('dashboard', ['user' => $user]);
        else
            return redirect()->route('validatePhone');
    }

    public function validatePhone() 
    {
        $user = Auth::user();
        if($user->phone_verified_at == null) {
            return view('dashboard', ['user' => $user]);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
