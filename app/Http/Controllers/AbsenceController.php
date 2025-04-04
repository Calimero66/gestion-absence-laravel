<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbsenceNotification;

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
            'penalty' => 'nullable|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);
    
        $validated['teacher_id'] = auth()->id();
        $absence = Absence::create($validated);
    
        try {
            $student = User::find($validated['user_id']);
            $totalAbsences = Absence::where('user_id', $student->id)->count();
    
            // Only send email if total absences is 5 or more
            if ($totalAbsences >= 5) {
                $message = "Dear {$student->name},\n\n";
                $message .= "An absence has been recorded for you:\n";
                $message .= "Date: {$absence->date}\n";
                $message .= "Session: {$absence->session}\n";
                $message .= "Teacher: {$absence->teacher->name}\n\n";
    
                // Add conditional messages based on total absences
                if ($totalAbsences >= 10) {
                    $message .= "ALERT: You have {$totalAbsences} absences.\n";
                    $message .= "You must bring your parent to the administration immediately.\n";
                } elseif ($totalAbsences >= 15) {
                    $message .= "URGENT: DISCIPLINARY ACTION REQUIRED\n";
                    $message .= "You have {$totalAbsences} absences.\n";
                    $message .= "You must bring your parent to the administration IMMEDIATELY.\n";
                } elseif ($totalAbsences >= 5) {
                    $message .= "CAUTION: You have accumulated {$totalAbsences} absences.\n";
                    $message .= "Please be aware that reaching 10 absences will require parental intervention.\n";
                }
    
                Mail::raw($message, function ($email) use ($student, $totalAbsences) {
                    $subject = $totalAbsences >= 15 ? 'URGENT: Parental Meeting Required' : 
                            ($totalAbsences >= 10 ? 'ALERT: High Absence Count' : 'Absence Notification');
                    
                    $email->to($student->email)->subject($subject);
                });
            }
    
        } catch (\Exception $e) {
            \Log::error('Failed to send absence notification email: ' . $e->getMessage());
        }
    
        return redirect()->route('absences.index')->with('success', 'Absence created successfully!');
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
