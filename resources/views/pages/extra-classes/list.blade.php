@php
    /** @var App\Models\ExtraClass $item */
    use App\Models\ExtraClass;$group = Route::getCurrentRoute()->parameter('group');
@endphp

@extends('layouts.list', [
    'create_href' => Auth::user()->can('create', [ExtraClass::class, $group]) ? route('extra-classes.create', $group) : null,
])
@section('title')
    Extra classes
@endsection

@section('thead')
    <tr>
        <th>Name</th>
        <th>Start time</th>
        <th>End time</th>
        <th>Location</th>
        <th></th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->start_time}}</td>
            <td>{{$item->end_time}}</td>
            <td>{{$item->location}}</td>
            <td class="text-nowrap">
                @can('update', $item)
                    <a href="{{route('extra-classes.edit', ['group' => $group, 'extraClass' => $item->id])}}"
                       type="button"
                       class="btn btn-primary">Edit</a>

                @endcan
                @can('delete', $item)
                    <x-button-delete
                        href="{{ route('extra-classes.destroy', ['group' => $group, 'extraClass' => $item->id]) }}"
                        :id="$item->id"></x-button-delete>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection
