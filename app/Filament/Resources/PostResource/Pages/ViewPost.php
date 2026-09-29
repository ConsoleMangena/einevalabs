<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    /**
     * The table's ViewAction links to this page. Without the route registered
     * in PostResource::getPages() the row action 404s, so the page has to
     * exist for the read-only view an admin expects.
     *
     * @return array<int, Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * An infolist is used instead of the form because the form's content field
     * is a 20-row markdown textarea, which is not a readable way to review a
     * post. The raw markdown is shown as-is, not passed through a renderer:
     * anything that rendered HTML here would be running the same
     * author-supplied content that the public view sanitises at parse time.
     */
    public function infolist(Infolist $infolist): Infolist
    {
        // ViewRecord::makeInfolist() already binds the record and the column
        // count, so this only supplies the components.
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Post')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('slug')
                            ->label('URL')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('published_at')
                            ->label('Publish at')
                            ->dateTime()
                            ->placeholder('Unpublished draft'),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn (Post $record): string => $record->isPublished() ? 'Published' : 'Draft')
                            ->color(fn (Post $record): string => $record->isPublished() ? 'success' : 'gray'),

                        Infolists\Components\ImageEntry::make('image')
                            ->label('Cover image')
                            ->height(200)
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('excerpt')
                            ->label('Excerpt')
                            ->placeholder('Falls back to the start of the content when empty.')
                            ->prose()
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('content')
                            ->label('Content (Markdown)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
