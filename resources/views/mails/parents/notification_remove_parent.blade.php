@extends('mails.master')
@section('content')
    <div style="padding: 0 0 10px">
        <h4 style="font-family: Nunito">Dear {{$parent->fullname}}!</h4>
        <p>{{$student->fullname}} ({{$student->username}}) has just removed you from the role of their parent on eStudiez.</p>
    </div>
@endsection
