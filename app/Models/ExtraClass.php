<?php

namespace App\Models;

use App\Http\Controllers\JobController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtraClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'group_id',
        'start_time',
        'end_time',
        'location',
    ];

    protected static function booted()
    {
        static::addGlobalScope('latest', function (Builder $builder) {
            $builder->orderBy('start_time', 'desc');
        });

        static::created(function ($resource){
            $group = Group::find($resource->group_id);
            app(JobController::class)->createExtraClass($group);
        });

        static::updated(function ($resource){
            $group = Group::find($resource->group_id);
            app(JobController::class)->updateExtraClass($group);
        });
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
