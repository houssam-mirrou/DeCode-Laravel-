<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classes::with('teachers')->orderBy('school_year', 'desc')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('Pages.Admin.classes', compact('classes', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255'
        ]);

        Classes::create([
            'name' => $request->name,
            'school_year' => $request->school_year
        ]);

        return redirect()->back()->with('success', 'Class created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255'
        ]);
        $class->update([
            'name' => $request->name,
            'school_year' => $request->school_year
        ]);
        return redirect()->back()->with('success', 'Class updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();
        return redirect()->back()->with('success', 'Class deleted successfully');
    }

    public function assign_teacher(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teachers' => 'required|array',
            'teachers.*' => 'exists:users,id'
        ]);

        $class = Classes::findOrFail($request->class_id);
        $class->teachers()->syncWithoutDetaching($request->teachers);
        return redirect()->back()->with('success', 'Teachers assigned successfully');
    }

    public function remove_teacher(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:users,id'
        ]);

        $class = Classes::findOrFail($request->class_id);
        $class->teachers()->detach($request->teacher_id);
        return redirect()->back()->with('success', 'Teacher removed successfully');
    }
}
