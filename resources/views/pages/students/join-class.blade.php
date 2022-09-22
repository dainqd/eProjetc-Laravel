@extends('layouts.index', ['back_href' => route('classes.ongoing'), 'card_width' => '768px'])
@section('title')
    Join class
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form action="" method="post">
                        <p>Ask your teacher for the class code, then enter it here</p>
                        <x-input :col="12" name="join_code" :show-label="false" placeholder="Enter code"/>
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
