@php
    use App\Enums\UserRole;use App\Models\User;$group = Route::getCurrentRoute()->parameter('group');
@endphp

<header class='mb-3 border-bottom border-theme-200'>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="javascript:void(0)" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between align-center" id="navbarSupportedContent">
                @if($group)
                    <a href="{{ route('classes.show', $group->id) }}"
                       class="d-block mx-lg-2 site-title font-bold">{{ $group->name }}
                        @if($group->is_archived)
                            <span class="text-sm text-gray-600">(Archived)</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="d-block mx-lg-2 site-title font-bold">eStudiez</a>
                @endif
                <div class="position-absolute" style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
                    @include('layouts.components.nav')
                </div>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ auth()->user()->full_name }}</h6>
                                <p class="mb-0 text-sm text-gray-600">{{ auth()->user()->role->name }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ auth()->user()->avatar ?? '/assets/images/faces/1.jpg' }}"
                                         alt="{{ auth()->user()->full_name }}"/>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ auth()->user()->first_name }}!</h6>
                        </li>
                        @can('settings', User::class)
                            <li><a class="dropdown-item" href="{{ route('students.settings')}}"><i
                                        class="icon-mid bi bi-gear me-2"></i>
                                    Email Settings</a></li>
                            <li><a class="dropdown-item" href="{{route('students.parents')}}"><i
                                        class="icon-mid bi bi-person-rolodex me-2"></i>
                                    Parent</a></li>
                        @endcan
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('auth.logout') }}"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
