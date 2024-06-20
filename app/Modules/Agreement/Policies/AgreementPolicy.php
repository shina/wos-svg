<?php

namespace App\Modules\Agreement\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Agreement\Agreement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgreementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, Agreement $agreement): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, Agreement $agreement): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function delete(User $user, Agreement $agreement): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function restore(User $user, Agreement $agreement): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function forceDelete(User $user, Agreement $agreement): bool
    {
        return $user->hasRole(Role::MANAGER);
    }
}
