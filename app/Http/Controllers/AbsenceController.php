<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absences = Absence::with(['user', 'teacher'])->get(); // Eager load user (student) and teacher

        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role', 'student')->get(); // Fetch users with role 'student'
        // $students = User::students()->get(); // Get all students // Fetch students
        return view('absences.create', compact('students')); // Return the form view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'type' => 'required|string|in:sick,vacation,personal',
            'user_id' => 'required|exists:users,id', // Validate the student selection
        ]);

        // Add the authenticated teacher's ID
        $validated['teacher_id'] = auth()->id(); // Store the authenticated teacher's ID

        // Create the new absence record, including the teacher's ID
        Absence::create($validated);

        // Redirect to the index page with a success message
        return redirect()->route('absences.index')
            ->with('success', 'Absence added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absence $absence)
    {
        return view('absences.show', compact('absence')); // Show details of a specific absence
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absence $absence)
    {
        return view('absences.edit', compact('absence')); // Return the edit form
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
            'type' => 'required|string|in:sick,vacation,personal',
            'student_id' => 'required|exists:users,id',
        ]);

        $absence->update($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absence updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $absence)
    {
        $absence->delete(); // Delete the absence

        return redirect()->route('absences.index')
            ->with('success', 'Absence deleted successfully!');
    }
}
