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
        $this->authorize('create', session('employee_id'));
        $validated = $req->validated();
        try {
            $validated['employee_id'] = session('employee_id');
            Certificate::create($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'New certificate data has added');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to add new certificate!', $th->getMessage())]);
        }
    }
    public function edit(Certificate $certificate)
    {
        $this->authorize('update', $certificate);
        $types = $this->types;
        return view('employees.certificates.edit', compact('certificate', 'types'));
    }
    public function update(CertificateRequest $req, Certificate $certificate)
    {
        $this->authorize('update', $certificate);
        $validated = $req->validated();
        try {
            $validated['employee_id'] = session('employee_id');
            $certificate->update($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Certificate data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to update certificate data!', $th->getMessage())]);
        }
    }
    public function destroy(Certificate $certificate)
    {
        $this->authorize('delete', $certificate);
        try {
            $certificate->delete();
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Certificate data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to delete certificate data!', $th->getMessage())]);
        }
    }
}
