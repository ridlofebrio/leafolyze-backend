<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use App\Services\ShopService;
use App\Services\Interfaces\CloudinaryServiceInterface;

class CreateShop extends CreateRecord
{
    protected static string $resource = ShopResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $tempFile = Storage::disk('public')->get($data['image']);
        $tempPath = Storage::disk('public')->path($data['image']);
        
        $file = new \Illuminate\Http\UploadedFile(
            $tempPath,
            $data['image'],
            Storage::disk('public')->mimeType($data['image']),
            null,
            true
        );
        
        $data['image'] = $file;

        $cloudinaryService = app(CloudinaryServiceInterface::class);
        $shopService = new ShopService($cloudinaryService);
        return $shopService->createShop($data);
    }
}
