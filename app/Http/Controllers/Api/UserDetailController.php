<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserDetailStoreRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Models\UserDetail;
use App\Providers\Services\UserDetailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserDetailController extends Controller
{
    private UserDetailService $service;

    public function __construct(UserDetailService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            Log::info('Attempting to retrieve posts');
            $posts = UserDetail::all();
            Log::info('Posts retrieved successfully');
            return new ApiResponse(true, 'List Data Posts', $posts);
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
            $post = UserDetail::findOrFail($id);
            Log::info("Post with ID $id retrieved successfully");
            return new ApiResponse(true, 'Detail Data Post', $post);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve post with ID: $id", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Post dengan ID ' . $id . ' tidak ditemukan',
            ], 500);
        }
    }

    public function store(UserDetailStoreRequest $request): ApiResponse
    {
        $success = $this->service->store($request->getFile());

        return $success ?
            new ApiResponse(true, 'Gambar berhasil ditambahkan!', '') :
            new ApiResponse(false, 'Gambar gagal ditambahkan!', '');
    }

    public function update(UserDetailStoreRequest $request, $id): ApiResponse
    {
        $success = $this->service->update($id, $request->getFile());

        return $success ?
            new ApiResponse(true, 'Gambar berhasil diupdate!', '') :
            new ApiResponse(false, 'Gambar gagal diupdate!', '');
    }

    public function destroy($id): ApiResponse
    {
        $success = $this->service->delete($id);

        return $success ?
            new ApiResponse(true, 'Gambar berhasil dihapus', '') :
            new ApiResponse(false, 'Gagal menghapus gambar', '');
    }
}
