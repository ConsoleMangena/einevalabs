<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Store';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'ulid';

    public static function label(): string
    {
        return 'Orders';
    }

    /*
     * Read-mostly by design. OrderPolicy denies create and delete outright, and
     * the form is inert, so a mis-click in the panel cannot alter a financial
     * record. Corrections are refunds, which is a status change.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Order')
                ->schema([
                    Forms\Components\TextInput::make('ulid')
                        ->label('Order reference')
                        ->disabled(),

                    // badge() is an infolist/table API, not a form one, so the
                    // status is rendered as plain disabled text here and
                    // colour-coded in the table and in the view page infolist.
                    Forms\Components\TextInput::make('status')
                        ->disabled(),

                    Forms\Components\TextInput::make('total')
                        ->label('Total')
                        ->prefix('$')
                        ->formatStateUsing(fn (?string $state): ?string => $state === null
                            ? null
                            : number_format((float) $state, 2))
                        ->disabled(),

                    Forms\Components\TextInput::make('reference_number')
                        ->label('Gateway reference')
                        ->disabled(),

                    Forms\Components\DateTimePicker::make('created_at')
                        ->label('Placed')
                        ->disabled(),

                    Forms\Components\DateTimePicker::make('paid_at')
                        ->label('Settled')
                        ->disabled(),

                    Forms\Components\TextInput::make('failure_reason')
                        ->disabled()
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Customer')
                ->schema([
                    Forms\Components\TextInput::make('customer_name')
                        ->disabled(),

                    Forms\Components\TextInput::make('customer_email')
                        ->email()
                        ->disabled(),

                    Forms\Components\TextInput::make('customer_phone')
                        ->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Items')
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->hiddenLabel()
                        // These three take ?Closure / string, not booleans.
                        // Passing false was a TypeError that made every admin
                        // page showing an order 500, because Filament builds
                        // the resource form even for the read-only view.
                        ->deleteAction(fn (Forms\Components\Actions\Action $action) => $action->hidden())
                        ->reorderAction(fn (Forms\Components\Actions\Action $action) => $action->hidden())
                        ->defaultItems(0)
                        ->disabled()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Product')
                                ->disabled()
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('quantity')
                                ->label('Qty')
                                ->disabled(),

                            Forms\Components\TextInput::make('unit_price')
                                ->label('Unit')
                                ->prefix('$')
                                ->disabled(),

                            Forms\Components\TextInput::make('line_total')
                                ->label('Line total')
                                ->prefix('$')
                                ->disabled(),
                        ])
                        ->columns(4),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('ulid')
                    ->label('Order')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->limit(12),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        Order::STATUS_PAID => 'success',
                        Order::STATUS_PENDING => 'warning',
                        Order::STATUS_FAILED => 'danger',
                        Order::STATUS_REFUNDED => 'gray',
                    ]),

                Tables\Columns\TextColumn::make('total')
                    // The currency is stored on the order rather than assumed,
                    // so a gateway configured for anything other than USD is
                    // not silently displayed in the wrong unit.
                    ->money(fn (Order $record): string => $record->currency ?: 'USD')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer_email')
                    ->label('Customer')
                    ->searchable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('reference_number')
                    ->label('Gateway ref')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Placed')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Settled')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Order::STATUS_PENDING => 'Pending',
                        Order::STATUS_PAID => 'Paid',
                        Order::STATUS_FAILED => 'Failed',
                        Order::STATUS_REFUNDED => 'Refunded',
                    ])
                    ->default(fn () => null),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No delete: OrderPolicy::deleteAny() is false, and an order is
                // a financial record.
            ]);
    }

    /**
     * @param  Builder<Order>  $query
     * @return Builder<Order>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('items');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
