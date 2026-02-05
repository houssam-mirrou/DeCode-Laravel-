<?php

namespace App\Http\Controllers;

use App\Models\Brief;
use App\Models\Livrable;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        return view('Pages.Student.project', compact('sprints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $brief = \App\Models\Brief::with([
            'competences',

            'livrables' => function ($query) use ($user) {
                $query->where('student_id', $user->id);
            },

            'evaluations' => function ($query) use ($user) {
                $query->where('student_id', $user->id);
            }
        ])->findOrFail($id);
        // dd($brief);
        return view('Pages.Student.brief', compact('brief'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
