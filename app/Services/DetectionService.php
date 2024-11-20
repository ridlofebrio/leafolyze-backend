<?php

namespace App\Services;

use App\Models\TomatoLeafDetection;
use App\Services\Interfaces\DetectionServiceInterface;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetectionService implements DetectionServiceInterface
{
    public function __construct(
        protected CloudinaryServiceInterface $cloudinaryService
    ) {}

    public function getAllDetections(int $userId)
    {
        try {
            return TomatoLeafDetection::with(['diseases', 'image', 'user'])
                ->where('user_id', $userId)
                ->latest()
                ->get();
        } catch (\Exception $e) {
            Log::error('Error fetching detections: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getDetectionById(int $id)
    {
        try {
            return TomatoLeafDetection::with(['diseases.products.shop', 'image', 'user'])
                ->findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Error fetching detection ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function createDetection(array $data)
    {
        try {
            DB::beginTransaction();

            // Upload image to Cloudinary
            if (!isset($data['image'])) {
                throw new \Exception('Detection image is required');
            }

            // Create detection record
            $detection = TomatoLeafDetection::create([
                'user_id' => $data['user_id'],
                'title' => $data['title'],
            ]);

            // Upload and create image
            $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'detections');
            $detection->image()->create([
                'path' => $uploadResult['path'],
                'public_id' => $uploadResult['public_id'],
                'type' => 'tomato_leaf_detection'
            ]);

            // Attach diseases
            if (isset($data['disease_ids']) && is_array($data['disease_ids'])) {
                $detection->diseases()->attach($data['disease_ids']);
            }

            DB::commit();

            return $detection->load(['diseases.products.shop', 'image', 'user']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating detection: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateDetection(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $detection = TomatoLeafDetection::with('image')->findOrFail($id);

            // Update title if provided
            if (isset($data['title'])) {
                $detection->update(['title' => $data['title']]);
            }

            // Handle image regeneration if new image is provided
            if (isset($data['image'])) {
                // Delete old image from Cloudinary if exists
                if ($detection->image) {
                    $this->cloudinaryService->deleteFile($detection->image->public_id);
                    $detection->image->delete();
                }

                // Upload new image
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'detections');
                $detection->image()->create([
                    'path' => $uploadResult['path'],
                    'public_id' => $uploadResult['public_id'],
                    'type' => 'tomato_leaf_detection'
                ]);

                // Update diseases if provided with new detection
                if (isset($data['disease_ids']) && is_array($data['disease_ids'])) {
                    $detection->diseases()->sync($data['disease_ids']);
                }
            }

            DB::commit();

            return $detection->fresh(['diseases.products.shop', 'image', 'user']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating detection ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteDetection(int $id)
    {
        try {
            DB::beginTransaction();

            $detection = TomatoLeafDetection::with('image')->findOrFail($id);

            // Delete image from Cloudinary if exists
            if ($detection->image) {
                $this->cloudinaryService->deleteFile($detection->image->public_id);
            }

            $detection->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting detection ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}