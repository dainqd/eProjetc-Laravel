

@extends('layouts.index',[
    'back_href' => route('feedbacks.index'),
])

@section('title')
    Feedback detail
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$data->title}}</h4>
                </div>
                <div class="card-body">
                    {{$data->content}}
                </div>
            </div>
        </div>
    </div>
@endsection
