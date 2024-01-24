<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'start_date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'place' => collect(['Yangon', 'Mandalay', 'Letpadan'])->random(),
            'description' => fake()->realText(200),
        ];
    }
}
