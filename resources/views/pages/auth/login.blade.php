@extends('layouts.master', ['title' => 'Login'])

@section('title', 'Login')

@section('headCss')
    <link rel="stylesheet" href="{{ asset('/assets/css/pages/auth.css') }}">
@endsection

@section('main')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <h1 class="auth-title">eStudiez</h1>
                    <p class="auth-subtitle mb-5">
                        Please login to continue.
                    </p>

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                            {{ session()->get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{route('auth.login')}}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Username"
                                   name="username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password"
                                   name="password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                            Login
                        </button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{route('auth.register')}}" class="font-bold">Register</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div class="h-100">
                    <img
                        src="https://unsplash.com/photos/hhUx08PuYpc/download?ixid=MnwxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNjYwMjIxMTE3&force=true&w=1920"
                        alt="" class="h-100 w-100" style="object-fit: cover;"/>
                </div>
            </div>
        </div>
    </div>
@endsection
