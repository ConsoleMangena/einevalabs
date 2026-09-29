<?php

namespace Tests\Feature;

use App\Jobs\SendWeb3FormsNotification;
use App\Models\ContactSubmission;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PublicFormsTest extends TestCase
{
    use RefreshDatabase;

    /*
     |----------------------------------------------------------------------
     | Contact form
     |----------------------------------------------------------------------
     */

    public function test_a_valid_message_is_stored_and_dispatched(): void
    {
        Queue::fake();

        $this->post(route('contact.submit'), [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'subject' => 'Pen test quote',
            'message' => 'We would like a quote for a web application assessment.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', ['email' => 'ada@example.com']);

        Queue::assertPushed(SendWeb3FormsNotification::class, function (SendWeb3FormsNotification $job): bool {
            return $job->payload['email'] === 'ada@example.com';
        });
    }

    public function test_a_honeypot_submission_is_silently_dropped(): void
    {
        Queue::fake();

        // Previously a filled honeypot redirected with a success message but
        // still wrote the row and sent the mail, which told a bot its
        // submission had worked.
        $this->post(route('contact.submit'), [
            'name' => 'Spam Bot',
            'email' => 'bot@example.com',
            'message' => 'Buy cheap backlinks.',
            'botcheck' => 'i am a bot',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount('contact_submissions', 0);
        Queue::assertNothingPushed();
    }

    public function test_the_contact_form_validates_its_input(): void
    {
        $this->post(route('contact.submit'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'hi',
        ])->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_submissions', 0);
    }

    public function test_the_contact_form_rejects_an_oversized_message(): void
    {
        $this->post(route('contact.submit'), [
            'name' => 'Ada',
            'email' => 'ada@example.com',
            'message' => str_repeat('a', 6000),
        ])->assertSessionHasErrors('message');
    }

    /*
     |----------------------------------------------------------------------
     | Newsletter
     |----------------------------------------------------------------------
     */

    public function test_a_subscriber_is_stored(): void
    {
        Queue::fake();

        $this->post(route('newsletter.subscribe'), [
            'email' => 'reader@example.com',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('subscribers', ['email' => 'reader@example.com']);
    }

    public function test_an_email_is_normalised_before_storage(): void
    {
        // The column is unique, so storing "Reader@Example.com" alongside
        // "reader@example.com" on a case-insensitive MySQL collation either
        // throws a duplicate-key error or creates two rows for one person.
        $this->post(route('newsletter.subscribe'), ['email' => 'Reader@Example.COM'])->assertSessionHas('success');
        $this->post(route('newsletter.subscribe'), ['email' => 'reader@example.com'])->assertSessionHas('success');

        $this->assertSame(1, Subscriber::query()->count());
        $this->assertDatabaseHas('subscribers', ['email' => 'reader@example.com']);
    }

    public function test_an_invalid_email_is_rejected(): void
    {
        $this->post(route('newsletter.subscribe'), ['email' => 'nope'])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('subscribers', 0);
    }

    public function test_a_honeypot_newsletter_submission_is_silently_dropped(): void
    {
        Queue::fake();

        $this->post(route('newsletter.subscribe'), [
            'email' => 'bot@example.com',
            'botcheck' => 'spam',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount('subscribers', 0);
        Queue::assertNothingPushed();
    }

    /*
     |----------------------------------------------------------------------
     | Rate limiting
     |----------------------------------------------------------------------
     */

    public function test_the_contact_form_is_rate_limited(): void
    {
        Queue::fake();

        $payload = [
            'name' => 'Ada',
            'email' => 'ada@example.com',
            'message' => 'A message.',
        ];

        // Five per minute, then the sixth is rejected. Without a limit this
        // endpoint was an open relay for filling the table and burning the
        // third-party mail quota.
        foreach (range(1, 5) as $ignored) {
            $this->post(route('contact.submit'), $payload);
        }

        $this->post(route('contact.submit'), $payload)
            ->assertSessionHas('error');

        $this->assertSame(5, ContactSubmission::query()->count());
    }
}
