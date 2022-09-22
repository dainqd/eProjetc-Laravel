@php /** @var App\Models\User $item */ @endphp

@extends('layouts.list', [
    'create_href' => route('users.create')
])
@section('title')
    Manage users
@endsection

@section('thead')
    <tr>
        <th>Username</th>
        <th>Full name</th>
        <th>Contact</th>
        <th>Role</th>
        <th></th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->username}}</td>
            <td>{{$item->full_name}}</td>
            <td class="text-nowrap"><i class="bi bi-envelope"></i> {{$item->email}} <br>  <i class="bi bi-telephone-fill"></i> {{$item->phone_number}}</td>
            <td>{{$item->role->name}}</td>
            <td class="text-nowrap">
                @can('update', $item)
                    <a href="{{route('users.edit', $item->id)}}" type="button" class="btn btn-primary">Edit</a>
                @endcan
                @can('delete', $item)
                    <x-button-delete href="{{ route('users.destroy', $item->id) }}" :id="$item->id"></x-button-delete>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection
