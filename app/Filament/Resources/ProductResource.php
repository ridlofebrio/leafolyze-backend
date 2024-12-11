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
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                                    ->maxSize(2048)
                                    ->label('Product Image')
                                    ->disk('public')
                                    ->preserveFilenames()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1')
                                    ->imageResizeTargetWidth('512')
                                    ->imageResizeTargetHeight('512')
                                    ->helperText('Max 2MB.')
//                                    ->required(),
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

        $user = auth('web')->user();

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
                'image' => fn($q) => $q->select('id', 'product_id', 'path'),
            ]);

        if ($user->access == 'penjual') {
            $query->whereHas('shop', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        }
        return static::$model::query()
            ->whereIn('id', $query->pluck('id'))
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
