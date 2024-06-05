<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateRequest;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CertificateController extends Controller
{
    private $types = [];
    public function __construct()
    {
        $this->types = [
            (object)['name' => "Bootcamp", "value" => "BOOTCAMP"],
            (object)['name' => "Internship", "value" => "INTERNSHIP"],
        ];
    }

    public function create()
    {
        $types = $this->types;
        return view('employees.certificates.create', compact('types'));
    }
    public function store(CertificateRequest $req)
    {
        $validated = $req->validated();
        try {
            $validated['employee_id'] = session('employee_id');
            Certificate::create($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'New certificate data has added');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to add new certificate!')]);
        }
    }
    public function edit(Certificate $certificate)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $certificate->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $types = $this->types;
        return view('employees.certificates.edit', compact('certificate', 'types'));
    }
    public function update(CertificateRequest $req, Certificate $certificate)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $certificate->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $validated = $req->validated();
        try {
            $validated['employee_id'] = session('employee_id');
            $certificate->update($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Certificate data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to update certificate data!')]);
        }
    }
    public function destroy(Certificate $certificate)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $certificate->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        try {
            $certificate->delete();
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Certificate data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to delete certificate data!')]);
        }
    }
}
