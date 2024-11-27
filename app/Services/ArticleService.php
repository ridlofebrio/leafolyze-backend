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
           if (isset($data['image'])) {
               $uploadResult = $this->cloudinaryService->uploadFile($data['image'], 'articles');
                // Create article
               $article = Article::create([
                   'user_id' => $data['user_id'],
                   'title' => $data['title'],
                   'content' => $data['content'],
                   'duration' => $data['duration'],
               ]);
                $article->image()->create([
                   'path' => $uploadResult['path'],
                   'public_id' => $uploadResult['public_id'],
                   'type' => 'article'
               ]);
                return $article->load('image');
           }
            throw new \Exception('Article image is required');
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
               if ($article->image()->exists()) {
                   $oldImage = $article->image()->first();
                   $this->cloudinaryService->deleteFile($oldImage->public_id);
                   $oldImage->delete();
               }
               $article->image()->create([
                   'path' => $uploadResult['path'],
                   'public_id' => $uploadResult['public_id'],
                   'type' => 'article'
               ]);
           }
           $article->update([
               'title' => $data['title'] ?? $article->title,
               'content' => $data['content'] ?? $article->content,
               'duration' => $data['duration'] ?? $article->duration,
           ]);
            return $article->fresh('image');
       } catch (\Exception $e) {
           Log::error("Error updating article ID {$id}: " . $e->getMessage());
           throw $e;
       }
   }



    public function deleteArticle(int $id)
   {
       try {
           $article = Article::with('image')->findOrFail($id);
            if (Auth::user()->access !== 'admin') {
               throw new \Exception('Unauthorized. Only admin can delete articles.');
           }
            // Delete image from Cloudinary if exists
           if ($article->image) {
               $this->cloudinaryService->deleteFile($article->image->public_id);
           }
            return $article->delete();
       } catch (\Exception $e) {
           Log::error("Error deleting article ID {$id}: " . $e->getMessage());
           throw $e;
       }
   }
}
