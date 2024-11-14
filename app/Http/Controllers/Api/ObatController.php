<?php

namespace App\Http\Controllers\Api;

use App\Models\Obat;
use App\Http\Controllers\Controller;
use App\Providers\Services\ObatService;
use App\Http\Requests\Api\ObatStoreRequest;
use App\Http\Requests\Api\ObatUpdateRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\GambarResource;


class ObatController extends Controller
{
    private ObatService $service;
    public function __construct(ObatService $service)
    {
        $this->service = $service;
    }

    /**
     * index
     *
     * @return GambarResource
     */

    public function index()
    {
        try {
            Log::info('Attempting to retrieve posts');
            $posts = Obat::all();
            Log::info('Posts retrieved successfully');
            return new GambarResource(true, 'List Data Posts', $posts);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve posts', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data post',
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            Log::info("Attempting to retrieve post with ID: $id");
            $post = Obat::findOrFail($id);
            Log::info("Post with ID $id retrieved successfully");
            return new GambarResource(true, 'Detail Data Post', $post);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve post with ID: $id", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Post dengan ID ' . $id . ' tidak ditemukan',
            ], 500);
        }
    }

    public function store(ObatStoreRequest $request): GambarResource
    {
        $success = $this->service->store($request->getFile());

        return $success ?
            new GambarResource(true, 'Gambar berhasil ditambahkan!', '') :
            new GambarResource(false, 'Gagal menambahkan gambar', '');
    }

    public function update(ObatUpdateRequest $request, $id): GambarResource
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
