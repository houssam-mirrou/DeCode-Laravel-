<?php

namespace App\Http\Controllers;

use App\Models\Brief;
use App\Models\Competence;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BriefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competences = Competence::all();

        $sprints = Sprint::with(['briefs.competences', 'briefs.teachers'])
            ->orderBy('start_date', 'asc')
            ->get();
        // dd($sprints);
        return view('Pages.Teacher.brief', compact('competences', 'sprints'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_remise' => 'required|date',
            'type' => 'required|string|max:100',
            'sprint_id' => 'required|exists:sprints,id',
            'competences' => 'array',
            'competences.*.id' => 'exists:competences,id',
            'competences.*.level' => 'required|string|max:100',
        ]);
        $brief = Brief::create([
            'title' => $request->title,
            'description' => $request->description,
            'date_remise' => $request->date_remise,
            'type' => $request->type,
            'sprint_id' => $request->sprint_id,
        ]);
        $levelMap = [
            1 => 'IMITER',
            2 => 'S_ADAPTER',
            3 => 'TRANSPOSER'
        ];

        $insertData = [];

        if ($request->has('competences')) {
            foreach ($request->competences as $id => $data) {

                if (isset($data['checked'])) {
                    $insertData[] = [
                        'brief_id'      => $brief->id,
                        'competence_id' => $id,
                        'level'         => $levelMap[$data['level']] ?? 'IMITER',
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            DB::table('brief_competences')->insert($insertData);
        }
        DB::table('brief_teachers')->insert([
            'teacher_id' => Auth::id(),
            'brief_id' => $brief->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Brief created successfully.');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_remise' => 'required|date',
            'type' => 'required|string|max:100',
            'sprint_id' => 'required|exists:sprints,id',
            'competences' => 'array',
            'competences.*.id' => 'exists:competences,id',
            'competences.*.level' => 'required|string|max:100',
        ]);
        $brief = Brief::findOrFail($id);
        $brief->update([
            'title' => $request->title,
            'description' => $request->description,
            'date_remise' => $request->date_remise,
            'type' => $request->type,
            'sprint_id' => $request->sprint_id,
        ]);
        $levelMap = [
            1 => 'IMITER',
            2 => 'S_ADAPTER',
            3 => 'TRANSPOSER'
        ];
        $insertData = [];
        if ($request->has('competences')) {
            foreach ($request->competences as $id => $data) {

                if (isset($data['checked'])) {
                    $insertData[] = [
                        'brief_id'      => $brief->id,
                        'competence_id' => $id,
                        'level'         => $levelMap[$data['level']] ?? 'IMITER',
                    ];
                }
            }
        }
        // Sync competences
        $brief->competences()->sync([]);
        if (!empty($insertData)) {
            DB::table('brief_competences')->insert($insertData);
        }
        return redirect()->back()->with('success', 'Brief updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brief = Brief::findOrFail($id);
        $brief->delete();
        return redirect()->back()->with('success', 'Brief deleted successfully.');
    }
}
