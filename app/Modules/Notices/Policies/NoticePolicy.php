<?php

namespace App\Modules\Notices\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Notices\Notice;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, Notice $notice): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, Notice $notice): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function delete(User $user, Notice $notice): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function restore(User $user, Notice $notice): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function forceDelete(User $user, Notice $notice): bool
    {
        return $user->hasRole(Role::MANAGER);
    }
}
