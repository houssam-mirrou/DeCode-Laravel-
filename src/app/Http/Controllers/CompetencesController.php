<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;

class CompetencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competences = Competence::all();
        return view('Pages.Admin.competences',compact('competences'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|string|max:255',
            'libelle'=>'required|string|max:255',
            'description'=>'required|string|max:255',
        ]);
        Competence::create([
            'code'=>$request->code,
            'libelle'=>$request->libelle,
            'description'=>$request->description,
        ]);
        return redirect()->back()->with('success','Competence added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competence $competence)
    {
        $request->validate([
            'code'=>'required|string|max:255',
            'libelle'=>'required|string|max:255',
            'description'=>'required|string|max:255',
        ]);
        $competence->update([
            'code'=>$request->code,
            'libelle'=>$request->libelle,
            'description'=>$request->description,
        ]);
        return redirect()->back()->with('success','Competence updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $competence = Competence::findOrFail($id);
        $competence->delete();
        return redirect()->back()->with('success','Competence deleted successfully');
    }
}
