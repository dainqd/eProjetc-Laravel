@php
    /** @var App\Models\Student $child */
        use App\Enums\UserRole;use App\Models\Group;use App\Models\User;$current = Route::currentRouteName();
        $prefix = request()->route()->getPrefix();
        $user = auth()->user();
        $isRoleAdmin = $user->role === UserRole::Admin;
        $ongoingClasses = match ($user->role) {
            UserRole::Teacher => Group::query()->archived(false)->ofCurrentUser()->get(),
            UserRole::Student => Group::query()->archived(false)->ofCurrentStudent()->get(),
            default => []
        };
        $group = Route::getCurrentRoute()->parameter('group');
        $children = $user->role === UserRole::Parent ? $user->children : [];
@endphp
<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('dashboard') }}" class="d-block">eStudiez</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">{{ Auth::user()->role->name }}
                        Portal</a>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">

                @can('viewAny', Group::class)
                    <x-menu-item href="{{ route('classes.ongoing') }}" icon="bi bi-distribute-vertical"
                                 name="Classes"
                                 :is-active="$current == 'classes.ongoing'"/>
                    <x-menu-item href="{{ route('classes.archived') }}" icon="bi bi-clock-history"
                                 name="Archived classes"
                                 :is-active="$current == 'classes.archived'"/>
                @endcan
                @can('viewAny', User::class)
                    <x-menu-item href="{{ route('users.index') }}" icon="bi bi-people" name="Users"
                                 :is-active="$prefix == '/users'"/>
                @endcan
                @if($isRoleAdmin)
                    <x-menu-item href="{{ route('feedbacks.index') }}" icon="bi bi-mailbox" name="Feedback"
                                 :is-active="$prefix == '/feedbacks'"/>
                @else
                    <x-menu-item href="{{ route('feedbacks.create') }}" icon="bi bi-mailbox" name="Send feedback"
                                 :is-active="$prefix == '/feedbacks'"/>
                    <x-menu-item href="{{ route('contact') }}" icon="bi bi-telephone" name="Contact us"
                                 :is-active="$current === 'contact'"/>
                @endif

                @if($ongoingClasses && $ongoingClasses->count())
                    <li class="sidebar-title">Ongoing classes</li>

                    @foreach($ongoingClasses as $ongoingClass)
                        <x-menu-item href="{{ route('classes.show', $ongoingClass->id) }}"
                                     icon="bi bi-plus" :name="$ongoingClass->name"
                                     :is-active="$group && $group->id === $ongoingClass->id"/>
                    @endforeach
                @endif

                @if($children && $children->count())
                    <li class="sidebar-title">Children</li>

                    @foreach($children as $child)
                        @php
                            $studyingGroups = $child->user->studyingGroups()->archived(false)->get();
                        @endphp
                        <x-menu-item icon="bi bi-person" :name="$child->user->full_name"
                                     :is-active="$group && $studyingGroups->pluck('id')->contains($group->id)">
                            @foreach($studyingGroups as $studyingGroup)
                                <x-submenu-item :name="$studyingGroup->name"
                                                :is-active="$group && $group->id === $studyingGroup->id"
                                                href="{{ route('classes.show', $studyingGroup->id) }}"/>
                            @endforeach
                        </x-menu-item>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
