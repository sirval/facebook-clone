<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('view comment')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        if ($user->can('view comment')) {
            return true;
        }

        if ($user->can('view own comment')) {
            if ($user->id === $comment->user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('create comment')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        if ($user->can('update own comment')) {
            if ($user->id === $comment->user_id) {
                return true;
            }
        }

        if ($user->can('update all comment')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        if ($user->can('delete own comment')) {
            if ($user->id === $comment->user_id) {
                return true;
            }
        }

        if ($user->can('delete all comment')) {
            return true;
        }
        return false;
    }

}
