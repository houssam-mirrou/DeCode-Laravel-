<?php

namespace App\Http\Controllers;

use App\Models\Livrable;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashBoardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sprints = Sprint::where('class_id', $user->class_id)
            ->with(['briefs' => function ($query) use ($user) {
                $query->with([
                    'competences',
                    'livrables' => function ($q) use ($user) {
                        $q->where('student_id', $user->id);
                    },
                    'evaluations' => function ($q) use ($user) {
                        $q->where('student_id', $user->id);
                    }
                ]);
            }])
            ->orderBy('start_date', 'asc')
            ->get();
        // dd($sprints);
        return view('Pages.Dashboards.student', compact('sprints'));
    }

    public function submit_brief(Request $request)
    {
        $request->validate([
            'brief_id' => 'required|exists:briefs,id',
            'repo_link' => 'required|url',
            'comment' => 'required|string'
        ]);
        Livrable::create(
            [
                'brief_id' => $request->brief_id,
                'comment' => $request->comment,
                'student_id' => Auth::user()->id,
                'url' => $request->repo_link,
                'submission_date' => now()
            ]
        );
        return redirect()->back()->with('Successfully', 'The livrable being inserted right');
    }
}
