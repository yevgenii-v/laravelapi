<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketMessagePolicy
{
    use HandlesAuthorization;

    public function __construct(Request $request)
    {
        $this->ticket = $request->route('ticket');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param TicketMessage $message
     * @return bool
     */
    public function view(User $user, TicketMessage $message)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN) ||
               $this->ticket->support_id === null ||
               auth('sanctum')->user()->id === $this->ticket->support_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param TicketMessage $ticketMessage
     * @return Response|bool
     */
    public function update(User $user, TicketMessage $message)
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN) ||
               $user->id === $message->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param TicketMessage $message
     * @return Response|bool
     */
    public function delete(User $user, TicketMessage $message)
    {
        return $user->roles->containsStrict('id', Role::IS_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param TicketMessage $message
     * @return bool
     */
    public function restore(User $user, TicketMessage $message): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param TicketMessage $message
     * @return bool
     */
    public function forceDelete(User $user, TicketMessage $message): bool
    {
        return false;
    }
}
