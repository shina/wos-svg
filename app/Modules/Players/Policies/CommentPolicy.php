<?php

namespace App\Modules\Players\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Players\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, Comment $comment): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, Comment $comment): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $comment->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }

    public function delete(User $user, Comment $comment): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $comment->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }

    public function restore(User $user, Comment $comment): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $comment->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $comment->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }
}
