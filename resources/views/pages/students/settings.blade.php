@extends('layouts.index', ['card_width' => '768px'])
@section('title')
    Email settings
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="score" value="1"
                                   name="is_score_notified" {{$data->is_score_notified ? 'checked' : ''}}>
                            <label class="form-check-label" for="score">
                                Receives email when your score is published
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="resource" value="1"
                                   name="is_resource_notified" {{$data->is_resource_notified ? 'checked' : ''}}>
                            <label class="form-check-label" for="resource">
                                Receives email when a new resource is added
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="class" value="1"
                                   name="is_extra_class_notified" {{$data->is_extra_class_notified ? 'checked' : ''}}>
                            <label class="form-check-label" for="class">
                                Receives email when a new extra class is added
                            </label>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
