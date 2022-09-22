@php
    /** @var App\Models\Group $item */
use App\Enums\UserRole;use App\Models\Group;$isArchived = str_contains(Route::currentRouteName(), 'archived');
@endphp

@extends('layouts.list', [
    'create_href' => $isArchived ? null : match (Auth::user()->role) {
        UserRole::Teacher => route('classes.create'),
        UserRole::Student => route('students.join-class'),
        default => null
    },
    'create_label' => match (Auth::user()->role) {
        UserRole::Teacher => 'Create',
        UserRole::Student => 'Join class',
        default => null
    }
])

@section('title')
    @if($isArchived)
        Archived classes
    @else
        Classes
    @endif
@endsection

@section('above')
    <div class="row">
        @foreach($data as $item)
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img src="{{$item->banner_url}}" class="card-img-top img-fluid" alt="singleminded">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('classes.show', $item->id) }}">{{$item->name}}</a>
                            </h5>
                            <div class="card-text">
                                <div>{{ $item->school }} - {{ $item->subject }}</div>
                                @if(Auth::user()->role == UserRole::Teacher)
                                    @if(!$isArchived)
                                        <div class="join_code" title="Copy to clipboard" slot="{{$item->join_code}}">
                                            <a href="javascript:void(0)" class="text-gray-600">
                                                <span>{{$item->join_code}}</span>
                                                <i class="bi-middle bi bi-clipboard"></i>
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div>{{ $item->teacher->full_name }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @canany(['unarchive', 'update', 'archive'], $item)
                        <div class="card-footer text-muted">
                            <div class="d-flex justify-content-end gap-1">

                                @if($isArchived)
                                    @can('unarchive', $item)
                                        <a href="{{route('classes.archived.off', $item->id)}}" class="btn btn-success">Unarchive</a>
                                    @endcan
                                @else
                                    @can('update', $item)
                                        <a href="{{route('classes.edit', $item->id)}}" type="button"
                                           class="btn btn-primary">Edit</a>
                                    @endcan

                                    @can('archive', $item)
                                        <a type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                           data-bs-target="#delete-{{ $item->id }}">Archive</a>
                                        <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Archive class</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to archive this?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel
                                                        </button>
                                                        <a href="{{route('classes.archived.on', $item->id)}}"
                                                           class="btn btn-danger">Confirm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    @endcanany
                </div>
            </div>
        @endforeach


    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <svg class="bd-placeholder-img rounded me-2 text-success" width="20" height="20" fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice"
                     focusable="false">
                    <rect width="100%" height="100%"></rect>
                </svg>
                <strong class="me-auto">Success</strong>
                <small></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body font-bold">Join code copied to clipboard.</div>
        </div>
    </div>
@endsection

@section('extraJs')
    <script>
        $('.join_code').click(function () {
            const toastLiveExample = document.getElementById("liveToast")
            navigator.clipboard.writeText(this.slot);
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        });

        $('form .card-body').css('display', 'none');
    </script>
@endsection
