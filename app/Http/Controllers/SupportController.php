<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string'
        ]);

        Mail::send('emails.support', ['data' => $validated], function ($message) use ($validated) {
            $message->to('tood000doot@gmail.com')
                    ->subject('New Support Message from ' . $validated['firstName']);
        });

        return response()->json(['message' => 'Support message sent successfully.']);
    }
}
