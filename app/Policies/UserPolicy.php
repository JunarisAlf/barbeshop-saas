<?php

namespace App\Policies;

use App\Models\Barbershop;
use App\Models\SuperUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        } else {
            if (in_array('viewAnyUser', Auth::user()->getArrayOfPermissions())) {
                return true;
            }
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($authUser, User $model): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        }else{
            if(in_array('viewUser', Auth::user()->getArrayOfPermissions())){
                return true;
            }
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($authUser): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        }else{
            if(in_array('createUser', Auth::user()->getArrayOfPermissions())){
                return true;
            }
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($authUser, User $model): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        }else{
            if(in_array('updateUser', Auth::user()->getArrayOfPermissions())){
                return true;
            }
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($authUser, User $model): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        }else{
            if(in_array('deleteUser', Auth::user()->getArrayOfPermissions())){
                return true;
            }
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($authUser, User $model): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        }else{
            if(in_array('restoreUser', Auth::user()->getArrayOfPermissions())){
                return true;
            }
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($authUser, User $model): bool
    {
        if (Auth::guard()->name === 'superadmin') {
            return true;
        }else{
            if(in_array('forceDeleteUser', Auth::user()->getArrayOfPermissions())){
                return true;
            }
            return false;
        }
    }
}
