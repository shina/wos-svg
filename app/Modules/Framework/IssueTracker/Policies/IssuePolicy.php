<?php

namespace App\Modules\Framework\IssueTracker\Policies;

use App\Models\User;
use App\Modules\Framework\IssueTracker\Issue;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Issue $issue): bool
    {
        return $issue->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Issue $issue): bool
    {
        return $issue->user_id === $user->id;
    }

    public function delete(User $user, Issue $issue): bool
    {
        return $issue->user_id === $user->id;
    }

    public function restore(User $user, Issue $issue): bool
    {
        return $issue->user_id === $user->id;
    }

    public function forceDelete(User $user, Issue $issue): bool
    {
        return $issue->user_id === $user->id;
    }
}
