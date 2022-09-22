@php /** @var App\Models\User $item */ @endphp
@php /** @var Collection $data */ use App\Enums\UserRole;use App\Models\Group;use App\Models\Score;use Illuminate\Support\Collection;@endphp

@extends('layouts.index', [
    'card_width' => '1200px'
])

@section('title')
    {{ $group->name }}
@endsection

@section('subtitle')
    <div class="d-flex justify-content-between">
        <div>
            <div class="text-white">
                {{ $group->school . ($group->subject ? ' - ' . $group->subject : '') }}
            </div>
            @if(Auth::user()->role == UserRole::Teacher)
                @if(!$group->is_archived)
                    <div class="join_code" title="Copy to clipboard" slot="{{$group->join_code}}">
                        <a href="javascript:void(0)" class="text-gray-400">
                            <span>{{$group->join_code}}</span>
                            <i class="bi-middle bi bi-clipboard"></i>
                        </a>
                    </div>
                    <div class="toast-container position-fixed top-0 end-0 p-3">
                        <div id="liveToast" class="toast fade hide" role="alert" aria-live="assertive"
                             aria-atomic="true">
                            <div class="toast-header">
                                <svg class="bd-placeholder-img rounded me-2 text-success" width="20" height="20"
                                     fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                     preserveAspectRatio="xMidYMid slice"
                                     focusable="false">
                                    <rect width="100%" height="100%"></rect>
                                </svg>
                                <strong class="me-auto">Success</strong>
                                <small></small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
                            </div>
                            <div class="toast-body font-bold">Join code copied to clipboard.</div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="gap-1">
            @if($group->is_archived)
                @can('unarchive', $group)
                    <a href="{{route('classes.archived.off', $group->id)}}" class="btn btn-success">Unarchive</a>
                @endcan
            @else
                @can('update', $group)
                    <a href="{{route('classes.edit', $group->id)}}" type="button"
                       class="btn btn-primary">Edit</a>
                @endcan

                @can('archive', $group)
                    <a type="button" class="btn btn-secondary" data-bs-toggle="modal"
                       data-bs-target="#delete-{{ $group->id }}">Archive</a>
                    <div class="modal fade" id="delete-{{ $group->id }}" tabindex="-1"
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
                                    <a href="{{route('classes.archived.on', $group->id)}}"
                                       class="btn btn-danger">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
        </div>
    </div>
@endsection

@section('extraCss')
    <style>
        .page-title {
            background-image: linear-gradient(
                rgba(0, 0, 0, -0.5),
                rgba(0, 0, 0, 0.8)
            ), url('{{$group->banner_url}}');
            border-radius: 10px;
            padding: 0 32px;
            aspect-ratio: 3/1;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: end;
        }

        .page-title h3 {
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <h3>Teacher</h3>
            <div class="card mt-2">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Full name</th>
                                    <th>Contact</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$teacher->full_name}}</td>
                                    <td>
                                        <div>{{$teacher->email}}</div>
                                        <div>{{$teacher->phone_number}}</div>
                                    </td>
                                    <td class="text-nowrap"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h3>Students</h3>
            <div class="card mt-2">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Full name</th>
                                    <th>Contact</th>
                                    @if(auth()->user()->role === UserRole::Teacher)
                                        <th>Parent</th>
                                    @endif
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($data && sizeof($data) > 0)
                                    @foreach($data as $item)
                                        <tr>
                                            <td class="font-bold">{{$item->full_name}}</td>
                                            <td>
                                                <div>{{$item->email}}</div>
                                                <div>{{$item->phone_number}}</div>
                                            </td>
                                            @if(auth()->user()->role === UserRole::Teacher)
                                                @php
                                                    $parent = $item->student->parent;
                                                @endphp
                                                @if($parent && $item->student->is_parent_confirmed)
                                                    <td>
                                                        <div class="font-semibold">{{$parent->full_name}}</div>
                                                        <div>{{$parent->email}}</div>
                                                        <div>{{$parent->phone_number}}</div>
                                                    </td>
                                                @elseif($parent)
                                                    <td class="text-danger">Parent not confirmed</td>
                                                @else
                                                    <td class="text-danger">No parent set</td>
                                                @endif
                                            @endif
                                            <td class="text-nowrap">
                                                @if(Auth::user()->role == UserRole::Teacher)
                                                    <a href="{{route('scores.list-by-student', [$group->id, $item->id])}}"
                                                       type="button"
                                                       class="btn btn-primary">View scores</a>
                                                @endif
                                                @can('remove', [Group::class, $group, $item])
                                                    <x-button-delete
                                                        href="{{ route('classes.remove', [$group->id, $item->id]) }}"
                                                        :id="$item->id"></x-button-delete>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="odd">
                                        <td colspan="8" class="dataTables_empty text-center">No data</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <script>
        $('.join_code').click(function () {
            const toastLiveExample = document.getElementById("liveToast")
            navigator.clipboard.writeText(this.slot);
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        });
    </script>
@endsection
