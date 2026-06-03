<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WriterReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WriterReportController extends Controller
{
    /**
     * Ensure only logged-in community members can report other writers.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created writer profile report.
     */
    public function store(Request $request, $id)
    {
        $reportedUser = User::findOrFail($id);
        $currentUser = Auth::user();

        // Security check: Prevent users from reporting themselves
        if ($reportedUser->id === $currentUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot report your own author profile!'
            ], 400);
        }

        // Security check: Prevent duplicate spam submissions
        $duplicateCheck = WriterReport::where('reporter_id', $currentUser->id)
            ->where('reported_id', $reportedUser->id)
            ->exists();

        if ($duplicateCheck) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reported this writer. Our moderation team is currently investigating their profile.'
            ], 422);
        }

        // Validate reason and detail payload properties
        $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'required|string|min:15|max:1000',
        ]);

        // Secure persistence 
        WriterReport::create([
            'reporter_id' => $currentUser->id,
            'reported_id' => $reportedUser->id,
            'reason' => $request->reason,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you. Your report has been submitted. Our administrators will review this writer\'s credentials immediately.'
        ]);
    }
}