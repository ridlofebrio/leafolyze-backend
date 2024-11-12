<?php

namespace App\Trait;

use App\Providers\Services\Interface\Services\CloudinaryStorage;
use Illuminate\Support\Facades\Log;
use App\Models\Gambar;

trait ImageTrait
{
    public function handleUpload($id = null){
        if ($this->hasFile('gambarUrl')) {
            if ($id) {
                $gambar = Gambar::findOrFail($id);
                CloudinaryStorage::delete($gambar->gambarUrl);
            }

            $image = $this->file('gambarUrl');

            $result = CloudinaryStorage::upload($image, $this->input('gambarUrl'));

            $this->merge(['gambarUrl' => $result]);
            Log::info('Image uploaded successfully', ['url' => $result]);
        }
    }

}
