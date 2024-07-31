<?php

namespace Database\Seeders;

use App\Enums\BarbershopStatusEnum;
use App\Models\Barbershop;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarbershopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barbershop = Barbershop::create( [
            'id'            => 1,
            'name'          => 'Barberhsop Pertama',
            'address'       => 'Jl. Merpati No. 84, Taluk Kuantan',
            'expired_date'  => now()->addDays(30)->format('Y-m-d H:i:s'),
            'gmaps_url'     => 'https://maps.app.goo.gl/TQXLewgiL3Gd5yP68',
            'status'        => BarbershopStatusEnum::ACTIVE
        ]);
        $user = $barbershop->users()->create([
            'id'                => 1,
            'name'              => 'Fulan bin Fulan',
            'email'             => 'fulan@gmail.com',
            'wa_number'         => fake()->numerify('628##########'),
            'password'          => 'password',
            'is_owner'          => true
        ]);

        $user->roles()->attach($barbershop->roles()->where('name', 'Owner')->first()->id);
        // $paymentDispatchers = Payment::getEventDispatcher();
        // Payment::unsetEventDispatcher();

        // Barbershop
        //     ::factory()->count(200)
        //     ->has(Payment::factory()->count(2))
        //     ->has(User::factory()->count(2), 'users')
        //     ->create();
        
        // Payment::setEventDispatcher($paymentDispatchers);
    }
}
