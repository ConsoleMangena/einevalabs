<?php

namespace App\Jobs;

use App\Models\ContactSubmission;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Forwards a form submission to the third-party inbox provider.
 *
 * Queued on purpose. This used to be a synchronous Http::post() inside the
 * controller, so a slow or unreachable provider turned every contact form
 * submission into a slow page load and threw away a message that had already
 * been saved to the database. Moving it to a job means the visitor gets an
 * instant, reliable response and the notification is retried on failure.
 */
class SendWeb3FormsNotification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    /** Give up quickly and let the queue back off rather than tie up a worker. */
    public int $timeout = 20;

    /**
     * @param  array<string, string|null>  $payload
     */
    public function __construct(public readonly array $payload) {}

    public static function forContactSubmission(ContactSubmission $submission): self
    {
        // Prefixed onto the subject so an enquiry can be routed to the right
        // department without opening the site or reading the message body.
        $subject = $submission->subject ?: 'New contact form submission';

        if ($department = $submission->departmentLabel()) {
            $subject = '['.$department.'] '.$subject;
        }

        return new self([
            'email' => $submission->email,
            'name' => $submission->name,
            'subject' => $subject,
            'message' => $submission->message,
        ]);
    }

    public static function forSubscriber(Subscriber $subscriber): self
    {
        return new self([
            'email' => $subscriber->email,
            'name' => 'Newsletter subscriber',
            'subject' => 'New newsletter subscription',
            'message' => 'New subscriber: '.$subscriber->email,
        ]);
    }

    public function handle(): void
    {
        $accessKey = (string) config('services.web3forms.access_key');

        if ($accessKey === '') {
            // Not a failure to retry: the key is missing by configuration and
            // three more attempts will not conjure it.
            Log::warning('Web3Forms notification skipped: WEB3FORMS_ACCESS_KEY is not set.');

            return;
        }

        $response = Http::timeout((int) config('services.web3forms.timeout'))
            ->retry(2, 250)
            ->asJson()
            ->post((string) config('services.web3forms.endpoint'), [
                'access_key' => $accessKey,
                ...$this->payload,
            ]);

        if (! $response->successful()) {
            // Throw so the queue retries and eventually surfaces the failure.
            throw new \RuntimeException(sprintf(
                'Web3Forms rejected the notification with status %d: %s',
                $response->status(),
                $response->body()
            ));
        }

        if ($response->json('success') === false) {
            Log::warning('Web3Forms reported a failure.', $response->json());
        }
    }
}
