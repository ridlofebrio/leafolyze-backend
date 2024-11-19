<?php

namespace App\Providers\Services;


use App\Models\UserDetail;
use App\Providers\Services\Interface\CRUDInterface;
use Illuminate\Support\Facades\Log;

class UserDetailService implements  CRUDInterface
{
    public function store($data): bool
    {
        try {
            Log::info('Uploading image to Cloudinary');
            Log::info($data);
            $gambar = UserDetail::create($data);
            Log::info('Post created successfully', ['post_id' => $gambar->id]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to upload image to Cloudinary', ['error' => $e->getMessage()]);
            return false;
        }
    }
    public function update($id, $data): bool
    {
        try {
            Log::info("Attempting to update post with ID: $id");
            $gambar = UserDetail::findOrFail($id)->update($data);
            Log::info("Post with ID: $id updated successfully");

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to update post with ID: $id", ['error' => $e->getMessage()]);
            return false;
        }
    }
    public function delete($id): bool
    {
        try {
            Log::info("Attempting to delete post with ID: $id");
            $gambar = UserDetail::findOrFail($id);
            $gambar->delete();
            Log::info("Post with ID: $id deleted successfully");

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete post with ID: $id", ['error' => $e->getMessage()]);
            return false;
        }
    }
}
