<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifyRecaptcha
{
    /**
     * Verify the g-recaptcha-response token against Google's siteverify API
     * and reject the request if the v3 score is below the configured threshold.
     *
     * Usage: ->middleware('recaptcha:contact') — the action name must match
     * the action passed to grecaptcha.execute() in the form's JS.
     */
    public function handle(Request $request, Closure $next, ?string $action = null)
    {
        $secret = config('services.recaptcha.secret_key');

        // If no secret key is configured, skip verification instead of
        // locking out every public form because setup isn't finished yet.
        if (empty($secret)) {
            Log::warning('reCAPTCHA secret key not configured; skipping verification.');
            return $next($request);
        }

        $token = $request->input('g-recaptcha-response');

        if (empty($token)) {
            return back()->withInput()->with('recaptcha_error', 'Please try submitting the form again.');
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ])->json();
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA verification request failed: ' . $e->getMessage());
            return back()->withInput()->with('recaptcha_error', 'Sorry, we could not verify your request right now. Please try again.');
        }

        $success = $response['success'] ?? false;
        $score = $response['score'] ?? 0;
        $returnedAction = $response['action'] ?? null;

        if (!$success || $score < (float) config('services.recaptcha.score_threshold', 0.5) || ($action && $returnedAction !== $action)) {
            Log::warning('reCAPTCHA check failed', [
                'action' => $action,
                'returned_action' => $returnedAction,
                'score' => $score,
                'errors' => $response['error-codes'] ?? [],
            ]);

            return back()->withInput()->with('recaptcha_error', 'We could not verify you are human. Please try again.');
        }

        return $next($request);
    }
}
