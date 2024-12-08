<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->label('Email')
                            ->lazy()
                            ->disabled()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->label('Password')
                            ->lazy(),
                    ]),
                Forms\Components\Section::make('Detail Information')
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
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('userDetail.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('access')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'penjual' => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('userDetail.birth')
                    ->label('Birth Date')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('userDetail.gender')
                    ->label('Gender')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('access')
                    ->options([
                        'admin' => 'Admin',
                        'penjual' => 'Penjual',
                        'user' => 'User',
                    ]),
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
            ->select([
                'id',
                'email',
                'access',
                'created_at',
            ])
            ->where('access', '!=', 'admin')
            ->with([
                'userDetail' => fn($q) => $q->select(
                    'id',
                    'user_id',
                    'name',
                    'birth',
                    'gender',
                    'address'
                ),
            ]);

        return static::$model::query()
            ->whereIn('id', $query->pluck('id'))
            ->where('access', '!=', 'admin')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
