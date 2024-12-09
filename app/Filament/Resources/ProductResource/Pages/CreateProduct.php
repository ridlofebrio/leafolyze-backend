<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\ProductService;
use App\Services\Interfaces\CloudinaryServiceInterface;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = auth('web')->user();
        if ($user && $user->shop) {
            $data['shop_id'] = $user->shop->id;
        } else {
            // Handle the case where the user does not have a shop
            // For example, you might throw an exception or set a default value
            throw new \Exception('User does not have an associated shop.');
        }
        log::info($data);

        $tempFile = Storage::disk('public')->get($data['image']);
        $tempPath = Storage::disk('public')->path($data['image']);

        // Buat UploadedFile instance
        $file = new \Illuminate\Http\UploadedFile(
            $tempPath,
            $data['image'],
            Storage::disk('public')->mimeType($data['image']),
            null,
            true
        );

        // Update data dengan file yang sudah dikonversi
        $data['image'] = $file;

        $cloudinaryService = app(CloudinaryServiceInterface::class);
        $productService = new ProductService($cloudinaryService);
        return $productService->createProduct($data);
    }
}
