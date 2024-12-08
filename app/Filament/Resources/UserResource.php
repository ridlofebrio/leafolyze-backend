<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with('userDetail')
            ->select(['id', 'email', 'created_at']);

        $cacheKey = 'users_resource_data';

        $userIds = Cache::remember($cacheKey, 3600, function () use ($query) {
            return $query->pluck('id');
        });

        return static::$model::query()
            ->whereIn('id', $userIds)
            ->with('userDetail')
            ->select(['id', 'email', 'created_at']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('userDetail.name')
                            ->required()
                            ->label('Name')
                            ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                if ($record && $record->userDetail) {
                                    $component->state($record->userDetail->name);
                                }
                            })
                            ->dehydrated(true)
                            ->live()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($record && $record->userDetail) {
                                    $record->userDetail->update(['name' => $state]);
                                }
                            }),
                        Forms\Components\DatePicker::make('userDetail.birth')
                            ->label('Birth Date')
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record && $record->userDetail) {
                                    $component->state($record->userDetail->birth);
                                }
                            })
                            ->dehydrated(true)
                            ->live()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($record && $record->userDetail) {
                                    $record->userDetail->update(['birth' => $state]);
                                }
                            }),
                        Forms\Components\Select::make('userDetail.gender')
                            ->label('Gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record && $record->userDetail) {
                                    $component->state($record->userDetail->gender);
                                }
                            })
                            ->dehydrated(true)
                            ->live()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($record && $record->userDetail) {
                                    $record->userDetail->update(['gender' => $state]);
                                }
                            }),
                        Forms\Components\Textarea::make('userDetail.address')
                            ->label('Address')
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record && $record->userDetail) {
                                    $component->state($record->userDetail->address);
                                }
                            })
                            ->dehydrated(true)
                            ->live()
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($record && $record->userDetail) {
                                    $record->userDetail->update(['address' => $state]);
                                }
                            }),
                        // Original user fields
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->required(fn(string $operation): bool => $operation === 'create'),
                        Forms\Components\Select::make('access')
                            ->options([
                                'admin' => 'Admin',
                                'petani' => 'Petani',
                                'penjual' => 'Penjual',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('id', 'desc')
            ->poll('0')
            ->columns([
                Tables\Columns\TextColumn::make('userDetail.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('access'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
