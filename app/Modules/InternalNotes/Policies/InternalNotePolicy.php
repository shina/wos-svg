<?php

namespace App\Modules\InternalNotes\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\InternalNotes\InternalNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class InternalNotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, InternalNote $internalNote): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, InternalNote $internalNote): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function delete(User $user, InternalNote $internalNote): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function restore(User $user, InternalNote $internalNote): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function forceDelete(User $user, InternalNote $internalNote): bool
    {
        return $user->hasRole(Role::MANAGER);
    }
}
