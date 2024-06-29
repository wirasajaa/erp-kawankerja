<?php

namespace App\Http\Controllers;

use App\Models\MeetingSchedule;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    private $project, $meeting, $user;
    public function __construct(Project $project, MeetingSchedule $meeting, User $user)
    {
        $this->meeting = $meeting;
        $this->project = $project;
        $this->user = $user;
    }

    public function returnToDashboard()
    {
        return redirect()->route('dashboard');
    }
    public function index()
    {
        $projectResume = $this->project->getResume();
        $meetingResume = $this->meeting->getResume();
        $users = $this->user->getResume();
        // return dd($users);
        return view('dashboard', compact('projectResume', 'meetingResume', 'users'));
    }
}
