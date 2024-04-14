<?php

namespace App\Modules\Wiki\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Wiki\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, Page $page): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, Page $page): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function restore(User $user, Page $page): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function forceDelete(User $user, Page $page): bool
    {
        return $user->hasRole(Role::MANAGER);
    }
}
