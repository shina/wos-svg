<?php

namespace App\Modules\Players\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Players\Player;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function view(User $user, Player $player): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function update(User $user, Player $player): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function delete(User $user, Player $player): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function restore(User $user, Player $player): bool
    {
        return $user->hasRole(Role::MANAGER);
    }

    public function forceDelete(User $user, Player $player): bool
    {
        return $user->hasRole(Role::MANAGER);
    }
}
