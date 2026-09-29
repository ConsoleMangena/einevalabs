<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Str;

class StoreOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $revenue = (float) Order::query()
            ->where('status', Order::STATUS_PAID)
            ->sum('total');

        $paidCount = Order::query()->where('status', Order::STATUS_PAID)->count();
        $pendingCount = Order::query()->where('status', Order::STATUS_PENDING)->count();
        $subscriberCount = Subscriber::query()->count();
        $onRequestCount = Product::query()->whereNull('price')->count();

        return [
            Stat::make('Revenue', '$'.number_format($revenue, 2))
                ->description($paidCount.' settled '.Str::plural('order', $paidCount))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            /*
             * Pending orders are the ones that may still be paid, so this is
             * the number worth watching: it should drain as the gateway
             * callbacks and the reconciliation action work through them.
             */
            Stat::make('Pending orders', (string) $pendingCount)
                ->description('Awaiting gateway confirmation')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'warning' : 'success'),

            Stat::make('Products', (string) Product::query()->count())
                ->description($onRequestCount.' priced on request')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('gray'),

            Stat::make('Enquiries', (string) ContactSubmission::query()->count())
                ->description($subscriberCount.' newsletter '.Str::plural('subscriber', $subscriberCount))
                ->descriptionIcon('heroicon-m-envelope')
                ->color('gray'),
        ];
    }
}
