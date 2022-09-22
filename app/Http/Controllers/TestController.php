<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMarkRequest;
use App\Http\Requests\MarkRequest;
use App\Http\Requests\TestRequest;
use App\Models\Group;
use App\Models\Test;
use App\Services\ScoreService;
use App\Services\TestService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private TestService $testService;
    private ScoreService $scoreService;

    public function __construct(TestService $testService, ScoreService $scoreService)
    {
        $this->testService = $testService;
        $this->scoreService = $scoreService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request, Group $group)
    {
        $this->authorize('viewAny', [Test::class, $group]);
        $data = $this->testService->listAllByGroup($group);
        return view('pages.tests.list', [
            'data' => $data,
            'percentage' => $data->count() ? round($data->filter(function ($value) {
                    return $value->scores_count > 0;
                })->count() / $data->count() * 100) : 0,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(Group $group)
    {
        $this->authorize('create', [Test::class, $group]);
        return view('pages.tests.form');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(TestRequest $request, Group $group)
    {
        $this->authorize('create', [Test::class, $group]);
        $data = $request->validated();
        $data['group_id'] = $group->id;
        $this->testService->store($data);
        return redirect()->route('tests.index', $group)->with('success', 'Test created successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Group $group, Test $test)
    {
        $this->authorize('update', $test);
        return view('pages.tests.form', [
            'data' => $test,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Group $group, Test $test)
    {
        $this->authorize('delete', $test);
        $this->testService->destroy($test);
        return redirect()->route('tests.index', $group)->with('success', 'Test deleted successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function mark(Group $group, Test $test)
    {
        $this->authorize('mark', $test);
        $collection = $test->scores()->get()->toArray();
        $scores = collect($collection)->map(function ($item, $key) {
            return ['score_given' => $item['score_given'], 'notes' => $item['notes'], 'student_id' => $item['student_id']];
        })->toArray();
        return view('pages.marks.index', [
            'test' => $test,
            'data' => $group->students,
            'scores' => $scores
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function processGiveMark(MarkRequest $request, Group $group, Test $test)
    {
        $this->authorize('mark', $test);
        $this->scoreService->giveMark($test, $request->validated()['scores']);
        return redirect()->route('tests.index', $group)->with('success', 'Scores saved successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function processEditMark(EditMarkRequest $request, Group $group, Test $test)
    {
        $this->authorize('mark', $test);
        $score = $this->scoreService->getScoreToEdit($test->id, $request['student_id']);
        $this->scoreService->update($request->validated(), $score);
        return redirect()->back()->with('success', 'Score saved successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(TestRequest $request, Group $group, Test $test)
    {
        $this->authorize('update', $test);
        $this->testService->update($request->validated(), $test);
        return redirect()->route('tests.index', $group)->with('success', 'Test updated successfully');
    }


    public function getReportTest(Group $group){
        $data = $this->testService->listAllByGroup($group);
    }
}
