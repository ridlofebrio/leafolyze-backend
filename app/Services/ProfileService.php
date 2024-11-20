<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        protected CloudinaryServiceInterface $cloudinaryService
    ) {}

    public function getProfile(int $userId)
    {
        try {
            return User::with(['userDetail.image'])->findOrFail($userId);
        } catch (\Exception $e) {
            Log::error("Error fetching profile for user ID {$userId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateProfile(int $userId, array $data)
    {
        try {
            DB::beginTransaction();

            $user = User::with('userDetail.image')->findOrFail($userId);

            // Update email if provided
            if (isset($data['email'])) {
                $user->update(['email' => $data['email']]);
            }

            // Update or create user details
            $userDetail = $user->userDetail ?? new UserDetail(['user_id' => $userId]);
            $userDetailData = array_intersect_key($data, array_flip(['name', 'birth', 'gender', 'address']));

            if (!empty($userDetailData)) {
                $userDetail->fill($userDetailData);
                $userDetail->save();
            }

            // Handle profile image update
            if (isset($data['image'])) {
                // Delete old image if exists
                if ($userDetail->image) {
                    $this->cloudinaryService->deleteFile($userDetail->image->public_id);
                    $userDetail->image->delete();
                }

                // Upload new image
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'profiles');
                $userDetail->image()->create([
                    'path' => $uploadResult['path'],
                    'public_id' => $uploadResult['public_id'],
                    'type' => 'user_detail'
                ]);
            }

            DB::commit();

            return $user->fresh(['userDetail.image']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating profile for user ID {$userId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function updatePassword(int $userId, array $data)
    {
        try {
            $user = User::findOrFail($userId);

            // Verify old password
            if (!Hash::check($data['current_password'], $user->password)) {
                throw new \Exception('Current password is incorrect');
            }

            // Update password
            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error("Error updating password for user ID {$userId}: " . $e->getMessage());
            throw $e;
        }
    }
}
