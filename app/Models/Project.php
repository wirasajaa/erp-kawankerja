<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

use function PHPSTORM_META\map;

class Project extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    protected $guarded = ['id'];

    public function lead()
    {
        return $this->hasOne(Employee::class, 'id', 'pic');
    }

    public function employees()
    {
        return $this->hasMany(ProjectEmployee::class, 'project_id', 'id');
    }

    public function meetings()
    {
        return $this->hasMany(MeetingSchedule::class, 'project_id', 'id');
    }

    public function getProjects($perPage = 15)
    {
        return $this->with('lead:id,fullname')->orderBy('created_at')->paginate($perPage);
    }

    public function getProjectOptions()
    {
        if (auth()->user()->hasAnyPermission('super-admin', 'human-resources')) {
            return $this->select('id', 'name', 'created_at')->where('status', '!=', 'ARCHIVING')->orderBy('created_at')->with('employees')->get();
        } else {
            return $this->select('id', 'name', 'created_at')->where('status', '!=', 'ARCHIVING')->where('pic', auth()->user()->employee->id)->orderBy('created_at')->with('employees')->get();
        }
    }

    public function previewProject($id)
    {
        $data = $this->with('employees.profile.user.roles')->find($id);
        $data->employees = $data->employees->map(function ($item) {
            $temp = $item;
            $temp->status = str_replace('_', ' ', $item->status);
            return $temp;
        });
        $data->employees = collect($data->employees)->sortBy([['status'], ['profile.user.role.name'], ['fullname']])->values()->all();
        return $data;
    }

    public function reportProject($id)
    {
        $data = $this->find($id)->load(
            'lead:id,fullname',
            'employees:id,employee_id,project_id,status,notes',
            'employees.profile:id,nip,fullname',
            'employees.profile.user:id,employee_id,username,email',
            'employees.profile.user.roles',
            'meetings:id,project_id,meeting_date,meeting_start,meeting_end,description,status',
            "meetings.absences:id,meeting_id,employee_id,status,notes",
            "meetings.absences.profile:id,fullname"
        );
        $data->employees = $data->employees->map(function ($item) {
            $temp = $item;
            $temp->status = str_replace('_', ' ', $item->status);
            return $temp;
        });
        return $data;
    }
}
