<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        try {
            // Send synchronously so a real SMTP failure surfaces to the user
            // instead of a false success (queued mail can silently never send).
            Mail::to($validated['email'])->send(
                new NewsletterSubscriptionMail($validated['email'])
            );
        } catch (\Throwable $e) {
            Log::error('Newsletter confirmation email failed: ' . $e->getMessage());

            return back()->with('newsletter_error', 'You are subscribed, but we could not send the confirmation email right now.');
        }

        return back()->with('newsletter_success', 'Thanks for subscribing to Authentic Morocco Adventures!');
    }
}
