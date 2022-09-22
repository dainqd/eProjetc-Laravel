@php
    /** @var App\Models\Feedback $item */
use App\Models\Feedback;
@endphp

@extends('layouts.list')
@section('title')
    Feedback
@endsection

@section('thead')
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Action</th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->title}}</td>
            <td>{{$item->content}}</td>
            <td class="text-nowrap">
                <a href="{{route('feedbacks.show', ['feedback' => $item->id])}}"
                   type="button"
                   class="btn btn-primary">View</a>
                <x-button-delete
                    href="{{ route('feedbacks.destroy', ['feedback' => $item->id]) }}"
                    :id="$item->id">
                </x-button-delete>
            </td>
        </tr>
    @endforeach
@endsection
