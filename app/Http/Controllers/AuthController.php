<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\StudentService;
use App\Services\UserService;
use Error;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only(['username', 'password']);
        $remember = !!$request->input('remember', false);
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function handleRegister(UserRequest $userRequest)
    {
        $this->userService->store($userRequest->validated());
        return redirect()->route('auth.login');
    }
}
