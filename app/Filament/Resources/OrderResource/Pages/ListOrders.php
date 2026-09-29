<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Services\CheckoutService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Log;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reconcile')
                ->label('Reconcile pending')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->modalHeading('Reconcile pending orders?')
                ->modalDescription('This asks the payment gateway about pending orders from the last 30 days, oldest first. It stops after about 20 seconds so the page cannot time out; run it again to continue with the rest.')
                ->action(function (): void {
                    /*
                     * One synchronous gateway call per order, so the amount of
                     * work has to be bounded. Unbounded, a few hundred pending
                     * orders pushed the request past max_execution_time and the
                     * admin got a timeout with no record of how far it got.
                     * A time budget makes the action resumable instead: the
                     * next click picks up the orders still pending.
                     */
                    $budgetSeconds = 20;
                    $deadline = microtime(true) + $budgetSeconds;

                    $pending = Order::query()
                        ->where('status', Order::STATUS_PENDING)
                        ->whereNotNull('reference_number')
                        ->where('created_at', '>=', now()->subDays(30));

                    $totalPending = (clone $pending)->count();

                    $service = app(CheckoutService::class);
                    $settled = 0;
                    $unreachable = 0;
                    $checked = 0;

                    $pending->orderBy('id')->chunk(25, function ($orders) use (
                        $service,
                        $deadline,
                        &$settled,
                        &$unreachable,
                        &$checked,
                    ): bool {
                        foreach ($orders as $order) {
                            if (microtime(true) >= $deadline) {
                                // Returning false tells chunk() to stop.
                                return false;
                            }

                            try {
                                // Note: `$x += $y ? 1 : 0` parses as
                                // `($x += $y) ? 1 : 0` because += binds tighter
                                // than ?:, so the count has to be parenthesised.
                                $settled += ($service->settle($order) ? 1 : 0);
                            } catch (\Throwable $e) {
                                // Misconfiguration or a transport failure - count
                                // it separately so a gateway outage is not reported
                                // as "the customer has not paid".
                                $unreachable++;

                                Log::warning('Reconcile could not reach the gateway.', [
                                    'order_ulid' => $order->ulid,
                                    'error' => $e->getMessage(),
                                ]);
                            }

                            $checked++;
                        }

                        return true;
                    });

                    $remaining = max(0, $totalPending - $checked);

                    Notification::make()
                        ->title('Reconciliation complete')
                        ->body(sprintf(
                            'Checked %d of %d pending order(s): %d settled, %d could not be checked.%s',
                            $checked,
                            $totalPending,
                            $settled,
                            $unreachable,
                            $remaining > 0
                                ? ' Run this again to check the remaining '.$remaining.'.'
                                : ''
                        ))
                        ->success()
                        ->send();
                }),
        ];
    }
}
