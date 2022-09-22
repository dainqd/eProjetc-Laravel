@extends('layouts.index', ['card_width' => '768px'])
@section('title')
    Your parent
@endsection

@section('content')
    @if(!$data->parent_id)
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h1 class="card-title">Add parent</h1>
                        <form action="{{route('students.parents.add')}}" method="post">
                            @if(session('parent_not_found'))
                                <div class="alert alert-danger">{{session('parent_not_found')}}.</div>
                            @endif

                            <p>We need information about your parent username</p>
                            <x-input :col="12" name="username" :show-label="false"
                                     placeholder="Enter your parent's username"/>
                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif(!$data->is_parent_confirmed)
        @php
            $parent = \App\Models\User::find($data->parent_id)
        @endphp
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <img
                        src="{{$parent->avatar != null ? $parent->avatar :'https://res.cloudinary.com/kee/image/upload/v1660362020/sem3/765-default-avatar_sk9nez.png'}}"
                        class="card-img-top img-fluid" alt="singleminded">
                    <div class="card-body">
                        <h5 class="card-title">{{$parent->fullname}} ({{$parent->username}})</h5>
                        <p class="card-text">
                            Waiting for confirmation from parent...
                        </p>

                        <p class="text-danger font-bold float-end" style="cursor: pointer" data-bs-toggle="modal"
                           data-bs-target="#remove-parent">
                            Remove
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        @php
            $parent = \App\Models\User::find($data->parent_id)
        @endphp
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <img
                        src="{{$parent->avatar != null ? $parent->avatar :'https://res.cloudinary.com/kee/image/upload/v1660362020/sem3/765-default-avatar_sk9nez.png'}}"
                        class="card-img-top img-fluid" alt="singleminded">
                    <div class="card-body">
                        <h5 class="card-title">{{$parent->fullname}} ({{$parent->username}})</h5>
                        <p class="card-text">
                            Email: {{$parent->email}}
                        </p>
                        <p class="text-danger font-bold float-end" style="cursor: pointer" data-bs-toggle="modal"
                           data-bs-target="#remove-parent">
                            Remove
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="remove-parent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove your parent information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel
                    </button>
                    <a href="{{route('students.parents.remove')}}"
                       class="btn btn-danger">Confirm</a>
                </div>
            </div>
        </div>
    </div>
@endsection

