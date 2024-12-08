<?php

namespace App\Forms\Components;

use Filament\Forms\Components\FileUpload;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryFileUpload extends FileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeStateDehydrated(function () {
            $state = $this->getState();

            Log::debug('Initial state:', ['state' => $state]);

            if (!$state) return;

            if (is_array($state)) {
                $fileData = reset($state);
                if (is_array($fileData) && isset($fileData['Livewire\Features\SupportFileUploads\TemporaryUploadedFile'])) {
                    $filePath = $fileData['Livewire\Features\SupportFileUploads\TemporaryUploadedFile'];

                    try {
                        Log::debug('Attempting Cloudinary upload', [
                            'path' => $filePath
                        ]);

                        $result = Cloudinary::upload($filePath, [
                            'folder' => 'articles',
                            'resource_type' => 'auto'
                        ]);

                        Log::debug('Cloudinary upload result', [
                            'result' => $result
                        ]);

                        $this->state($result->getSecurePath());

                        log::info('Upload state:', ['state' => $this->getState()]);
                    } catch (\Exception $e) {
                        Log::error('Cloudinary upload failed', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }
            });
        }
}
