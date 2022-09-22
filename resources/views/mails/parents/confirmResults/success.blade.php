@extends('layouts.error')
@section('title', 'Complete confirmation')

@section('content')
    <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
            <div class="text-center">
                <img class="img-error" src="{{ asset('/assets/images/samples/error-500.svg') }}" alt="Complete confirmation">
                <h1 class="error-title">eStudiez</h1>
                <p class="fs-5 text-gray-600">Complete confirmation!</p>
                <a href="{{route('dashboard')}}" class="btn btn-lg btn-primary mt-3">Go to Home</a>
            </div>
        </div>
    </div>
@endsection
