<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'role_name' => 'required|exists:roles,name',
            'username' => ['required', Rule::unique('users', 'username')->ignore(@$this->user->id)],
            'email' => ['required', Rule::unique('users', 'email')->ignore(@$this->user->id)],
            'password' => 'nullable|confirmed',
        ];
    }
}
