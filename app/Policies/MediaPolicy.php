<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\Technical;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MediaPolicy
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
    public function view(User|Technical $user, Media $media): bool
    {
        return true;
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
    public function update(User|Technical $user, Media $media): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|Technical $user, Media $media): bool
    {
        return true;
    }
}
