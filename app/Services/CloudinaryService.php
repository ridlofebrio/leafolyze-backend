<?php

namespace App\Services;

use App\Models\Image;
use App\Services\Interfaces\CloudinaryServiceInterface;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryService implements CloudinaryServiceInterface
{
    /**
     * Upload a file to Cloudinary
     *
     * @param mixed $file
     * @param string $folder
     * @return array
     */
    public function uploadFile($file, string $folder): array
    {
        try {
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                $result = $file->storeOnCloudinary($folder);
            } else {
                $result = Cloudinary::uploadFile($file, ['folder' => $folder]);
            }

            return [
                'path' => $result->getSecurePath(),
                'public_id' => $result->getPublicId(),
            ];
        } catch (\Exception $e) {
            Log::error("Error uploading file to Cloudinary: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a file from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function deleteFile(string $publicId): bool
    {
        try {
            $result = Cloudinary::destroy($publicId);
            return $result['result'] === 'ok';
        } catch (\Exception $e) {
            Log::error("Error deleting file from Cloudinary: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete multiple files from Cloudinary
     *
     * @param array $images
     * @return void
     */
    public function deleteMultipleFiles(array $images): void
    {
        foreach ($images as $image) {
            try {
                $this->deleteFile($image->public_id);
                $image->delete();
            } catch (\Exception $e) {
                Log::error("Error deleting image {$image->public_id}: " . $e->getMessage());
            }
        }
    }


    /**
     * Process multiple images (create, update, delete)
     *
     * @param array $existingImages
     * @param array $oldRequestData
     * @param array $newRequestData
     * @param int $modelId
     * @param string $folder
     * @return void
     */
    public function processImages(array $existingImages, array $oldRequestData, array $newRequestData, int $modelId, string $folder): void
    {
        try {
            foreach ($oldRequestData as $index => $oldRequestItem) {
                if ($oldRequestItem === null && isset($existingImages[$index])) {
                    // Delete old image
                    $this->deleteFile($existingImages[$index]->public_id);
                    $existingImages[$index]->delete();

                    // Upload new image if exists
                    if (isset($newRequestData[$index])) {
                        $this->createImage($newRequestData[$index], $modelId, $folder);
                    }
                } elseif ($oldRequestItem !== null && !isset($existingImages[$index]) && isset($newRequestData[$index])) {
                    // Create new image
                    $this->createImage($newRequestData[$index], $modelId, $folder);
                }
            }

            // Handle additional new images
            if (count($oldRequestData) > count($existingImages)) {
                for ($i = count($existingImages); $i < count($oldRequestData); $i++) {
                    if (isset($newRequestData[$i])) {
                        $this->createImage($newRequestData[$i], $modelId, $folder);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error processing images: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a new image record
     *
     * @param mixed $file
     * @param int $modelId
     * @param string $folder
     * @return Image
     */
    private function createImage($file, int $modelId, string $folder): Image
    {
        $cloudinaryData = $this->uploadFile($file, $folder);

        return Image::create([
            $folder . '_id' => $modelId,
            'type' => $folder,
            'path' => $cloudinaryData['path'],
            'public_id' => $cloudinaryData['public_id'],
            'name' => $file->getClientOriginalName(),
        ]);
    }
}