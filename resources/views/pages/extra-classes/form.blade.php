@php
    $groupId = Route::getCurrentRoute()->parameter('group');
@endphp

@extends('layouts.form', [
    'back_href' => route('extra-classes.index', $groupId),
])
@section('title')
    @isset($data)
        Update extra class
    @else
        Create extra class
    @endif
@endsection

@section('fields')
    @include('layouts.form-fields', [
    'fields' => [
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'name',
            'label' => 'Name',
        ],
         [
            'element' => 'input',
            'col' => 6,
            'name' => 'start_time',
            'label' => 'Start time',
            'type' => 'datetime-local',
        ],
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'end_time',
            'label' => 'End time',
            'type' => 'datetime-local',
        ],
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'location',
            'label' => 'Location',
            'type' => 'text'
        ],
    ],
    'data' => $data ?? null
])
@endsection
