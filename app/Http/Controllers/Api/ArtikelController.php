<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GambarResource;
use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Providers\Services\ArtikelService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class ArtikelController extends Controller
{
    private ArtikelService $service;

    public function __construct(ArtikelService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            Log::info('Attempting to retrieve posts');
            $posts = Artikel::latest()->paginate(5);
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
            $post = Artikel::findOrFail($id);
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
    public function store(Request $request)
    {
        $success = $this->service->store($request->getFile());

        return $success ?
            new GambarResource(true, 'Gambar berhasil ditambahkan!', '') :
            new GambarResource(false, 'Gagal menambahkan gambar', '');
    }

    public function update(Request $request, $id)
    {
        $success = $this->service->update($id, $request->getFile());

        return $success ?
            new GambarResource(true, 'Gambar berhasil diupdate', '') :
            new GambarResource(false, 'Gagal mengupdate gambar', '');
    }

    public function destroy($id)
    {
        $success = $this->service->delete($id);

        return $success ?
            new GambarResource(true, 'Gambar berhasil dihapus', '') :
            new GambarResource(false, 'Gagal menghapus gambar', '');
    }

}
