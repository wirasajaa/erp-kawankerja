<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationRequest;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EducationController extends Controller
{
    private $educations = [];
    public function __construct()
    {
        $this->educations =  (object)[
            'SD',
            'SMP',
            'SMA',
            'SMK',
            'D1',
            'D2',
            'D3',
            'S1',
            'S2',
            'S4',
        ];
    }

    public function create()
    {
        $educations = $this->educations;
        return view('employees.educations.create', compact('educations'));
    }
    public function store(EducationRequest $req)
    {
        $validated = $req->validated();
        try {
            $validated['created_by'] = auth()->user()->id;
            $validated['employee_id'] = session('employee_id');
            Education::create($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'New education data has added');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to add new education!')]);
        }
    }
    public function edit(Education $education)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $education->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $educations = $this->educations;
        return view('employees.educations.edit', compact('education', 'educations'));
    }
    public function update(EducationRequest $req, Education $education)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $education->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $validated = $req->validated();
        try {
            $validated['updated_by'] = auth()->user()->id;
            $validated['employee_id'] = session('employee_id');
            $education->update($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Education data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to update education data!')]);
        }
    }
    public function destroy(Education $education)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $education->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        try {
            $education->update(['deleted_by' => auth()->user()->id]);
            $education->delete();
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Education data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to delete education data!')]);
        }
    }
}
