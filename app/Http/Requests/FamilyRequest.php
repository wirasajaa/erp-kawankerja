<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class FamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identity_number' => ['required', 'numeric', 'digits:16', Rule::unique('families', 'identity_number')->ignore($this->family)],
            'name' => 'required|min:3',
            'gender' => 'required',
            'relationship' => 'required',
            'birthday' => 'required|date',
            'birthplace' => 'required|alpha_dash',
        ];
    }
}
