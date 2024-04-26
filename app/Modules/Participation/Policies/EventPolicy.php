<?php

namespace App\Modules\Participation\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Modules\Participation\Attendee;
use App\Modules\Participation\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function view(User $user, Event|Attendee $event): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function update(User $user, Event|Attendee $event): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function delete(User $user, Event|Attendee $event): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function restore(User $user, Event|Attendee $event): bool
    {
        return $user->hasRole(Role::BETA);
    }

    public function forceDelete(User $user, Event|Attendee $event): bool
    {
        return $user->hasRole(Role::BETA);
    }
}
