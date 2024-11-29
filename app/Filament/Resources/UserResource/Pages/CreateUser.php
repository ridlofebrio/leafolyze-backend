<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\UserDetail;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // protected function handleRecordCreation(array $data): \App\Models\User
    // {
    //     // Extract name from data
    //     $name = $data['userDetail']['name'] ?? null;
    //     unset($data['userDetail']);

    //     // Create user
    //     $user = static::getModel()::create($data);

    //     // Create associated UserDetail
    //     if ($name) {
    //         UserDetail::create([
    //             'user_id' => $user->id,
    //             'name' => $name
    //         ]);
    //     }

    //     return $user;
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
