@php
    /** @var App\Models\Test $item */
    use App\Enums\UserRole;use App\Models\Test;$group = Route::getCurrentRoute()->parameter('group');
@endphp

@extends('layouts.list', [
    'create_href' => Auth::user()->can('create', [Test::class, $group]) ? route('tests.create', $group) : null,
    'card_width' => '1200px'
])

@section('title')
    Academic progress
@endsection

@section('thead')
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Date</th>
        <th>Maximum score</th>
        <th>Weight</th>
        <th>Score published</th>
        <th></th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->description}}</td>
            <td>{{$item->date}}</td>
            <td>{{$item->maximum_score}}</td>
            <td>{{$item->weight}}</td>
            <td>
                @if($item->scores_count)
                    <i class="bi bi-check text-success text-4xl"></i>
                @endif
            </td>
            <td class="text-nowrap">
                @can('mark', $item)
                    <a href="{{route('tests.mark', ['group' => $group->id, 'test' => $item->id])}}"
                       class="btn {{ $item->scores_count ? 'btn-warning' : 'btn-info' }}">
                        {{ $item->scores_count ? 'Edit mark' : 'Give mark' }}
                    </a>
                @endcan
                @can('update', $item)
                    <a href="{{route('tests.edit', ['group' => $group, 'test' => $item->id])}}"
                       type="button"
                       class="btn btn-primary">Edit</a>
                @endcan
                @can('delete', $item)
                    <x-button-delete
                        href="{{ route('tests.destroy', ['group' => $group, 'test' => $item->id]) }}"
                        :id="$item->id"></x-button-delete>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection

@section('above')
    @if(Auth::user()->role == UserRole::Parent)
        <p>
            <a href="">Send me by email</a>
        </p>
    @endif
    <div class="progress progress-primary  mb-4">
        <div class="progress-bar progress-label" role="progressbar" style="width: {{ $percentage }}%"
             aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
@endsection
