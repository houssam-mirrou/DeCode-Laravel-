<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Student;
use App\Models\Brief;
use App\Models\Evaluation;
use App\Models\Livrable;
use App\Models\Sprint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherId = Auth::user()->id;
        $classId = DB::table('teachers_in_classes')
            ->where('teacher_id', $teacherId)
            ->value('class_id');
        $students = User::where('class_id', $classId)
            ->where('role', 'student')
            ->get();

        $sprints = Sprint::where('class_id', $classId)
            ->with(['briefs' => function ($q) {
                $q->with(['livrables', 'evaluations']);
            }])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('Pages.Teacher.evaluation', compact('students', 'sprints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($brief_id, $student_id)
    {
        $brief = Brief::findOrFail($brief_id);
        $student = User::findOrFail($student_id);

        $livrable = Livrable::where('brief_id', $brief_id)
            ->where('student_id', $student_id)
            ->first();

        $evaluation = Evaluation::where('brief_id', $brief_id)
            ->where('student_id', $student_id)
            ->with('competence_grades')
            ->first();

        return view('Pages.Teacher.eval_brief', compact('brief', 'student', 'livrable', 'evaluation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'brief_id' => 'required',
            'competences' => 'required|array',
            'review' => 'required',
            'level' => 'required',
            'comments' => 'required|string'
        ]);
        $evaluation = Evaluation::create(
            [
                'student_id' => $request->student_id,
                'brief_id' => $request->brief_id,
                'comments' => $request->comments,
                'review' => $request->review,
                'level' => $request->level
            ]
        );
        $levelMap = [
            1 => 'IMITER',
            2 => 'S_ADAPTER',
            3 => 'TRANSPOSER'
        ];
        $insertData = [];


        foreach ($request->competences as $id => $data) {

            if (isset($data)) {
                $insertData[] = [
                    'evaluation_id'=> $evaluation->id,
                    'competence_id' => $id,
                    'level'         => $data ?? 'IMITER',
                ];
            }
        }
        if (!empty($insertData)) {
            DB::table('evaluation_competences')->insert($insertData);
        }
        return redirect()->back()->with('success', 'Brief created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
