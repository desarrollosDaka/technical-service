<?php

namespace App\Policies;

use App\Models\Technical;
use App\Models\TechnicalVisit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TechnicalVisitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|Technical $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|Technical $user, TechnicalVisit $technicalVisit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|Technical $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|Technical $user, TechnicalVisit $technicalVisit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|Technical $user, TechnicalVisit $technicalVisit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User|Technical $user, TechnicalVisit $technicalVisit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User|Technical $user, TechnicalVisit $technicalVisit): bool
    {
        return false;
    }
}
