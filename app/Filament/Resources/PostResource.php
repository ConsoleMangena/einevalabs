<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Section::make('Post Details')->schema([
                    Forms\Components\TextInput::make('title')
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
                        ->helperText('Used as the post URL: /blog/<slug>.')
                        ->unique(ignoreRecord: true)
                        ->dehydrateStateUsing(fn (?string $state): string => \Illuminate\Support\Str::slug((string) $state))
                        ->placeholder('my-first-post'),

                    Forms\Components\Textarea::make('excerpt')
                        ->maxLength(1000)
                        ->helperText('Shown on the blog index. Falls back to the start of the content when empty.')
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('posts/attachments')
                        ->fileAttachmentsVisibility('public')
                        ->columnSpanFull(),
                ])->columnSpan(2),

                Forms\Components\Section::make('Meta')->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Cover image')
                        ->image()
                        ->disk('public')
                        ->directory('posts')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(4096),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Publish at')
                        ->seconds(false)
                        ->helperText('Leave empty to keep this post as an unpublished draft.'),
                ])->columnSpan(1),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(''),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->description(fn (Post $record): ?string => Str::limit($record->slug, 40))
                    ->wrap(),

                Tables\Columns\IconColumn::make('published_at')
                    ->label('Status')
                    ->boolean()
                    ->getStateUsing(fn (Post $record): bool => $record->isPublished())
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->color(fn (Post $record): string => $record->isPublished() ? 'success' : 'warning')
                    ->tooltip(fn (Post $record): string => match (true) {
                        $record->isPublished() => 'Published '.$record->published_at->format('j M Y'),
                        $record->published_at !== null => 'Scheduled for '.$record->published_at->format('j M Y'),
                        default => 'Draft',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published only')
                    ->nullable()
                    ->query(function ($query, array $data): void {
                        match ($data['state'] ?? null) {
                            true => $query->published(),
                            false => $query->whereNull('published_at'),
                            default => null,
                        };
                    })
                    ->indicateUsing(fn (array $data): array => match ($data['state'] ?? null) {
                        true => ['Published'],
                        false => ['Drafts'],
                        default => [],
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
