<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Models\Group;
use App\Models\Resource;
use App\Services\ResourceService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    private ResourceService $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * @param Request $request
     * @param Group $group
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(Request $request, Group $group)
    {
        $this->authorize('viewAny', [Resource::class, $group]);
        $limit = $request->get('limit', 10);
        return view('pages.resources.list', [
            'data' => $this->resourceService->getByGroup($group, $limit),
        ]);
    }

    /**
     * @param Group $group
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(Group $group)
    {
        $this->authorize('create', [Resource::class, $group]);
        return view('pages.resources.form');
    }

    /**
     * @param ResourceRequest $request
     * @param Group $group
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ResourceRequest $request, Group $group)
    {
        $this->authorize('create', [Resource::class, $group]);
        $data = $request->validated();
        $data['group_id'] = $group->id;
        $this->resourceService->store($data);
        return redirect()->route('resources.index', $group)->with('success', 'Resource created successfully');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Group $group, Resource $resource)
    {
        $this->authorize('update', $resource);
        return view('pages.resources.form', [
            'data' => $resource,
        ]);
    }

    /**
     * @param ResourceRequest $request
     * @param Resource $resource
     * @param Group $group
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Group $group, ResourceRequest $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        $this->resourceService->update($request->validated(), $resource);
        return redirect()->route('resources.index', $group)->with('success', 'Resource updated successfully');
    }

    /**
     * @param Resource $resources
     * @param Group $group
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Group $group, Resource $resources)
    {
        $this->authorize('delete', $resources);
        $this->resourceService->destroy($resources);
        return redirect()->route('resources.index', $group)->with('success', 'Resource deleted successfully');
    }
}
