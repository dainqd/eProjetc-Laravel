<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>z
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'password' => 'coder9tuoi',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'dob' => $this->faker->dateTimeBetween('-22 years', '-6 years')->format('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->numerify('09########'),
            'address' => $this->faker->address(),
            'avatar' => $this->faker->imageUrl(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => UserRole::Student,
            'created_at' => Carbon::now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function setRole(UserRole $role)
    {
        return $this->state(function () use ($role) {
            return [
                'role' => $role->value,
                'dob' => $role == UserRole::Student
                    ? $this->faker->dateTimeBetween('-22 years', '-6 years')->format('Y-m-d')
                    : $this->faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            ];
        });
    }
}
