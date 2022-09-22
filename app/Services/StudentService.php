<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class StudentService extends BaseService
{
    protected $modelClass = Student::class;

    public function addParent(int $parent_id, Student $student): bool
    {
        $student->parent_id = $parent_id;
        $student->is_parent_confirmed = false;
        $student->parent_confirmation_code = $this->generateParentConfirmationCode();
        return $student->save();
    }

    public function removeParent(Student $student): bool
    {
        return $student->update([
            'parent_id' => null,
            'is_parent_confirmed' => false,
            'parent_confirmation_code' => null
        ]);
    }

    public function parentConfirm(string $code): bool
    {
        $student = Student::where(['parent_confirmation_code' => $code])->first();
        return $student->update([
            'is_parent_confirmed' => true,
        ]);
    }

    private function generateParentConfirmationCode(): string
    {
        $code = Str::random(10);
        if (Student::query()->where('parent_confirmation_code', $code)->exists()) {
            return $this->generateParentConfirmationCode();
        } else {
            return $code;
        }
    }

    public function listByGroupWithParent(Group $group): Collection
    {
        return $group->students()->with('student.parent')->get();
    }
}
