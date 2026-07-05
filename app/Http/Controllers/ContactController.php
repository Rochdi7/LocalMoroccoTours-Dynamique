<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            // Send synchronously so a real SMTP failure surfaces to the user
            // instead of a false success (queued mail can silently never send).
            Mail::to('localmoroccotour1@gmail.com')
                ->send(new ContactMessageMail($validated));
        } catch (\Throwable $e) {
            Log::error('Contact form email failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('contact_error', 'Sorry, we could not send your message right now. Please try again later or contact us directly.');
        }

        return back()->with('contact_success', 'Your message has been sent. We’ll get back to you soon!');
    }
}
