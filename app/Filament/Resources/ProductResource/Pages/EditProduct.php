<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use App\Services\ProductService;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        log::info('id:', [$record->id]);
        if (isset($data['image'])) {
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
        }

        $cloudinaryService = app(CloudinaryServiceInterface::class);
        $productService = new ProductService($cloudinaryService);
        return $productService->updateProduct($record->id, $data);
    }
}
