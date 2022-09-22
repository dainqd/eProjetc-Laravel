<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Score;
use App\Models\Test;
use App\Models\User;
use Illuminate\Support\Collection;

class ScoreService extends BaseService
{
    protected $modelClass = Score::class;

    public function giveMark(Test $test, mixed $data): void
    {
        $test->scores()->createMany($data);
    }

    public function getScoreToEdit(int $test_id, int $student_id): ?Score
    {
        return Score::where('test_id', $test_id)->where('student_id', $student_id)->get()->firstOrFail();
    }

    public function listByStudent(Group $group, User $user): Collection
    {
        return Score::with('test')
            ->ofGroup($group)
            ->where('student_id', $user->id)
            ->get();
    }

    /**
     * @param Collection $scores
     * @return float
     */
    public function getAverageScore(Collection $scores): float
    {
        $accScore = $scores->sum(function ($item) {
            return $item->score_given * $item->test->weight;
        });
        $maximumAccScore = $scores->sum(function ($item) {
            return $item->test->maximum_score * $item->test->weight;
        });
        return round($maximumAccScore ? $accScore / $maximumAccScore * 100 : 0);
    }

    public function getGrade(float $score): string
    {
        if ($score >= 90) {
            return 'A';
        } else if ($score >= 80) {
            return 'B';
        } else if ($score >= 70) {
            return 'C';
        } else if ($score >= 60) {
            return 'D';
        } else {
            return 'F';
        }
    }
}
