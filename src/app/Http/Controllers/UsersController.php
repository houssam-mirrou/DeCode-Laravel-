<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['student_class', 'teaching_classes'])
            ->where('id', '!=', auth()->id());

        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $classes = Classes::all();

        return view('Pages.Admin.users', compact('users', 'classes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,teacher,student',
        ]);
        if ($request->role == 'student') {
            $request->validate([
                'class_id' => 'required|exists:classes,id',
            ]);
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'class_id' => $request->class_id,
            ]);
        } else {
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
        }
        return redirect()->route('users.index')->with('sucsses', 'User created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,teacher,student',
        ]);

        if ($request->role == 'student') {
            $request->validate([
                'class_id' => 'required|exists:classes,id',
            ]);
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => $request->role,
                'class_id' => $request->class_id,
            ]);
        } else {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => $request->role,
                'class_id' => null,
            ]);
        }
        if($request->filled('password')){
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
