<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashBoardController extends Controller
{
    public function index()
    {
        return view('Pages.Dashboards.student');
    }
}
