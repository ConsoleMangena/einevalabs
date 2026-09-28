<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ContactSubmission;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'botcheck' => 'nullable|in:0,false,'
        ]);

        if ($request->filled('botcheck') && $request->botcheck !== 'false' && $request->botcheck !== '0') {
            return back()->with('error', 'Spam detected.');
        }

        // Save to Database
        ContactSubmission::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Send to Web3Forms API directly
        $response = Http::post('https://api.web3forms.com/submit', [
            'access_key' => '59265f9c-bc0d-418f-a892-8394a7bc4c80',
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject ?? 'New Contact Form Submission',
            'message' => $request->message
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
        }

        return back()->with('error', 'There was a problem sending your message. Please try again later.');
    }
}
