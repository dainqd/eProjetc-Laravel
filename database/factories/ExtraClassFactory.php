<?php

namespace Database\Factories;

use App\Models\ExtraClass;
use App\Models\Group;
use DateInterval;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExtraClassFactory extends Factory
{
    protected $model = ExtraClass::class;

    public function definition(): array
    {
        $startTime = DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 years', '+1 years')->setTime(8, 0));
        return [
            'name' => 'Extra class ' . $this->faker->randomNumber(),
            'group_id' => Group::inRandomOrder()->first()->id,
            'start_time' => $startTime,
            'end_time' => $startTime->add(new DateInterval('PT4H')),
            'location' => 'Room ' . ucfirst($this->faker->word()),
            'created_at' => Carbon::now(),
        ];
    }
}
