<?php

namespace App\Models;

use App\Http\Controllers\JobController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'test_id',
        'student_id',
        'score_given',
        'notes',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function scopeOfGroup(Builder $query, Group $group): Builder
    {
        return $query->whereHas('test', function ($query) use ($group) {
            $query->where('group_id', $group->id);
        });
    }

    protected static function booted()
    {
        static::created(function ($score) {
            $student = Student::find((int)$score->student_id);
            $user = User::find((int)$score->student_id);
            $test = Test::find((int)$score->test_id);
            $group = Group::find($test->group_id);
            if ($student->is_score_notified) {
                app(JobController::class)->mark($user, $test, $group);
            }
        });

        static::updated(function ($score) {
            $user = User::find((int)$score->student_id);
            $test = Test::find((int)$score->test_id);
            $student = Student::find((int)$score->student_id);
            $group = Group::find($test->group_id);
            if ($student->is_score_notified) {
                app(JobController::class)->updateMark($user, $test, $group);
            }
        });
    }
}
