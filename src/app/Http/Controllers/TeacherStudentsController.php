<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherStudentsController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $classId = DB::table('teachers_in_classes')
            ->where('teacher_id', $teacherId)
            ->value('class_id');
        $totalBriefsCount = Sprint::where('class_id', $classId)
            ->withCount('briefs')
            ->get()
            ->sum('briefs_count');

        $students = User::where('class_id', $classId)
            ->where('role', 'student')
            ->withCount(['evaluations as validated_briefs' => function ($query) {
                $query->whereIn('review', ['good', 'excellent']);
            }])
            ->orderBy('last_name')
            ->get();

        return view('Pages.Teacher.students', compact('students', 'totalBriefsCount'));
    }
}
