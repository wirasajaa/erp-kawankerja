<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class MeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::any(['is-admin', 'is-level2', 'is-pic-project'], $this->project_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $time = "00:00";
        if ($this->request->get('meeting_date') > date("Y-m-d")) {
            $time = "00:00";
        } else {
            $time = date('H:i', strtotime(now()));
        }
        return [
            'project_id' => 'required',
            'meeting_date' => 'required|date|after_or_equal:today',
            'meeting_start' => 'required|date_format:H:i|after_or_equal:' . $time,
            'meeting_end' => 'required|date_format:H:i|after:meeting_start',
            'description' => 'required|min:10',
        ];
    }
}
