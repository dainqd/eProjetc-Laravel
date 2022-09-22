@extends('mails.master')
@section('content')
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #0407aa;
            color: white;
        }
    </style>
    <div style="padding: 0 0 10px">
        <h4 style="font-family: Nunito">Dear {{$parent->fullname}}!</h4>
        <p>{{$student->fullname}} ({{$student->username}})
        <p>eStudiez in the notice of students' grades grade: {{$student->fullname}}</p>
        <p>Class: {{$group->name}} - Teacher:{{$teacher->fullname}}</p>
    </div>
    <h1>Score</h1>

    <table id="customers">
        <tr>
            <th style="text-align-last: left">Test</th>
            <th style="text-align-last: left">Date</th>
            <th style="text-align-last: left">Score</th>
            <th style="text-align-last: left">Weight</th>
            <th style="text-align-last: left">Notes</th>
        </tr>
        @foreach($datas as $data)
            <tr>
                <td>{{$data['test']['name']}}</td>
                <td>{{$data['test']['date']}}</td>
                <td>{{$data['score_given']}} / {{$data['test']['maximum_score']}}</td>
                <td>{{$data['test']['weight']}}</td>
                <td>{{$data['notes']}}</td>
            </tr>
        @endforeach
    </table>
@endsection
