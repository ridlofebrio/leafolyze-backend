<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateShopRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Models\Shop;
use App\Services\ShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    private ShopService $service;

    public function __construct(ShopService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            Log::info('Attempting to retrieve shops');
            $shops = Shop::all();
            Log::info('Shops retrieved successfully');
            return new ApiResponse(true, 'List of Shops', $shops);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve shops', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve shop data',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            Log::info("Attempting to retrieve shop with ID: $id");
            $shop = Shop::findOrFail($id);
            Log::info("Shop with ID $id retrieved successfully");
            return new ApiResponse(true, 'Shop Details', $shop);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve shop with ID: $id", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Shop with ID ' . $id . ' not found',
            ], 500);
        }
    }

    public function store(CreateShopRequest $request): JsonResponse
    {
        try {
            $article = $this->service->createShop($request->validated());
            return ApiResponse::success('Article created successfully', $article)
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function update(CreateShopRequest $request, $id): JsonResponse
    {
        try {
            $article = $this->service->updateShop($id, $request->validated());
            return ApiResponse::success('Article updated successfully', $article)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->deleteShop($id);
            return ApiResponse::success('Article deleted successfully')->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }
}
