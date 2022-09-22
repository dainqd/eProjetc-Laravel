@extends('mails.master')
@section('content')
    <div style="padding: 0 0 10px">
        <h4 style="font-family: Nunito">Dear {{$user->fullname}}!</h4>
        <p>Your account has been created successfully!</p>
    </div>
@endsection
