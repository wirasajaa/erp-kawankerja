<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            'ktp_number' => ['numeric', 'digits:16', Rule::unique('employees', 'ktp_number')->ignore(@$this->employee->id)],
            'title_front' => 'nullable|min:3|regex:/^[A-Za-z. -]+$/',
            'title_back' => 'nullable|min:3|regex:/^[A-Za-z. -]+$/',
            'fullname' => 'required|min:3|regex:/^[A-Za-z. -]+$/',
            'nickname' => 'required|min:3|regex:/^[A-Za-z. -]+$/',
            'whatsapp_number' => 'required|min:12|regex:/^([0-9\s\-\+\(\)]*)$/',
            'birthday' => 'required|date|before:-17 years',
            'birthplace' => 'required',
            'religion' => 'required',
            'marital_status' => 'required',
            'blood_type' => 'required',
            'gender' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'birthday.before' => 'Minimum age is 17 years'
        ];
    }
}
