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
            $shops = $this->service->getAllShop();
            return ApiResponse::success('shops retrieved successfully', $shops)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(500);
        }
    }

    public function show($id)
    {
        try {
            $shop = $this->service->getShopById($id);
            return ApiResponse::success('shop retrieved successfully', $shop)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }

    public function store(CreateShopRequest $request): JsonResponse
    {
        try {
            $shop = $this->service->createShop($request->validated());
            return ApiResponse::success('shop created successfully', $shop)
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function update(CreateShopRequest $request, $id): JsonResponse
    {
        try {
            $shop = $this->service->updateShop($id, $request->validated());
            return ApiResponse::success('shop updated successfully', $shop)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->deleteShop($id);
            return ApiResponse::success('shop deleted successfully')->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }
}
