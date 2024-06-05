<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingSchedule extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id')->withTrashed();
    }
    public function absences()
    {
        return $this->hasMany(MeetingAbsence::class, 'meeting_id');
    }

    public function getMeetingsSchedules($perPage = 15)
    {
        return $this->orderBy('meeting_date')->orderBy('meeting_start')->orderBy('project_id')->with('project')->paginate($perPage);
    }
    public function getMeetingsSchedulesByUser($projecs = [], $perPage = 15)
    {
        $project_list = collect($projecs)->map(function ($item) {
            if ($item->project_id) {
                return $item->project_id;
            } else {
                return $item->id;
            }
        })->all();
        $data = $this->whereIn('project_id', $project_list)->orderBy('meeting_date')->orderBy('meeting_start')->orderBy('project_id')->with('project')->paginate($perPage);
        return $data;
    }
    public function getActivity()
    {
        $data = collect($this->get());
        $resume = $data->groupBy(function ($val) {
            return date('F', strtotime($val->meeting_date));
        })->all();
        $label = [];
        $data = [];
        foreach ($resume as $key => $val) {
            array_push($label, $key);
            array_push($data, count($val));
        }
        $final = ['label' => $label, 'data' => $data];
        return $final;
    }
}
