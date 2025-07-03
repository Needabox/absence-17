<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'name' => $this->faker->name(),
        'gender' => $this->faker->numberBetween(0, 1),
        'nis' => $this->faker->unique()->numerify('#####'), // 5 digit
        'nisn' => $this->faker->numerify('########'), // 8 digit
        'major_id' => $this->faker->numberBetween(1, 4), // ganti pakai faker juga bisa
        'status' => 1,
    ];
}

}
