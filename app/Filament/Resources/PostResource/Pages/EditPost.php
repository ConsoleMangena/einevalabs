<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view')
                ->label('View post')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('posts.show', ['post' => $this->record]))
                ->visible(fn (): bool => $this->record->isPublished())
                ->openUrlInNewTab(),

            Actions\DeleteAction::make(),
        ];
    }
}
