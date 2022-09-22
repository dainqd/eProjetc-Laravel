<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
            'maximum_score' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
        ];
        return $rules;
    }
}
