<?php

namespace App\Observers;

use App\Enums\EmployeeTypeEnum;
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
        $resources = Resource::with('permissions')->whereIn('name', ['User', 'Payment', 'Role', 'Schedule', 'Seat', 'Employee', 'Member'])->get();
        $ownerRole = Role::create(['name' => 'Owner', 'barbershop_id' => $barbershop->id]);
        $ownerRole->permissions()->attach($resources->where('name', 'User')->first()->permissions->pluck('id'));
        $ownerRole->permissions()->attach($resources->where('name', 'Role')->first()->permissions->pluck('id'));
        $ownerRole->permissions()->attach($resources->where('name', 'Schedule')->first()->permissions->pluck('id'));
        $ownerRole->permissions()->attach($resources->where('name', 'Seat')->first()->permissions->pluck('id'));
        $ownerRole->permissions()->attach($resources->where('name', 'Employee')->first()->permissions->pluck('id'));
        $ownerRole->permissions()->attach($resources->where('name', 'Member')->first()->permissions->pluck('id'));


        $employee = $barbershop->employees()->create([
            'fullname'          => $barbershop->name . ' SuperUser',
            'gender'            => 'MALE',
            'type'              => EmployeeTypeEnum::OWNER->name,
        ]);

        $user = $barbershop->users()->create([
            'name'              => $barbershop->name . ' SuperUser',
            'email'             => strtolower(str_replace(' ', '', $barbershop->name)) . '@example.com',
            'password'          => strtolower(str_replace(' ', '', $barbershop->name)) . '@example.com',
            'is_owner'          => true,
            'has_full_access'   => true,
            'employee_id'       => $employee->id
        ]);
        $user->roles()->attach($ownerRole->id);

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
