<?php

namespace App\Services\Interfaces;

interface ProfileServiceInterface
{
    public function getProfile(int $userId);
    public function updateProfile(int $userId, array $data);
    public function updatePassword(int $userId, array $data);
}
