<?php

namespace App\Policies;

use App\Models\Technical;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|Technical $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|Technical $user, Ticket $ticket): bool
    {
        return $ticket->technical_id === $user->getKey();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|Technical $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|Technical $user, Ticket $ticket): bool
    {
        return $ticket->technical_id === $user->getKey();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|Technical $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
