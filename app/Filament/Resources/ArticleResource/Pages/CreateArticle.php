<?php

namespace App\Filament\Resources\ArticleResource\Pages;


use App\Filament\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
  
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
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
        $articleService = new ArticleService($cloudinaryService);
        return $articleService->createArticle($data);
    }
}
