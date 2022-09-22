@php
    $groupId = Route::getCurrentRoute()->parameter('group');
@endphp

@extends('layouts.form', [
    'back_href' => route('tests.index', $groupId),
])
@section('title')
    @isset($data)
        Edit test
    @else
        Create test
    @endif
@endsection

@section('fields')
    @include('layouts.form-fields', [
    'fields' => [
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'name',
            'label' => 'Name'
        ],
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'description',
            'label' => 'Description'
        ],
        [
            'element' => 'input',
            'col' => 4,
            'name' => 'date',
            'type' => 'date',
            'label' => 'Date'
        ],
        [
            'element' => 'input',
            'col' => 4,
            'name' => 'maximum_score',
            'label' => 'Maximum Score'
        ],
        [
            'element' => 'input',
            'col' => 4,
            'name' => 'weight',
            'label' => 'Weight'
        ]
    ],
    'data' => $data ?? null
])
@endsection
