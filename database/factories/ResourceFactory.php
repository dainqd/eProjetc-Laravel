<?php

namespace Database\Factories;

use App\Enums\ResourceType;
use App\Models\Group;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'external_url' => $this->faker->url(),
            'resource_type' => $this->faker->randomElement(ResourceType::cases())->value,
            'created_at' => Carbon::now(),
            'group_id' => Group::inRandomOrder()->first()->id,
        ];
    }
}
