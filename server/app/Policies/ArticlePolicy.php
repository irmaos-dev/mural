<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

final class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Article  $article
     * @return bool
     */
    public function update(User $user, Article $article): bool
    {
        return $user->getKey() === $article->author->getKey();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Article  $article
     * @return bool
     */
    public function delete(User $user, Article $article): bool
    {
        $author = $this->update($user, $article);
        $canDelete=$user->can('delete_any_article');
        
        if ($author || $canDelete) {
            return true;
         } else return false;
    }
}
