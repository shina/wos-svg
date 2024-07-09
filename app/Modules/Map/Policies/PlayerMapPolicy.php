<?php

namespace App\Modules\Map\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Map\PlayerMap;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerMapPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function view(User $user, PlayerMap $playerMap): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function update(User $user, PlayerMap $playerMap): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function delete(User $user, PlayerMap $playerMap): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function restore(User $user, PlayerMap $playerMap): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function forceDelete(User $user, PlayerMap $playerMap): bool
    {
        return $user->hasRole(Role::BETA);
    }
}
