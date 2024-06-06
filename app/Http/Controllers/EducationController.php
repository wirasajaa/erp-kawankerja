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
        $this->authorize('create', session('employee_id'));
        $validated = $req->validated();
        try {
            $validated['created_by'] = auth()->user()->id;
            $validated['employee_id'] = session('employee_id');
            Education::create($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'New education data has added');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to add new education!', $th->getMessage())]);
        }
    }
    public function edit(Education $education)
    {
        $this->authorize('update', $education);
        $educations = $this->educations;
        return view('employees.educations.edit', compact('education', 'educations'));
    }
    public function update(EducationRequest $req, Education $education)
    {
        $this->authorize('update', $education);
        $validated = $req->validated();
        try {
            $validated['updated_by'] = auth()->user()->id;
            $validated['employee_id'] = session('employee_id');
            $education->update($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Education data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to update education data!', $th->getMessage())]);
        }
    }
    public function destroy(Education $education)
    {
        $this->authorize('delete', $education);
        try {
            $education->delete();
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Education data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to delete education data!', $th->getMessage())]);
        }
    }
}
