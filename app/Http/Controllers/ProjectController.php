<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    private $project, $employee;
    private $status_options;

    public function __construct(Project $project, Employee $employee)
    {
        $this->project = $project;
        $this->employee = $employee;
        $this->status_options = [
            (object)['name' => "IDEA", 'value' => "IDEA"],
            (object)['name' => "PLANING", 'value' => "PLANING"],
            (object)['name' => "DEVELOPMENT", 'value' => "DEVELOPMENT"],
            (object)['name' => "TESTING", 'value' => "TESTING"],
            (object)['name' => "DEPLOYMENT", 'value' => "DEPLOYMENT"],
            (object)['name' => "MAINTENANCE", 'value' => "MAINTENANCE"],
            (object)['name' => "ARCHIVING", 'value' => "ARCHIVING"],
        ];
    }
    public function index()
    {
        $projects = $this->project->getProjects();
        return view('projects.index', compact('projects'));
    }
    public function create()
    {
        $this->authorize('create', Project::class);
        $employees = $this->employee->getValidEmployeeOptions();
        $status_options = $this->status_options;

        return view('projects.create', compact('employees', 'status_options'));
    }

    public function store(ProjectRequest $req)
    {
        $this->authorize('create', Project::class);
        $validated = $req->validated();
        try {
            $validated['created_by'] = auth()->user()->id;
            Project::create($validated);
            return redirect()->route('projects')->with('system_success', 'New project has created');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage("Failed to create new project!", $th->getMessage(),)]);
        }
    }

    public function edit(Project $project)
    {
        $this->authorize('update', Project::class);
        $employees = $this->employee->getValidEmployeeOptions();
        $status_options = $this->status_options;
        return view('projects.edit', compact('employees', 'project', 'status_options'));
    }

    public function update(ProjectRequest $req, Project $project)
    {
        $this->authorize('update', Project::class);
        $validated = $req->validated();
        try {
            $validated['updated_by'] = auth()->user()->id;
            $project->update($validated);
            return redirect()->route('projects')->with('system_success', 'Project data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage("Failed to update project data!", $th->getMessage(),)]);
        }
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', Project::class);
        try {
            $project->update(['deleted_by' => auth()->user()->id]);
            $project->delete();
            return redirect()->route('projects')->with('system_success', 'Project data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage("Failed to delete project data!", $th->getMessage(),)]);
        }
    }

    public function preview($project)
    {
        $this->authorize('update', Project::class);
        session(['project_id' => $project]); //use for all project employee action

        $project = $this->project->previewProject($project);
        // return $project;
        return view('projects.preview', compact('project'));
    }

    public function report($project)
    {
        $project = $this->project->reportProject($project);
        return view('projects.report', compact('project'));
    }
}
