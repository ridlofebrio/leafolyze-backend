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
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->lazy(),

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
                            ->optionsLimit(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->lazy(),

                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('products')
                            ->maxSize(1024)
                            ->label('Product Image'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('id', 'desc')
            ->poll('0')
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('disease.name')
                    ->label('Disease')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select(['id', 'name', 'price', 'description', 'shop_id', 'disease_id'])
            ->with(['shop:id,name', 'disease:id,name']);

        if (auth('web')->user()->role === 'penjual') {
            $query->whereHas('shop', fn($q) => $q->where('user_id', auth('web')->id()));
        }

        $cacheKey = 'products_resource_data_' . auth('web')->id();

        $productIds = Cache::remember($cacheKey, 3600, function () use ($query) {
            return $query->pluck('id');
        });

        return $query->whereIn('id', $productIds);
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
