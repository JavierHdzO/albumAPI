<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $algo = ['A','B','C','D'];
        return [
            'name' => fake()->name,
            'grade' => fake()->numberBetween(1, 12),
            'group'=> $algo[fake()->numberBetween(0, 3)],
            'professor' => fake()->name,
            'start_scheule' => fake()->date(),
            'end_schedule' => fake()->date(),
            'user_id' => fake()->numberBetween(1, 5)
        ];
    }
}
