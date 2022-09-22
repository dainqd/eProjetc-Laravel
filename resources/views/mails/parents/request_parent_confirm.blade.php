@extends('mails.master')
@section('content')
    <div style="padding: 0 0 10px">
        <h4 style="font-family: Nunito">Dear {{$parent->fullname}}!</h4>
        <p>{{$student->fullname}} ({{$student->username}}) has just added you as their parent on eStudiez. As their parent, you can view and keep track of their scores and academic progress. Please click the following URL to confirm: (<a href="{{route('students.parents.confirm', $code)}}">{{route('students.parents.confirm', $code)}}</a>)</p>
    </div>
@endsection
