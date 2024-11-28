<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Detection\CreateDetectionRequest;
use App\Http\Requests\Detection\UpdateDetectionRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Services\Interfaces\DetectionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DetectionController extends Controller
{
    public function __construct(
        protected DetectionServiceInterface $detectionService
    ) {
//        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        try {

            $detections = $this->detectionService->getAllDetections(Auth::id());
            return ApiResponse::success('Detections retrieved successfully', $detections)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            if (Auth::user()->access !== 'petani') {
                return ApiResponse::error('Unauthorized. Only petani can access detections.')
                    ->response()
                    ->setStatusCode(403);
            }

            $detection = $this->detectionService->getDetectionById($id);

            // Check if detection belongs to user
            if ($detection->user_id !== Auth::id()) {
                return ApiResponse::error('Unauthorized. You can only view your own detections.')
                    ->response()
                    ->setStatusCode(403);
            }

            return ApiResponse::success('Detection retrieved successfully', $detection)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }

    public function store(CreateDetectionRequest $request): JsonResponse
    {
        Log::info('Controller', $request->all());
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            $detection = $this->detectionService->createDetection($data);
            return ApiResponse::success('Detection saved successfully', $detection)
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function update(UpdateDetectionRequest $request, int $id): JsonResponse
    {
        try {
            $detection = $this->detectionService->getDetectionById($id);

            // Check if detection belongs to user
            if ($detection->user_id !== Auth::id()) {
                return ApiResponse::error('Unauthorized. You can only update your own detections.')
                    ->response()
                    ->setStatusCode(403);
            }

            $data = $request->validated();
            $updatedDetection = $this->detectionService->updateDetection($id, $data);

            return ApiResponse::success(
                $request->has('image') ? 'Detection regenerated successfully' : 'Detection title updated successfully',
                $updatedDetection
            )->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {

            $detection = $this->detectionService->getDetectionById($id);

            // Check if detection belongs to user
            if ($detection->user_id !== Auth::id()) {
                return ApiResponse::error('Unauthorized. You can only delete your own detections.')
                    ->response()
                    ->setStatusCode(403);
            }

            $this->detectionService->deleteDetection($id);
            return ApiResponse::success('Detection deleted successfully')->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }
}
