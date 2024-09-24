<?php

namespace Database\Seeders;

use App\Enums\BarbershopStatusEnum;
use App\Enums\DaysEnum;
use App\Enums\EmployeeTypeEnum;
use App\Enums\SeatTypeEnum;
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
        $barbershop =Barbershop::create([
            'id'            => 1,
            'name'          => 'Barberhsop Pertama',
            'address'       => 'Jl. Merpati No. 84, Taluk Kuantan',
            'expired_date'  => now()->addDays(30)->format('Y-m-d H:i:s'),
            'gmaps_url'     => 'https://maps.app.goo.gl/TQXLewgiL3Gd5yP68',
            'status'        => BarbershopStatusEnum::ACTIVE->name
        ]);


        $barbershop->schedules()->createMany([
            ['day' => DaysEnum::MONDAY->name, 'open' => '09:00', 'close' => '12:00'],
            ['day' => DaysEnum::MONDAY->name, 'open' => '13:00', 'close' => '20:00'],
            ['day' => DaysEnum::TUESDAY->name, 'open' => '09:00', 'close' => '20:00'],
        ]);
        $barbershop->seats()->createMany([
            ['name' => 'A1', 'type' => SeatTypeEnum::ADULT->name, 'est_duration' => 40],
            ['name' => 'A2', 'type' => SeatTypeEnum::ADULT->name, 'est_duration' => 40],
            ['name' => 'B1', 'type' => SeatTypeEnum::KID->name, 'est_duration' => 25],
        ]);
        $barbershop->members()->create([
            'fullname'  => 'Member 1',
            'gender'    => 'MALE',
            'wa_number' => '6282290890767',
            'email'     => 'member@gmail.com',
            'address'   => 'JL. Durian No. 81, Pekanbaru',
        ]);
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
