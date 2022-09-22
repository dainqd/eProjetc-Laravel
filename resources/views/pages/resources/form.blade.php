@php
    use App\Enums\ResourceType;$groupId = Route::getCurrentRoute()->parameter('group');
@endphp

@extends('layouts.form', [
    'back_href' => route('resources.index', $groupId),
])
@section('title')
    @isset($data)
        Update resource
    @else
        Create resource
    @endif
@endsection

@section('fields')
    @include('layouts.form-fields', [
    'fields' => [
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'name',
            'label' => 'Name',
        ],
        [
            'element' => 'select',
            'col' => 6,
            'name' => 'resource_type',
            'label' => 'Resource type',
            'placeholder' => 'Select resource type',
            'options' => array_column(ResourceType::cases(), 'name', 'value'),
        ],
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'external_url',
            'label' => 'External url',
            'type' => 'text',
        ],

    ],
    'data' => $data ?? null
])
@endsection
