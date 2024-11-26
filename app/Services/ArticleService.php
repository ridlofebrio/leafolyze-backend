<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Image;
use App\Services\Interfaces\ArticleServiceInterface;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleService implements ArticleServiceInterface
{
    public function __construct(
        protected CloudinaryServiceInterface $cloudinaryService
    ) {}

    public function getAllArticles()
    {
        try {
            return Article::with('image')->latest()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getArticleById(int $id)
    {
        try {
            return Article::with('image')->findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Error fetching article ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function createArticle(array $data)
    {
        try {
            DB::beginTransaction();

            $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'articles');
            $data['path'] = $uploadResult['path'];
            $data['public_id'] = $uploadResult['public_id'];

            $article = Article::create($data);

            Image::create([
                'url' => $data['path'],
                'public_id' => $data['public_id'],
                'type' => 'article',
                'article_id' => $article->id,
            ]);

            DB::commit();

            return $article;

        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateArticle(int $id, array $data)
    {
        try {
            $article = Article::findOrFail($id);

            // Check if a new image is provided
            if (isset($data['image'])) {
                // Upload the new image
                $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'articles');
                $data['path'] = $uploadResult['path'];
                Log::info("Uploaded new image: {$data['path']}");

                // Delete the old image if it exists
                if ($article->image) {
                    $oldImage = Image::where('article_id', $article->id)->where('type', 'article')->first();

                    if ($oldImage && $oldImage->url) {
                        $publicId = $this->getPublicIdFromUrl($oldImage->url); // Extract public ID
                        if ($publicId) {
                            $this->cloudinaryService->deleteFile($publicId);
                            Log::info("Deleted old image with public ID: {$publicId}");
                        } else {
                            Log::warning("No valid public ID found for image: {$oldImage->url}");
                        }
                    }
                }

                // Update or create the image record
                Image::updateOrCreate(
                    ['article_id' => $article->id, 'type' => 'article'], // Conditions to find the record
                    ['url' => $data['path']] // Data to update or insert
                );
            }

            // Update the article
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
