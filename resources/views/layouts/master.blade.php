@php
    use App\Enums\UserRole;
    $themeClass = match (Auth::user()?->role ?? UserRole::Student) {
        UserRole::Student => 'orange-theme',
        UserRole::Teacher => 'red-theme',
        UserRole::Parent => 'purple-theme',
        UserRole::Admin => 'blue-theme',
    }
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | eStudiez by CD9T</title>
    @include('layouts.components.head')
    @yield('headCss')
    @yield('extraCss')

</head>

<body class="{{ $themeClass }}">
@yield('main')
@include('layouts.components.script')
@yield('script')
</body>

</html>
