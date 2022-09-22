<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>z
     */
    public function definition()
    {
        return [
            'name' => 'Class ' . $this->faker->regexify('[A-Z]') . $this->faker->numberBetween(1, 99),
            'school' => 'FPT Aptech',
            'join_code' => Str::random(10),
            'subject' => 'Subject ' . $this->faker->word(),
            'is_archived' => $this->faker->boolean,
            'teacher_id' => User::where('role', UserRole::Teacher)->inRandomOrder()->first()->id,
            'banner_url' => $this->faker->imageUrl(),
            'created_at' => Carbon::now(),
        ];
    }
}
