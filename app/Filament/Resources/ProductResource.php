<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;
use App\Models\Disease;
use App\Models\Shop;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->lazy()
                                    ->autocomplete(false)
                                    ->placeholder('Product name'),

                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->lazy(),

                                Forms\Components\Select::make('disease_id')
                                    ->label('Disease')
                                    ->required()
                                    ->relationship('disease', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->optionsLimit(20)
                                    ->placeholder('Select disease')
                            ])
                            ->columns(2),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('description')
                                    ->required()
                                    ->lazy()
                                    ->rows(4)
                                    ->placeholder('Product description'),

                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('products')
                                    ->maxSize(1024)
                                    ->label('Product Image')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1')
                                    ->imageResizeTargetWidth('512')
                                    ->imageResizeTargetHeight('512'),
                            ])
                            ->columns(1),
                    ])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at', 'desc')
            ->poll('0')
            ->deferLoading()
            ->persistSortInSession()
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->square()
                    ->label('Image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('disease.name')
                    ->label('Disease')
                    ->searchable()
                    ->tooltip(fn(Product $record): string => $record->description),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disease')
                    ->relationship('disease', 'name')
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select([
                'id',
                'name',
                'price',
                'description',
                'shop_id',
                'disease_id',
                'created_at',
            ])
            ->with([
                'shop' => fn($q) => $q->select('id', 'name', 'user_id'),
                'disease' => fn($q) => $q->select('id', 'name'),
                'image' => fn($q) => $q->select('id', 'product_id', 'path')
            ]);

        if (auth('web')->user()->role === 'penjual') {
            $query->whereHas('shop', function ($q) {
                $q->where('user_id', auth('web')->id());
            });
        }

        $cacheKey = 'products_resource_' . auth('web')->id() . '_' . auth('web')->user()->role;

        $productIds = Cache::remember($cacheKey, 3600, function () use ($query) {
            return $query->pluck('id');
        });

        return static::$model::query()
            ->whereIn('id', $productIds)
            ->latest();
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
