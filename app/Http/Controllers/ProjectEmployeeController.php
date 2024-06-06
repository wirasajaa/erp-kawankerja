<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectEmployeeRequest;
use App\Models\Employee;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectEmployeeController extends Controller
{
    private $employee;
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }
    public function create()
    {
        if (Gate::none(['is-admin', 'is-hr'])) {
            return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        $projectEmployee = ProjectEmployee::get();
        $employees = $this->employee->getEmployeeForProject($projectEmployee);

        return view('projects.employee.create', compact('employees'));
    }
    public function store(ProjectEmployeeRequest $req)
    {

        if (Gate::none(['is-admin', 'is-hr'])) {
            return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        $validated = $req->validated();
        try {
            $validated['project_id'] = session('project_id');

            $find = ProjectEmployee::where([['employee_id', $req->employee_id], ['project_id', session('project_id')]])->withTrashed()->first();

            if (empty($find)) {
                $validated['created_by'] = auth()->user()->id;
                ProjectEmployee::create($validated);
            } else {
                $validated['updated_by'] = auth()->user()->id;
                $validated['deleted_at'] = null;
                ProjectEmployee::withTrashed()->find($find->id)->update($validated);
            }
            return redirect()->route('projects.preview', ['project' => session('project_id')])->with('system_success', 'New employee has added');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to add employee!', $th->getMessage())]);
        }
    }
    public function edit(ProjectEmployee $employee)
    {
        if (Gate::none(['is-admin', 'is-hr'])) {
            return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        $employee = $employee->load('profile.user.roles');
        return view('projects.employee.edit', compact('employee'));
    }
    public function update(ProjectEmployeeRequest $req, ProjectEmployee $employee)
    {
        if (Gate::none(['is-admin', 'is-hr'])) {
            return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        $validated = $req->validated();
        try {
            $validated['updated_by'] = auth()->user()->id;
            $employee->update($validated);
            return redirect()->route('projects.preview', ['project' => session('project_id')])->with('system_success', 'Employee data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to update employee!', $th->getMessage())]);
        }
    }
    public function destroy(ProjectEmployee $employee)
    {
        if (Gate::none(['is-admin', 'is-hr'])) {
            return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        try {
            $employee->update(['deleted_by' => auth()->user()->id, 'status' => 'NON_ACTIVE']);
            $employee->delete();
            return redirect()->route('projects.preview', ['project' => session('project_id')])->with('system_success', 'Employee data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage('Failed to delete employee!', $th->getMessage())]);
        }
    }
}
