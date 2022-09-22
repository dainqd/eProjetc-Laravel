<?php

namespace Database\Factories;

use App\Models\Score;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScoreFactory extends Factory
{
    protected $model = Score::class;

    public function definition(): array
    {
        return [
            'score_given' => $this->faker->numberBetween(40, 100),
            'notes' => $this->faker->sentence(),
            'created_at' => Carbon::now(),

            'test_id' => Test::factory(),
            'student_id' => User::factory(),
        ];
    }
}
