<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Jobs\SendMailScoreParent;
use App\Jobs\SendNotificationRemoveParent;
use App\Models\Group;
use App\Models\Score;
use App\Models\User;
use App\Services\GroupService;
use App\Services\ScoreService;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    private ScoreService $scoreService;

    public function __construct(ScoreService $scoreService, StudentService $studentService, GroupService $groupService, UserService $userService)
    {
        $this->scoreService = $scoreService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request, Group $group)
    {
        $this->authorize('viewAny', [Score::class, $group]);
        $user = auth()->user();
        if ($user->role === UserRole::Teacher) {
            return view('pages.scores.students', [
                'data' => $group->students,
                'group' => $group,
            ]);
        } else if ($user->role === UserRole::Parent) {
            $children = $group->students->whereIn('id', $user->children->pluck('user_id'));
            if ($children->count() === 1) {
                return redirect()->route('scores.list-by-student', [$group, $children->first()])->with('only-child', true);
            }
            return view('pages.scores.students', [
                'data' => $group->students->whereIn('id', $user->children->pluck('user_id')),
                'group' => $group,
            ]);
        } else {
            return redirect()->route('scores.list-by-student', [$group, $user]);
        }
    }

    public function getReportScore(Group $group, User $user)
    {
        $data = $this->scoreService->listByStudent($group, $user);
        if ($data) {
            $this->dispatch(new SendMailScoreParent($user, $group, $data->toArray()));
        }
        return redirect()->back()->with(['success' => 'Send score successfully']);
    }

    /**
     * @throws AuthorizationException
     */
    public function listByStudent(Request $request, Group $group, User $user)
    {
        $this->authorize('view', [Score::class, $group, $user]);
        $data = $this->scoreService->listByStudent($group, $user);
        $averageScore = $this->scoreService->getAverageScore($data);
        $totalTestCount = $data->count() ? $data->first()->test->group->tests->count() : 0;
        return view('pages.scores.list', [
            'data' => $data,
            'averageScore' => $averageScore,
            'grade' => $this->scoreService->getGrade($averageScore),
            'testCount' => $data->count(),
            'testPercentage' => $totalTestCount ? round($data->count() / $totalTestCount * 100) : 0,
        ]);
    }
}
