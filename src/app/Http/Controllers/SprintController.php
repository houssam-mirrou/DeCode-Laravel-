<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sprint;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sprints = Sprint::with(['classes','briefs'])->orderBy('start_date','desc')->get();
        $classes = Classes::all();

        return view('Pages.Admin.sprints',compact('sprints','classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'class_id' => 'required|exists:classes,id',
        ]);

        Sprint::create($validated);

        return redirect()->back()->with('success', 'Sprint created successfully.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sprint $sprint)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'class_id' => 'required|exists:classes,id',
        ]);
        $sprint->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'class_id' => $request->class_id,
        ]);
        return redirect()->back()->with('success', 'Sprint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sprint = Sprint::findOrFail($id);
        $sprint->delete();
        return redirect()->back()->with('success', 'Sprint deleted successfully.');
    }
}
