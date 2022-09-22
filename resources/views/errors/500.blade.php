@extends('layouts.error')
@section('title', '500 Error')

@section('content')
    <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
            <div class="text-center">
                <img class="img-error" src="{{ asset('/assets/images/samples/error-500.svg') }}" alt="Server error">
                <h1 class="error-title">System Error</h1>
                <p class="fs-5 text-gray-600">The website is currently unavailable. Try again later or contact the
                    developer.</p>
                <a href="{{route('dashboard')}}" class="btn btn-lg btn-primary mt-3">Go Home</a>
            </div>
        </div>
    </div>
@endsection
