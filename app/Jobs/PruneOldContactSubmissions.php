<?php

namespace App\Jobs;

use App\Models\ContactSubmission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

/**
 * Deletes contact submissions past the retention window.
 *
 * These are personal data captured from an unauthenticated public form, so
 * keeping them forever is both a privacy exposure and a slow-growing table.
 */
class PruneOldContactSubmissions implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly int $days = 180) {}

    public function handle(): void
    {
        $cutoff = now()->subDays($this->days);

        $deleted = ContactSubmission::query()
            ->where('created_at', '<', $cutoff)
            ->delete();

        if ($deleted > 0) {
            Log::info('Pruned old contact submissions.', [
                'deleted' => $deleted,
                'older_than_days' => $this->days,
            ]);
        }
    }
}
