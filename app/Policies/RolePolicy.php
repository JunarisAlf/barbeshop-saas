<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
   public function before(User $user)
   {
        if($user->has_full_access){
            return true;
        }
   }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (in_array('viewAnyRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        if (in_array('viewRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (in_array('createRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        if (in_array('updateRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        if (in_array('deleteRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        if (in_array('restoreRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        if (in_array('forceDeleteRole', $user->getArrayOfPermissions())) {
            return true;
        }
        return false;
    }
}
