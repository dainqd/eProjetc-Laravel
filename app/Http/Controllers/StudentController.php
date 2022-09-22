<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinClassRequest;
use App\Jobs\SendNotificationRemoveParent;
use App\Jobs\SendRequestParentConfirm;
use App\Models\Student;
use App\Models\User;
use App\Services\GroupService;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    private StudentService $studentService;
    private GroupService $groupService;
    private UserService $userService;

    public function __construct(StudentService $studentService, GroupService $groupService, UserService $userService)
    {
        $this->studentService = $studentService;
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    /**
     * @throws AuthorizationException
     */
    public function handleJoinClass(JoinClassRequest $request)
    {
        $this->authorize('joinClass', User::class);
        $group = $this->groupService->findByJoinCode($request->get('join_code'));
        if (!$group) {
            return redirect()->back()->with('error', 'Invalid code. Please check again or try contacting your teacher.');
        }
        $hasJoined = $this->userService->hasJoined($group, auth()->user());
        if ($hasJoined) {
            return redirect()->back()->with('error', 'You have already joined this class.');
        }
        $this->userService->joinClass($group, auth()->user());
        return redirect()->back()->with('success', 'Joined class successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function joinClass()
    {
        $this->authorize('joinClass', User::class);
        return view('pages.students.join-class');
    }

    /**
     * @throws AuthorizationException
     */
    public function settings()
    {
        $this->authorize('settings', User::class);
        return view('pages.students.settings', [
            'data' => Auth::user()->student
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function handleSettings(Request $request)
    {
        $this->authorize('settings', User::class);
        $student = Auth::user()->student;
        $data = [
            'is_score_notified' => $request->has('is_score_notified'),
            'is_extra_class_notified' => $request->has('is_extra_class_notified'),
            'is_resource_notified' => $request->has('is_resource_notified'),
        ];
        $this->studentService->update($data, $student);
        return redirect()->back()->with(['success' => 'Email settings saved']);
    }

    public function parents()
    {
        $student = Auth::user()->student;
        return view('pages.students.parent', [
            'data' => $student
        ]);
    }

    public function addParent(Request $request)
    {
        $parent = $this->userService->findByAttribute('username', $request->username);
        if (!$parent) {
            return redirect()->back()->with(['parent_not_found' => $request->username . ' user not found in system']);
        }
        $student = Auth::user()->student;
        $this->studentService->addParent($parent->id, $student);
        $this->dispatch(new SendRequestParentConfirm(Auth::user()));
        return redirect(route('students.parents'));
    }

    public function removeParent()
    {
        $student = Auth::user()->student;
        $parent_id = $student->parent_id;
        $is_parent_confirmed = $student->is_parent_confirmed;
        $this->studentService->removeParent($student);
        if ($is_parent_confirmed) {
            $this->dispatch(new SendNotificationRemoveParent(Auth::user(), $parent_id));
        }
        return redirect(route('students.parents'));
    }

    public function confirm(string $code)
    {
        $this->studentService->parentConfirm($code);
        return view('mails.parents.confirmResults.success');
    }
}
