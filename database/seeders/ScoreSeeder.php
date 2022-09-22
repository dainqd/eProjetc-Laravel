<?php

namespace Database\Seeders;

use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    public function run()
    {
        $tests = Test::with('group.students')->where('date', '<=', now())->get();
        foreach ($tests as $test) {
            $test->group->students->each(function ($student) use ($test) {
                $student->scores()->create([
                    'score_given' => fake()->numberBetween(40, 100),
                    'notes' => fake()->sentence(),
                    'created_at' => Carbon::now(),
                    'test_id' => $test->id,
                ]);
            });
        }
    }
}
