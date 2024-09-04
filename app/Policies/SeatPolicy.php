<?php

namespace App\Policies;

use App\Models\Seat;
use App\Models\User;

class SeatPolicy
{
    public function before(User $user)
    {
        if ($user->has_full_access) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (in_array('viewAnySeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if (in_array('viewSeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (in_array('createSeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Seat $seat): bool
    {
        if (in_array('updateSeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Seat $seat): bool
    {
        if (in_array('deleteSeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Seat $seat): bool
    {
        if (in_array('restoreSeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Seat $seat): bool
    {
        if (in_array('forceDeleteSeat', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }
}
