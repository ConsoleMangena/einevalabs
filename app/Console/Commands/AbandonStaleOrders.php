<?php

namespace App\Console\Commands;

use App\Services\CheckoutService;
use Illuminate\Console\Command;

class AbandonStaleOrders extends Command
{
    protected $signature = 'orders:abandon-stale
                            {--hours=24 : How long an order may stay pending before it is abandoned}';

    protected $description = 'Mark abandoned pending orders as failed so the table does not fill with orders nobody completed';

    public function handle(CheckoutService $checkout): int
    {
        $hours = max(1, (int) $this->option('hours'));

        $abandoned = $checkout->abandonStalePendingOrders($hours);

        $this->info("Marked {$abandoned} order(s) as failed after {$hours}h without a gateway answer.");

        return self::SUCCESS;
    }
}
