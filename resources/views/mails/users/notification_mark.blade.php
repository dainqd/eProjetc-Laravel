@extends('mails.master')
@section('content')
    <div style="padding: 0 0 10px">
        <h4 style="font-family: Nunito">Dear {{$user->fullname}}!</h4>
        <p>The {{$test->name}} test has scores, click on the link to see details:
            <a href="{{route('tests.mark', ['group'=>$group->id, 'test' => $test->id])}}">{{route('tests.mark', ['group'=>$group->id, 'test' => $test->id])}}</a>
        </p>
    </div>
@endsection
