<?php

namespace App\Services;

use App\Models\Article;
use App\Services\Interfaces\ArticleServiceInterface;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleService implements ArticleServiceInterface
{
    public function __construct(
        protected CloudinaryServiceInterface $cloudinaryService
    ) {}

    public function getAllArticles()
    {
        try {
            return Article::with('user.userDetail')->latest()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getArticleById(int $id)
    {
        try {
            return Article::with('user.userDetail')->findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Error fetching article ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function createArticle(array $data)
    {
        try {
            if (isset($data['image'])) {
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'articles');
                $data['gambarUrl'] = $uploadResult['path'];
            }

            $data['user_id'] = Auth::id();
            return Article::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateArticle(int $id, array $data)
    {
        try {
            $article = Article::findOrFail($id);

            if (isset($data['image'])) {
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'articles');
                $data['gambarUrl'] = $uploadResult['path'];

                // Delete old image if exists
                if ($article->gambarUrl) {
                    $oldPublicId = $this->getPublicIdFromUrl($article->gambarUrl);
                    if ($oldPublicId) {
                        $this->cloudinaryService->deleteFile($oldPublicId);
                    }
                }
            }

            $article->update($data);
            return $article->fresh();
        } catch (\Exception $e) {
            Log::error("Error updating article ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteArticle(int $id)
    {
        try {
            $article = Article::findOrFail($id);

            if (Auth::user()->access !== 'admin') {
                throw new \Exception('Unauthorized. Only admin can delete articles.');
            }

            // Delete image from Cloudinary if exists
            if ($article->gambarUrl) {
                $publicId = $this->getPublicIdFromUrl($article->gambarUrl);
                if ($publicId) {
                    $this->cloudinaryService->deleteFile($publicId);
                }
            }

            return $article->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting article ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    private function getPublicIdFromUrl(string $url): ?string
    {
        preg_match('/articles\/([^.]+)/', $url, $matches);
        return isset($matches[1]) ? 'articles/' . $matches[1] : null;
    }
}