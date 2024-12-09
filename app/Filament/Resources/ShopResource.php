<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopResource\Pages;
use App\Filament\Resources\ShopResource\RelationManagers;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->lazy()
                            ->placeholder('Shop name'),

                        Forms\Components\TextInput::make('operational')
                            ->required()
                            ->maxLength(255)
                            ->lazy()
                            ->placeholder('e.g. Mon-Fri 09:00-17:00'),

                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->lazy()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->maxLength(255)
                            ->lazy()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('shops')
                            ->maxSize(5120)
                            ->disk('public')
                            ->preserveFilenames()
                            ->columnSpanFull()
                            ->label('Shop Image')
                            ->helperText('Max 2MB.')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at', 'desc')
            ->deferLoading()
            ->poll('0')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.userDetail.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('operational')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            ->select([
                'id',
                'name',
                'address',
                'description',
                'operational',
                'user_id',
                'created_at'
            ])
            ->with([
                'user.userDetail' => fn($q) => $q->select('id', 'name'),
                'image' => fn($q) => $q->select('id', 'shop_id', 'path')
            ]);

        return static::$model::query()
            ->whereIn('id', $query->pluck('id'))
            ->select([
                'id',
                'name',
                'address',
                'description',
                'operational',
                'user_id',
                'created_at'
            ])
            ->with([
                'user.userDetail',
                'image'
            ])
            ->latest();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShops::route('/'),
            'create' => Pages\CreateShop::route('/create'),
            'edit' => Pages\EditShop::route('/{record}/edit'),
        ];
    }
}
