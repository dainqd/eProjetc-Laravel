
@php
   $fields = [
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'first_name',
            'label' => 'First name'
        ],
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'last_name',
            'label' => 'Last name'
        ],
         [
            'element' => 'input',
            'col' => 6,
            'name' => 'dob',
            'label' => 'Date of birth',
            'type' => 'date'
        ],
         [
            'element' => 'select',
            'col' => 6,
            'name' => 'role',
            'label' => 'Role',
            'placeholder' => 'Select role of user',
            'options' => array_column(\App\Enums\UserRole::cases(), 'name', 'value'),
        ],
        [
            'element' => 'divider',
            'text' => 'Login credentials',
        ],
        [
            'element' => 'input',
            'col' => 4,
            'name' => 'username',
            'label' => 'Username',
        ],
        [
            'element' => 'input',
            'col' => 4,
            'name' => 'password',
            'label' => 'Password',
            'type' => 'password'
        ],
        [
            'element' => 'input',
            'col' => 4,
            'name' => 'password_confirmation',
            'label' => 'Password confirmation',
            'type' => 'password'
        ],
        [
            'element' => 'divider',
            'text' => 'Contact details',
        ],
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email'
        ],
        [
            'element' => 'input',
            'col' => 6,
            'name' => 'phone_number',
            'label' => 'Phone number'
        ],
        [
            'element' => 'input',
            'col' => 12,
            'name' => 'address',
            'label' => 'Address'
        ],
        [
            'element' => 'single-image',
            'col' => 4,
            'name' => 'avatar',
            'label' => 'Avatar',
            'placeholder' => 'Upload photo'
        ],
    ];
   if (isset($data)){
       unset($fields[3]) ;
   }
@endphp
@extends('layouts.form', [
    'back_href' => route('users.index'),
])
@section('title')
    @isset($data)
        Edit user
    @else
        Create user
    @endif
@endsection

@section('fields')
    @include('layouts.form-fields', [
    'fields' => $fields,
    'data' => $data ?? null
])
@endsection
