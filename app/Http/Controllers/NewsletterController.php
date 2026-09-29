<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Jobs\SendWeb3FormsNotification;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(SubscribeRequest $request): RedirectResponse
    {
        if ($request->honeypotTripped()) {
            Log::info('Newsletter honeypot tripped.', ['ip' => $request->ip()]);

            return back()->with('success', 'Thank you for subscribing to our newsletter!');
        }

        $subscriber = Subscriber::subscribe((string) $request->validated('email'));

        // See ContactController: the static Dispatchable::dispatch() re-runs
        // the constructor, so the built job instance must go through the bus.
        dispatch(SendWeb3FormsNotification::forSubscriber($subscriber));

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
