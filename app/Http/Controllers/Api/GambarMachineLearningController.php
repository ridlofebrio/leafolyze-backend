<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostStoreRequest;
use App\Http\Requests\Api\PostUpdateRequest;
use App\Http\Resources\GambarResource;
use App\Models\Gambar;
use App\Providers\Services\GambarService;
use Illuminate\Support\Facades\Log;

class GambarMachineLearningController extends Controller
{
    private GambarService $service;

    public function __construct(GambarService $service)
    {
        $this->service = $service;
    }

    /**
     * index
     *
     * @return GambarResource
     */
    public function index(): GambarResource
    {
        try {
            Log::info('Attempting to retrieve posts');
            $posts = Gambar::latest()->paginate(5);
            Log::info('Posts retrieved successfully');

            return new GambarResource(true, 'List Data Posts', $posts);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve posts', ['error' => $e->getMessage()]);
            return new GambarResource(false, 'Gagal mengambil data post', '');
        }
    }

    public function show($id): GambarResource
    {
        try {
            Log::info("Attempting to retrieve post with ID: $id");
            $post = Gambar::findOrFail($id);
            Log::info("Post with ID $id retrieved successfully");

            return new GambarResource(true, 'Detail Data Post', $post);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve post with ID: $id", ['error' => $e->getMessage()]);
            return new GambarResource(false, 'Post dengan ID ' . $id . ' tidak ditemukan', '');
        }
    }

    public function store(PostStoreRequest $request): GambarResource
    {
        $success = $this->service->store($request->getFile());

        return $success ?
            new GambarResource(true, 'Gambar berhasil ditambahkan!', '') :
            new GambarResource(false, 'Gagal menambahkan gambar', '');
    }

    public function update(PostUpdateRequest $request, $id): GambarResource
    {
        $success = $this->service->update($id, $request->getFile());

        return $success ?
            new GambarResource(true, 'Gambar berhasil diupdate', '') :
            new GambarResource(false, 'Gagal mengupdate gambar', '');
    }

    public function destroy($id): GambarResource
    {
        $success = $this->service->delete($id);

        return $success ?
            new GambarResource(true, 'Gambar berhasil dihapus', '') :
            new GambarResource(false, 'Gagal menghapus gambar', '');
    }
}
