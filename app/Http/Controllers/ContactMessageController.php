<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ContactMessageController extends Controller
{
    /**
     * Store a new contact message.
     */
    public function store(StoreContactMessageRequest $request)
    {
        // Rate limiting
        $key = 'contact-message:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => ["Too many contact attempts. Please try again in {$seconds} seconds."],
            ]);
        }

        try {
            // Create the contact message
            $contactMessage = ContactMessage::create([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'subject' => $request->validated('subject'),
                'budget' => $request->validated('budget'),
                'message' => $request->validated('message'),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'new',
            ]);

            // Increment rate limiter
            RateLimiter::hit($key, 300); // 5 minutes

            // Log successful creation for admin monitoring
            // TODO: Add Filament notification broadcasting when user is available

            Log::info('New contact message received', [
                'id' => $contactMessage->id,
                'email' => $contactMessage->email,
                'subject' => $contactMessage->subject,
            ]);

            // Handle AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message! I\'ll get back to you within 24 hours.',
                ]);
            }

            // Handle regular form submissions
            return redirect()->route('contact')
                ->with('success', 'Thank you for your message! I\'ll get back to you within 24 hours.');

        } catch (\Exception $e) {
            Log::error('Failed to store contact message', [
                'error' => $e->getMessage(),
                'data' => $request->validated(),
            ]);

            // Handle AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there was an error sending your message. Please try again later.',
                ], 500);
            }

            // Handle regular form submissions
            return redirect()->route('contact')
                ->withErrors(['message' => 'Sorry, there was an error sending your message. Please try again later.'])
                ->withInput();
        }
    }
}
