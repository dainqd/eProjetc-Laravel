@php
    /** @var App\Models\Resource $item */
use App\Models\Resource;$group = Route::getCurrentRoute()->parameter('group');
@endphp

@extends('layouts.list', [
    'create_href' => Auth::user()->can('create', [Resource::class, $group]) ? route('resources.create', $group) : null,
])
@section('title')
    Study resources
@endsection

@section('thead')
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>URL</th>
        <th></th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->resource_type->name}}</td>
            <td><a href="{{$item->external_url}}" target="_blank">{{$item->external_url}}</a></td>
            <td class="text-nowrap">
                @can('update', $item)
                    <a href="{{route('resources.edit', ['group' => $group, 'resource' => $item->id])}}"
                       type="button"
                       class="btn btn-primary">Edit</a>
                @endcan
                @can('delete', $item)
                    <x-button-delete
                        href="{{ route('resources.destroy', ['group' => $group, 'resource' => $item->id]) }}"
                        :id="$item->id"></x-button-delete>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection
