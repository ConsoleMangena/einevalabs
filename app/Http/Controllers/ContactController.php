<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Jobs\SendWeb3FormsNotification;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(ContactRequest $request): RedirectResponse
    {
        // The honeypot was filled in, so this is a bot. Persist nothing, send
        // nothing, and report success so the bot gets no signal to work with.
        if ($request->honeypotTripped()) {
            Log::info('Contact form honeypot tripped.', ['ip' => $request->ip()]);

            return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
        }

        $submission = ContactSubmission::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            // nullable, so validated() can legitimately be null here.
            'department' => $request->validated('department'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
        ]);

        // Dispatch the instance through the bus. Note that
        // SendWeb3FormsNotification::dispatch() is the *static* helper from the
        // Dispatchable trait and does `new static(...$arguments)`, so calling
        // it on an already-built job re-invokes the constructor with no
        // arguments and throws an ArgumentCountError.
        dispatch(SendWeb3FormsNotification::forContactSubmission($submission));

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
