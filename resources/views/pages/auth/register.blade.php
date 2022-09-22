@php
    use App\Enums\UserRole;$formFields = [
    'fields' => [
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
            'options' => [
                UserRole::Student->value => 'Student',
                UserRole::Parent->value => 'Parent',
                UserRole::Teacher->value => 'Teacher',
],
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
    ],
    'data' => $data ?? null
]
@endphp

@extends('layouts.master')
@section('title', 'Register')

@section('main')
    <div id="app">
        <section class="h-100 orange-theme">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <form method="POST">
                        @csrf
                        <div class="col">
                            <div class="card card-registration my-4">
                                <div class="row g-0">
                                    <div class="col-xl-6 d-none d-xl-block">
                                        <img
                                            src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img4.webp"
                                            alt="Sample photo" class="img-fluid"
                                            style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"/>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card-body p-md-5 text-black">
                                            <h2 class="mb-5">Create your eStudiez account</h2>
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible show fade">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                </div>
                                            @endif
                                            <div class="row">
                                                @include('layouts.form-fields', $formFields)
                                            </div>
                                            <div class="d-flex justify-content-center pt-3">
                                                <button type="submit"
                                                        class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                                                    Register
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
@endsection
