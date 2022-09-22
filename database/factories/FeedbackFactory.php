<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'user_id' => User::whereIn('role', [UserRole::Teacher,UserRole::Parent,UserRole::Student])->inRandomOrder()->first()->id,
            'title' => $this->faker->name,
            'content' => $this->faker->text,
        ];
    }
}
