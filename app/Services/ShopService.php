<?php

namespace App\Services;

use App\Models\Shop;
use App\Services\Interfaces\CloudinaryServiceInterface;
use App\Services\Interfaces\ShopServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopService implements ShopServiceInterface
{
    public function __construct(
        protected CloudinaryServiceInterface $cloudinaryService
    ) {}

    public function getShop(int $shopId)
    {
        try {
            return Shop::with(['user', 'products', 'image'])->findOrFail($shopId);
        } catch (\Exception $e) {
            Log::error("Error fetching shop with ID {$shopId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateShop(int $shopId, array $data)
    {
        try {
            DB::beginTransaction();

            $shop = Shop::with('image')->findOrFail($shopId);

            // Update shop details
            $shopData = array_intersect_key($data, array_flip(['name', 'address', 'description', 'operational']));
            if (!empty($shopData)) {
                $shop->update($shopData);
            }

            // Handle shop image update
            if (isset($data['image'])) {
                // Delete old image if exists
                if ($shop->image) {
                    $this->cloudinaryService->deleteFile($shop->image->public_id);
                    $shop->image->delete();
                }

                // Upload new image
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'shops');
                $shop->image()->create([
                    'path' => $uploadResult['path'],
                    'public_id' => $uploadResult['public_id'],
                    'type' => 'shop'
                ]);
            }

            DB::commit();

            return $shop->fresh(['user', 'products', 'image']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating shop with ID {$shopId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function createShop(array $data)
    {
        try {
            DB::beginTransaction();

            $shopData = array_intersect_key($data, array_flip(['user_id', 'name', 'address', 'description', 'operational']));
            $shop = Shop::create($shopData);

            // Handle shop image upload
            if (isset($data['image'])) {
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'shops');
                $shop->image()->create([
                    'path' => $uploadResult['path'],
                    'public_id' => $uploadResult['public_id'],
                    'type' => 'shop'
                ]);
            }

            DB::commit();

            return $shop->fresh(['user', 'products', 'image']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error creating shop: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteShop(int $shopId)
    {
        try {
            $shop = Shop::with('image')->findOrFail($shopId);

            // Delete shop image if exists
            if ($shop->image) {
                $this->cloudinaryService->deleteFile($shop->image->public_id);
                $shop->image->delete();
            }

            $shop->delete();

            return true;
        } catch (\Exception $e) {
            Log::error("Error deleting shop with ID {$shopId}: " . $e->getMessage());
            throw $e;
        }
    }
    public function getAllShop()
    {
        try {
            return Shop::with('image')->latest()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getShopById(int $id)
    {
        try {
            return Shop::with('image')->findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Error fetching article ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}
