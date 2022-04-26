<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $authUser
     * @return Response|bool
     */
    public function viewAny(User $authUser)
    {
        return $authUser->roles->containsStrict('id', Role::IS_ADMIN) ||
               $authUser->roles->containsStrict('id', Role::IS_SUPPORT);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $authUser
     * @param User $user
     * @return bool
     */
    public function view(User $authUser, User $user): bool
    {
        return $authUser->roles->containsStrict('id', Role::IS_ADMIN) ||
               $authUser->roles->containsStrict('id', Role::IS_SUPPORT);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $authUser
     * @param User $user
     * @return bool
     */
    public function update(User $authUser, User $user): bool
    {
        return $authUser->roles->containsStrict('id', Role::IS_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $authUser
     * @param User $user
     * @return bool
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->roles->containsStrict('id', Role::IS_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $authUser
     * @param User $user
     * @return void
     */
    public function restore(User $authUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $authUser
     * @param User $user
     * @return void
     */
    public function forceDelete(User $authUser, User $user)
    {
        //
    }
}
