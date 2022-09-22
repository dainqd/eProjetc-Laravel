<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMarkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'score_given' => ['required', 'integer'],
            'notes' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
