<?php

namespace App\Filament\Resources\ContactSubmissionResource\Pages;

use App\Filament\Resources\ContactSubmissionResource;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

/**
 * A contact submission is a record of what a visitor wrote, so it is never
 * edited or deleted (ContactSubmissionPolicy forbids both). It is presented as
 * an infolist rather than the resource form: the form's fields are all
 * disabled anyway, and rendering a message in a text input makes a long
 * message unreadable and impossible to copy.
 */
class ViewContactSubmission extends ViewRecord
{
    protected static string $resource = ContactSubmissionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Message')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('From'),

                        Infolists\Components\TextEntry::make('email')
                            // copyable() exists on TextEntry and TextColumn,
                            // not on the form's TextInput, so the copy button
                            // has to be declared here.
                            ->copyable(),

                        Infolists\Components\TextEntry::make('department')
                            ->label('Capability')
                            // Renders the slug through config('departments')
                            // so the panel shows "Software Engineering" rather
                            // than the stored value, and shows a dash for rows
                            // written before the column existed.
                            ->formatStateUsing(fn (?string $state): ?string => $state === null
                                ? null
                                : config('departments.'.$state.'.label', $state))
                            ->placeholder('Not specified')
                            ->badge(),

                        Infolists\Components\TextEntry::make('subject')
                            ->placeholder('No subject')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('message')
                            ->columnSpanFull()
                            ->prose(),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Received')
                            ->dateTime(),
                    ]),
            ]);
    }
}
