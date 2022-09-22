<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->authorizeResource(User::class, 'user');
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        return view('pages.users.list', [
            'data' => $this->userService->list($limit),
        ]);
    }

    public function create()
    {
        return view('pages.users.form');
    }

    public function edit(User $user)
    {
        return view('pages.users.form', [
            'data' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->userService->update($request->validated(), $user);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $this->userService->destroy($user);
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function store(UserRequest $request)
    {
        $this->userService->store($request->validated());
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
}
