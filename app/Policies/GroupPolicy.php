<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     *
     * @return bool
     */
    public function view(User $user, Group $group)
    {
        return $this->userCanManageGroup($user, $group);
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     *
     * @return bool
     */
    public function update(User $user, Group $group)
    {
        return $this->userCanManageGroup($user, $group);
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     *
     * @return bool
     */
    public function delete(User $user, Group $group): bool
    {
        return $this->userCanManageGroup($user, $group);
    }

    /**
     * Determine if the user may manage the given group.
     *
     * @param User $user
     * @param Group $group
     *
     * @return bool
     */
    protected function userCanManageGroup(User $user, Group $group): bool
    {
        return $user->groups()->manageable()->pluck('groups.id')->contains($group->id);
    }
}
