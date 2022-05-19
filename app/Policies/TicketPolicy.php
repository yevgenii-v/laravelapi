<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN) ||
               $user->roles->containsStrict('id', Role::IS_SUPPORT);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN) ||
               $user->id === $ticket->support_id ||
               $ticket->support_id === null;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN) ||
               $user->roles->containsStrict('id', Role::IS_SUPPORT);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return Response|bool
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return Response|bool
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return Response|bool
     */
    public function restore(User $user, Ticket $ticket)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return Response|bool
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        return false;
    }
}
