<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Services\Interfaces\ProfileServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileServiceInterface $profileService
    ) {
        $this->middleware('auth:api');
    }

    public function show(): JsonResponse
    {
        try {
            $profile = $this->profileService->getProfile(Auth::id());
            return ApiResponse::success('Profile retrieved successfully', $profile)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $profile = $this->profileService->updateProfile(Auth::id(), $request->validated());
            return ApiResponse::success('Profile updated successfully', $profile)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        try {
            $this->profileService->updatePassword(Auth::id(), $request->validated());
            return ApiResponse::success('Password updated successfully')->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }
}