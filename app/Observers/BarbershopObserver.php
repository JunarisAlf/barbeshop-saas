<?php

namespace App\Observers;

use App\Models\Barbershop;
use App\Models\Resource;
use App\Models\Role;

class BarbershopObserver
{
    /**
     * Handle the Barbershop "created" event.
     */
    public function created(Barbershop $barbershop): void
    {
        // TODO: create basic role
        $resources = Resource::with('permissions')->whereIn('name', ['User', 'Payment', 'Role'])->get();
        
        $ownerRole = Role::create(['name' => 'Owner', 'barbershop_id' => $barbershop->id]);
        $ownerRole->permissions()->attach($resources->where('name', 'User')->first()->permissions->pluck('id'));
        $ownerRole->permissions()->attach($resources->where('name', 'Role')->first()->permissions->pluck('id'));


    }

    /**
     * Handle the Barbershop "updated" event.
     */
    public function updated(Barbershop $barbershop): void
    {
        //
    }

    /**
     * Handle the Barbershop "deleted" event.
     */
    public function deleted(Barbershop $barbershop): void
    {
        //
    }

    /**
     * Handle the Barbershop "restored" event.
     */
    public function restored(Barbershop $barbershop): void
    {
        //
    }

    /**
     * Handle the Barbershop "force deleted" event.
     */
    public function forceDeleted(Barbershop $barbershop): void
    {
        //
    }
}
