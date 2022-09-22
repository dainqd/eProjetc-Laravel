@php
    /** @var App\Models\Group $item */
    $groupId = Route::getCurrentRoute()->parameter('group');
    $isEdit = $test->scores->count() > 0;
@endphp

@extends('layouts.list', [
    'card_width' => '1200px',
])

@section('title')
    {{ $isEdit ? 'Edit mark' : 'Give mark' }}: {{ $test->name }}
@endsection
@section('form')
    action="{{route('tests.give-mark', ['group' => $groupId, 'test' => $test])}}" method="post"
@endsection

@section('thead')
    <tr>
        <th>Name</th>
        <th>Date of birth</th>
        <th>Mark</th>
        <th>Comment</th>
        @if($isEdit)
            <th></th>
        @endif
    </tr>
@endsection

@section('tbody')
    @if($data && sizeof($data) > 0)
        @foreach($data as $key => $item)

            @php
                $score = $test->scores()->where('student_id', $item->id)->first();
            @endphp

            <tr>
                <td>{{$item->full_name}}</td>
                <td>{{$item->dob}}</td>
                <td>
                    @if($score)
                        {{ $score->score_given }}
                    @else
                        <input class="form-control" type="number" min="0" max="{{$test->maximum_score}}"
                               name="scores[{{$key}}][score_given]" value="">
                    @endif
                </td>
                <td>
                    @if($score)
                        {{ $score->notes }}
                    @else
                        <input class="form-control" type="text" name="scores[{{$key}}][notes]" value="">
                    @endif
                </td>
                <input type="hidden" name="scores[{{$key}}][student_id]" value="{{$item->id}}">
                <input type="hidden" name="scores[{{$key}}][test_id]" value="{{$test->id}}">
                @if($isEdit)
                    <td class="text-nowrap">
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal"
                           onclick="handleShowModal({{$item}})">Edit</a>
                    </td>
                @endif
            </tr>

        @endforeach
    @endif
@endsection

@section('modal')
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('tests.edit-mark', ['group' => $groupId, 'test' => $test])}}" method="post">
                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label">Score</label>
                                <input type="number" name="score_given" class="form-control" min="0"
                                       max="{{$test->maximum_score}}" value="" id="score_given">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <input type="text" class="form-control" name="notes" value="" id="notes">
                            </div>
                        </div>
                        <input type="hidden" value="" name="student_id" id="student_id">
                        <input type="hidden" value="{{$test->id}}" name="test_id" id="test_id">

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('button-custom')
    @if(!$isEdit)
        <div class="d-flex justify-content-end">
            <button id="mark" type="submit" class="btn btn-primary">Submit</button>
        </div>
    @endif
@endsection

@section('extraJs')
    <script>
        function handleShowModal(item) {
            const score = '<?php echo json_encode($scores) ?>';
            const scores = JSON.parse(score);
            const data = [...scores].filter(e => e.student_id === item.id)
            $('#title').text(`${item.first_name} ${item.last_name}`)
            $('#student_id').val(item.id);
            $('input[name=score_given]').val(data[0].score_given);
            $('input[name=notes]').val(data[0].notes);
        }
    </script>
@endsection

