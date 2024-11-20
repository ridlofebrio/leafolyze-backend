<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
     /**
     * Determine if the user can delete the article.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->access === 'admin';
    }
}