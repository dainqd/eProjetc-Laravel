<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'school',
        'subject',
        'join_code',
        'is_archived',
        'teacher_id',
        'banner_url',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'groups_users', 'group_id', 'student_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function extraClasses(): HasMany
    {
        return $this->hasMany(ExtraClass::class);
    }

    public function scopeArchived(Builder $query, bool $isArchived): Builder
    {
        return $query->where('is_archived', $isArchived);
    }

    public function scopeOfCurrentUser(Builder $query): Builder
    {
        return $query->where('teacher_id', auth()->id());
    }

    public function scopeOfCurrentStudent(Builder $query): Builder
    {
        return $query->whereRelation('students', 'id', auth()->id());
    }

    public function scopeOfCurrentParent(Builder $query): Builder
    {
        return $query->whereRelation('students.student', 'parent_id', auth()->id());
    }

    protected function joinCode(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value),
        );
    }
}
