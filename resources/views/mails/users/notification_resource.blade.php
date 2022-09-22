@extends('mails.master')
@section('content')
    <div style="padding: 0 0 10px">
        <h4 style="font-family: Nunito">Dear {{$user->fullname}}!</h4>
        @if($type == 'create')
            <p>A new resource has been announced for class {{$group->name}} Visit eStudiez portal to see details:
                <a href="{{route('resources.index', $group->id)}}">{{route('resources.index', $group->id)}}</a>
            </p>
        @else
            <p>An resource has been updated for class {{$group->name}} Visit eStudiez portal to see details:
                <a href="{{route('resources.index', $group->id)}}">{{route('resources.index', $group->id)}}</a>
            </p>
        @endif

    </div>
@endsection
