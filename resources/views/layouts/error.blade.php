@extends('layouts.master')
@section('main')
    <div id="error" style="background-color: var(--theme-50)">
        @yield('content')
    </div>
@endsection

@section('extraCss')
    <link rel="stylesheet" href="{{asset('/assets/css/pages/error.css')}}">
@endsection
