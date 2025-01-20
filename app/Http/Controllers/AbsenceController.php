<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Absence::class);

        if (auth()->user()->role === 'teacher') {
            $absences = Absence::with(['user', 'teacher'])
                ->where('teacher_id', auth()->id())
                ->get();
        } elseif (auth()->user()->role === 'student') {
            $absences = Absence::with(['teacher'])
                ->where('user_id', auth()->id())
                ->get();
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Absence::class);
        $students = User::where('role', 'student')->get();

        return view('absences.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Absence::class);

        $validated = $request->validate([
            'date' => 'required|date',
            'session' => 'required|string|max:255',
            'justification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'penalty' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('justification')) {
            $validated['justification'] = $request->file('justification')->store('justifications', 'public');
        }

        $validated['teacher_id'] = auth()->id();
        Absence::create($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absence added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absence $absence)
    {
        $this->authorize('view', $absence);

        return view('absences.show', compact('absence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absence $absence)
    {
        $this->authorize('update', $absence);

        return view('absences.edit', compact('absence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $absence)
{
    // Check if the user is authorized to update the absence
    if (auth()->user()->role === 'student') {
        // Ensure only the justification upload action is allowed for students
        $this->authorize('uploadJustification', $absence);

        // Validate the justification file
        $validated = $request->validate([
            'justification' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // If there's an existing justification, delete it
        if ($absence->justification && Storage::disk('public')->exists($absence->justification)) {
            Storage::disk('public')->delete($absence->justification);
        }

        // Store the new justification file
        $absence->update([
            'justification' => $request->file('justification')->store('justifications', 'public')
        ]);

        return redirect()->route('absences.index')->with('success', 'Justification uploaded successfully!');
    }

    // Allow full edit for teachers
    if (auth()->user()->role === 'teacher') {
        $this->authorize('update', $absence);

        $validated = $request->validate([
            'date' => 'required|date',
            'session' => 'required|string|max:255',
            'penalty' => 'nullable|numeric',
            'status' => 'required|in:pending,approved,rejected',
            'justification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('justification')) {
            if ($absence->justification && Storage::disk('public')->exists($absence->justification)) {
                Storage::disk('public')->delete($absence->justification);
            }
            $validated['justification'] = $request->file('justification')->store('justifications', 'public');
        }

        $absence->update($validated);

        return redirect()->route('absences.index')->with('success', 'Absence updated successfully!');
    }

    return redirect()->back()->with('error', 'Unauthorized action.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $absence)
    {
        $this->authorize('delete', $absence);

        if ($absence->justification && Storage::disk('public')->exists($absence->justification)) {
            Storage::disk('public')->delete($absence->justification);
        }

        $absence->delete();

        return redirect()->route('absences.index')
            ->with('success', 'Absence deleted successfully!');
    }

    /**
     * Download the justification file.
     */
    public function download(Absence $absence)
    {
        $this->authorize('view', $absence);

        if (!$absence->justification) {
            return redirect()->back()->with('error', 'No justification file found.');
        }

        return response()->download(storage_path('app/public/' . $absence->justification));
    }
}
