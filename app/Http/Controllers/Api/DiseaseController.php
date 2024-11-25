<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ApiResponse;
use App\Services\Interfaces\DiseaseServiceInterface;
use Illuminate\Http\JsonResponse;

class DiseaseController extends Controller
{
    public function __construct(
        protected DiseaseServiceInterface $diseaseService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $diseases = $this->diseaseService->getAllDiseases();
            return ApiResponse::success('Diseases retrieved successfully', $diseases)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $disease = $this->diseaseService->getDiseaseById($id);
            return ApiResponse::success('Disease retrieved successfully', $disease)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }
}
