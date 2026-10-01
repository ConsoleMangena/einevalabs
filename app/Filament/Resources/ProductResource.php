<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Store';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Section::make('Product Details')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (?string $state, callable $set, callable $get): void {
                            if (blank($get('slug'))) {
                                $set('slug', \Illuminate\Support\Str::slug((string) $state));
                            }
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Used as the product URL: /store/<slug>.')
                        ->unique(ignoreRecord: true)
                        ->dehydrateStateUsing(fn (?string $state): string => \Illuminate\Support\Str::slug((string) $state))
                        ->placeholder('hardened-workstation-14'),

                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('products/attachments')
                        ->fileAttachmentsVisibility('public')
                        ->columnSpanFull(),

                    Forms\Components\KeyValue::make('specs')
                        ->keyLabel('Specification')
                        ->valueLabel('Value')
                        ->columnSpanFull(),
                ])->columnSpan(2),

                Forms\Components\Section::make('Meta')->schema([
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(99999999.99)
                        ->step('0.01')
                        ->prefix('$')
                        ->helperText('Leave empty for "price on request".'),
                        
                    Forms\Components\TextInput::make('category')
                        ->required()
                        ->maxLength(255)
                        ->default('General')
                        ->helperText('Groups products on the storefront landing page.'),

                    Forms\Components\FileUpload::make('image_url')
                        ->label('Primary image')
                        ->image()
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(4096),

                    Forms\Components\FileUpload::make('images')
                        ->label('Gallery')
                        ->image()
                        ->multiple()
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(4096)
                        ->maxFiles(8)
                        ->reorderable()
                        ->columnSpanFull(),
                ])->columnSpan(1),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn (Product $record): ?string => Str::limit($record->slug, 40))
                    ->wrap(),

                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    // A null price is "on request", not zero. Rendering it as
                    // $0.00 advertised a free product.
                    ->formatStateUsing(fn (?string $state): string => $state === null
                        ? 'On request'
                        : '$'.number_format((float) $state, 2))
                    ->badge()
                    ->color(fn (?string $state): string => $state === null ? 'gray' : 'success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(fn (): array => Product::query()
                        ->select('category')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->all()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
