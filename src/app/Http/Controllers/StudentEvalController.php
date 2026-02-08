<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentEvalController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::where('student_id', Auth::user()->id)
            ->with(['briefs', 'competences'])
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($evaluations);
        return view('Pages.Student.evaluations', compact('evaluations'));
    }
}
