<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\ExtraClass;
use App\Models\Group;
use App\Models\Resource;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $members = ['quan', 'hinh'];
        foreach ($members as $member) {
            foreach (UserRole::cases() as $role) {
                User::factory()
                    ->setRole($role)
                    ->has(
                        Group::factory($role == UserRole::Teacher ? 5 : 0)
                            ->has(ExtraClass::factory(5))
                            ->has(Resource::factory(10))
                            ->has(Test::factory(8))
                            ->hasAttached(User::factory(8)->setRole(UserRole::Student)->create(), [], 'students')
                    )
                    ->create([
                        'username' => $member . '.' . strtolower($role->name),
                        'first_name' => ucfirst($member),
                        'last_name' => $role->name,
                        'email' => 'cd9t.estudiez+' . $member . strtolower($role->name) . '@gmail.com',
                    ]);
            }
            $teacher = User::where('username', $member . '.teacher')->first();
            $userStudent = User::where('username', $member . '.student')->first();
            $userStudent->studyingGroups()->attach($teacher->groups);

            $student = $userStudent->student;
            $parent = User::where('username', $member . '.parent')->first();
            $student->parent()->associate($parent);
            $student->is_parent_confirmed = true;
            $student->save();
        }
    }
}
