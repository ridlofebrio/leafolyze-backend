<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Forms\Components\CloudinaryFileUpload;
use App\Models\Article;
use App\Services\CloudinaryService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\FileUpload;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Article Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->debounce(500)
                            ->autocomplete(false)
                            ->placeholder('Enter article title'),

                        Forms\Components\TextInput::make('duration')
                            ->required()
                            ->numeric()
                            ->suffix('minutes')
                            ->minValue(1)
                            ->maxValue(180)
                            ->step(5)
                            ->default(30)
                            ->lazy(),

                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('articles/attachments')
                            ->lazy(),

                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1280')
                            ->imageResizeTargetHeight('720')
                            ->disk('public')
                            ->directory('articles')
                            ->maxSize(2048)
                            ->preserveFilenames()
                            ->columnSpanFull()
                            ->label('Article Image')
                            ->helperText('Recommended size: 1280x720px (16:9). Max 2MB.')
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsible()
            ])
            ->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at', 'desc')
            ->poll('0')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('duration')
                    ->suffix(' min')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
            ])
            ->bulkActions([])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select([
                'id',
                'title',
                'duration',
                'content',
                'created_at'
            ])
            ->with([
                'image' => fn($q) => $q->select('id', 'article_id', 'path')
            ])
            ->latest();

        return static::$model::query()
            ->whereIn('id', $query->pluck('id'))
            ->select([
                'id',
                'title',
                'duration',
                'content',
                'created_at'
            ])
            ->with([
                'image' => fn($q) => $q->select('id', 'article_id', 'path')
            ])
            ->latest();
    }
}
