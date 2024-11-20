<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService
    ) {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->productService->getAllProducts();
            return ApiResponse::success('Products retrieved successfully', $products)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);
            return ApiResponse::success('Product retrieved successfully', $product)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->createProduct($request->validated());
            return ApiResponse::success('Product created successfully', $product)
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $product = $this->productService->updateProduct($id, $request->validated());
            return ApiResponse::success('Product updated successfully', $product)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);
            return ApiResponse::success('Product deleted successfully')->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function byShop(int $shopId): JsonResponse
    {
        try {
            $products = $this->productService->getProductsByShop($shopId);
            return ApiResponse::success('Shop products retrieved successfully', $products)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }

    public function byDisease(int $diseaseId): JsonResponse
    {
        try {
            $products = $this->productService->getProductsByDisease($diseaseId);

            if ($products->isEmpty()) {
                return ApiResponse::success(
                    "No products found for disease ID: {$diseaseId}",
                    []
                )->response();
            }

            return ApiResponse::success(
                "Products retrieved successfully",
                $products
            )->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())
                ->response()
                ->setStatusCode(400);
        }
    }
}