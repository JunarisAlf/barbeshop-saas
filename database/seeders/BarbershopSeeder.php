<?php

namespace Database\Seeders;

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
        Barbershop
            ::factory()->count(200)
            ->has(Payment::factory()->count(2), 'payments')
            ->has(User::factory()->count(2), 'users')
            ->create();
    }
}
