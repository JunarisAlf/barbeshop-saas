<?php

namespace Database\Seeders;

use App\Models\SuperUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       SuperUser::create([
            'name'      => 'Junaris A',
            'email'     => 'junaris0715@gmail.com',
            'wa_number' => '+6282284393018',
            'password'  => 'admin123'
       ]);
    }
}
