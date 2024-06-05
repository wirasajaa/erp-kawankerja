<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() || Gate::allows('is-admin') || Gate::allows('is-level2');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "type" => 'required',
            "number" => ['required', Rule::unique('certificates', 'number')->ignore($this->certificate)],
            "title" => 'required',
            "description" => 'required',
            "publish_date" => 'required|date',
            "date_start" => 'required|date',
            "date_end" => 'required|date|after:date_start',
        ];
    }
}
