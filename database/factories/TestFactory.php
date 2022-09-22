<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TestFactory extends Factory
{
    protected $model = Test::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['15 minute test', '30 minute test', '60 minute test', '90 minute test', '120 minute test', 'Final exam', 'Assignment']),
            'description' => $this->faker->text(),
            'date' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
            'maximum_score' => 100,
            'weight' => $this->faker->numberBetween(1, 4) * 10,
            'group_id' => Group::inRandomOrder()->first()->id,
            'created_at' => Carbon::now(),
        ];
    }
}
