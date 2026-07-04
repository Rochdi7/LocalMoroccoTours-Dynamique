<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscriptionMail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate the email field
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        // Save to the newsletter_subscriptions table
        DB::table('newsletter_subscriptions')->insert([
            'email' => $validated['email'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Queue the confirmation email
        Mail::to($validated['email'])->queue(
            new NewsletterSubscriptionMail($validated['email'])
        );

        return back()->with('success', 'Thanks for subscribing to Authentic Morocco Adventures!');
    }
}
