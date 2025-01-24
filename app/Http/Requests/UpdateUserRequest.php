<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'min:4', 'max:255'],
            'email' => ['nullable', 'email:dns',  'max:255', 'unique:users'],
            'password' => ['sometimes', 'required_with:confirm_password', 'same:confirm_password', 'min:8', 'max:255'],
            'confirm_password' => ['sometimes', 'min:8', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ];
    }
}