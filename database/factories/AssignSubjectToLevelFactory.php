<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Level;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AssignSubjectToLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => Subject::select('id')->inRandomOrder()->first()->id,
            'level_id' => Level::select('id')->inRandomOrder()->first()->id,
            'school_id' => 'e1abe19b-cad8-449c-ab58-b60af6c9422a',
            'branch_id' => '39ee8fa4-f1e4-4da0-9e12-1a366c864f76'
        ];
    }
}
