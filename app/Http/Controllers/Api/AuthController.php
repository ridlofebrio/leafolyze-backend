<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());
            return ApiResponse::success('Login successful', $result)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->register($request->validated());
            return ApiResponse::success('Register successful', $result)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Middleware(['auth:api'])]
    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();
            return ApiResponse::success('Successfully logged out')->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    #[Middleware(['auth:api'])]
    public function refresh(): JsonResponse
    {
        try {
            $result = $this->authService->refresh();
            return ApiResponse::success('Refresh successful', $result)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    #[Middleware(['auth:api'])]
    public function profile(): JsonResponse
    {
        try {
            $result = $this->authService->profile();
            return ApiResponse::success('Profile retrieved successfully', $result)->response();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
