@extends('layouts.form', [
    'back_href' => route('classes.ongoing'),
])
@section('title')
    @isset($data)
        Edit class
    @else
        Create class
    @endif
@endsection

@section('fields')
    @include('layouts.form-fields', [
    'fields' => [
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'school',
            'label' => 'School name'
        ],
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'name',
            'label' => 'Class name'
        ],
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'subject',
            'label' => 'Subject'
        ],
        [
            'element' => 'single-image',
            'col' => 4,
            'name' => 'banner_url',
            'label' => 'Banner url',
            'placeholder' => 'Upload photo'
        ],
    ],
    'data' => $data ?? null
])
@endsection
