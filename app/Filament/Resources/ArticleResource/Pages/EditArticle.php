<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

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
        if (isset($data['image'])) {
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
        }

        $cloudinaryService = app(CloudinaryServiceInterface::class);
        $articleService = new ArticleService($cloudinaryService);
        return $articleService->updateArticle($record->id, $data);
    }
}
