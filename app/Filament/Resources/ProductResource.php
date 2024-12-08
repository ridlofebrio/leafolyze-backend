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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('shop_id')
                    ->label('Shop')
                    ->required()
                    ->options(Shop::all()->pluck('name', 'id'))
                    ->relationship('shop', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                Forms\Components\Select::make('disease_id')
                    ->label('Disease')
                    ->required()
                    ->options(Disease::all()->pluck('name', 'id'))
                    ->relationship('disease', 'name')
                    ->native(false)
                    ->preload(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('products')
                    ->columnSpanFull()
                    ->label('Product Image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('id', 'desc')
            ->poll('0')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shop.name')
                    ->label('Shop')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('disease.name')
                    ->label('Disease')
                    ->sortable()
                    ->searchable(),
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
                //
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select(['id', 'name', 'price', 'shop_id', 'disease_id', 'created_at'])
            ->with(['shop', 'disease', 'image']);

        if (auth('web')->user()->role == 'penjual') {
            $query->whereHas('shop', function ($query) {
                $query->where('user_id', auth('web')->id());
            });
        }

        $cacheKey = 'products_resource_data_' . auth('web')->id();

        $productIds = Cache::remember($cacheKey, 3600, function () use ($query) {
            return $query->pluck('id');
        });

        return static::$model::query()
            ->whereIn('id', $productIds)
            ->select(['id', 'name', 'price', 'shop_id', 'disease_id', 'created_at'])
            ->with(['shop', 'disease', 'image']);
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
