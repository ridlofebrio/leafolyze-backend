<?php

namespace App\Services\Interfaces;

interface CloudinaryServiceInterface
{
    /**
     * Upload a file to Cloudinary
     *
     * @param mixed $file
     * @param string $folder
     * @return array
     */
    public function uploadFile($file, string $folder): array;

    /**
     * Delete a file from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function deleteFile(string $publicId): bool;

    /**
     * Delete multiple files from Cloudinary
     *
     * @param array $images
     * @return void
     */
    public function deleteMultipleFiles(array $images): void;

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
    public function processImages(array $existingImages, array $oldRequestData, array $newRequestData, int $modelId, string $folder): void;
}
