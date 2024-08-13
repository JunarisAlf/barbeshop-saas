<?php

namespace Database\Factories;

use App\Enums\BarbershopStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barbershop>
 */
class BarbershopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->bothify('?????-#####'),
            'address'       => fake()->address(),
            'expired_date'  => now()->format('Y-m-d H:i:s'),
            'gmaps_url'     => 'https://maps.app.goo.gl/TQXLewgiL3Gd5yP68',
            'status'        => fake()->randomElement(BarbershopStatusEnum::names())
        ];
    }
}
