<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class RegistrationEmployeeController extends Controller
{
    public $marital_status, $blood_type, $religion_status;
    public function __construct()
    {
        $this->marital_status = (object)config('employee.marital_status');
        $this->religion_status = (object)config('employee.religion_status');
        $this->blood_type = (object)config('employee.blood_type');
    }
    public function validateCodeForm()
    {
        return view('auth.validate_code');
    }
    public function validateCode(Request $req)
    {
        $validator = $req->validate([
            'code' => ['required', Rule::in(config('app.registration_code'))]
        ]);
        return redirect(URL::temporarySignedRoute('register.employee', now()->addMinutes(5)));
    }
    public function registerEmployee(Request $req)
    {
        if (!$req->hasValidSignature()) {
            return redirect()->route('registration')->withErrors(['system_error' => "Your URL has expired!"]);
        }
        $religions = $this->religion_status;
        $maritals = $this->marital_status;
        $blood_type = $this->blood_type;
        return view('auth.registration_employee', compact('religions', 'maritals', 'blood_type'));
    }
}
