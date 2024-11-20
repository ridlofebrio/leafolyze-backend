<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Articles\CreateArticleRequest;
use App\Http\Requests\Api\Articles\UpdateArticleRequest;
use App\Http\Resources\Api\ApiResponse;
use App\Models\Article;
use App\Services\Interfaces\ArticleServiceInterface;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleServiceInterface $articleService
    ) {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        try {
            $articles = $this->articleService->getAllArticles();
            return ApiResponse::success('Articles retrieved successfully', $articles)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $article = $this->articleService->getArticleById($id);
            return ApiResponse::success('Article retrieved successfully', $article)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(404);
        }
    }

    public function store(CreateArticleRequest $request): JsonResponse
    {
        try {
            $article = $this->articleService->createArticle($request->validated());
            return ApiResponse::success('Article created successfully', $article)
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function update(UpdateArticleRequest $request, int $id): JsonResponse
    {
        try {
            $article = $this->articleService->updateArticle($id, $request->validated());
            return ApiResponse::success('Article updated successfully', $article)->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            if (auth()->user()->access !== 'admin') {
                return ApiResponse::error('Unauthorized. Only admin can delete articles.')
                    ->response()
                    ->setStatusCode(403);
            }

            $this->articleService->deleteArticle($id);
            return ApiResponse::success('Article deleted successfully')->response();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage())->response()->setStatusCode(400);
        }
    }
}