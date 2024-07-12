<?php

namespace Database\Factories;

use App\Models\SuperUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $superusers = SuperUser::all()->pluck('id')->toArray();
        $datetime   = fake()->dateTimeThisYear();
        return [
            'user_id'       => fake()->randomElement($superusers),
            'payer_name'    => fake()->name(),
            'amount'        => 50_000,
            'days_added'    => 30,
            'created_at'    => $datetime,
            'updated_at'    => $datetime
        ];
    }
}
