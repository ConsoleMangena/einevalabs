<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'botcheck' => 'nullable|in:0,false,'
        ]);

        if ($request->filled('botcheck') && $request->botcheck !== 'false' && $request->botcheck !== '0') {
            return back()->with('error', 'Spam detected.');
        }

        // Save to Database
        Subscriber::firstOrCreate([
            'email' => $request->email
        ]);

        // Send to Web3Forms API directly
        $response = Http::post('https://api.web3forms.com/submit', [
            'access_key' => '59265f9c-bc0d-418f-a892-8394a7bc4c80',
            'email' => $request->email,
            'subject' => 'New Newsletter Subscription',
            'message' => "New subscriber: " . $request->email
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Thank you for subscribing to our newsletter!');
        }

        return back()->with('error', 'There was a problem subscribing. Please try again later.');
    }
}
