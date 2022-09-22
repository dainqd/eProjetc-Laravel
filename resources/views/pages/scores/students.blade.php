@php /** @var App\Models\User $item */ @endphp
@php /** @var Collection $data */ use App\Models\Group;use App\Models\Score;use Illuminate\Support\Collection;@endphp

@extends('layouts.list')

@section('title')
    Students
@endsection

@section('thead')
    <tr>
        <th>Full name</th>
        <th>Contact</th>
        <th></th>
    </tr>
@endsection

@section('tbody')
    @foreach($data as $item)
        <tr>
            <td>{{$item->full_name}}</td>
            <td>
                <div>{{$item->email}}</div>
                <div>{{$item->phone_number}}</div>
            </td>
            <td class="text-nowrap">
                @can('viewAny', [Score::class, $group])
                    <a href="{{route('scores.list-by-student', [$group->id, $item->id])}}"
                       type="button"
                       class="btn btn-primary">View scores</a>
                @endcan
            </td>
        </tr>
    @endforeach
@endsection
