<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TrekkingReservationMail;

class TrekkingReservationController extends Controller
{
    
    public function store(Request $request, $slug)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'nationality' => 'required|string|max:100',
                'phone' => 'required|string|max:50',
                'arrival_date' => 'required|date',
                'departure_date' => 'required|date|after_or_equal:arrival_date',
                'duration_days' => 'required|integer|min:1',
                'adults' => 'required|integer|min:1',
                'children' => 'nullable|integer|min:0',
                'message' => 'required|string',
            ]);

            // Send reservation email via queue
            Mail::to('localmoroccotour1@gmail.com')->queue(
                new TrekkingReservationMail($validated, $slug)
            );

            return redirect()->back()
                ->with('success', 'Your trekking reservation has been submitted successfully!');

        } catch (\Exception $e) {
            Log::error('Trekking reservation error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, something went wrong while submitting your reservation. Please try again.');
        }
    }
}
