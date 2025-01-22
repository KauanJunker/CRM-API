<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['novo', 'em negociação', 'fechado', 'perdido']);

        return [
            'name' => fake()->name(),
            'email'=> fake()->email(),
            'phone'=> fake()->phoneNumber(),
            'status' => $status,
            'user_id' => 1,
        ];
    }
}
