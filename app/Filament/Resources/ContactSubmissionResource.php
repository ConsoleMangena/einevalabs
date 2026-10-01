<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationGroup = 'Enquiries';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function label(): string
    {
        return 'Contact Messages';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('department')
                ->options(collect(config('departments', []))
                    ->mapWithKeys(fn (array $dept): array => [$dept['slug'] => $dept['label']])
                    ->all())
                ->default(null)
                ->disabled(),

            Forms\Components\TextInput::make('subject')
                ->maxLength(255)
                ->default(null),

            Forms\Components\Textarea::make('message')
                ->required()
                ->rows(12)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn (ContactSubmission $record): ?string => $record->email),

                Tables\Columns\TextColumn::make('department')
                    ->label('Capability')
                    ->formatStateUsing(fn (?string $state): ?string => $state === null
                        ? null
                        : config('departments.'.$state.'.label', $state))
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->placeholder('(no subject)')
                    ->limit(50),

                // Truncated in the table so one long message cannot stretch a
                // row to thousands of pixels; the full text is on the view
                // page.
                Tables\Columns\TextColumn::make('message')
                    ->limit(80)
                    ->tooltip(fn (ContactSubmission $record): string => $record->message)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department')
                    ->options(collect(config('departments', []))
                        ->mapWithKeys(fn (array $dept): array => [$dept['slug'] => $dept['label']])
                        ->all())
                    ->placeholder('All capabilities'),

                Tables\Filters\TernaryFilter::make('has_subject')
                    ->label('Has a subject')
                    // A TernaryFilter's state is an array keyed "value", not
                    // "state". Reading $data['state'] raised an undefined-key
                    // error every time this table rendered.
                    ->query(fn ($query, array $data) => ($data['value'] ?? null)
                        ? $query->whereNotNull('subject')
                        : $query->whereNull('subject'))
                    ->indicateUsing(fn (array $data): array => blank($data['value'] ?? null)
                        ? []
                        : [($data['value'] ? 'Has a subject' : 'Has no subject')]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // No edit or delete: a submission is a record of what a visitor
                // wrote. ContactSubmissionPolicy forbids both.
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                // No create action: these only ever arrive from the public form.
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
        ];
    }
}
