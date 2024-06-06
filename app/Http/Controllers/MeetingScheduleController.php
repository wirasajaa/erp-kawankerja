<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingRequest;
use App\Models\MeetingSchedule;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MeetingScheduleController extends Controller
{
    private $meeting, $project;
    public function __construct(MeetingSchedule $meeting, Project $project)
    {
        $this->meeting = $meeting;
        $this->project = $project;
    }
    public function index()
    {
        $this->authorize('view', MeetingSchedule::class);
        $user = auth()->user();
        if (Gate::any(['is-admin', 'is-hr'])) {
            $meetings = $this->meeting->getMeetingsSchedules();
        } else {
            if (count($user->employee->pic) > 0) {
                $prpojects = $user->employee->pic;
            } else {
                $prpojects = $user->employee->projectEmployee;
            }
            $meetings = $this->meeting->getMeetingsSchedulesByUser($prpojects);
        }
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $this->authorize('create', MeetingSchedule::class);
        $projects = $this->project->getProjectOptions();
        $projects = collect($projects)->filter(function ($val) {
            return count($val->employees) > 0;
        })->except('employees')->values()->all();
        return view('meetings.create', compact('projects'));
    }
    public function store(MeetingRequest $req)
    {
        $this->authorize('create', MeetingSchedule::class);
        $picProject = Project::find($req->project_id)->load('lead.pic');
        $collectPIC = collect($picProject->lead->pic);
        $relationProject = $collectPIC->pluck("id")->all();

        $check = MeetingSchedule::where(function ($query) use ($req) {
            $query->whereBetween('meeting_start', [$req->meeting_start,  $req->meeting_end])->orWhere(function ($query) use ($req) {
                $query->whereBetween('meeting_end', [$req->meeting_start,  $req->meeting_end]);
            });
        })->where('meeting_date', $req->meeting_date)->whereIn('project_id', $relationProject)->first();
        try {
            if (empty($check)) {
                $validated = $req->validated();
                $validated['created_by'] = auth()->user()->id;
                $validated['updated_at'] = null;
                MeetingSchedule::create($validated);
                return redirect()->route('meetings')->with('system_success', 'New meeting schedule has crated!');
            } else {
                return back()->withInput()->withErrors(['system_error' => "Schedule clashes with other schedules"]);
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage("Failed to craete meeting schedule!", $th->getMessage())]);
        }
    }

    public function preview(MeetingSchedule $meeting)
    {
        $this->authorize('preview', $meeting);
        $status = ['PRESENT', 'SICK', 'PERMISSION', 'LEAVE', 'ABSTAIN'];
        $meeting = $meeting->load('project.employees.profile:id,fullname', 'absences');
        $absences = collect($meeting->absences);
        $employees = collect($meeting->project->employees);
        $employees = $employees->map(function ($item) use ($absences) {
            $temp = $item;
            $temp->absence = $absences->where('employee_id', $item->employee_id)->first();
            return $temp;
        })->values()->all();
        $project = $meeting->project;
        $meeting = (object)collect($meeting)->except(['project', 'absences'])->all();

        if ($meeting->updated_at == null) {
            $update = (object)[
                'action' => true,
                'remaining_time' => "3 Days"
            ];
        } else {
            $date = Carbon::parse($meeting->updated_at);
            $after3D = $date->addDay(3);
            $now = Carbon::now();

            $update = (object)[
                'action' => $now->diffInSeconds($after3D, false) > 0 || $meeting->status == "PLAN",
                'remaining_time' => $now->diff($after3D,)
            ];
        }
        return view('meetings.absences.preview', compact('project', 'employees', 'status', 'meeting', 'update'));
    }
    public function previewOnly(MeetingSchedule $meeting)
    {
        $this->authorize('preview', $meeting);
        $status = ['PRESENT', 'SICK', 'PERMISSION', 'LEAVE', 'ABSTAIN'];
        $meeting = $meeting->load('project.employees.profile:id,fullname', 'absences');
        $absences = collect($meeting->absences);
        $employees = collect($meeting->project->employees);
        $employees = $employees->map(function ($item) use ($absences) {
            $temp = $item;
            $temp->absence = $absences->where('employee_id', $item->employee_id)->first();
            return $temp;
        })->values()->all();
        $project = $meeting->project;
        $meeting = (object)collect($meeting)->except(['project', 'absences'])->all();

        if ($meeting->updated_at == null) {
            $update = (object)[
                'action' => true,
                'remaining_time' => "3 Days"
            ];
        } else {
            $date = Carbon::parse($meeting->updated_at);
            $after3D = $date->addDay(3);
            $now = Carbon::now();

            $update = (object)[
                'action' => $now->diffInSeconds($after3D, false) > 0 || $meeting->status == "PLAN",
                'remaining_time' => $now->diff($after3D,)
            ];
        }
        return view('meetings.absences.preview_only', compact('project', 'employees', 'status', 'meeting', 'update'));
    }
    public function edit(MeetingSchedule $meeting)
    {
        $this->authorize('update', $meeting);
        $projects = $this->project->getProjectOptions();
        return view('meetings.edit', compact('projects', 'meeting'));
    }

    public function update(MeetingSchedule $meeting, MeetingRequest $req)
    {
        $this->authorize('update', $meeting);
        $picProject = Project::find($req->project_id)->load('lead.pic');
        $collectPIC = collect($picProject->lead->pic);
        $relationProject = $collectPIC->pluck("id")->all();

        $check = MeetingSchedule::where(function ($query) use ($req) {
            $query->whereBetween('meeting_start', [$req->meeting_start,  $req->meeting_end])->orWhere(function ($query) use ($req) {
                $query->whereBetween('meeting_end', [$req->meeting_start,  $req->meeting_end]);
            });
        })->where('meeting_date', $req->meeting_date)->whereIn('project_id', $relationProject)->where('id', '!=', $meeting->id)->first();
        try {
            if (empty($check)) {
                $validated = $req->validated();
                $validated['updated_by'] = auth()->user()->id;
                $meeting->update($validated);
                return redirect()->route('meetings')->with('system_success', 'Meeting schedule has updated!');
            } else {
                return back()->withInput()->withErrors(['system_error' => "Schedule clashes with other schedules"]);
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => systemMessage("Failed to update meeting schedule!", $th->getMessage())]);
        }
    }

    public function destroy(MeetingSchedule $meeting)
    {
        $this->authorize('delete', $meeting);
        try {
            $meeting->update(['deleted_by' => auth()->user()->id]);
            $meeting->delete();
            return redirect()->route('meetings')->with('system_success', 'Meeting Schedule has deleted!');
        } catch (\Throwable $th) {
            return back()->withErrors(['system_error' => systemMessage("Deleting meeting schedule is failed!", $th->getMessage())]);
        }
    }
}
