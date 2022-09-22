<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email', Rule::unique('users')],
            'phone_number' => ['required', 'string'],
            'address' => ['required', 'string'],
            'avatar' => ['nullable'],
        ];
        if (request()->routeIs('users.update')) {
            $rules['username'] = ['required', 'string', Rule::unique('users')->ignore($this->user)];
            $rules['email'] = ['required', 'email', Rule::unique('users')->ignore($this->user)];
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        }
        if (request()->routeIs('auth.handle-register')) {
            $rules['role'] = ['required', 'integer', Rule::in(UserRole::Student->value, UserRole::Teacher->value, UserRole::Parent->value)];
        }
        if (request()->routeIs('users.store')) {
            $rules['role'] = ['required', 'integer', Rule::in(UserRole::Student->value, UserRole::Teacher->value, UserRole::Parent->value,UserRole::Admin->value)];
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
