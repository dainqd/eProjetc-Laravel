<?php

namespace App\Models;

use App\Enums\ResourceType;
use App\Http\Controllers\JobController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'external_url',
        'resource_type',
        'group_id',
    ];
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class,'group_id');
    }
    protected $casts = [
        'resource_type' => ResourceType::class,
    ];

    protected static function booted()
    {
        static::created(function ($resource){
            $group = Group::find($resource->group_id);
            app(JobController::class)->createResource($group);
        });

        static::updated(function ($resource){
            $group = Group::find($resource->group_id);
            app(JobController::class)->updateResource($group);
        });
    }
}
