<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyRequest;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FamilyController extends Controller
{
    private $relations = [];
    public function __construct()
    {
        $this->relations = [
            (object)['name' => "FATHER", "value" => "FATHER"],
            (object)['name' => "MOTHER", "value" => "MOTHER"],
            (object)['name' => "BROTHER", "value" => "BROTHER"],
            (object)['name' => "SISTER", "value" => "SISTER"],
            (object)['name' => "GRAND MOTHER", "value" => "GRANDM_OTHER"],
            (object)['name' => "GRAND FATHER", "value" => "GRAND_FATHER"],
        ];
    }

    public function create()
    {
        $relations = $this->relations;
        return view('employees.family.create', compact('relations'));
    }
    public function store(FamilyRequest $req)
    {
        $validated = $req->validated();
        try {
            $validated['created_by'] = auth()->user()->id;
            $validated['employee_id'] = session('employee_id');
            Family::create($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'New family data has added');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to add new family!')]);
        }
    }
    public function edit(Family $family)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $family->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have access!"]);
        }
        $relations = $this->relations;
        return view('employees.family.edit', compact('family', 'relations'));
    }
    public function update(FamilyRequest $req, Family $family)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $family->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $validated = $req->validated();
        try {
            $validated['updated_by'] = auth()->user()->id;
            $validated['employee_id'] = session('employee_id');
            $family->update($validated);
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Family data has updated');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to update family data!')]);
        }
    }
    public function destroy(Family $family)
    {
        if (Gate::none(['is-admin', 'is-level2', 'is-employee'], $family->employee_id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        try {
            $family->update(['deleted_by' => auth()->user()->id]);
            $family->delete();
            return redirect()->route('employees.edit', ['employee' => session('employee_id')])->with('system_success', 'Family data has deleted');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to delete family data!')]);
        }
    }
}
