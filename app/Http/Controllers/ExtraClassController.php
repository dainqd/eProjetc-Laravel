<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtraClassRequest;
use App\Models\ExtraClass;
use App\Models\Group;
use App\Services\ExtraClassService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ExtraClassController extends Controller
{
    private ExtraClassService $extraClassService;

    public function __construct(ExtraClassService $extraClassService)
    {
        $this->extraClassService = $extraClassService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request, Group $group)
    {
        $this->authorize('viewAny', [ExtraClass::class, $group]);
        $limit = $request->get('limit', 10);
        return view('pages.extra-classes.list', [
            'data' => $this->extraClassService->listByGroup($group, $limit),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(Group $group)
    {
        $this->authorize('create', [ExtraClass::class, $group]);
        return view('pages.extra-classes.form');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(ExtraClassRequest $request, Group $group)
    {
        $this->authorize('create', [ExtraClass::class, $group]);
        $data = $request->validated();
        $data['group_id'] = $group->id;
        $this->extraClassService->store($data);
        return redirect()->route('extra-classes.index', $group)->with('success', 'Extra class created successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Group $group, ExtraClass $extraClass)
    {
        $this->authorize('update', $extraClass);
        return view('pages.extra-classes.form', [
            'data' => $extraClass,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(ExtraClassRequest $request, Group $group, ExtraClass $extraClass)
    {
        $this->authorize('update', $extraClass);
        $this->extraClassService->update($request->validated(), $extraClass);
        return redirect()->route('extra-classes.index', $group)->with('success', 'Extra class created successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Group $group, ExtraClass $extraClass)
    {
        $this->authorize('delete', $extraClass);
        $this->extraClassService->destroy($extraClass);
        return redirect()->route('extra-classes.index', $group)->with('success', 'Extra class deleted successfully');
    }
}
