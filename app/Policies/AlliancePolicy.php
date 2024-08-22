<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Alliance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlliancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function view(User $user, Alliance $alliance): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function update(User $user, Alliance $alliance): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function delete(User $user, Alliance $alliance): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function restore(User $user, Alliance $alliance): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function forceDelete(User $user, Alliance $alliance): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
