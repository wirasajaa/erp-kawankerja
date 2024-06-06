<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceRequest;
use App\Models\MeetingAbsence;
use App\Models\MeetingSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class MeetingAbsenceController extends Controller
{
    public function absence(AbsenceRequest $req)
    {

        $validated = $req->validated();
        $data = collect($validated['data']);
        $actionBy = auth()->user()->id;
        $meeting_id = $req->meeting_id;

        $meeting = MeetingSchedule::find($meeting_id)->load('project');
        if (Gate::none(['is-admin', 'is-hr', 'is-pm'], $meeting->project->pic)) {
            return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
        $date = Carbon::parse($meeting->updated_at);
        $after3D = $date->addDay(3);
        $now = Carbon::now();

        DB::beginTransaction();
        try {
            if ($now->diffInSeconds($after3D, false) > 0 || $meeting->status == "PLAN") {
                if ($req->action == 'skip') {
                    MeetingAbsence::where('meeting_id', $meeting_id)->delete();
                    $meeting->status = "SKIP";
                } else if ($req->action == "done") {

                    $data = $data->map(function ($item) use ($actionBy, $meeting_id) {
                        $temp = $item;
                        if ($temp['id'] == null) {
                            $temp['id'] = Str::ulid()->toBase32();
                        }
                        $temp['meeting_id'] = $meeting_id;
                        $temp['created_by'] = $actionBy;
                        $temp['updated_by'] = $actionBy;
                        return $temp;
                    })->all();

                    $status = strtoupper($req->action);
                    MeetingAbsence::upsert($data, ['id', 'meeting_id', 'employee_id'], ['updated_by', 'status', 'notes']);
                    $meeting->status = $status;
                }

                if ($meeting->updated_at != null) {
                    $meeting->timestamps = false;
                }
                $meeting->save();

                DB::commit();
                return redirect()->route('meetings.preview', ['meeting' => $meeting_id])->with('system_success', 'Meeting absences has updated!');
            } else {
                DB::commit();
                return redirect()->route('meetings.preview', ['meeting' => $meeting_id])->withErrors(['system_error' => "The time to change the absence data has expired!"]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->withErrors(['system_error' => systemMessage("Failed to update meeting absences!", $th->getMessage())]);
        }
    }
}
