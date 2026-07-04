<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // Queue the contact email
        Mail::to('localmoroccotour1@gmail.com')
            ->queue(new ContactMessageMail($validated));

        return back()->with('success', 'Your message has been sent. We’ll get back to you soon!');
    }
}
