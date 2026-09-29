<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Services\CheckoutService;
use Filament\Actions\Action;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Log;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    /**
     * @return array<int, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('reverify')
                ->label('Re-verify with gateway')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->visible(fn (): bool => $this->record->isPending() && $this->record->reference_number !== null)
                ->action(function (): void {
                    /*
                     * settle() mutates this very record instance, so the
                     * infolist re-renders from the updated model with no
                     * explicit refill. There is no fillInfolist() on a
                     * ViewRecord page - that helper only exists for forms.
                     */
                    try {
                        $paid = app(CheckoutService::class)->settle($this->record);
                    } catch (\Throwable $e) {
                        Log::warning('Manual re-verification failed.', [
                            'order_ulid' => $this->record->ulid,
                            'error' => $e->getMessage(),
                        ]);

                        Notification::make()
                            ->title('Could not reach the gateway')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();

                        return;
                    }

                    $notification = Notification::make()
                        ->title($paid ? 'Payment confirmed' : 'Still pending')
                        ->body($paid
                            ? 'The gateway reported this order as settled.'
                            : 'The gateway has not reported a settlement yet. It will be confirmed automatically by the webhook.');

                    // success()/warning() take no argument in Filament 3.
                    $paid ? $notification->success() : $notification->warning();

                    $notification->send();
                }),
        ];
    }

    /**
     * An infolist rather than the resource form: an order is a financial
     * record and is only ever read here, so nothing about it should be
     * presented as an editable field.
     */
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('ulid')
                            ->label('Order reference')
                            ->fontFamily('mono')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->colors([
                                Order::STATUS_PAID => 'success',
                                Order::STATUS_PENDING => 'warning',
                                Order::STATUS_FAILED => 'danger',
                                Order::STATUS_REFUNDED => 'gray',
                            ]),

                        Infolists\Components\TextEntry::make('total')
                            ->money(fn (Order $record): string => $record->currency ?: 'USD'),

                        Infolists\Components\TextEntry::make('currency')
                            ->label('Currency'),

                        Infolists\Components\TextEntry::make('reference_number')
                            ->label('Gateway reference')
                            ->fontFamily('mono')
                            ->copyable()
                            ->placeholder('—'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Placed')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('paid_at')
                            ->label('Settled')
                            ->dateTime()
                            ->placeholder('—'),

                        Infolists\Components\TextEntry::make('failed_at')
                            ->label('Failed')
                            ->dateTime()
                            ->placeholder('—'),

                        Infolists\Components\TextEntry::make('failure_reason')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Customer')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('customer_name')
                            ->placeholder('Guest'),
                        Infolists\Components\TextEntry::make('customer_email')
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('customer_phone')
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('user_id')
                            ->label('Account')
                            ->placeholder('Guest checkout'),
                    ]),

                Infolists\Components\Section::make('Items')
                    ->description('Priced at checkout from the database, not from the session.')
                    ->schema([
                        /*
                         * $order->items is a JSON snapshot cast to 'array' and
                         * shares its name with the HasMany relation, so
                         * RepeatableEntry would read the array of arrays and
                         * render nothing. The relation is used explicitly.
                         */
                        Infolists\Components\RepeatableEntry::make('itemRows')
                            ->label('Items')
                            ->state(fn (Order $record): array => $record->items()->get()->map(fn ($item): array => [
                                'name' => $item->name,
                                'quantity' => $item->quantity,
                                'unit_price' => number_format((float) $item->unit_price, 2),
                                'line_total' => number_format((float) $item->line_total, 2),
                            ])->all())
                            ->columns(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Product')
                                    ->columnSpan(2),
                                Infolists\Components\TextEntry::make('quantity')
                                    ->label('Qty'),
                                Infolists\Components\TextEntry::make('unit_price')
                                    ->label('Unit'),
                                Infolists\Components\TextEntry::make('line_total')
                                    ->label('Line total'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Gateway response')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Infolists\Components\TextEntry::make('gateway_response')
                            ->hiddenLabel()
                            ->formatStateUsing(fn (?array $state): string => $state === null
                                ? 'No gateway payload stored.'
                                : json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                            ->fontFamily('mono')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
