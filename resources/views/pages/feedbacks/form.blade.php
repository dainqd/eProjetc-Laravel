@extends('layouts.form')
@section('title')
    @isset($data)
        Create feedback
    @else
        Create feedback
    @endif
@endsection

@section('fields')
    @include('layouts.form-fields', [
    'fields' => [
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'title',
            'label' => 'Title'
        ],
        [
            'element' => 'textarea',
            'col' => 12,
            'name' => 'content',
            'label' => 'Content',
            'type' => 'textarea'
        ],
    ],
    'data' => $data ?? null
])
@endsection
