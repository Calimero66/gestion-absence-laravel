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
        // Authorize that the user can view absences
        $this->authorize('viewAny', Absence::class);

        // Fetch absences with related student and teacher data
        $absences = Absence::with(['user', 'teacher'])
            ->where('teacher_id', auth()->id()) // Ensure teachers only see their own absences
            ->get();

        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Authorize that the user can create absences
        $this->authorize('create', Absence::class);

        // Fetch all students to populate the dropdown
        $students = User::where('role', 'student')->get();

        return view('absences.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Authorize that the user can create absences
        $this->authorize('create', Absence::class);

        // Validate request input
        $validated = $request->validate([
            'date' => 'required|date',
            'session' => 'required|string|max:255',
            'justification' => 'nullable|string|max:255',
            'penalty' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected',
            'user_id' => 'required|exists:users,id', // ID of the student
        ]);

        // Add teacher_id to the validated data
        $validated['teacher_id'] = auth()->id();

        // Create the absence record
        Absence::create($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absence added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absence $absence)
    {
        // Authorize that the user can view this specific absence
        $this->authorize('view', $absence);

        return view('absences.show', compact('absence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absence $absence)
    {
        // Authorize that the user can update this specific absence
        $this->authorize('update', $absence);

        return view('absences.edit', compact('absence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $absence)
    {
        // Authorize that the user can update this specific absence
        $this->authorize('update', $absence);

        // Validate request input
        $validated = $request->validate([
            'date' => 'required|date',
            'session' => 'required|string|max:255',
            'justification' => 'nullable|string|max:255',
            'penalty' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Update the absence record
        $absence->update($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absence updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $absence)
    {
        // Authorize that the user can delete this specific absence
        $this->authorize('delete', $absence);

        // Delete the absence record
        $absence->delete();

        return redirect()->route('absences.index')
            ->with('success', 'Absence deleted successfully!');
    }
}
