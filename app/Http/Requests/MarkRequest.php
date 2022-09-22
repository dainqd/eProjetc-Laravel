<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'scores' => ['required', 'array', 'min:1'],
            'scores.*.student_id' => ['required', 'integer'],
            'scores.*.score_given' => ['required', 'integer', 'min:0'],
            'scores.*.notes' => ['nullable', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'scores.*.student_id.required' => 'Student id is required',
            'scores.*.student_id.integer' => 'Student id must be an integer',
            'scores.*.score_given.required' => 'Score given is required',
            'scores.*.score_given.integer' => 'Score given must be an integer',
            'scores.*.score_given.min' => 'Score given must be greater than 0',
            'scores.*.notes.string' => 'Notes must be a string'
        ];
    }
}
