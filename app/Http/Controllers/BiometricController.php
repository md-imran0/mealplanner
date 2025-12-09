<?php

namespace App\Http\Controllers;

use App\Models\Biometric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * BiometricController backend
 * 
 * Manages biometric measurements (body measurements) for the user.
 * Users can track their physical measurements over time including:
 * - Weight
 * - Height
 * - Body fat percentage
 * 
 * This helps users track their progress towards fitness goals.
 */
class BiometricController extends Controller
{
    /**
     * Show all user's biometric records
     * 
     * Displays a list of all body measurements the user has recorded,
     * sorted by most recent measurements first.
     */
    public function index()
    {
        // Get all biometric records for the logged-in user
        $biometrics = Biometric::where('user_id', Auth::id())
                               ->orderBy('measurement_date', 'desc')  // Most recent first
                               ->get();
        
        return view('biometrics.index', compact('biometrics'));
    }

    /**
     * Show form to add a new biometric measurement
     * 
     * Displays a form where users can record:
     * - Weight (in kg or lbs)
     * - Height (in cm or inches)
     * - Body fat percentage
     * - Measurement date
     */
    public function create()
    {
        return view('biometrics.create');
    }

    /**
     * Save a new biometric measurement to the database
     * 
     * Creates a new biometric record with the user's current body measurements.
     * Users can record these measurements regularly to track progress.
     */
    public function store(Request $request)
    {
        // Debug logging - helps track what data is being submitted
        \Log::info('Biometric store - ALL DATA:', $request->all());
        \Log::info('Biometric store - measurement_date:', ['value' => $request->input('measurement_date')]);
        
        // Validate the measurement data
        $validated = $request->validate([
            'measurement_date' => 'required|date',                        // Date of measurement
            'weight' => 'nullable|numeric|min:0',                         // Weight (optional)
            'height' => 'nullable|numeric|min:0',                         // Height (optional)
            'body_fat_percentage' => 'nullable|numeric|min:0|max:100',    // Body fat % (0-100)
        ]);
        
        // More debug logging
        \Log::info('Biometric store - VALIDATED:', $validated);

        // Create the biometric record
        $bio = Biometric::create([
            'user_id' => Auth::id(),                           // Record for logged-in user
            'measurement_date' => $validated['measurement_date'],
            'weight' => $validated['weight'] ?? null,
            'height' => $validated['height'] ?? null,
            'body_fat_percentage' => $validated['body_fat_percentage'] ?? null,
        ]);
        
        // Debug - log what was created
        \Log::info('Biometric created:', $bio->toArray());

        return redirect()->route('biometrics.index')
                        ->with('success', 'Biometric record added successfully!');
    }

    /**
     * Show details of a single biometric record
     * 
     * Displays all measurements from a single date.
     */
    public function show(Biometric $biometric)
    {
        return view('biometrics.show', compact('biometric'));
    }

    /**
     * Show form to edit a biometric record
     * 
     * Allows user to correct measurements if they were entered incorrectly.
     */
    public function edit(Biometric $biometric)
    {
        return view('biometrics.edit', compact('biometric'));
    }

    /**
     * Update a biometric record
     * 
     * Saves corrections to body measurements.
     */
    public function update(Request $request, Biometric $biometric)
    {
        // Validate the measurement data
        $request->validate([
            'measurement_date' => 'required|date',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'body_fat_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Update the biometric record
        $biometric->update($request->all());

        return redirect()->route('biometrics.show', $biometric)
                        ->with('success', 'Biometric record updated successfully!');
    }

    /**
     * Delete a biometric record
     * 
     * Removes a biometric measurement from the user's history.
     */
    public function destroy(Biometric $biometric)
    {
        // Delete the biometric record
        $biometric->delete();
        return redirect()->route('biometrics.index')
                        ->with('success', 'Biometric record deleted successfully!');
    }
}
