<?php

namespace App\Services;

use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        protected CloudinaryServiceInterface $cloudinaryService
    ) {}

    public function getAllProducts()
    {
        try {
            return Product::with(['shop', 'image'])->latest()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProductById(int $id)
    {
        try {
            return Product::with(['shop', 'image'])->findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Error fetching product ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function getProductsByShop(int $shopId)
    {
        try {
            return Product::with(['shop', 'image'])
                ->where('shop_id', $shopId)
                ->latest()
                ->get();
        } catch (\Exception $e) {
            Log::error("Error fetching products for shop ID {$shopId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function getProductsByDisease(int $diseaseId)
    {
        try {
            return Product::with(['shop', 'image', 'disease'])
                ->where('disease_id', $diseaseId)
                ->latest()
                ->get();
        } catch (\Exception $e) {
            Log::error("Error fetching products for disease ID {$diseaseId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function createProduct(array $data)
    {
        try {
            // Upload image to Cloudinary if exists
            if (isset($data['image'])) {
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'products');

                // Create product
                $product = Product::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'shop_id' => $data['shop_id'],
                ]);

                // Create image record
                $product->images()->create([
                    'path' => $uploadResult['path'],
                    'public_id' => $uploadResult['public_id'],
                    'type' => 'product'
                ]);

                return $product->load(['shop.user.userDetail', 'images']);
            }

            throw new \Exception('Product image is required');
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProduct(int $id, array $data)
    {
        try {
            $product = Product::findOrFail($id);

            // Check if user owns the shop
            if ($product->shop->user_id !== Auth::id()) {
                throw new \Exception('Unauthorized. You can only update your own products.');
            }

            // Handle image update if new image is provided
            if (isset($data['image'])) {
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'products');

                // Delete old image if exists
                if ($product->images()->exists()) {
                    $oldImage = $product->images()->first();
                    $this->cloudinaryService->deleteFile($oldImage->public_id);
                    $oldImage->delete();
                }

                // Create new image record
                $product->images()->create([
                    'path' => $uploadResult['path'],
                    'public_id' => $uploadResult['public_id'],
                    'type' => 'product'
                ]);
            }

            // Update product details
            $product->update([
                'name' => $data['name'] ?? $product->name,
                'description' => $data['description'] ?? $product->description,
                'price' => $data['price'] ?? $product->price,
                'stock' => $data['stock'] ?? $product->stock,
            ]);

            return $product->fresh(['shop.user.userDetail', 'images']);
        } catch (\Exception $e) {
            Log::error("Error updating product ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteProduct(int $id)
    {
        try {
            $product = Product::with('images')->findOrFail($id);

            // Check if user owns the shop
            if ($product->shop->user_id !== Auth::id()) {
                throw new \Exception('Unauthorized. You can only delete your own products.');
            }

            // Delete images from Cloudinary
            foreach ($product->images as $image) {
                $this->cloudinaryService->deleteFile($image->public_id);
            }

            return $product->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting product ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}