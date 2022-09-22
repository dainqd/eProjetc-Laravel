@php
    /** @var App\Models\Score $item */
    /** @var App\Models\User $student */
    use App\Enums\UserRole;
    use App\Models\ExtraClass;
    $group = Route::getCurrentRoute()->parameter('group');
    $student = Route::getCurrentRoute()->parameter('user');
@endphp

@extends('layouts.list', [
    'back_href' => Auth::user()->role == UserRole::Student || session()->has('only-child') ? null : route('scores.index', $group),
    'card_width' => '1200px'
])
@section('title')
    @if(Auth::user()->role == UserRole::Student)
        My scores
    @else
        Scores of {{ $student->full_name }}
    @endif
@endsection

@section('thead')
    <tr>
        <th>Test</th>
        <th>Date</th>
        <th>Score</th>
        <th>Weight</th>
        <th>Notes</th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->test->name}}</td>
            <td>{{$item->test->date}}</td>
            <td>{{$item->score_given}} / {{$item->test->maximum_score}}</td>
            <td>{{$item->test->weight}}</td>
            <td>{{$item->notes}}</td>
        </tr>
    @endforeach
@endsection

@section('above')
    @if(Auth::user()->role == UserRole::Parent)
        <p>
            <a href="{{route('scores.send-to-parent',['group'=>$group->id, 'user'=> $student->id])}}">Send me by
                email</a>
        </p>
    @endif
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <i class="iconly-boldShow"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Average score</h6>
                            <h6 class="font-extrabold mb-0">{{ $averageScore }} / 100</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon blue mb-2">
                                <i class="iconly-boldProfile"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">{{ $testPercentage === 100 ? 'Grade' : 'Current grade' }}</h6>
                            <h6 class="font-extrabold mb-0">{{ $grade }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldAdd-User"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Tests finished</h6>
                            <h6 class="font-extrabold mb-0">{{ $testCount }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon red mb-2">
                                <i class="iconly-boldBookmark"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Finished percentage</h6>
                            <h6 class="font-extrabold mb-0">{{ $testPercentage }}%</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
