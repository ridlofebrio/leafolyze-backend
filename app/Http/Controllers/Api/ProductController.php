<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ProductStoreRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Providers\Services\ProductService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\GambarResource;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    private ProductService $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * index
     *
     * @return GambarResource
     */


    public function index(Request $request)
    {
        try {
            $type = ucwords(str_replace('-', ' ', ($request->query('type'))));
            Log::info('Attempting to retrieve posts');
            $products = ($type) ? Product::with('shop')->where('type', $type)->get() : Product::with('shop')->get();
            Log::info('Posts retrieved successfully');
            return new GambarResource(true, 'List Data Posts', $products);
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
            $post = Product::findOrFail($id);
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

    public function store(ProductStoreRequest $request): GambarResource
    {
        $success = $this->service->store($request->getFile());

        return $success ?
            new GambarResource(true, 'Gambar berhasil ditambahkan!', '') :
            new GambarResource(false, 'Gagal menambahkan gambar', '');
    }

    public function update(ProductUpdateRequest $request, $id): GambarResource
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
