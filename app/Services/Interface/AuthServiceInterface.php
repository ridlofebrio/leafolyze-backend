<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    public function login(array $credentials);
    public function register(array $data);
    public function logout();
    public function refresh();
    public function profile();
}
