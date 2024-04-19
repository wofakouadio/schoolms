<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_name' => fake()->word(),
            'school_id' => 'e1abe19b-cad8-449c-ab58-b60af6c9422a',
            'branch_id' => '39ee8fa4-f1e4-4da0-9e12-1a366c864f76'
        ];
    }
}
