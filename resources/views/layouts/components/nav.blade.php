@php
    $groupId = Route::getCurrentRoute()->parameter('group');
    $routeName = Route::currentRouteName();
@endphp

@if($groupId)
    <div class="nav nav-pills" id="v-pills-tab" role="tablist">
        <a class="nav-link {{ str_starts_with($routeName, 'classes.show') ? 'active' : '' }}"
           href="{{ route('classes.show', $groupId) }}">Information</a>
        <a class="nav-link {{ str_starts_with($routeName, 'scores') ? 'active' : '' }}"
           href="{{ route('scores.index', $groupId) }}">Scores</a>
        <a class="nav-link {{ str_starts_with($routeName, 'tests') ? 'active' : '' }}"
           href="{{ route('tests.index', $groupId) }}">Academic
            progress</a>
        <a class="nav-link {{ str_starts_with($routeName, 'resources') ? 'active' : '' }}"
           href="{{ route('resources.index', $groupId) }}">Study
            resources</a>
        <a class="nav-link {{ str_starts_with($routeName, 'extra-classes') ? 'active' : '' }}"
           href="{{ route('extra-classes.index', $groupId) }}">Extra
            classes</a>
    </div>
@endif
