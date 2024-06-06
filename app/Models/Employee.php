<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id', 'id')->withTrashed();
    }
    public function projectEmployee()
    {
        return $this->hasMany(projectEmployee::class, 'employee_id', 'id');
    }

    public function pic()
    {
        return $this->hasMany(Project::class, 'pic', 'id');
    }

    public function getEmployees()
    {
        $data = $this->with('user.roles')->where('id', '!=', auth()->user()->employee_id)->get();
        $employees = collect($data)->map(function ($item) {
            $temp = $item;
            $temp->fullname = $temp->title_front . ' ' . $temp->fullname . ' ' . $temp->title_back;
            return $temp;
        })->sortBy([['user.roles.name', 'desc'], ['fullname', 'asc']])->values();
        return $employees;
    }
    public function showEmployee($id)
    {
        return $this->with('user.roles')->find($id);
    }

    public function getEmployeeOptions($owned_id = null)
    {
        $data = collect($this->select('id', 'fullname', 'title_front', 'title_back')->with('user')->get()); //get all employee data
        $employees = $data->filter(function ($value) use ($owned_id) {
            //filter employee data that doesnt have user data or have same id with owned data
            return is_null($value->user) || $value->id == $owned_id;
        });
        return (object)$employees->all();
    }
    public function getValidEmployeeOptions()
    {
        $employees = $this->select('id', 'fullname')->with('user.roles', 'projectEmployee.project')->get(); //get all employee data

        $data = collect($employees);
        $filter = $data->filter(function ($value) {
            //filter employee data that doesnt have user data or have same id with owned data
            $projectEmployee = collect($value->projectEmployee);
            $checkArchive = !$projectEmployee->contains(function ($value) {
                return $value->project->status != "ARCHIVING";
            });
            $checkValidUser = !is_null($value->user);
            return  $checkArchive && $checkValidUser;
        });
        return (object)$filter->all();
    }
    public function getEmployeeForProject($project_employee)
    {
        $data = collect($this->select('id', 'fullname')->with('user.roles', 'pic')->get());
        $hasExist = collect($project_employee)->map(function ($item) {
            return $item->employee_id;
        })->all();
        $options = $data->filter(function ($item) use ($hasExist) {
            if (!empty($hasExist)) {
                return !is_null($item->user) && count($item->pic) < 1 && !in_array($item->id, $hasExist);
            } else {
                return !is_null($item->user) && count($item->pic) < 1;
            }
        })->sortBy([['user.roles.name'], ['fullname']]);
        return (object)$options->values()->all();
    }

    public function getCountPopulation()
    {
        $data = $this->select('id', 'nip')->get();
        $collect = collect($data);
        $valid = $collect->filter(function ($item) {
            return str_contains($item->nip, 'KKI-');
        })->count();
        $notValid = $collect->count() - $valid;
        return [$valid, $notValid];
    }
}
