<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return match(Auth::user()->role){
            'admin'=> redirect('/admin/dashboard'),
            'student'=>redirect('/student/dashboard'),
            'teacher'=>redirect('/teacher/dashboard')
        };
    }
}
