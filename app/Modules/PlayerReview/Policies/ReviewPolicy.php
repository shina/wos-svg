<?php

namespace App\Modules\PlayerReview\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\PlayerReview\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, Review $review): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, Review $review): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $review->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }

    public function delete(User $user, Review $review): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $review->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }

    public function restore(User $user, Review $review): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $review->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }

    public function forceDelete(User $user, Review $review): bool
    {
        $isOwner = $user->hasRole(Role::MANAGER) && $review->reviewer_user_id === $user->id;

        return $isOwner || $user->hasRole(Role::ADMIN);
    }
}
