<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\GroupService;
use App\Services\StudentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Request;

class GroupController extends Controller
{
    private GroupService $groupService;
    private StudentService $studentService;

    public function __construct(GroupService $groupService, StudentService $studentService)
    {
        $this->authorizeResource(Group::class, 'group');
        $this->groupService = $groupService;
        $this->studentService = $studentService;
    }

    public function index()
    {
        $limit = request()->query('limit') ?? 10;
        $data = match (auth()->user()->role) {
            UserRole::Teacher => $this->groupService->listOngoing($limit),
            UserRole::Student => $this->groupService->listOngoingForStudent($limit),
            UserRole::Parent => $this->groupService->listOngoingForParent($limit),
        };
        return view('pages.groups.list', [
            'data' => $data,
        ]);
    }

    public function onArchived(Group $group)
    {
        $this->groupService->archived($group);
        return redirect(route('classes.ongoing'));
    }

    public function archived()
    {
        $limit = request()->query('limit') ?? 10;
        $data = match (auth()->user()->role) {
            UserRole::Teacher => $this->groupService->listArchived($limit),
            UserRole::Student => $this->groupService->listArchivedForStudent($limit),
            UserRole::Parent => $this->groupService->listArchivedForParent($limit),
        };
        return view('pages.groups.list', [
            'data' => $data
        ]);
    }

    public function offArchived(Group $group)
    {
        $this->groupService->unArchived($group);
        return redirect(route('classes.archived'));
    }

    public function create()
    {
        return view('pages.groups.form');
    }

    public function store(GroupRequest $request)
    {
        $data = $request->validated();
        $data['teacher_id'] = Auth::user()->id;
        if ($data['banner_url'] === null) {
            $data['banner_url'] = fake()->imageUrl;
        }
        $this->groupService->store($data);
        return redirect(route('classes.ongoing'));
    }

    public function show(Group $group)
    {
        return view('pages.groups.details', [
            'data' => $this->studentService->listByGroupWithParent($group),
            'group' => $group,
            'teacher' => $group->teacher
        ]);
    }

    public function edit(Group $group)
    {
        return view('pages.groups.form', [
            'data' => $group
        ]);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $data = $request->validated();
        if ($data['banner_url'] === null) {
            $data['banner_url'] = fake()->imageUrl;
        }
        $this->groupService->update($data, $group);
        return redirect(route('classes.ongoing'));
    }

    /**
     * @throws AuthorizationException
     */
    public function remove(Request $request, Group $group, User $user)
    {
        $this->authorize('remove', [$group, $user]);
        $this->groupService->remove($group, $user);
        return redirect()->route('classes.show', $group)->with('success', 'Student removed from class');
    }
}
