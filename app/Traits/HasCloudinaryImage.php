<?php

namespace App\Traits;

use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Log;

trait HasCloudinaryImage
{
    /**
     * Handle image upload to Cloudinary
     *
     * @param mixed $file
     * @param string $folder
     * @return string|null
     */
    protected function handleImageUpload($file, string $folder): ?string
    {
        try {
            if ($file) {
                $cloudinaryService = app(CloudinaryServiceInterface::class);
                $result = $cloudinaryService->uploadFile($file, $folder);
                return $result['path'];
            }
            return null;
        } catch (\Exception $e) {
            Log::error("Error handling image upload: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete image from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    protected function deleteCloudinaryImage(string $publicId): bool
    {
        try {
            $cloudinaryService = app(CloudinaryServiceInterface::class);
            return $cloudinaryService->deleteFile($publicId);
        } catch (\Exception $e) {
            Log::error("Error deleting cloudinary image: " . $e->getMessage());
            throw $e;
        }
    }
}
